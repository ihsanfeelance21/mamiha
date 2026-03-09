<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahGambarMobile extends Migration
{
    public function up()
    {
        $this->forge->addColumn('hero_slider', [
            'gambar_mobile' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true, // Boleh kosong, nanti kita buat fallback ke gambar desktop
                'after'      => 'gambar' // Diletakkan setelah kolom gambar utama
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('hero_slider', 'gambar_mobile');
    }
}
