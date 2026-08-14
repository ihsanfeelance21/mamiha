<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengumumanModel;

class PengumumanController extends BaseController
{
    protected $pengumumanModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }

    public function index()
    {
        $this->cekIzin('kegiatan');
        $data = [
            'title'      => 'Manajemen Pengumuman',
            'pengumuman' => $this->pengumumanModel->orderBy('tanggal_publish', 'DESC')->findAll()
        ];

        return view('admin/pengumuman/index', $data);
    }

    public function create()
    {
        $this->cekIzin('kegiatan');
        $data = [
            'title' => 'Tambah Pengumuman'
        ];

        return view('admin/pengumuman/create', $data);
    }

    public function store()
    {
        $this->cekIzin('kegiatan');
        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true) . '-' . time();

        // Handle Upload Gambar
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $this->prosesUpload($fileGambar, 'pengumuman', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);

        $this->pengumumanModel->save([
            'judul'           => $judul,
            'slug'            => $slug,
            'kategori'        => $this->request->getPost('kategori'),
            'konten'          => $this->request->getPost('konten'),
            'tanggal_publish' => $this->request->getPost('tanggal_publish'),
            'gambar'          => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Pengumuman berhasil ditambahkan.');
        return redirect()->to('/admin/pengumuman');
    }

    public function edit($id)
    {
        $this->cekIzin('kegiatan');
        $data = [
            'title'      => 'Edit Pengumuman',
            'pengumuman' => $this->pengumumanModel->find($id)
        ];

        if (empty($data['pengumuman'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengumuman tidak ditemukan');
        }

        return view('admin/pengumuman/edit', $data);
    }

    public function update($id)
    {
        $this->cekIzin('kegiatan');
        $pengumumanLama = $this->pengumumanModel->find($id);
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $pengumumanLama['gambar'];

        // Cek jika ada gambar baru yang diupload
        $baru = $this->prosesUpload($fileGambar, 'pengumuman', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);
        if ($baru) {
            $namaGambar = $baru;

            // Hapus gambar lama jika ada
            if ($pengumumanLama['gambar'] && file_exists(FCPATH . 'uploads/pengumuman/' . $pengumumanLama['gambar'])) {
                unlink(FCPATH . 'uploads/pengumuman/' . $pengumumanLama['gambar']);
            }
        }

        $this->pengumumanModel->update($id, [
            'judul'           => $this->request->getPost('judul'),
            'kategori'        => $this->request->getPost('kategori'),
            'konten'          => $this->request->getPost('konten'),
            'tanggal_publish' => $this->request->getPost('tanggal_publish'),
            'gambar'          => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Pengumuman berhasil diubah.');
        return redirect()->to('/admin/pengumuman');
    }

    public function delete($id)
    {
        $this->cekIzin('kegiatan');
        $pengumuman = $this->pengumumanModel->find($id);

        // Hapus gambar dari folder jika ada
        if ($pengumuman['gambar'] && file_exists('uploads/pengumuman/' . $pengumuman['gambar'])) {
            unlink('uploads/pengumuman/' . $pengumuman['gambar']);
        }

        $this->pengumumanModel->delete($id);
        session()->setFlashdata('pesan', 'Pengumuman berhasil dihapus.');
        return redirect()->to('/admin/pengumuman');
    }
}
