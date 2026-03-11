<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SetupProfilFasilitas extends Migration
{
    public function up()
    {
        // --- TAMBAHKAN 3 BARIS INI UNTUK MENGHAPUS TABEL LAMA JIKA ADA ---
        $this->forge->dropTable('fasilitas_galeri', true);
        $this->forge->dropTable('fasilitas', true);
        $this->forge->dropTable('profil_website', true);
        // -----------------------------------------------------------------

        // ==========================================
        // 1. TABEL PROFIL WEBSITE (Kilas Balik, Visi Misi, Tentang Kami)
        // ==========================================
        $this->forge->addField([
            'id'                     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kilas_balik_deskripsi'  => ['type' => 'TEXT', 'null' => true],
            'kilas_balik_foto'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'visi'                   => ['type' => 'TEXT', 'null' => true],
            'misi'                   => ['type' => 'TEXT', 'null' => true],
            'tentang_kami_judul'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tentang_kami_deskripsi' => ['type' => 'TEXT', 'null' => true],
            'tentang_kami_video_tipe' => ['type' => 'ENUM', 'constraint' => ['upload', 'link'], 'default' => 'link'],
            'tentang_kami_video'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'updated_at'             => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('profil_website');

        // Insert Default Data
        $dataDefault = [
            'kilas_balik_deskripsi'  => 'Tulis sejarah singkat madrasah di sini...',
            'visi'                   => 'Tulis visi madrasah di sini...',
            'misi'                   => 'Tulis misi madrasah di sini...',
            'tentang_kami_judul'     => 'Mengenal Lebih Dekat Madrasah Kami',
            'tentang_kami_deskripsi' => 'Deskripsi singkat tentang kami...',
            'tentang_kami_video_tipe' => 'link',
            'tentang_kami_video'     => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'updated_at'             => date('Y-m-d H:i:s'),
        ];
        $this->db->table('profil_website')->insert($dataDefault);


        // ==========================================
        // 2. TABEL FASILITAS (Data Utama / Card)
        // ==========================================
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'icon'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'judul'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi'   => ['type' => 'TEXT', 'null' => true],
            'foto_cover'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // Foto utama untuk background card
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('fasilitas');


        // ==========================================
        // 3. TABEL FASILITAS GALERI (Foto-foto Popup)
        // ==========================================
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'fasilitas_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true], // Relasi ke tabel fasilitas
            'foto'         => ['type' => 'VARCHAR', 'constraint' => 255], // Nama file foto galeri
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);

        // Membuat foreign key (Jika fasilitas dihapus, galerinya otomatis terhapus)
        $this->forge->addForeignKey('fasilitas_id', 'fasilitas', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('fasilitas_galeri');
    }

    public function down()
    {
        // Drop tabel harus berurutan dari anaknya dulu (karena ada foreign key)
        $this->forge->dropTable('fasilitas_galeri');
        $this->forge->dropTable('fasilitas');
        $this->forge->dropTable('profil_website');
    }
}
