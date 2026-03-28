<?php

namespace App\Models;

use CodeIgniter\Model;

class PrestasiModel extends Model
{
    protected $table            = 'prestasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Field sesuai dengan gambar struktur tabel yang Mas berikan
    protected $allowedFields    = [
        'kategori_prestasi',
        'judul',
        'slug',
        'konten',
        'gambar',
        'layout',
        'juara',
        'nama_lomba',
        'nama_pemenang',
        'kelas',
        'nama_guru',
        'nama_penghargaan',
        'tahun_perolehan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
