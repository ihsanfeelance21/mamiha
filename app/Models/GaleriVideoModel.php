<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriVideoModel extends Model
{
    protected $table            = 'galeri_video';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'link_video', 'orientasi', 'tanggal'];

    // Aktifkan jika Mas pakai kolom created_at dan updated_at di tabel
    protected $useTimestamps = true;
}
