<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table            = 'kegiatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // Fitur pengaman: Hanya kolom di bawah ini yang boleh diisi dari form (menghindari Mass Assignment Vulnerability)
    protected $allowedFields    = ['judul', 'slug', 'konten', 'gambar'];

    // Aktifkan timestamp agar created_at dan updated_at terisi otomatis oleh sistem
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
