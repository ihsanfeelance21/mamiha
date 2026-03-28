<?php

namespace App\Controllers;

use App\Models\GaleriModel;
use App\Models\GaleriFotoModel;
use App\Models\GaleriVideoModel;

class GaleriController extends BaseController
{
    protected $galeriModel;
    protected $galeriFotoModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
        $this->galeriFotoModel = new GaleriFotoModel();
    }

    public function index()
    {
        // Ambil semua data album galeri
        $galeri = $this->galeriModel->orderBy('tanggal', 'DESC')->findAll();

        // Hitung jumlah foto untuk masing-masing album (untuk badge "X Foto")
        foreach ($galeri as &$item) {
            $item['jumlah_foto'] = $this->galeriFotoModel->where('galeri_id', $item['id'])->countAllResults();
        }

        $data = [
            'title'  => 'Galeri Kegiatan',
            'galeri' => $galeri
        ];

        return view('galeri_index', $data);
    }

    public function detail($slug)
    {
        // Cari album berdasarkan slug di URL
        $galeri = $this->galeriModel->where('slug', $slug)->first();

        if (empty($galeri)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Album galeri tidak ditemukan');
        }

        $data = [
            'title'  => $galeri['judul'],
            'galeri' => $galeri,
            'fotos'  => $this->galeriFotoModel->where('galeri_id', $galeri['id'])->findAll()
        ];

        return view('galeri_detail', $data);
    }

    public function video()
    {
        $videoModel = new GaleriVideoModel();

        $data = [
            'title'  => 'Galeri Video | Madrasah', // Bebas disesuaikan
            'videos' => $videoModel->orderBy('tanggal', 'DESC')->findAll(),
            'landscape' => $videoModel->where('orientasi', 'landscape')->orderBy('tanggal', 'DESC')->findAll(),
            // Ambil khusus portrait
            'portrait'  => $videoModel->where('orientasi', 'portrait')->orderBy('tanggal', 'DESC')->findAll()
        ];


        // Memanggil file view yang baru saja kita buat tadi
        return view('galeri_video', $data);
    }
}
