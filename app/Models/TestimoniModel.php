<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimoniModel extends Model
{
    protected $table            = 'testimoni';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'status_user', 'rating', 'isi_testimoni', 'foto', 'is_approved'];
    protected $useTimestamps    = true; // Otomatis mengisi created_at & updated_at
}