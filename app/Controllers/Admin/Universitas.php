<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UniversitasModel;

class Universitas extends BaseController
{
    protected $universitasModel;

    public function __construct()
    {
        $this->universitasModel = new UniversitasModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Universitas',
            'universitas' => $this->universitasModel->orderBy('nama_universitas', 'ASC')->findAll()
        ];
        return view('admin/universitas/index', $data);
    }

    public function store()
    {
        // Handle Logo
        $fileLogo = $this->request->getFile('logo');
        $namaLogo = null;
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $namaLogo = $fileLogo->getRandomName();
            $fileLogo->move('uploads/universitas', $namaLogo);
        }

        // Handle Gambar Gedung
        $fileGedung = $this->request->getFile('gambar_gedung');
        $namaGedung = null;
        if ($fileGedung && $fileGedung->isValid() && !$fileGedung->hasMoved()) {
            $namaGedung = $fileGedung->getRandomName();
            // Simpan di folder baru: uploads/gedung
            $fileGedung->move('uploads/gedung', $namaGedung);
        }

        $this->universitasModel->insert([
            'nama_universitas' => $this->request->getPost('nama_universitas'),
            'logo'             => $namaLogo,
            'gambar_gedung'    => $namaGedung
        ]);

        return redirect()->to('admin/universitas')->with('pesan', 'Data universitas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Universitas',
            'kampus' => $this->universitasModel->find($id)
        ];

        if (empty($data['kampus'])) {
            return redirect()->to('admin/universitas')->with('error', 'Data universitas tidak ditemukan.');
        }

        return view('admin/universitas/edit', $data);
    }

    public function update($id)
    {
        $kampusLama = $this->universitasModel->find($id);

        // Handle Logo Update
        $fileLogo = $this->request->getFile('logo');
        $namaLogo = $kampusLama['logo'];
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $namaLogo = $fileLogo->getRandomName();
            $fileLogo->move('uploads/universitas', $namaLogo);
            if ($kampusLama['logo'] && file_exists('uploads/universitas/' . $kampusLama['logo'])) {
                unlink('uploads/universitas/' . $kampusLama['logo']);
            }
        }

        // Handle Gambar Gedung Update
        $fileGedung = $this->request->getFile('gambar_gedung');
        $namaGedung = $kampusLama['gambar_gedung'];
        if ($fileGedung && $fileGedung->isValid() && !$fileGedung->hasMoved()) {
            $namaGedung = $fileGedung->getRandomName();
            $fileGedung->move('uploads/gedung', $namaGedung);
            if ($kampusLama['gambar_gedung'] && file_exists('uploads/gedung/' . $kampusLama['gambar_gedung'])) {
                unlink('uploads/gedung/' . $kampusLama['gambar_gedung']);
            }
        }

        $this->universitasModel->update($id, [
            'nama_universitas' => $this->request->getPost('nama_universitas'),
            'logo'             => $namaLogo,
            'gambar_gedung'    => $namaGedung
        ]);

        return redirect()->to('admin/universitas')->with('pesan', 'Data universitas berhasil diperbarui.');
    }

    public function delete($id)
    {
        $kampus = $this->universitasModel->find($id);

        // Hapus logo
        if ($kampus['logo'] && file_exists('uploads/universitas/' . $kampus['logo'])) {
            unlink('uploads/universitas/' . $kampus['logo']);
        }

        // Hapus gambar gedung
        if ($kampus['gambar_gedung'] && file_exists('uploads/gedung/' . $kampus['gambar_gedung'])) {
            unlink('uploads/gedung/' . $kampus['gambar_gedung']);
        }

        $this->universitasModel->delete($id);
        return redirect()->to('admin/universitas')->with('pesan', 'Data berhasil dihapus.');
    }
}
