<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Testimoni extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'status_user'   => ['type' => 'VARCHAR', 'constraint' => 100], // Cth: Alumni 2020, Wali Murid
            'rating'        => ['type' => 'INT', 'constraint' => 1], // Angka 1-5 untuk bintang
            'isi_testimoni' => ['type' => 'TEXT'],
            'foto'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_approved'   => ['type' => 'BOOLEAN', 'default' => false], // 0 = Pending/Reject, 1 = Approved
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('testimoni');
    }

    public function down()
    {
        $this->forge->dropTable('testimoni');
    }
}