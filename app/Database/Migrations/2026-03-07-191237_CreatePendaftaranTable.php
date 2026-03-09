<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePendaftaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 1, 'unsigned' => true, 'auto_increment' => true],
            'poster'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'brosur'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tipe_daftar'    => ['type' => 'ENUM', 'constraint' => ['internal', 'eksternal'], 'default' => 'internal'],
            'link_daftar'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status_ppdb'    => ['type' => 'ENUM', 'constraint' => ['buka', 'tutup'], 'default' => 'tutup'],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pendaftaran');

        // Isi data awal (Seed otomatis)
        $db = \Config\Database::connect();
        $db->table('pendaftaran')->insert([
            'tipe_daftar' => 'internal',
            'status_ppdb' => 'tutup'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('pendaftaran');
    }
}
