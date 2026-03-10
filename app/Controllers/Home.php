<?php

namespace App\Controllers;

use App\Models\KegiatanModel; // Wajib ditambahkan agar bisa akses tabel kegiatan
use App\Models\TestimoniModel; // Wajib ditambahkan agar bisa akses tabel testimoni

class Home extends BaseController
{
    public function index(): string
    {
        // 1. Panggil model-model yang dibutuhkan di halaman beranda
        $kegiatanModel = new KegiatanModel();
        $heroModel = new \App\Models\HeroSliderModel();
        $testimoniModel = new TestimoniModel(); // Inisialisasi model testimoni

        // 2. Kumpulkan semua data ke dalam satu array $data
        $data = [
            'title'             => "Beranda | MA Mabadi'ul Ihsan",
            // Mengambil 3 data kegiatan terbaru berdasarkan tanggal dibuat
            'kegiatan'          => $kegiatanModel->orderBy('created_at', 'DESC')->findAll(3),
            // Mengambil data slider dari database
            'sliders'           => $heroModel->findAll(),
            // Mengambil 6 data testimoni terbaru yang statusnya sudah di-approve (1)
            'testimoni_terbaru' => $testimoniModel->where('is_approved', 1)
                ->orderBy('created_at', 'DESC')
                ->findAll(6),
        ];

        // 3. Kirim data ke view home
        return view('home', $data);
    }

    public function detail_kegiatan($slug)
    {
        $kegiatanModel = new KegiatanModel();

        // Cari kegiatan berdasarkan slug
        $kegiatan = $kegiatanModel->where('slug', $slug)->first();

        // Jika data tidak ditemukan, tampilkan halaman error 404
        if (!$kegiatan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kegiatan tidak ditemukan.');
        }

        $data = [
            'title'    => $kegiatan['judul'] . " | MA Mabadi'ul Ihsan",
            'kegiatan' => $kegiatan
        ];

        return view('kegiatan_detail', $data);
    }
}
