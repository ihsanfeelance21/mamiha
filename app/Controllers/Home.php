<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\TestimoniModel;
use App\Models\ProfilWebsiteModel;
use App\Models\HeroSliderModel;

class Home extends BaseController
{
    public function index(): string
    {
        // 1. Panggil SEMUA model yang dibutuhkan di halaman beranda
        $beritaModel    = new BeritaModel();
        $heroModel      = new HeroSliderModel();
        $testimoniModel = new TestimoniModel();
        $profilModel    = new ProfilWebsiteModel();

        // 2. Kumpulkan SEMUA data ke dalam SATU array $data
        $data = [
            'title'             => "Beranda | MA Mabadi'ul Ihsan",

            // <-- MENGAMBIL DATA BERITA TERBARU DENGAN FILTER KEAMANAN -->
            'berita' => $beritaModel->select('berita.*, kategori_berita.nama_kategori')
                ->join('kategori_berita', 'kategori_berita.id = berita.id_kategori', 'left')
                // Gembok Status
                ->groupStart()
                ->where('berita.status', 'terbit')
                ->orWhere('berita.status', 'terjadwal')
                ->groupEnd()
                // Gembok Waktu
                ->groupStart()
                ->where('berita.waktu_tayang <=', date('Y-m-d H:i:s'))
                ->orWhere('berita.waktu_tayang IS NULL')
                ->groupEnd()
                ->orderBy('berita.waktu_tayang', 'DESC')
                ->limit(3)
                ->find(),

            // Mengambil data slider
            'sliders'           => $heroModel->findAll(),

            // Mengambil 6 data testimoni terbaru (approved)
            'testimoni_terbaru' => $testimoniModel->where('is_approved', 1)
                ->orderBy('created_at', 'DESC')
                ->findAll(6),

            // Menggabungkan data profil
            'profil'            => $profilModel->first(),
        ];

        // 3. Kirim data gabungan ke view home
        return view('home', $data);
    }
}
