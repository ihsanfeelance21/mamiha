<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kegiatan extends Migration
{
    public function up()
    {
        // Mendefinisikan kolom untuk tabel 'kegiatan'
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'slug'        => [ // Slug sangat penting untuk URL SEO Friendly (misal: /kegiatan/lomba-pramuka)
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
            ],
            'konten'      => [
                'type' => 'TEXT',
            ],
            'gambar'      => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true, // Boleh kosong jika tidak ada gambar
            ],
            'created_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Menjadikan 'id' sebagai Primary Key
        $this->forge->addKey('id', true);

        // Membuat tabel 'kegiatan'
        $this->forge->createTable('kegiatan');
    }

    public function down()
    {
        // Menghapus tabel jika kita melakukan 'rollback' (undo)
        $this->forge->dropTable('kegiatan');
    }
}
