<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\TestimoniModel;
use App\Models\ProfilWebsiteModel; // <-- NAMA MODELNYA SUDAH SAYA BENARKAN DI SINI

class Home extends BaseController
{
    public function index(): string
    {
        // 1. Panggil SEMUA model yang dibutuhkan di halaman beranda
        $kegiatanModel  = new KegiatanModel();
        $heroModel      = new \App\Models\HeroSliderModel();
        $testimoniModel = new TestimoniModel();
        $profilModel    = new ProfilWebsiteModel(); // <-- INISIALISASINYA JUGA SUDAH DIBENARKAN

        // 2. Kumpulkan SEMUA data ke dalam SATU array $data
        $data = [
            'title'             => "Beranda | MA Mabadi'ul Ihsan",

            // Mengambil 3 data kegiatan terbaru
            'kegiatan'          => $kegiatanModel->orderBy('created_at', 'DESC')->findAll(3),

            // Mengambil data slider
            'sliders'           => $heroModel->findAll(),

            // Mengambil 6 data testimoni terbaru (approved)
            'testimoni_terbaru' => $testimoniModel->where('is_approved', 1)
                ->orderBy('created_at', 'DESC')
                ->findAll(6),

            // <-- GABUNGKAN DATA PROFIL DI SINI -->
            'profil'            => $profilModel->first(),
        ];

        // 3. Kirim data gabungan ke view home
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
