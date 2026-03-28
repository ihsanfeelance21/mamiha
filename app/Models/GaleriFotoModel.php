<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriFotoModel extends Model
{
    protected $table            = 'galeri_foto';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['galeri_id', 'nama_file'];
    protected $useTimestamps    = true;
}
