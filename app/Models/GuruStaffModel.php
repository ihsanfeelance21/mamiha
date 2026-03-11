<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruStaffModel extends Model
{
    protected $table            = 'guru_staff';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'nama',
        'jabatan',
        'kategori',
        'foto',
        'sambutan',
        'urutan',
        'pendidikan',
        'youtube',
        'facebook',
        'instagram',
        'tiktok',
        'linkedin',
        'cv_file'
    ];
}
