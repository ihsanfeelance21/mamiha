<?php

namespace App\Models;

use CodeIgniter\Model;

class AksesCepatModel extends Model
{
    protected $table            = 'akses_cepat';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_link', 'url_link'];
    protected $useTimestamps    = true;
}
