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
        $this->cekIzin('alumni');
        $data = [
            'title' => 'Kelola Universitas',
            'universitas' => $this->universitasModel->orderBy('nama_universitas', 'ASC')->findAll()
        ];
        return view('admin/universitas/index', $data);
    }

    public function store()
    {
        $this->cekIzin('alumni');
        // Handle Logo
        $fileLogo = $this->request->getFile('logo');
        $namaLogo = $this->prosesUpload($fileLogo, 'universitas', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif'], 2);

        // Handle Gambar Gedung
        $fileGedung = $this->request->getFile('gambar_gedung');
        $namaGedung = $this->prosesUpload($fileGedung, 'gedung', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);

        $this->universitasModel->insert([
            'nama_universitas' => $this->request->getPost('nama_universitas'),
            'logo'             => $namaLogo,
            'gambar_gedung'    => $namaGedung
        ]);

        return redirect()->to('admin/universitas')->with('pesan', 'Data universitas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->cekIzin('alumni');
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
        $this->cekIzin('alumni');
        $kampusLama = $this->universitasModel->find($id);

        // Handle Logo Update
        $fileLogo = $this->request->getFile('logo');
        $namaLogo = $kampusLama['logo'];
        $baruLogo = $this->prosesUpload($fileLogo, 'universitas', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif'], 2);
        if ($baruLogo) {
            $namaLogo = $baruLogo;
            if ($kampusLama['logo'] && file_exists(FCPATH . 'uploads/universitas/' . $kampusLama['logo'])) {
                unlink(FCPATH . 'uploads/universitas/' . $kampusLama['logo']);
            }
        }

        // Handle Gambar Gedung Update
        $fileGedung = $this->request->getFile('gambar_gedung');
        $namaGedung = $kampusLama['gambar_gedung'];
        $baruGedung = $this->prosesUpload($fileGedung, 'gedung', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);
        if ($baruGedung) {
            $namaGedung = $baruGedung;
            if ($kampusLama['gambar_gedung'] && file_exists(FCPATH . 'uploads/gedung/' . $kampusLama['gambar_gedung'])) {
                unlink(FCPATH . 'uploads/gedung/' . $kampusLama['gambar_gedung']);
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
        $this->cekIzin('alumni');
        $kampus = $this->universitasModel->find($id);

        // Hapus logo
        if ($kampus['logo'] && file_exists(FCPATH . 'uploads/universitas/' . $kampus['logo'])) {
            unlink(FCPATH . 'uploads/universitas/' . $kampus['logo']);
        }

        // Hapus gambar gedung
        if ($kampus['gambar_gedung'] && file_exists(FCPATH . 'uploads/gedung/' . $kampus['gambar_gedung'])) {
            unlink(FCPATH . 'uploads/gedung/' . $kampus['gambar_gedung']);
        }

        $this->universitasModel->delete($id);
        return redirect()->to('admin/universitas')->with('pesan', 'Data berhasil dihapus.');
    }
}
