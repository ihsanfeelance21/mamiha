<?php

namespace App\Models;

use CodeIgniter\Model;

class UniversitasModel extends Model
{
    protected $table            = 'universitas';
    protected $primaryKey       = 'id_universitas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Aktifkan timestamp otomatis
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields    = [
        'nama_universitas',
        'logo',
        'gambar_gedung'
    ];
}
