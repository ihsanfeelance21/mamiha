<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahLogoPengaturan extends Migration
{
    public function up()
    {
        // Menambahkan kolom logo
        $this->forge->addColumn('pengaturan', [
            'logo' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pengaturan', 'logo');
    }
}
