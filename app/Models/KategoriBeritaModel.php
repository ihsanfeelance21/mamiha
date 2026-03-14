<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriBeritaModel extends Model
{
    protected $table            = 'kategori_berita';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // Hanya nama dan slug yang boleh diisi
    protected $allowedFields    = ['nama_kategori', 'slug_kategori'];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
