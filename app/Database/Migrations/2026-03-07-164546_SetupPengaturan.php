<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SetupPengaturan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 1, 'unsigned' => true, 'auto_increment' => true],
            'nama_sekolah'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'alamat'           => ['type' => 'TEXT'],
            'telepon'          => ['type' => 'VARCHAR', 'constraint' => 20],
            'email'            => ['type' => 'VARCHAR', 'constraint' => 50],
            'deskripsi_footer' => ['type' => 'TEXT'],
            'facebook'         => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'instagram'        => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'youtube'          => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('pengaturan');
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan');
    }
}
