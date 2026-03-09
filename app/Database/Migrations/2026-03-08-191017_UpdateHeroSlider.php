<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateHeroSlider extends Migration
{
    public function up()
    {
        // 1. Ubah kolom judul menjadi boleh kosong (NULL)
        $this->forge->modifyColumn('hero_slider', [
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);

        // 2. Tambahkan kolom untuk 2 tombol (teks dan url)
        $this->forge->addColumn('hero_slider', [
            'btn1_teks' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'btn1_url'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'btn2_teks' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'btn2_url'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('hero_slider', ['btn1_teks', 'btn1_url', 'btn2_teks', 'btn2_url']);
    }
}
