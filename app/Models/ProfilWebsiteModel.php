<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilWebsiteModel extends Model
{
    protected $table            = 'profil_website';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kilas_balik_deskripsi',
        'kilas_balik_foto',
        'visi',
        'misi',
        'tentang_kami_judul',
        'tentang_kami_deskripsi',
        'tentang_kami_video_tipe',
        'tentang_kami_video',
        'updated_at'
    ];
}
