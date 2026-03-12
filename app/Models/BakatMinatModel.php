<?php

namespace App\Models;

use CodeIgniter\Model;

class BakatMinatModel extends Model
{
    protected $table            = 'bakat_minat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields    = [
        'judul',
        'deskripsi',
        'jadwal',
        'tipe_pembina',
        'guru_id',
        'nama_pembina_manual',
        'gambar'
    ];
}
