<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Prestasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kategori_prestasi' => ['type' => 'ENUM', 'constraint' => ['Siswa', 'Guru', 'Madrasah'], 'default' => 'Siswa'],
            'judul'             => ['type' => 'VARCHAR', 'constraint' => '255'],
            'slug'              => ['type' => 'VARCHAR', 'constraint' => '255', 'unique' => true],
            'konten'            => ['type' => 'LONGTEXT'],
            'gambar'            => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'layout'            => ['type' => 'ENUM', 'constraint' => ['split', 'block', 'immersive'], 'default' => 'split'],

            // Custom fields
            'juara'             => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'nama_lomba'        => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'nama_pemenang'     => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'kelas'             => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true],
            'nama_guru'         => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'nama_penghargaan'  => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'tahun_perolehan'   => ['type' => 'YEAR', 'null' => true],

            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('prestasi');
    }

    public function down()
    {
        $this->forge->dropTable('prestasi');
    }
}
