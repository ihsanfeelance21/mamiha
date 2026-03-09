<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahTiktok extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pengaturan', [
            'tiktok' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pengaturan', 'tiktok');
    }
}
