<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\TestimoniModel;
use App\Models\ProfilWebsiteModel;
use App\Models\HeroSliderModel;
use App\Models\PrestasiModel;
use App\Models\KegiatanModel;

class Home extends BaseController
{
    public function index(): string
    {
        // 1. Panggil SEMUA model yang dibutuhkan di halaman beranda
        $beritaModel    = new BeritaModel();
        $heroModel      = new HeroSliderModel();
        $testimoniModel = new TestimoniModel();
        $profilModel    = new ProfilWebsiteModel();
        $prestasiModel  = new PrestasiModel();

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

            // <-- MENGAMBIL 3 DATA PRESTASI TERBARU -->
            'prestasi'          => $prestasiModel->orderBy('created_at', 'DESC')->limit(3)->findAll(),

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

    /**
     * Halaman daftar kegiatan sekolah.
     */
    public function kegiatan()
    {
        $kegiatanModel = new KegiatanModel();

        $data = [
            'title'    => 'Kegiatan Sekolah | MA Mabadi\'ul Ihsan',
            'kegiatan' => $kegiatanModel->orderBy('created_at', 'DESC')->paginate(9, 'kegiatan'),
            'pager'    => $kegiatanModel->pager,
        ];

        return view('kegiatan_index', $data);
    }

    /**
     * Halaman detail kegiatan sekolah berdasarkan slug.
     */
    public function detail_kegiatan($slug)
    {
        $kegiatanModel = new KegiatanModel();

        $kegiatan = $kegiatanModel->where('slug', $slug)->first();

        if (! $kegiatan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kegiatan tidak ditemukan.');
        }

        $data = [
            'title'    => $kegiatan['judul'] . ' | MA Mabadi\'ul Ihsan',
            'kegiatan' => $kegiatan,
        ];

        return view('kegiatan_detail', $data);
    }
}
