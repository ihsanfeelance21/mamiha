<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahPengaturanTutupPPDB extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pendaftaran', [
            'pesan_tutup'     => ['type' => 'TEXT', 'null' => true],
            'link_admin_ppdb' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pendaftaran', ['pesan_tutup', 'link_admin_ppdb']);
    }
}
