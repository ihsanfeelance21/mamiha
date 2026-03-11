<?php

namespace App\Models;

use CodeIgniter\Model;

class FasilitasModel extends Model
{
    protected $table            = 'fasilitas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true; // Otomatis isi created_at & updated_at
    protected $allowedFields    = ['icon', 'judul', 'deskripsi', 'foto_cover'];
}
