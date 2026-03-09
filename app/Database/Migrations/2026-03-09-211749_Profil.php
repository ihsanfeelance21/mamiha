<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Profil extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 1, 'unsigned' => true, 'auto_increment' => true],
            // Tentang Kami
            'tentang_judul'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'tentang_deskripsi' => ['type' => 'TEXT'],
            'tentang_video'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            // Sejarah / Kilas Balik
            'sejarah_deskripsi' => ['type' => 'TEXT'],
            'sejarah_foto'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            // Visi Misi
            'visi'              => ['type' => 'TEXT'],
            'misi'              => ['type' => 'TEXT'], // Bisa disimpan dengan format HTML list atau pisah baris
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('profil');
    }

    public function down()
    {
        $this->forge->dropTable('profil');
    }
}