<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Berita extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_kategori' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'judul'       => ['type' => 'VARCHAR', 'constraint' => '255'],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => '255', 'unique' => true],
            'konten'      => ['type' => 'LONGTEXT'],
            'gambar'      => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'layout'      => ['type' => 'ENUM', 'constraint' => ['split', 'block', 'immersive'], 'default' => 'split'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_kategori', 'kategori_berita', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('berita');
    }

    public function down()
    {
        $this->forge->dropTable('berita');
    }
}
