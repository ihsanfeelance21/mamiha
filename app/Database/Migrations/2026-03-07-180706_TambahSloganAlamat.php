<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahSloganAlamat extends Migration
{
    public function up()
    {
        // Menambahkan kolom slogan dan alamat_singkat
        $this->forge->addColumn('pengaturan', [
            'slogan'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'alamat_singkat' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pengaturan', ['slogan', 'alamat_singkat']);
    }
}
