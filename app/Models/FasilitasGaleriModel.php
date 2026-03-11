<?php

namespace App\Models;

use CodeIgniter\Model;

class FasilitasGaleriModel extends Model
{
    protected $table            = 'fasilitas_galeri';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $allowedFields    = ['fasilitas_id', 'foto', 'created_at'];
}
