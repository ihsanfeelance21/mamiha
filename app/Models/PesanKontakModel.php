<?php

namespace App\Models;

use CodeIgniter\Model;

class PesanKontakModel extends Model
{
    protected $table            = 'pesan_kontak';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    // Sesuaikan field ini
    protected $allowedFields    = [
        'nama',
        'email',
        'no_wa',
        'kategori',
        'pesan',
        'status'
    ];
}
