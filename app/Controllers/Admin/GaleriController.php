<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GaleriModel;
use App\Models\GaleriFotoModel;

class GaleriController extends BaseController
{
    protected $galeriModel;
    protected $galeriFotoModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
        $this->galeriFotoModel = new GaleriFotoModel();
    }

    public function index()
    {
        $this->cekIzin('galeri');

        // Hitung jumlah foto per album sekali query (hindari N+1)
        $galeri = $this->galeriModel->orderBy('tanggal', 'DESC')->findAll();
        $ids = array_column($galeri, 'id');

        $jumlahFoto = [];
        if ($ids !== []) {
            $rows = $this->galeriFotoModel->select('galeri_id, COUNT(*) AS total')
                ->whereIn('galeri_id', $ids)
                ->groupBy('galeri_id')
                ->findAll();
            foreach ($rows as $r) {
                $jumlahFoto[$r['galeri_id']] = (int) $r['total'];
            }
        }

        foreach ($galeri as &$item) {
            $item['jumlah_foto'] = $jumlahFoto[$item['id']] ?? 0;
        }

        $data = [
            'title'  => 'Manajemen Galeri',
            'galeri' => $galeri
        ];

        return view('admin/galeri/index', $data);
    }

    public function create()
    {
        $this->cekIzin('galeri');

        $data = [
            'title' => 'Tambah Album Galeri'
        ];

        return view('admin/galeri/create', $data);
    }

    public function store()
    {
        $this->cekIzin('galeri');

        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true) . '-' . time();

        // Handle Upload Sampul
        $fileSampul = $this->request->getFile('sampul');
        $namaSampul = $this->prosesUpload($fileSampul, 'galeri', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);

        $this->galeriModel->save([
            'judul'     => $judul,
            'slug'      => $slug,
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tanggal'   => $this->request->getPost('tanggal'),
            'sampul'    => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Album berhasil ditambahkan.');
        return redirect()->to('/admin/galeri');
    }

    public function edit($id)
    {
        $this->cekIzin('galeri');

        $data = [
            'title'  => 'Edit Album Galeri',
            'galeri' => $this->galeriModel->find($id),
            // Ambil foto-foto yang sudah diupload dalam album ini
            'fotos'  => $this->galeriFotoModel->where('galeri_id', $id)->findAll()
        ];

        if (empty($data['galeri'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Album tidak ditemukan');
        }

        return view('admin/galeri/edit', $data);
    }

    public function update($id)
    {
        $this->cekIzin('galeri');

        $galeriLama = $this->galeriModel->find($id);
        $fileSampul = $this->request->getFile('sampul');
        $namaSampul = $galeriLama['sampul'];

        // Cek jika ada sampul baru yang diupload
        $baru = $this->prosesUpload($fileSampul, 'galeri', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);
        if ($baru) {
            $namaSampul = $baru;
            if ($galeriLama['sampul'] && file_exists(FCPATH . 'uploads/galeri/' . $galeriLama['sampul'])) {
                unlink(FCPATH . 'uploads/galeri/' . $galeriLama['sampul']);
            }
        }

        $this->galeriModel->update($id, [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tanggal'   => $this->request->getPost('tanggal'),
            'sampul'    => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Album berhasil diubah.');
        return redirect()->to('/admin/galeri');
    }

    public function delete($id)
    {
        $this->cekIzin('galeri');

        $galeri = $this->galeriModel->find($id);

        // Hapus sampul dari folder jika ada
        if ($galeri['sampul'] && file_exists(FCPATH . 'uploads/galeri/' . $galeri['sampul'])) {
            unlink(FCPATH . 'uploads/galeri/' . $galeri['sampul']);
        }

        // Hapus semua foto dalam album dari folder public
        $fotos = $this->galeriFotoModel->where('galeri_id', $id)->findAll();
        foreach ($fotos as $foto) {
            if ($foto['nama_file'] && file_exists(FCPATH . 'uploads/galeri/fotos/' . $foto['nama_file'])) {
                unlink(FCPATH . 'uploads/galeri/fotos/' . $foto['nama_file']);
            }
        }

        // Hapus data album dan foto-foto terkait dari database (karena ON DELETE CASCADE)
        $this->galeriModel->delete($id);

        session()->setFlashdata('pesan', 'Album berhasil dihapus.');
        return redirect()->to('/admin/galeri');
    }

    // Metode khusus untuk mengupload foto-foto dalam album sekaligus
    public function uploadPhotos($id)
    {
        $this->cekIzin('galeri');

        if ($this->request->isAJAX()) {
            $fileFoto = $this->request->getFile('file'); // 'file' adalah nama field dari library Dropzone.js

            $namaFoto = $this->prosesUpload($fileFoto, 'galeri/fotos', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);

            if ($namaFoto) {
                $this->galeriFotoModel->save([
                    'galeri_id' => $id,
                    'nama_file' => $namaFoto
                ]);

                return $this->response->setJSON(['status' => 'success']);
            }
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    // Metode khusus untuk menghapus foto tertentu dalam album
    public function deletePhoto($id)
    {
        $this->cekIzin('galeri');

        if ($this->request->isAJAX()) {
            $photoId = $this->request->getPost('id');
            $foto = $this->galeriFotoModel->find($photoId);

            if ($foto) {
                // Hapus foto dari folder
                if ($foto['nama_file'] && file_exists(FCPATH . 'uploads/galeri/fotos/' . $foto['nama_file'])) {
                    unlink(FCPATH . 'uploads/galeri/fotos/' . $foto['nama_file']);
                }
                // Hapus foto dari database
                $this->galeriFotoModel->delete($photoId);
                return $this->response->setJSON(['status' => 'success']);
            }
            return $this->response->setJSON(['status' => 'error']);
        }
    }
}
