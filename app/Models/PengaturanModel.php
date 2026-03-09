<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table            = 'pengaturan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nama_sekolah',
        'alamat',
        'telepon',
        'email',
        'deskripsi_footer',
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
        'updated_at',
        'favicon',
        'meta_deskripsi',
        'meta_keywords',
        'logo',
        'slogan',
        'alamat_singkat',
        'link_maps',
        'link_whatsapp'
    ];
}
