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
        $data = [
            'title'      => 'Manajemen Pengumuman',
            'pengumuman' => $this->pengumumanModel->orderBy('tanggal_publish', 'DESC')->findAll()
        ];

        return view('admin/pengumuman/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengumuman'
        ];

        return view('admin/pengumuman/create', $data);
    }

    public function store()
    {
        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true) . '-' . time();

        // Handle Upload Gambar
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = null;

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/pengumuman', $namaGambar);
        }

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
        $pengumumanLama = $this->pengumumanModel->find($id);
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $pengumumanLama['gambar'];

        // Cek jika ada gambar baru yang diupload
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/pengumuman', $namaGambar);

            // Hapus gambar lama jika ada
            if ($pengumumanLama['gambar'] && file_exists('uploads/pengumuman/' . $pengumumanLama['gambar'])) {
                unlink('uploads/pengumuman/' . $pengumumanLama['gambar']);
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
