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
        // Kita hitung jumlah foto untuk setiap album
        $galeri = $this->galeriModel->orderBy('tanggal', 'DESC')->findAll();
        foreach ($galeri as &$item) {
            $item['jumlah_foto'] = $this->galeriFotoModel->where('galeri_id', $item['id'])->countAllResults();
        }

        $data = [
            'title'  => 'Manajemen Galeri',
            'galeri' => $galeri
        ];

        return view('admin/galeri/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Album Galeri'
        ];

        return view('admin/galeri/create', $data);
    }

    public function store()
    {
        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true) . '-' . time();

        // Handle Upload Sampul
        $fileSampul = $this->request->getFile('sampul');
        $namaSampul = null;

        if ($fileSampul && $fileSampul->isValid() && !$fileSampul->hasMoved()) {
            $namaSampul = $fileSampul->getRandomName();
            $fileSampul->move('uploads/galeri', $namaSampul);
        }

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
        $galeriLama = $this->galeriModel->find($id);
        $fileSampul = $this->request->getFile('sampul');
        $namaSampul = $galeriLama['sampul'];

        // Cek jika ada sampul baru yang diupload
        if ($fileSampul && $fileSampul->isValid() && !$fileSampul->hasMoved()) {
            $namaSampul = $fileSampul->getRandomName();
            $fileSampul->move('uploads/galeri', $namaSampul);

            // Hapus sampul lama jika ada
            if ($galeriLama['sampul'] && file_exists('uploads/galeri/' . $galeriLama['sampul'])) {
                unlink('uploads/galeri/' . $galeriLama['sampul']);
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
        $galeri = $this->galeriModel->find($id);

        // Hapus sampul dari folder jika ada
        if ($galeri['sampul'] && file_exists('uploads/galeri/' . $galeri['sampul'])) {
            unlink('uploads/galeri/' . $galeri['sampul']);
        }

        // Hapus semua foto dalam album dari folder public
        $fotos = $this->galeriFotoModel->where('galeri_id', $id)->findAll();
        foreach ($fotos as $foto) {
            if ($foto['nama_file'] && file_exists('uploads/galeri/fotos/' . $foto['nama_file'])) {
                unlink('uploads/galeri/fotos/' . $foto['nama_file']);
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
        if ($this->request->isAJAX()) {
            $fileFoto = $this->request->getFile('file'); // 'file' adalah nama field dari library Dropzone.js

            if ($fileFoto->isValid() && !$fileFoto->hasMoved()) {
                $namaFoto = $fileFoto->getRandomName();
                $fileFoto->move('uploads/galeri/fotos', $namaFoto);

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
        if ($this->request->isAJAX()) {
            $photoId = $this->request->getPost('id');
            $foto = $this->galeriFotoModel->find($photoId);

            if ($foto) {
                // Hapus foto dari folder
                if ($foto['nama_file'] && file_exists('uploads/galeri/fotos/' . $foto['nama_file'])) {
                    unlink('uploads/galeri/fotos/' . $foto['nama_file']);
                }
                // Hapus foto dari database
                $this->galeriFotoModel->delete($photoId);
                return $this->response->setJSON(['status' => 'success']);
            }
            return $this->response->setJSON(['status' => 'error']);
        }
    }
}
