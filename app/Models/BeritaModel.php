<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'berita';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Konfigurasi Timestamps (Cukup ditulis sekali)
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Kolom yang diizinkan untuk diisi
    protected $allowedFields    = [
        'id_kategori',
        'judul',
        'slug',
        'konten',
        'gambar',
        'layout',
        'status',
        'waktu_tayang'
    ];

    // Fungsi mengambil semua berita untuk daftar (Admin/Frontend)
    public function getBeritaDenganKategori()
    {
        // Tambahkan 'left' join agar berita tetap muncul meskipun kategorinya tidak sengaja terhapus
        return $this->select('berita.*, kategori_berita.nama_kategori')
            ->join('kategori_berita', 'kategori_berita.id = berita.id_kategori', 'left')
            ->orderBy('berita.created_at', 'DESC')
            ->findAll();
    }

    // Fungsi KHUSUS untuk mengambil 1 berita berdasarkan slug
    public function getBeritaBySlug($slug)
    {
        return $this->select('berita.*, kategori_berita.nama_kategori')
            ->join('kategori_berita', 'kategori_berita.id = berita.id_kategori', 'left')
            ->where('slug', $slug)
            ->first();
    }
}
