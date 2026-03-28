<?php

namespace App\Controllers;

use App\Models\PrestasiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PrestasiController extends BaseController
{
    protected $prestasiModel;

    public function __construct()
    {
        $this->prestasiModel = new PrestasiModel();
    }

    // Menampilkan daftar semua prestasi
    public function index()
    {
        $data = [
            'title'    => 'Daftar Prestasi',
            // Urutkan dari tahun perolehan terbaru, lalu id terbaru
            'prestasi' => $this->prestasiModel->orderBy('tahun_perolehan', 'DESC')->orderBy('id', 'DESC')->findAll()
        ];

        return view('prestasi_index', $data);
    }

    // Menampilkan detail spesifik satu prestasi berdasarkan slug
    public function detail($slug)
    {
        // Cari data berdasarkan slug
        $prestasi = $this->prestasiModel->where('slug', $slug)->first();

        // Jika URL slug ngawur / data tidak ditemukan, tampilkan error 404
        if (!$prestasi) {
            throw PageNotFoundException::forPageNotFound('Halaman prestasi tidak ditemukan');
        }

        $data = [
            'title'    => $prestasi['judul'],
            'prestasi' => $prestasi
        ];

        return view('prestasi_detail', $data);
    }
}
