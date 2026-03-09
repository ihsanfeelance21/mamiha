<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table            = 'pendaftaran';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['poster', 'brosur', 'tipe_daftar', 'link_daftar', 'status_ppdb', 'pesan_tutup', 'link_admin_ppdb', 'updated_at'];
}
