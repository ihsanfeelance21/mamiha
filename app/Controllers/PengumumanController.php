<?php

namespace App\Controllers;

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
        // Menangkap filter kategori dari URL (jika ada)
        $kategori = $this->request->getGet('kategori');

        if ($kategori) {
            $pengumuman = $this->pengumumanModel->where('kategori', $kategori)->orderBy('tanggal_publish', 'DESC')->findAll();
        } else {
            $pengumuman = $this->pengumumanModel->orderBy('tanggal_publish', 'DESC')->findAll();
        }

        $data = [
            'title'          => 'Pengumuman Madrasah',
            'pengumuman'     => $pengumuman,
            'kategori_aktif' => $kategori
        ];

        return view('pengumuman_index', $data);
    }

    public function detail($slug)
    {
        $pengumuman = $this->pengumumanModel->where('slug', $slug)->first();

        if (empty($pengumuman)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengumuman tidak ditemukan');
        }

        $data = [
            'title'      => $pengumuman['judul'],
            'pengumuman' => $pengumuman
        ];

        return view('pengumuman_detail', $data);
    }
}
