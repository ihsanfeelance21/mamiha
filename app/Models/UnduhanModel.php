<?php

namespace App\Models;

use CodeIgniter\Model;

class UnduhanModel extends Model
{
    protected $table            = 'unduhan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Aktifkan timestamp agar created_at & updated_at terisi otomatis
    protected $useTimestamps    = true;

    protected $allowedFields    = [
        'judul',
        'kategori',
        'file_unduhan',
        'link_eksternal',
        'keterangan'
    ];
}
