<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WebSeeder extends Seeder
{
    public function run()
    {
        // 1. Data Dummy Gabungan untuk Tabel Pengaturan
        $dataPengaturan = [
            'id'               => 1,
            'nama_sekolah'     => "MA Mabadi'ul Ihsan",
            'meta_deskripsi'   => "Website Resmi MA Mabadi'ul Ihsan. Mencetak generasi unggul berwawasan global.",
            'meta_keywords'    => "madrasah, sekolah, mamiha, banyuwangi",
            'deskripsi_footer' => "Mencetak generasi yang unggul dalam IPTEK, kokoh dalam IMTAQ, dan berakhlakul karimah.",
            'alamat'           => "Jl. Pendidikan No. 1, Desa Contoh, Jawa Timur",
            'telepon'          => "(031) 1234567",
            'email'            => "info@mamiha.sch.id",
            'facebook'         => "https://facebook.com/mamiha",
            'instagram'        => "https://instagram.com/mamiha",
            'youtube'          => "https://youtube.com/mamiha",
            'updated_at'       => date('Y-m-d H:i:s')
        ];

        // 2. Data Dummy untuk Tabel Profil Website
        $dataProfil = [
            'kilas_balik_deskripsi'  => 'MA Mabadi\'ul Ihsan didirikan dengan semangat untuk mencetak generasi muslim yang tangguh.',
            'kilas_balik_foto'       => 'default.jpg',
            'visi'                   => 'Terwujudnya generasi muslim yang Berakhlakul Karimah dan Unggul.',
            'misi'                   => 'Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.',
            'tentang_kami_judul'     => 'Menjelajahi Lingkungan Belajar yang Inspiratif',
            'tentang_kami_deskripsi' => 'Kami tidak hanya mengajarkan ilmu pengetahuan, tetapi juga menanamkan nilai-nilai karakter yang kuat.',
            'tentang_kami_video_tipe' => 'youtube',
            'tentang_kami_video'     => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ',
            'updated_at'             => date('Y-m-d H:i:s'),
        ];

        // Gunakan replace() agar jika ID 1 sudah ada, datanya ditimpa (diupdate), bukan error
        $this->db->table('pengaturan')->replace($dataPengaturan);
        $this->db->table('profil_website')->replace($dataProfil);

        echo "✅ Data Seeder Pengaturan & Profil berhasil digabungkan dan dimasukkan!\n";
    }
}
