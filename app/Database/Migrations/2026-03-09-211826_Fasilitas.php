<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Fasilitas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'icon'       => ['type' => 'VARCHAR', 'constraint' => 50], // Cth: fa-solid fa-computer
            'foto'       => ['type' => 'VARCHAR', 'constraint' => 255], // Cth: 170942823_kelas.jpg
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('fasilitas');
    }

    public function down()
    {
        $this->forge->dropTable('fasilitas');
    }
}