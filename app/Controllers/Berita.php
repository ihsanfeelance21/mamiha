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
        $urutan   = $this->request->getGet('urutan') ?? 'terbaru';

        // Mulai Query Builder
        $query = $beritaModel->select('berita.*, kategori_berita.nama_kategori')
            ->join('kategori_berita', 'kategori_berita.id = berita.id_kategori', 'left');

        // ====================================================================
        // FILTER WAJIB: Boleh 'terbit' ATAU 'terjadwal' (Asal jam sudah lewat)
        // ====================================================================
        $query->groupStart()
            ->where('berita.status', 'terbit')
            ->orWhere('berita.status', 'terjadwal')
            ->groupEnd()
            ->groupStart()
            ->where('berita.waktu_tayang <=', date('Y-m-d H:i:s'))
            ->orWhere('berita.waktu_tayang IS NULL')
            ->groupEnd();

        // 1. Filter Pencarian
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

        // 3. Filter Tahun (Berdasarkan waktu tayang agar presisi)
        if (!empty($tahun)) {
            $query->where('YEAR(COALESCE(berita.waktu_tayang, berita.created_at))', $tahun);
        }

        // 4. Filter Urutan
        if ($urutan == 'terlama') {
            $query->orderBy('berita.waktu_tayang', 'ASC');
        } else {
            $query->orderBy('berita.waktu_tayang', 'DESC');
        }

        $data = [
            'title'         => 'Kumpulan Berita | MA Mabadi\'ul Ihsan',
            'berita'        => $query->paginate(9, 'berita'),
            'pager'         => $beritaModel->pager,
            'kategoriList'  => $kategoriModel->findAll(),
            'keyword'       => $keyword,
            'kategoriAktif' => $kategori,
            'tahunAktif'    => $tahun,
            'urutanAktif'   => $urutan,
        ];

        return view('berita_index', $data);
    }

    // ====================================================================
    // FUNGSI UNTUK MEMBACA FULL BERITA (SINGLE PAGE)
    // ====================================================================
    public function detail($slug)
    {
        $beritaModel = new BeritaModel();

        // Cari berita berdasarkan slug, pastikan status aman
        $berita = $beritaModel->select('berita.*, kategori_berita.nama_kategori')
            ->join('kategori_berita', 'kategori_berita.id = berita.id_kategori', 'left')
            ->where('berita.slug', $slug)
            ->groupStart()
            ->where('berita.status', 'terbit')
            ->orWhere('berita.status', 'terjadwal')
            ->groupEnd()
            ->groupStart()
            ->where('berita.waktu_tayang <=', date('Y-m-d H:i:s'))
            ->orWhere('berita.waktu_tayang IS NULL')
            ->groupEnd()
            ->first();

        // Jika berita tidak ada (atau status masih draft/terjadwal besok)
        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Berita tidak ditemukan atau belum dipublikasikan.");
        }

        // Ambil data Tag yang nempel di berita ini
        $db = \Config\Database::connect();
        $tags = $db->table('berita_tags')
            ->select('tags.nama_tag, tags.link_eksternal')
            ->join('tags', 'tags.id = berita_tags.id_tag')
            ->where('berita_tags.id_berita', $berita['id'])
            ->get()->getResultArray();

        $data = [
            'title'  => $berita['judul'] . ' | MA Mabadi\'ul Ihsan',
            'berita' => $berita,
            'tags'   => $tags
        ];

        return view('berita_detail', $data);
    }
}
