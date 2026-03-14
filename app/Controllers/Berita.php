<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\KategoriBeritaModel;

class Berita extends BaseController
{
    public function index()
    {
        $beritaModel = new BeritaModel();
        $kategoriModel = new KategoriBeritaModel();

        // Tangkap request dari form pencarian/filter di frontend
        $keyword  = $this->request->getGet('cari');
        $kategori = $this->request->getGet('kategori');
        $tahun    = $this->request->getGet('tahun');
        $urutan   = $this->request->getGet('urutan') ?? 'terbaru'; // Default terbaru

        // Mulai Query Builder
        $query = $beritaModel->select('berita.*, kategori_berita.nama_kategori')
            ->join('kategori_berita', 'kategori_berita.id = berita.id_kategori', 'left');

        // 1. Filter Pencarian (Judul atau Konten)
        if (!empty($keyword)) {
            $query->groupStart()
                ->like('berita.judul', $keyword)
                ->orLike('berita.konten', $keyword)
                ->groupEnd();
        }

        // 2. Filter Kategori
        if (!empty($kategori)) {
            $query->where('kategori_berita.slug_kategori', $kategori);
        }

        // 3. Filter Tahun
        if (!empty($tahun)) {
            $query->where('YEAR(berita.created_at)', $tahun);
        }

        // 4. Filter Urutan
        if ($urutan == 'terlama') {
            $query->orderBy('berita.created_at', 'ASC');
        } else {
            $query->orderBy('berita.created_at', 'DESC');
        }

        $data = [
            'title'        => 'Kumpulan Berita | MA Mabadi\'ul Ihsan',
            // Gunakan pagination bawaan CI4, tampilkan 9 berita per halaman
            'berita'       => $query->paginate(9, 'berita'),
            'pager'        => $beritaModel->pager,
            'kategoriList' => $kategoriModel->findAll(),

            // Kirim kembali inputan user agar form filter tetap terisi (sticky form)
            'keyword'      => $keyword,
            'kategoriAktif' => $kategori,
            'tahunAktif'   => $tahun,
            'urutanAktif'  => $urutan,
        ];

        return view('berita_index', $data);
    }
}
