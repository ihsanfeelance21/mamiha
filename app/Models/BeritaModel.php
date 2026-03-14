<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'berita';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // Semua kolom sesuai database migration
    protected $allowedFields    = ['id_kategori', 'judul', 'slug', 'konten', 'gambar', 'layout'];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Fungsi khusus untuk mengambil data Berita + Nama Kategori (JOIN)
    public function getBeritaDenganKategori()
    {
        return $this->select('berita.*, kategori_berita.nama_kategori')
            ->join('kategori_berita', 'kategori_berita.id = berita.id_kategori')
            ->orderBy('berita.created_at', 'DESC')
            ->findAll();
    }
    public function baca($slug)
    {
        $beritaModel = new \App\Models\BeritaModel();

        // Cari berita berdasarkan slug beserta nama kategorinya
        $berita = $beritaModel->select('berita.*, kategori_berita.nama_kategori')
            ->join('kategori_berita', 'kategori_berita.id = berita.id_kategori', 'left')
            ->where('slug', $slug)
            ->first();

        // Jika berita tidak ditemukan, lempar error 404
        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Berita tidak ditemukan.");
        }

        // Auto-generate Meta Description (Potong 150 karakter pertama dari konten)
        $metaDescription = mb_substr(strip_tags($berita['konten']), 0, 150) . '...';

        $data = [
            'title'            => $berita['judul'] . ' - MA Mabadi\'ul Ihsan',
            'berita'           => $berita,
            // Data untuk SEO & Open Graph
            'meta_description' => $metaDescription,
            'og_title'         => $berita['judul'],
            'og_description'   => $metaDescription,
            'og_image'         => base_url('uploads/berita/' . $berita['gambar']),
            'og_url'           => current_url()
        ];

        return view('berita_detail', $data);
    }
}
