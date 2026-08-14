<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LengkapiSkemaDatabase extends Migration
{
    public function up()
    {
        // ==========================================
        // PERBAIKAN TABEL BERITA (kolom status & waktu_tayang)
        // ==========================================
        $fields = $this->db->getFieldNames('berita');
        if (! in_array('status', $fields, true)) {
            $this->forge->addColumn('berita', [
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['draft', 'terjadwal', 'terbit'],
                    'default'    => 'draft',
                ],
            ]);
        }
        if (! in_array('waktu_tayang', $fields, true)) {
            $this->forge->addColumn('berita', [
                'waktu_tayang' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                ],
            ]);
        }

        // ==========================================
        // PERBAIKAN TABEL GURU_STAFF (kolom tambahan)
        // ==========================================
        $fields = $this->db->getFieldNames('guru_staff');
        foreach ([
            'pendidikan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'youtube'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'facebook'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'instagram'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tiktok'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'linkedin'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'cv_file'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ] as $kolom => $definisi) {
            if (! in_array($kolom, $fields, true)) {
                $this->forge->addColumn('guru_staff', [$kolom => $definisi]);
            }
        }

        // ==========================================
        // TABEL BARU: USERS (Autentikasi Admin)
        // ==========================================
        $this->forge->addField([
            'id_user'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => 255],
            'username'     => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'password'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'foto'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'role'         => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'admin'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('users', true);

        // ==========================================
        // TABEL BARU: USER_PERMISSIONS (Hak Akses Menu)
        // ==========================================
        $this->forge->addField([
            'id_perm'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'menu_slug' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id_perm', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_permissions', true);

        // ==========================================
        // TABEL BARU: LOGIN_LOGS (Catatan Login)
        // ==========================================
        $this->forge->addField([
            'id_log'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'user_agent' => ['type' => 'TEXT', 'null' => true],
            'login_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_log', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('login_logs', true);

        // ==========================================
        // TABEL BARU: GALERI (Album Foto)
        // ==========================================
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'deskripsi'  => ['type' => 'TEXT', 'null' => true],
            'sampul'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'tanggal'    => ['type' => 'DATE'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('galeri', true);

        // ==========================================
        // TABEL BARU: GALERI_FOTO
        // ==========================================
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'galeri_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_file'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('galeri_id', 'galeri', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('galeri_foto', true);

        // ==========================================
        // TABEL BARU: GALERI_VIDEO
        // ==========================================
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'link_video' => ['type' => 'VARCHAR', 'constraint' => 255],
            'orientasi'  => ['type' => 'ENUM', 'constraint' => ['landscape', 'portrait'], 'default' => 'landscape'],
            'tanggal'    => ['type' => 'DATE', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('galeri_video', true);

        // ==========================================
        // TABEL BARU: PENGUMUMAN
        // ==========================================
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'            => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'kategori'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'konten'          => ['type' => 'LONGTEXT'],
            'gambar'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tanggal_publish' => ['type' => 'DATE', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengumuman', true);

        // ==========================================
        // TABEL BARU: KALENDER_AKADEMIK
        // ==========================================
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'            => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'tanggal_mulai'   => ['type' => 'DATE'],
            'tanggal_selesai' => ['type' => 'DATE', 'null' => true],
            'deskripsi'       => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kalender_akademik', true);

        // ==========================================
        // TABEL BARU: UNDUHAN
        // ==========================================
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'kategori'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'file_unduhan'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'link_eksternal'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'keterangan'      => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('unduhan', true);

        // ==========================================
        // TABEL BARU: UNIVERSITAS
        // ==========================================
        $this->forge->addField([
            'id_universitas'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_universitas' => ['type' => 'VARCHAR', 'constraint' => 255],
            'logo'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'gambar_gedung'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_universitas', true);
        $this->forge->createTable('universitas', true);

        // ==========================================
        // TABEL BARU: ALUMNI
        // ==========================================
        $this->forge->addField([
            'id_alumni'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_alumni'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'tahun_lulus'         => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'id_universitas'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'usulan_universitas'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'jurusan'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'foto'                => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pesan_kesan'         => ['type' => 'TEXT', 'null' => true],
            'is_featured'         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'status'              => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'pending'],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_alumni', true);
        $this->forge->addKey('id_universitas');
        $this->forge->createTable('alumni', true);

        // ==========================================
        // TABEL BARU: TAGS
        // ==========================================
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_tag'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug_tag'       => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'link_eksternal' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tags', true);

        // ==========================================
        // TABEL BARU: BERITA_TAGS (Pivot)
        // ==========================================
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_berita' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_tag'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_berita', 'id_tag']);
        $this->forge->createTable('berita_tags', true);

        // ==========================================
        // TABEL BARU: PESAN_KONTAK
        // ==========================================
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'no_wa'      => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'kategori'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'pesan'      => ['type' => 'TEXT'],
            'status'     => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'belum dibaca'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pesan_kontak', true);

        // ==========================================
        // TABEL BARU: BAKAT_MINAT
        // ==========================================
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul'                 => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi'             => ['type' => 'TEXT', 'null' => true],
            'jadwal'                => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tipe_pembina'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'guru_id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'nama_pembina_manual'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'gambar'                => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'            => ['type' => 'DATETIME', 'null' => true],
            'updated_at'            => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bakat_minat', true);
    }

    public function down()
    {
        $this->forge->dropTable('bakat_minat', true);
        $this->forge->dropTable('pesan_kontak', true);
        $this->forge->dropTable('berita_tags', true);
        $this->forge->dropTable('tags', true);
        $this->forge->dropTable('alumni', true);
        $this->forge->dropTable('universitas', true);
        $this->forge->dropTable('unduhan', true);
        $this->forge->dropTable('kalender_akademik', true);
        $this->forge->dropTable('pengumuman', true);
        $this->forge->dropTable('galeri_video', true);
        $this->forge->dropTable('galeri_foto', true);
        $this->forge->dropTable('galeri', true);
        $this->forge->dropTable('login_logs', true);
        $this->forge->dropTable('user_permissions', true);
        $this->forge->dropTable('users', true);

        $this->forge->dropColumn('berita', ['status', 'waktu_tayang']);
        $this->forge->dropColumn('guru_staff', ['pendidikan', 'youtube', 'facebook', 'instagram', 'tiktok', 'linkedin', 'cv_file']);
    }
}
