<?php

namespace App\Models;

use CodeIgniter\Model;

class HeroSliderModel extends Model
{
    protected $table            = 'hero_slider';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['gambar', 'gambar_mobile', 'label', 'judul', 'subjudul', 'btn1_teks', 'btn1_url', 'btn2_teks', 'btn2_url'];
    protected $useTimestamps    = true;
}
