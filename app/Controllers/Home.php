<?php

namespace App\Controllers;

use App\Models\BeritaModel; // <-- KegiatanModel diganti menjadi BeritaModel
use App\Models\TestimoniModel;
use App\Models\ProfilWebsiteModel;
use App\Models\HeroSliderModel;

class Home extends BaseController
{
    public function index(): string
    {
        // 1. Panggil SEMUA model yang dibutuhkan di halaman beranda
        $beritaModel    = new BeritaModel(); // <-- Inisialisasi BeritaModel
        $heroModel      = new HeroSliderModel();
        $testimoniModel = new TestimoniModel();
        $profilModel    = new ProfilWebsiteModel();

        // 2. Kumpulkan SEMUA data ke dalam SATU array $data
        $data = [
            'title'             => "Beranda | MA Mabadi'ul Ihsan",

            // <-- MENGAMBIL DATA BERITA TERBARU (JOIN KATEGORI) -->
            'berita'            => $beritaModel->select('berita.*, kategori_berita.nama_kategori')
                ->join('kategori_berita', 'kategori_berita.id = berita.id_kategori', 'left')
                ->orderBy('berita.created_at', 'DESC')
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

    // Fungsi detail kita ubah namanya jadi detail_berita
    public function detail_berita($slug)
    {
        $beritaModel = new BeritaModel();

        // Cari berita berdasarkan slug + Join Kategori
        $berita = $beritaModel->select('berita.*, kategori_berita.nama_kategori')
            ->join('kategori_berita', 'kategori_berita.id = berita.id_kategori', 'left')
            ->where('berita.slug', $slug)
            ->first();

        // Jika data tidak ditemukan, tampilkan halaman error 404
        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Berita tidak ditemukan.');
        }

        $data = [
            'title'  => $berita['judul'] . " | MA Mabadi'ul Ihsan",
            'berita' => $berita
        ];

        return view('berita_detail', $data); // Nanti kita buat file view ini
    }
}
