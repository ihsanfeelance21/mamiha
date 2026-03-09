<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahFaviconMeta extends Migration
{
    public function up()
    {
        // Menambahkan 3 kolom baru ke tabel pengaturan
        $this->forge->addColumn('pengaturan', [
            'favicon'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_deskripsi' => ['type' => 'TEXT', 'null' => true],
            'meta_keywords'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
    }

    public function down()
    {
        // Menghapus kolom jika kita melakukan rollback
        $this->forge->dropColumn('pengaturan', ['favicon', 'meta_deskripsi', 'meta_keywords']);
    }
}
