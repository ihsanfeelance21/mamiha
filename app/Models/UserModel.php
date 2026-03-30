<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;

    // Tambahkan atau pastikan baris ini ada:
    protected $allowedFields    = ['nama_lengkap', 'username', 'password', 'foto', 'role'];

    // (Kode lain yang mungkin sudah Mas buat di bawahnya tetap biarkan saja)
    protected $useTimestamps    = true;
}
