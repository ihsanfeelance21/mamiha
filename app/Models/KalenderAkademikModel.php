<?php

namespace App\Models;

use CodeIgniter\Model;

class KalenderAkademikModel extends Model
{
    protected $table            = 'kalender_akademik';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['judul', 'slug', 'tanggal_mulai', 'tanggal_selesai', 'deskripsi'];

    // Aktifkan timestamps agar created_at dan updated_at terisi otomatis
    protected $useTimestamps    = true;
}
