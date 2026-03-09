<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatHeroSlider extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'gambar'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'label'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'judul'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'subjudul'    => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('hero_slider');
    }

    public function down()
    {
        $this->forge->dropTable('hero_slider');
    }
}
