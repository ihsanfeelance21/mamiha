<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGuruStaffTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'kategori' => [
                'type'       => 'ENUM',
                'constraint' => ['pimpinan', 'guru'],
                'default'    => 'guru',
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'sambutan' => [
                'type'       => 'TEXT',
                'null'       => true, // Khusus untuk pimpinan/kepala sekolah
            ],
            'urutan' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0, // Untuk mengatur siapa yang tampil duluan
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('guru_staff');
    }

    public function down()
    {
        $this->forge->dropTable('guru_staff');
    }
}
