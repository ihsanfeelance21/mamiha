<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaTagModel extends Model
{
    protected $table         = 'berita_tags';

    // Tabel pivot/jembatan biasanya tidak butuh primary key dan timestamps
    protected $allowedFields = ['id_berita', 'id_tag'];
}
