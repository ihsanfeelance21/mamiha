<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PerbaruiSlugPermission extends Migration
{
    /**
     * Peta konversi slug permission lama (broad) ke slug baru (granular).
     */
    private array $peta = [
        'kegiatan'   => ['kegiatan', 'berita', 'prestasi', 'pengumuman', 'kalender'],
        'profil'     => ['profil', 'bakat_minat', 'testimoni'],
        'alumni'     => ['alumni', 'universitas'],
        'pengaturan' => ['pengaturan', 'unduhan', 'akses_cepat'],
    ];

    public function up()
    {
        $db = $this->db;

        $rows = $db->table('user_permissions')->get()->getResultArray();
        if ($rows === []) {
            return;
        }

        // Kumpulkan permission existing per user agar tidak dobel
        $existing = [];
        foreach ($rows as $r) {
            $existing[$r['id_user']][$r['menu_slug']] = true;
        }

        // Hapus semua slug lama yang dipetakan
        $db->table('user_permissions')->whereIn('menu_slug', array_keys($this->peta))->delete();

        // Insert ulang permission baru (granular) berdasarkan yang lama
        foreach ($rows as $r) {
            if (! isset($this->peta[$r['menu_slug']])) {
                continue;
            }

            foreach ($this->peta[$r['menu_slug']] as $slugBaru) {
                if (! isset($existing[$r['id_user']][$slugBaru])) {
                    $db->table('user_permissions')->insert([
                        'id_user'   => $r['id_user'],
                        'menu_slug' => $slugBaru,
                    ]);
                }
            }
        }
    }

    public function down()
    {
        // Konversi tidak dapat dibalik secara otomatis (data lama sudah dihapus)
    }
}
