<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahLinkAkses extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pengaturan', [
            'link_maps'     => ['type' => 'TEXT', 'null' => true],
            'link_whatsapp' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pengaturan', ['link_maps', 'link_whatsapp']);
    }
}
