<?php

namespace App\Controllers;

use App\Models\GaleriModel;
use App\Models\GaleriFotoModel;

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
}
