<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id'               => 1,
            'nama_sekolah'     => "MA Mabadi'ul Ihsan",
            'alamat'           => "Jl. Pendidikan No. 1, Desa Contoh, Jawa Timur",
            'telepon'          => "(031) 1234567",
            'email'            => "info@mamiha.sch.id",
            'deskripsi_footer' => "Mencetak generasi yang unggul dalam IPTEK, kokoh dalam IMTAQ, dan berakhlakul karimah.",
            'facebook'         => "https://facebook.com/mamiha",
            'instagram'        => "https://instagram.com/mamiha",
            'youtube'          => "https://youtube.com/mamiha",
            'updated_at'       => date('Y-m-d H:i:s')
        ];

        // Masukkan data ke tabel pengaturan
        $this->db->table('pengaturan')->insert($data);
    }
}
