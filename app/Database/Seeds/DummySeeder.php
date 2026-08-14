<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DummySeeder extends Seeder
{
    private string $font;

    public function run()
    {
        $this->font = $this->deteksiFont();

        $this->bersihkanData();
        $this->seederPengaturan();
        $this->seederProfil();
        $this->seederHero();
        $this->seederKategoriBerita();
        $this->seederBerita();
        $this->seederTags();
        $this->seederPrestasi();
        $this->seederPengumuman();
        $this->seederKalender();
        $this->seederKegiatan();
        $this->seederGaleri();
        $this->seederVideo();
        $this->seederUnduhan();
        $this->seederTestimoni();
        $this->seederGuru();
        $this->seederBakat();
        $this->seederFasilitas();
        $this->seederPpdb();
        $this->seederUniversitas();
        $this->seederAlumni();
        $this->seederAksesCepat();
        $this->seederPesanKontak();

        echo "✅ Dummy data lengkap berhasil di-generate!\n";
    }

    // ============================================================
    // PEMBERSIHAN DATA & FOLDER UPLOAD
    // ============================================================

    private function deteksiFont(): string
    {
        $kandidat = [
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
            '/usr/share/fonts/TTF/DejaVuSans-Bold.ttf',
            '/usr/share/fonts/dejavu/DejaVuSans-Bold.ttf',
            'C:/Windows/Fonts/arialbd.ttf',
        ];

        foreach ($kandidat as $f) {
            if (is_file($f)) {
                return $f;
            }
        }

        return '';
    }

    private function bersihkanData()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        $tabel = [
            'berita_tags', 'tags', 'berita', 'kategori_berita',
            'galeri_foto', 'galeri_video', 'galeri',
            'fasilitas_galeri', 'fasilitas',
            'testimoni', 'guru_staff', 'bakat_minat',
            'prestasi', 'pengumuman', 'kalender_akademik', 'kegiatan',
            'unduhan', 'universitas', 'alumni', 'akses_cepat',
            'pesan_kontak', 'hero_slider', 'pendaftaran',
        ];
        foreach ($tabel as $t) {
            if ($this->db->tableExists($t)) {
                $this->db->table($t)->truncate();
            }
        }

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    private function bersihkanFolder(array $folder)
    {
        foreach ($folder as $f) {
            $dir = FCPATH . 'uploads/' . $f;
            if (! is_dir($dir)) {
                continue;
            }
            foreach (glob($dir . '/*') as $file) {
                $nama = basename($file);
                if ($nama !== '.htaccess' && $nama !== 'index.html') {
                    @unlink($file);
                }
            }
        }
    }

    // ============================================================
    // GENERATOR GAMBAR & PDF
    // ============================================================

    /**
     * Buat gambar placeholder PNG bergradasi hijau + teks.
     */
    private function buatGambar(string $folder, string $nama, int $w, int $h, string $judul, string $sub = ''): string
    {
        $dir = FCPATH . 'uploads/' . $folder;
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $img = imagecreatetruecolor($w, $h);

        // Gradasi horizontal hijau (#0B4A2D -> #00A859)
        $c1 = [11, 74, 45];
        $c2 = [0, 168, 89];
        for ($x = 0; $x < $w; $x++) {
            $t  = $x / max(1, $w - 1);
            $r  = (int) ($c1[0] + ($c2[0] - $c1[0]) * $t);
            $g  = (int) ($c1[1] + ($c2[1] - $c1[1]) * $t);
            $b  = (int) ($c1[2] + ($c2[2] - $c1[2]) * $t);
            imageline($img, $x, 0, $x, $h, imagecolorallocate($img, $r, $g, $b));
        }

        // Lingkaran dekoratif
        $lingkar = imagecolorallocatealpha($img, 255, 255, 255, 70);
        imagefilledellipse($img, (int) ($w * 0.9), (int) ($h * 0.12), (int) ($w * 0.45), (int) ($w * 0.45), $lingkar);
        imagefilledellipse($img, (int) ($w * 0.05), (int) ($h * 0.95), (int) ($w * 0.35), (int) ($w * 0.35), $lingkar);

        $putih = imagecolorallocate($img, 255, 255, 255);

        if ($this->font !== '') {
            $judul = mb_strtoupper($judul);
            $size  = max(20, (int) ($w / 13));
            $bbox  = imagettfbbox($size, 0, $this->font, $judul);
            $tw    = $bbox[2] - $bbox[0];
            $th    = $bbox[1] - $bbox[7];
            $x     = (int) (($w - $tw) / 2);
            $y     = (int) (($h - $th) / 2);
            imagettftext($img, $size, 0, $x, $y, $putih, $this->font, $judul);

            if ($sub !== '') {
                $ssize = max(14, (int) ($w / 26));
                $sbbox = imagettfbbox($ssize, 0, $this->font, $sub);
                $sw    = $sbbox[2] - $sbbox[0];
                imagettftext($img, $ssize, 0, (int) (($w - $sw) / 2), $y + $th + 36, $putih, $this->font, $sub);
            }

            // Footer nama madrasah
            $foot    = "MA MABADI'UL IHSAN";
            $fsize   = max(12, (int) ($w / 36));
            $fbbox   = imagettfbbox($fsize, 0, $this->font, $foot);
            $fw      = $fbbox[2] - $fbbox[0];
            $footCol = imagecolorallocatealpha($img, 255, 255, 255, 70);
            imagettftext($img, $fsize, 0, (int) (($w - $fw) / 2), $h - (int) ($h * 0.08), $footCol, $this->font, $foot);
        } else {
            imagestring($img, 5, (int) ($w * 0.1), (int) ($h / 2), $judul, $putih);
        }

        imagepng($img, $dir . '/' . $nama);
        imagedestroy($img);

        return $nama;
    }

    /**
     * Buat file PDF satu halaman sederhana.
     */
    private function buatPdf(string $folder, string $nama, string $judul): string
    {
        $dir = FCPATH . 'uploads/' . $folder;
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $judul  = str_replace(["\r", "\n"], ' ', $judul);
        $teks   = "MA MABADI'UL IHSAN -- " . $judul;
        $teks   = addcslashes($teks, "()\\");
        $stream = "BT /F1 20 Tf 72 760 Td (" . $teks . ") Tj ET";
        $len    = strlen($stream);

        $objects = [
            1 => '<</Type/Catalog/Pages 2 0 R>>',
            2 => '<</Type/Pages/Kids[3 0 R]/Count 1>>',
            3 => '<</Type/Page/Parent 2 0 R/MediaBox[0 0 595 842]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>',
            4 => '<</Length ' . $len . ">>\nstream\n" . $stream . "\nendstream",
            5 => '<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>',
        ];

        $pdf   = "%PDF-1.4\n";
        $offset = [];
        foreach ($objects as $id => $body) {
            $offset[$id] = strlen($pdf);
            $pdf .= $id . " 0 obj\n" . $body . "\nendobj\n";
        }
        $xrefStart = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        foreach ($offset as $off) {
            $pdf .= sprintf("%010d 00000 n \n", $off);
        }
        $pdf .= "trailer\n<</Size " . (count($objects) + 1) . "/Root 1 0 R>>\nstartxref\n" . $xrefStart . "\n%%EOF";

        file_put_contents($dir . '/' . $nama, $pdf);

        return $nama;
    }

    // ============================================================
    // PENGATURAN & PROFIL
    // ============================================================

    private function seederPengaturan()
    {
        $this->bersihkanFolder(['pengaturan']);

        $logo = $this->buatGambar('pengaturan', 'logo.png', 512, 512, 'MA', 'Mabadi\'ul Ihsan');
        $fav  = $this->buatGambar('pengaturan', 'favicon.png', 64, 64, 'MA');

        $this->db->table('pengaturan')->update([
            'nama_sekolah'     => "MA Mabadi'ul Ihsan",
            'slogan'           => 'Berakhlak Mulia, Berprestasi, dan Berdaya Saing Global',
            'alamat'           => 'Jl. KH. Ahmad Dahlan No. 12, Tegalsari, Kec. Tegalsari, Kab. Banyuwangi, Jawa Timur 68491',
            'alamat_singkat'   => 'Tegalsari, Banyuwangi, Jawa Timur',
            'telepon'          => '(0333) 512345',
            'email'            => 'info@mamabadiulihsan.sch.id',
            'deskripsi_footer' => 'Madrasah Aliyah berbasis pesantren yang memadukan pendidikan agama dan umum secara seimbang untuk mencetak generasi unggul, berakhlak mulia, dan berdaya saing global.',
            'facebook'         => 'https://facebook.com/mamabadiulihsan',
            'instagram'        => 'https://instagram.com/mamabadiulihsan',
            'youtube'          => 'https://youtube.com/@mamabadiulihsan',
            'tiktok'           => 'https://tiktok.com/@mamabadiulihsan',
            'link_whatsapp'    => 'https://wa.me/6281234567890',
            'link_maps'        => 'https://maps.google.com/?q=Tegalsari+Banyuwangi',
            'meta_deskripsi'   => "Website Resmi MA Mabadi'ul Ihsan Banyuwangi. Madrasah Aliyah berbasis pesantren dengan program Tahfidz, Bilingual Class, dan prestasi membanggakan.",
            'meta_keywords'    => 'madrasah aliyah, ma mabadiul ihsan, pesantren banyuwangi, sekolah tegalsari, tahfidz, pendaftaran siswa baru',
            'logo'             => $logo,
            'favicon'          => $fav,
            'updated_at'       => date('Y-m-d H:i:s'),
        ], ['id' => 1]);
    }

    private function seederProfil()
    {
        $this->bersihkanFolder(['profil']);

        $fotoKilas = $this->buatGambar('profil', 'kilas-balik.png', 1200, 800, 'Kilas Balik Madrasah');

        $this->db->table('profil_website')->update([
            'kilas_balik_deskripsi' => "MA Mabadi'ul Ihsan berdiri pada tahun 1998 di atas tanah wakaf seluas 2 hektar di Desa Tegalsari, Banyuwangi. Madrasah ini lahir dari semangat para tokoh masyarakat dan ulama setempat yang ingin menghadirkan lembaga pendidikan yang memadukan kurikulum nasional dengan penguatan pendidikan agama.\n\nSejak awal berdirinya, madrasah konsisten mengembangkan tiga pilar utama: tahfidzul Qur'an, penguasaan bahasa asing (Arab dan Inggris), serta pembinaan akhlak. Kini, MA Mabadi'ul Ihsan telah menjadi salah satu madrasah rujukan di wilayah Tapal Kuda dengan akreditasi A dan ribuan alumni yang tersebar di perguruan tinggi dalam dan luar negeri.",
            'visi'                   => "Terwujudnya generasi muslim yang unggul dalam prestasi, kokoh dalam keimanan, dan berakhlakul karimah.",
            'misi'                   => "Menyelenggarakan pembelajaran yang aktif, inovatif, dan menyenangkan berbasis teknologi.\nMenanamkan nilai-nilai keislaman dan akhlakul karimah dalam setiap aspek kehidupan madrasah.\nMengembangkan potensi, bakat, dan minat peserta didik secara optimal.\nMembangun kemitraan yang harmonis dengan orang tua, masyarakat, dan alumni.\nMenyiapkan lulusan yang siap melanjutkan ke perguruan tinggi terbaik.",
            'tentang_kami_judul'     => 'Menjelajahi Lingkungan Belajar yang Inspiratif',
            'tentang_kami_deskripsi' => "Kami percaya setiap anak memiliki cahaya potensi masing-masing. Di MA Mabadi'ul Ihsan, kami tidak hanya mengajarkan ilmu pengetahuan, tetapi juga menyalakan semangat, membentuk karakter, dan mendampingi setiap santri menemukan jalan terbaiknya menuju masa depan yang gemilang.",
            'tentang_kami_video_tipe' => 'link',
            'tentang_kami_video'     => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ',
            'kilas_balik_foto'       => $fotoKilas,
            'updated_at'             => date('Y-m-d H:i:s'),
        ], ['id' => 1]);
    }

    // ============================================================
    // HERO SLIDER
    // ============================================================

    private function seederHero()
    {
        $this->bersihkanFolder(['hero']);

        $slide = [
            [
                'label' => 'Penerimaan Santri Baru',
                'judul' => 'Membentuk Generasi Qur\'ani yang Unggul',
                'sub'   => 'Pendaftaran Peserta Didik Baru Tahun Ajaran 2026/2027 telah dibuka. Kuota terbatas!',
                'btn1'  => ['Daftar Sekarang', '/daftar'],
                'btn2'  => ['Profil Madrasah', '/profil/madrasah'],
            ],
            [
                'label' => 'Program Unggulan',
                'judul' => 'Tahfidz, Bilingual, dan Teknologi',
                'sub'   => 'Kurikulum terpadu untuk mencetak generasi yang siap bersaing di kancah nasional dan global.',
                'btn1'  => ['Lihat Berita', '/berita'],
                'btn2'  => ['Lihat Galeri', '/galeri'],
            ],
            [
                'label' => 'Prestasi Membanggakan',
                'judul' => 'Gerbang Menuju Kampus Impian',
                'sub'   => 'Ratusan alumni telah diterima di perguruan tinggi favorit dalam dan luar negeri.',
                'btn1'  => ['Lihat Prestasi', '/prestasi'],
                'btn2'  => ['Direktori Alumni', '/alumni'],
            ],
        ];

        foreach ($slide as $i => $s) {
            $desktop = $this->buatGambar('hero', 'hero-desktop-' . ($i + 1) . '.png', 1920, 1080, $s['judul'], $s['label']);
            $mobile  = $this->buatGambar('hero', 'hero-mobile-' . ($i + 1) . '.png', 1080, 1350, $s['judul'], $s['label']);

            $this->db->table('hero_slider')->insert([
                'gambar'        => $desktop,
                'gambar_mobile' => $mobile,
                'label'         => $s['label'],
                'judul'         => $s['judul'],
                'subjudul'      => $s['sub'],
                'btn1_teks'     => $s['btn1'][0],
                'btn1_url'      => $s['btn1'][1],
                'btn2_teks'     => $s['btn2'][0],
                'btn2_url'      => $s['btn2'][1],
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }

    // ============================================================
    // KATEGORI & BERITA
    // ============================================================

    private function seederKategoriBerita()
    {
        $kategori = [
            ['nama_kategori' => 'Akademik', 'slug_kategori' => 'akademik'],
            ['nama_kategori' => 'Keagamaan', 'slug_kategori' => 'keagamaan'],
            ['nama_kategori' => 'Prestasi', 'slug_kategori' => 'prestasi'],
            ['nama_kategori' => 'Pengumuman', 'slug_kategori' => 'pengumuman'],
        ];
        $this->db->table('kategori_berita')->insertBatch($kategori);
    }

    private function seederBerita()
    {
        $this->bersihkanFolder(['berita', 'berita/konten']);

        $kat = $this->db->table('kategori_berita')->select('id, slug_kategori')->get()->getResultArray();
        $map = [];
        foreach ($kat as $k) {
            $map[$k['slug_kategori']] = $k['id'];
        }

        $berita = [
            [
                'kat' => 'akademik', 'layout' => 'split',
                'judul' => 'Pembelajaran Tatap Muka Semester Genap 2026 Resmi Dimulai',
                'waktu' => '2026-07-20 07:00:00',
            ],
            [
                'kat' => 'prestasi', 'layout' => 'immersive',
                'judul' => 'Ahmad Fauzi Raih Juara 1 OSN Matematika Tingkat Kabupaten',
                'waktu' => '2026-08-05 09:00:00',
            ],
            [
                'kat' => 'keagamaan', 'layout' => 'block',
                'judul' => 'Kegiatan Pondok Ramadhan 1447 H Berjalan Khidmat',
                'waktu' => '2026-03-02 08:00:00',
            ],
            [
                'kat' => 'pengumuman', 'layout' => 'split',
                'judul' => 'Pendaftaran Peserta Didik Baru 2026/2027 Telah Dibuka',
                'waktu' => '2026-08-10 10:00:00',
            ],
            [
                'kat' => 'akademik', 'layout' => 'block',
                'judul' => 'Kunjungan Edukasi Siswa ke Museum dan Kampus Universitas',
                'waktu' => '2026-05-12 08:30:00',
            ],
            [
                'kat' => 'keagamaan', 'layout' => 'immersive',
                'judul' => 'Peringatan Hari Santri Nasional di MA Mabadi\'ul Ihsan',
                'waktu' => '2025-10-22 09:00:00',
            ],
            [
                'kat' => 'prestasi', 'layout' => 'split',
                'judul' => 'Tim Futsal Madrasah Juara 3 Turnamen Se-Karesidenan',
                'waktu' => '2026-06-14 15:00:00',
            ],
            [
                'kat' => 'akademik', 'layout' => 'block',
                'judul' => 'Pembekalan Ujian Akhir Semester Genap 2026',
                'waktu' => '2026-06-01 08:00:00',
            ],
            [
                'kat' => 'akademik', 'layout' => 'immersive',
                'judul' => 'Gelar Karya Proyek Penguatan Profil Pelajar Pancasila',
                'waktu' => '2026-04-28 09:00:00',
            ],
        ];

        $kontenContoh = [
            'akademik' => "<p>MA Mabadi'ul Ihsan resmi memulai kegiatan pembelajaran tatap muka semester genap tahun ajaran 2026/2027. Seluruh santri mengikuti kegiatan dengan penuh semangat dan antusias.</p><p>Dalam sambutannya, Kepala Madrasah menyampaikan bahwa semester ini akan difokuskan pada penguatan literasi, numerasi, serta pendalaman materi tahfidzul Qur'an.</p><p>Madrasah juga telah menyiapkan berbagai program unggulan untuk mendukung prestasi akademik dan non-akademik para santri.</p>",
            'prestasi' => "<p>Kabar membanggakan datang dari Ahmad Fauzi, siswa kelas XII IPA 1 MA Mabadi'ul Ihsan yang berhasil meraih Juara 1 Olimpiade Sains Nasional (OSN) bidang Matematika tingkat Kabupaten Banyuwangi.</p><p>Prestasi ini diraih setelah melalui seleksi ketat dan persiapan intensif bersama tim pembina. Selanjutnya, Ahmad akan mewakili kabupaten ke tingkat provinsi.</p><p>Kepala Madrasah mengapresiasi capaian ini dan berharap prestasi serupa terus ditorehkan oleh santri lainnya.</p>",
            'keagamaan' => "<p>Rangkaian Pondok Ramadhan 1447 H di MA Mabadi'ul Ihsan berjalan dengan khidmat. Selama bulan suci, para santri mengikuti pesantren kilat, tadarus, serta kajian keislaman secara terjadwal.</p><p>Puncak kegiatan ditutup dengan buka puasa bersama dan pembagian santunan kepada anak yatim di sekitar lingkungan madrasah.</p><p>Kegiatan ini menjadi wujud nyata pembinaan spiritual dan kepedulian sosial bagi seluruh civitas akademika.</p>",
            'pengumuman' => "<p>Pendaftaran Peserta Didik Baru MA Mabadi'ul Ihsan tahun ajaran 2026/2027 resmi dibuka. Kuota terbatas hanya 4 rombongan belajar.</p><p>Gelombang I dibuka mulai bulan Agustus 2026. Calon santri dapat mendaftar secara online melalui formulir yang tersedia atau menghubungi panitia PPDB.</p><p>Syarat dan ketentuan lengkap dapat dilihat pada halaman pendaftaran atau menghubungi admin melalui WhatsApp.</p>",
        ];

        foreach ($berita as $i => $b) {
            $judul    = $b['judul'];
            $slug     = url_title($judul, '-', true);
            $gambar   = $this->buatGambar('berita', 'berita-' . ($i + 1) . '.png', 800, 600, $b['judul'], $b['kat']);
            $konten   = $kontenContoh[$b['kat']] ?? $kontenContoh['akademik'];
            $fotoKonten = $this->buatGambar('berita/konten', 'konten-' . ($i + 1) . '.png', 1200, 675, 'Dokumentasi', $b['kat']);

            $this->db->table('berita')->insert([
                'id_kategori'  => $map[$b['kat']],
                'judul'        => $judul,
                'slug'         => $slug,
                'konten'       => $konten . '<p><img src="' . base_url('uploads/berita/konten/' . $fotoKonten) . '" alt="Dokumentasi kegiatan" style="width:100%;"></p><p>Demikian informasi yang dapat kami sampaikan. Semoga bermanfaat.</p>',
                'gambar'       => $gambar,
                'layout'       => $b['layout'],
                'status'       => 'terbit',
                'waktu_tayang' => $b['waktu'],
                'created_at'   => $b['waktu'],
                'updated_at'   => $b['waktu'],
            ]);
        }
    }

    private function seederTags()
    {
        $tags = [
            ['nama_tag' => 'Sepak Bola', 'slug_tag' => 'sepak-bola', 'link_eksternal' => null],
            ['nama_tag' => 'OSN', 'slug_tag' => 'osn', 'link_eksternal' => null],
            ['nama_tag' => 'Tahfidz', 'slug_tag' => 'tahfidz', 'link_eksternal' => null],
            ['nama_tag' => 'PPDB', 'slug_tag' => 'ppdb', 'link_eksternal' => 'https://www.kemenag.go.id'],
            ['nama_tag' => 'Robotik', 'slug_tag' => 'robotik', 'link_eksternal' => null],
        ];
        $this->db->table('tags')->insertBatch($tags);

        $idTags = $this->db->table('tags')->select('id')->orderBy('id', 'ASC')->get()->getResultArray();
        $idBerita = $this->db->table('berita')->select('id')->orderBy('id', 'ASC')->get()->getResultArray();

        $pivot = [];
        foreach ($idBerita as $i => $b) {
            $jml = 2 + ($i % 2); // 2-3 tag per berita
            for ($t = 0; $t < $jml; $t++) {
                $idxTag = ($i + $t) % count($idTags);
                $pivot[] = ['id_berita' => $b['id'], 'id_tag' => $idTags[$idxTag]['id']];
            }
        }
        $this->db->table('berita_tags')->insertBatch($pivot);
    }

    // ============================================================
    // PRESTASI
    // ============================================================

    private function seederPrestasi()
    {
        $this->bersihkanFolder(['prestasi']);

        $prestasi = [
            ['kategori_prestasi' => 'Siswa', 'judul' => 'Juara 1 OSN Matematika Tingkat Kabupaten', 'juara' => 'Juara 1', 'nama_lomba' => 'Olimpiade Sains Nasional Matematika', 'nama_pemenang' => 'Ahmad Fauzi', 'kelas' => 'XII IPA 1', 'nama_penghargaan' => 'Piala & Piagam Bupati', 'tahun' => '2026'],
            ['kategori_prestasi' => 'Siswa', 'judul' => 'Juara 2 O2SN Bulu Tangkis Putri', 'juara' => 'Juara 2', 'nama_lomba' => 'Olimpiade Olahraga Siswa Nasional', 'nama_pemenang' => 'Siti Nurhaliza', 'kelas' => 'XI IPA 2', 'nama_penghargaan' => 'Medali Perak', 'tahun' => '2025'],
            ['kategori_prestasi' => 'Guru', 'judul' => 'Guru Berprestasi Tingkat Provinsi Jawa Timur', 'juara' => 'Juara 1', 'nama_lomba' => 'Guru dan Tenaga Kependidikan Berprestasi', 'nama_guru' => 'Ustadz Abdullah Hakim, S.Pd.', 'nama_penghargaan' => 'Piagam Gubernur', 'tahun' => '2025'],
            ['kategori_prestasi' => 'Madrasah', 'judul' => 'Juara Umum LKS Tingkat KKM Madrasah', 'juara' => 'Juara Umum', 'nama_lomba' => 'Lomba Kompetensi Siswa MA', 'nama_penghargaan' => 'Piala Bergilir', 'tahun' => '2024'],
            ['kategori_prestasi' => 'Siswa', 'judul' => 'Juara 1 MTQ Cabang Tilawah', 'juara' => 'Juara 1', 'nama_lomba' => 'Musabaqoh Tilawatil Qur\'an', 'nama_pemenang' => 'Muhammad Rizal', 'kelas' => 'X Agama', 'nama_penghargaan' => 'Piagam & Trofi', 'tahun' => '2026'],
            ['kategori_prestasi' => 'Guru', 'judul' => 'Penulis Modul Ajar Terbaik Nasional', 'juara' => 'Terbaik', 'nama_lomba' => 'Lomba Inovasi Pembelajaran', 'nama_guru' => 'Ustadzah Aisyah, S.Pd.', 'nama_penghargaan' => 'Piagam Kemenag RI', 'tahun' => '2026'],
        ];

        foreach ($prestasi as $i => $p) {
            $gambar = $this->buatGambar('prestasi', 'prestasi-' . ($i + 1) . '.png', 800, 600, $p['judul'], $p['kategori_prestasi']);

            $this->db->table('prestasi')->insert([
                'kategori_prestasi' => $p['kategori_prestasi'],
                'judul'             => $p['judul'],
                'slug'              => url_title($p['judul'], '-', true) . '-' . uniqid(),
                'konten'            => "Prestasi membanggakan kembali ditorehkan oleh keluarga besar MA Mabadi'ul Ihsan. " . $p['judul'] . ". Capaian ini menjadi bukti nyata komitmen madrasah dalam membina potensi terbaik para santri dan pendidiknya.",
                'gambar'            => $gambar,
                'layout'            => 'split',
                'juara'             => $p['juara'],
                'nama_lomba'        => $p['nama_lomba'],
                'nama_pemenang'     => $p['nama_pemenang'] ?? null,
                'kelas'             => $p['kelas'] ?? null,
                'nama_guru'         => $p['nama_guru'] ?? null,
                'nama_penghargaan'  => $p['nama_penghargaan'],
                'tahun_perolehan'   => $p['tahun'],
                'created_at'        => date('Y-m-d H:i:s', strtotime("-" . ($i + 1) . " months")),
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
        }
    }

    // ============================================================
    // PENGUMUMAN
    // ============================================================

    private function seederPengumuman()
    {
        $this->bersihkanFolder(['pengumuman']);

        $pengumuman = [
            ['judul' => 'Pengumuman Hasil Seleksi Program Tahfidz Gelombang I', 'kategori' => 'Akademik', 'tanggal' => '2026-08-12', 'konten' => "Hasil seleksi program tahfidz Gelombang I telah diumumkan. Seluruh calon santri dapat melihat pengumuman di papan informasi madrasah atau menghubungi bagian kesiswaan.\n\nBagi yang dinyatakan lulus, diwajibkan mengikuti tes penempatan kelas tahfidz pada minggu pertama masuk."],
            ['judul' => 'Jadwal Ujian Akhir Semester Genap 2026', 'kategori' => 'Akademik', 'tanggal' => '2026-12-01', 'konten' => "Ujian Akhir Semester Genap tahun ajaran 2026/2027 akan dilaksanakan pada tanggal 7-13 Desember 2026.\n\nSantri wajib mempersiapkan diri dan mematuhi tata tertib ujian yang telah disosialisasikan oleh wali kelas masing-masing."],
            ['judul' => 'Info Pembagian Rapor Tengah Semester', 'kategori' => 'Informasi', 'tanggal' => '2026-09-28', 'konten' => "Pembagian rapor tengah semester genap akan dilaksanakan pada tanggal 28 September 2026 secara daring dan luring.\n\nOrang tua/wali diharapkan hadir untuk menerima laporan perkembangan belajar putra-putrinya."],
            ['judul' => 'Lowongan Tenaga Pengajar Bahasa Inggris', 'kategori' => 'Lowongan', 'tanggal' => '2026-08-15', 'konten' => "MA Mabadi'ul Ihsan membuka lowongan tenaga pengajar Bahasa Inggris untuk tahun ajaran 2026/2027.\n\nPersyaratan: lulusan S1 Pendidikan Bahasa Inggris, memiliki kompetensi mengajar, dan berkomitmen mendampingi santri. Berkas lamaran dikirim ke bagian administrasi madrasah paling lambat 30 Agustus 2026."],
        ];

        foreach ($pengumuman as $i => $p) {
            $gambar = $this->buatGambar('pengumuman', 'pengumuman-' . ($i + 1) . '.png', 800, 600, $p['judul'], $p['kategori']);

            $this->db->table('pengumuman')->insert([
                'judul'           => $p['judul'],
                'slug'            => url_title($p['judul'], '-', true) . '-' . time(),
                'kategori'        => $p['kategori'],
                'konten'          => $p['konten'],
                'gambar'          => $gambar,
                'tanggal_publish' => $p['tanggal'],
                'created_at'      => $p['tanggal'] . ' 08:00:00',
                'updated_at'      => $p['tanggal'] . ' 08:00:00',
            ]);
        }
    }

    // ============================================================
    // KALENDER AKADEMIK
    // ============================================================

    private function seederKalender()
    {
        $kalender = [
            ['judul' => 'MPLS Tahun Ajaran 2026/2027', 'mulai' => '2026-07-13', 'selesai' => '2026-07-15', 'deskripsi' => 'Masa Pengenalan Lingkungan Sekolah bagi santri baru.'],
            ['judul' => 'Awal Semester Genap', 'mulai' => '2026-07-20', 'selesai' => null, 'deskripsi' => 'Kegiatan pembelajaran semester genap dimulai.'],
            ['judul' => 'Peringatan HUT Kemerdekaan RI ke-81', 'mulai' => '2026-08-17', 'selesai' => null, 'deskripsi' => 'Lomba dan upacara peringatan kemerdekaan.'],
            ['judul' => 'Peringatan Maulid Nabi Muhammad SAW', 'mulai' => '2026-09-16', 'selesai' => null, 'deskripsi' => 'Peringatan Maulid Nabi beserta sholawat bersama.'],
            ['judul' => 'Ujian Tengah Semester Genap', 'mulai' => '2026-09-21', 'selesai' => '2026-09-26', 'deskripsi' => 'Pelaksanaan UTS semester genap.'],
            ['judul' => 'Pembagian Rapor Tengah Semester', 'mulai' => '2026-09-28', 'selesai' => null, 'deskripsi' => 'Pembagian rapor tengah semester kepada orang tua/wali.'],
            ['judul' => 'Ujian Akhir Semester Genap', 'mulai' => '2026-12-07', 'selesai' => '2026-12-13', 'deskripsi' => 'Pelaksanaan UAS semester genap.'],
            ['judul' => 'Class Meeting', 'mulai' => '2026-12-14', 'selesai' => '2026-12-17', 'deskripsi' => 'Ajang perlombaan antar kelas setelah UAS.'],
            ['judul' => 'Pembagian Rapor Semester Genap', 'mulai' => '2026-12-18', 'selesai' => null, 'deskripsi' => 'Pembagian rapor akhir semester.'],
            ['judul' => 'Libur Semester', 'mulai' => '2026-12-21', 'selesai' => '2027-01-02', 'deskripsi' => 'Libur akhir semester genap.'],
        ];

        foreach ($kalender as $k) {
            $this->db->table('kalender_akademik')->insert([
                'judul'           => $k['judul'],
                'slug'            => url_title($k['judul'], '-', true) . '-' . strtotime($k['mulai']),
                'tanggal_mulai'   => $k['mulai'],
                'tanggal_selesai' => $k['selesai'],
                'deskripsi'       => $k['deskripsi'],
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
        }
    }

    // ============================================================
    // KEGIATAN
    // ============================================================

    private function seederKegiatan()
    {
        $this->bersihkanFolder(['kegiatan']);

        $kegiatan = [
            'Latihan Kesenian Hadrah Rutin',
            'Pembinaan OSN Matematika dan IPA',
            'Ekstrakurikuler Futsal dan Voli',
            'Tahsin dan Tahfidz Al-Qur\'an Pagi',
            'Kegiatan Jumat Bersih dan Sehat',
            'Latihan Pramuka Penggalang',
        ];

        foreach ($kegiatan as $i => $judul) {
            $gambar = $this->buatGambar('kegiatan', 'kegiatan-' . ($i + 1) . '.png', 800, 600, $judul);

            $this->db->table('kegiatan')->insert([
                'judul'      => $judul,
                'slug'       => url_title($judul, '-', true),
                'konten'     => "Kegiatan " . $judul . " rutin dilaksanakan di lingkungan MA Mabadi'ul Ihsan. Kegiatan ini bertujuan untuk mengembangkan bakat, minat, dan karakter positif para santri di luar jam pembelajaran formal.\n\nSeluruh santri sangat antusias mengikuti kegiatan ini setiap pekannya. Pendampingan dilakukan oleh pembina yang kompeten di bidangnya masing-masing.",
                'gambar'     => $gambar,
                'created_at' => date('Y-m-d H:i:s', strtotime("-" . ($i + 1) . " weeks")),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    // ============================================================
    // GALERI FOTO & VIDEO
    // ============================================================

    private function seederGaleri()
    {
        $this->bersihkanFolder(['galeri', 'galeri/fotos']);

        $album = [
            ['judul' => 'Kegiatan MPLS Tahun Ajaran 2026/2027', 'tanggal' => '2026-07-14', 'deskripsi' => 'Momen seru Masa Pengenalan Lingkungan Sekolah bagi santri baru.'],
            ['judul' => 'Peringatan HUT Kemerdekaan RI ke-81', 'tanggal' => '2026-08-17', 'deskripsi' => 'Berbagai lomba dan upacara bendera dalam rangka memeriahkan hari kemerdekaan.'],
            ['judul' => 'Study Tour ke Yogyakarta', 'tanggal' => '2026-05-10', 'deskripsi' => 'Kunjungan edukatif santri ke museum, candi, dan universitas di Yogyakarta.'],
        ];

        foreach ($album as $i => $a) {
            $sampul = $this->buatGambar('galeri', 'sampul-' . ($i + 1) . '.png', 800, 600, $a['judul']);

            $this->db->table('galeri')->insert([
                'judul'      => $a['judul'],
                'slug'       => url_title($a['judul'], '-', true) . '-' . time(),
                'deskripsi'  => $a['deskripsi'],
                'sampul'     => $sampul,
                'tanggal'    => $a['tanggal'],
                'created_at' => $a['tanggal'] . ' 10:00:00',
                'updated_at' => $a['tanggal'] . ' 10:00:00',
            ]);

            $idGaleri = $this->db->insertID();

            for ($f = 1; $f <= 8; $f++) {
                $foto = $this->buatGambar('galeri/fotos', 'album-' . ($i + 1) . '-foto-' . $f . '.png', 1024, 768, 'Album ' . ($i + 1), 'Foto ' . $f);
                $this->db->table('galeri_foto')->insert([
                    'galeri_id' => $idGaleri,
                    'nama_file' => $foto,
                    'created_at' => $a['tanggal'] . ' 10:00:00',
                    'updated_at' => $a['tanggal'] . ' 10:00:00',
                ]);
            }
        }
    }

    private function seederVideo()
    {
        $video = [
            ['judul' => 'Video Profil Madrasah 2026', 'link' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ', 'orientasi' => 'landscape', 'tanggal' => '2026-07-01'],
            ['judul' => 'Momentum Wisuda Angkatan ke-26', 'link' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ', 'orientasi' => 'landscape', 'tanggal' => '2026-06-15'],
            ['judul' => 'Shorts - Kegiatan Pondok Ramadhan', 'link' => 'https://youtu.be/aqz-KE-bpKQ', 'orientasi' => 'portrait', 'tanggal' => '2026-03-10'],
            ['judul' => 'Profil Program Unggulan Tahfidz', 'link' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ', 'orientasi' => 'landscape', 'tanggal' => '2026-05-20'],
        ];

        foreach ($video as $v) {
            $this->db->table('galeri_video')->insert([
                'judul'      => $v['judul'],
                'link_video' => $v['link'],
                'orientasi'  => $v['orientasi'],
                'tanggal'    => $v['tanggal'],
                'created_at' => $v['tanggal'] . ' 10:00:00',
                'updated_at' => $v['tanggal'] . ' 10:00:00',
            ]);
        }
    }

    // ============================================================
    // UNDUHAN
    // ============================================================

    private function seederUnduhan()
    {
        $this->bersihkanFolder(['unduhan']);

        $pdf1 = $this->buatPdf('unduhan', 'kalender-akademik-2026-2027.pdf', 'Kalender Akademik 2026/2027');
        $pdf2 = $this->buatPdf('unduhan', 'prosedur-ppdb-2026.pdf', 'Prosedur Pendaftaran PPDB 2026/2027');
        $pdf3 = $this->buatPdf('unduhan', 'profil-madrasah.pdf', 'Profil Madrasah MA Mabadi\'ul Ihsan');

        $unduhan = [
            ['judul' => 'Kalender Akademik 2026/2027', 'kategori' => 'Akademik', 'file' => $pdf1, 'link' => null, 'ket' => 'Kalender akademik resmi untuk tahun ajaran 2026/2027.'],
            ['judul' => 'Prosedur Pendaftaran PPDB 2026/2027', 'kategori' => 'Pendaftaran', 'file' => $pdf2, 'link' => null, 'ket' => 'Panduan lengkap alur pendaftaran peserta didik baru.'],
            ['judul' => 'Profil Madrasah', 'kategori' => 'Akademik', 'file' => $pdf3, 'link' => null, 'ket' => 'Dokumen profil lengkap MA Mabadi\'ul Ihsan.'],
            ['judul' => 'Modul Literasi Digital', 'kategori' => 'Modul', 'file' => null, 'link' => 'https://www.kemdikbud.go.id', 'ket' => 'Modul pembelajaran literasi digital untuk santri.'],
            ['judul' => 'Aplikasi E-Learning Madrasah', 'kategori' => 'Aplikasi', 'file' => null, 'link' => 'https://elearning.kemenag.go.id', 'ket' => 'Akses pembelajaran daring berbasis madrasah.'],
        ];

        foreach ($unduhan as $u) {
            $this->db->table('unduhan')->insert([
                'judul'          => $u['judul'],
                'kategori'       => $u['kategori'],
                'file_unduhan'   => $u['file'],
                'link_eksternal' => $u['link'],
                'keterangan'     => $u['ket'],
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
        }
    }

    // ============================================================
    // TESTIMONI
    // ============================================================

    private function seederTestimoni()
    {
        $this->bersihkanFolder(['testimoni']);

        $testimoni = [
            ['nama' => 'Bapak Ahmad Subhan', 'status' => 'Wali Murid', 'rating' => 5, 'isi' => 'Alhamdulillah, sangat bersyukur anak kami bisa belajar di MA Mabadi\'ul Ihsan. Lingkungannya islami, gurunya sabar dan profesional.'],
            ['nama' => 'Ibu Fatimah Azzahra', 'status' => 'Wali Murid', 'rating' => 5, 'isi' => 'Pembinaan karakter dan tahfidznya luar biasa. Anak kami yang tadinya pemalu kini percaya diri tampil di depan umum.'],
            ['nama' => 'Ustadz Rizky Pratama', 'status' => 'Alumni 2021', 'rating' => 4, 'isi' => 'Pengalaman belajar di sini sangat berkesan. Dasar agama dan bahasa yang kuat membuat saya siap kuliah di luar kota.'],
            ['nama' => 'Siti Maulida', 'status' => 'Alumni 2022', 'rating' => 5, 'isi' => 'Terima kasih MA Mabadi\'ul Ihsan! Berkat bimbingan guru, saya diterima di perguruan tinggi negeri favorit melalui jalur prestasi.'],
            ['nama' => 'Bapak Joko Susilo', 'status' => 'Wali Murid', 'rating' => 4, 'isi' => 'Fasilitas madrasah cukup lengkap dan kegiatan ekstrakurikulernya beragam. Anak kami sangat betah di sini.'],
            ['nama' => 'Ahmad Fauzi', 'status' => 'Alumni 2025', 'rating' => 5, 'isi' => 'Madrasah ini benar-benar mencetak juara. Saya berhasil meraih prestasi OSN dan diterima di kampus impian berkat dukungan penuh para guru.'],
            ['nama' => 'Ibu Nur Hidayati', 'status' => 'Wali Murid', 'rating' => 5, 'isi' => 'Komunikasi antara madrasah dan orang tua sangat baik. Setiap perkembangan anak selalu diinformasikan dengan transparan.'],
            ['nama' => 'Muhammad Rizal', 'status' => 'Alumni 2024', 'rating' => 4, 'isi' => 'Kegiatan keagamaan dan pembinaan mental sangat kuat. Bekal yang saya dapatkan sangat berguna hingga sekarang.'],
            ['nama' => 'Bapak Samsul Arifin', 'status' => 'Wali Murid', 'rating' => 5, 'isi' => 'Biaya terjangkau namun mutu pendidikan tidak kalah dengan sekolah favorit. Sangat direkomendasikan.'],
            ['nama' => 'Dewi Lestari', 'status' => 'Alumni 2024', 'rating' => 5, 'isi' => 'Alumni sini tersebar di banyak kampus bagus. Jaringan alumni-nya juga solid dan saling mendukung.'],
        ];

        foreach ($testimoni as $i => $t) {
            $foto = $this->buatGambar('testimoni', 'testimoni-' . ($i + 1) . '.png', 300, 300, $t['nama']);

            $this->db->table('testimoni')->insert([
                'nama'          => $t['nama'],
                'status_user'   => $t['status'],
                'rating'        => $t['rating'],
                'isi_testimoni' => $t['isi'],
                'foto'          => $foto,
                'is_approved'   => 1,
                'created_at'    => date('Y-m-d H:i:s', strtotime("-" . ($i + 2) . " days")),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }

    // ============================================================
    // GURU & STAFF
    // ============================================================

    private function seederGuru()
    {
        $this->bersihkanFolder(['guru', 'cv']);

        $guru = [
            ['nama' => 'H. Abdurrahman Zainuri, M.Pd.', 'jabatan' => 'Kepala Madrasah', 'kategori' => 'pimpinan', 'urutan' => 1, 'pendidikan' => 'S2 Manajemen Pendidikan, UIN Malang', 'sambutan' => 'Assalamu\'alaikum warahmatullahi wabarakatuh. Selamat datang di MA Mabadi\'ul Ihsan. Kami berkomitmen menghadirkan pendidikan yang memadukan keunggulan akademik dan pembinaan akhlak mulia. Semoga kehadiran kami bermanfaat bagi kemajuan generasi bangsa.', 'cv' => true],
            ['nama' => 'Dra. Hj. Siti Aisyah', 'jabatan' => 'Waka Kurikulum', 'kategori' => 'pimpinan', 'urutan' => 2, 'pendidikan' => 'S1 Tadris Matematika, IAIN Jember', 'sambutan' => 'Kurikulum adalah nyawa pendidikan. Kami terus berinovasi agar pembelajaran berjalan aktif, kreatif, dan menyenangkan bagi seluruh santri.', 'cv' => false],
            ['nama' => 'Ustadz Abdullah Hakim, S.Pd.', 'jabatan' => 'Guru Matematika', 'kategori' => 'guru', 'urutan' => 1, 'pendidikan' => 'S1 Pendidikan Matematika, UNEJ', 'sambutan' => 'Matematika itu menyenangkan bila dipahami dengan cara yang tepat. Saya senang membimbing santri menaklukkan angka dan logika.', 'cv' => false],
            ['nama' => 'Ustadzah Aisyah, S.Pd.', 'jabatan' => 'Guru Bahasa Indonesia', 'kategori' => 'guru', 'urutan' => 2, 'pendidikan' => 'S1 Pendidikan Bahasa Indonesia, UNEJ', 'sambutan' => 'Bahasa adalah jendela dunia. Mari kita bersama membiasakan literasi dan menulis sejak dini.', 'cv' => false],
            ['nama' => 'Ustadz Fahmi Ramadhan, S.Pd.', 'jabatan' => 'Guru Biologi', 'kategori' => 'guru', 'urutan' => 3, 'pendidikan' => 'S1 Pendidikan Biologi, UNAIR', 'sambutan' => 'Mengamati ciptaan Allah melalui sains adalah ibadah. Saya mengajak santri mencintai alam melalui eksperimen dan pengamatan.', 'cv' => false],
            ['nama' => 'Ustadzah Nurul Hidayah, M.Pd.', 'jabatan' => 'Guru Fisika', 'kategori' => 'guru', 'urutan' => 4, 'pendidikan' => 'S2 Pendidikan Fisika, ITS', 'sambutan' => 'Fisika mengajarkan kita berpikir sistematis dan rasional. Semoga santri-santri kita kelak menjadi ilmuwan yang bermanfaat.', 'cv' => false],
            ['nama' => 'Ustadz Ahmad Zaki, S.Pd.', 'jabatan' => 'Guru Bahasa Inggris', 'kategori' => 'guru', 'urutan' => 5, 'pendidikan' => 'S1 Pendidikan Bahasa Inggris, UNEJ', 'sambutan' => 'Kuasai bahasa, kuasai dunia. Kami membiasakan percakapan bilingual di lingkungan madrasah.', 'cv' => false],
            ['nama' => 'Ustadzah Khadijah, S.Ag.', 'jabatan' => 'Guru Pendidikan Agama Islam', 'kategori' => 'guru', 'urutan' => 6, 'pendidikan' => 'S1 Pendidikan Agama Islam, UIN Malang', 'sambutan' => 'Menanamkan akidah dan akhlak adalah tugas mulia. Semoga setiap santri tumbuh menjadi pribadi yang taat dan berbudi pekerti luhur.', 'cv' => false],
            ['nama' => 'Ustadz Yusuf Alamsyah, S.Pd.', 'jabatan' => 'Guru Sejarah', 'kategori' => 'guru', 'urutan' => 7, 'pendidikan' => 'S1 Pendidikan Sejarah, UNEJ', 'sambutan' => 'Belajar sejarah adalah belajar dari masa lalu untuk melangkah lebih baik ke depan.', 'cv' => false],
            ['nama' => 'Ustadz Hasan Basri, S.Pd.', 'jabatan' => 'Guru PJOK', 'kategori' => 'guru', 'urutan' => 8, 'pendidikan' => 'S1 Pendidikan Jasmani, UNESA', 'sambutan' => 'Jasmani yang sehat menunjang jiwa yang kuat. Mari berolahraga dan berprestasi.', 'cv' => false],
            ['nama' => 'Ibu Lailatul Fitri', 'jabatan' => 'Staf Tata Usaha', 'kategori' => 'staff', 'urutan' => 1, 'pendidikan' => 'D3 Administrasi, Politeknik Banyuwangi', 'sambutan' => '', 'cv' => false],
            ['nama' => 'Bapak Imam Syafi\'i', 'jabatan' => 'Pustakawan', 'kategori' => 'staff', 'urutan' => 2, 'pendidikan' => 'S1 Ilmu Perpustakaan, UIN Malang', 'sambutan' => '', 'cv' => false],
        ];

        foreach ($guru as $i => $g) {
            $foto = $this->buatGambar('guru', 'guru-' . ($i + 1) . '.png', 600, 800, $g['nama'], $g['jabatan']);
            $cvFile = null;
            if ($g['cv']) {
                $cvFile = $this->buatPdf('cv', 'cv-guru-' . ($i + 1) . '.pdf', 'Curriculum Vitae - ' . $g['nama']);
            }

            $this->db->table('guru_staff')->insert([
                'nama'       => $g['nama'],
                'jabatan'    => $g['jabatan'],
                'kategori'   => $g['kategori'],
                'foto'       => $foto,
                'sambutan'   => $g['sambutan'],
                'urutan'     => $g['urutan'],
                'pendidikan' => $g['pendidikan'],
                'cv_file'    => $cvFile,
                'youtube'    => 'https://youtube.com/@mamabadiulihsan',
                'facebook'   => 'https://facebook.com/mamabadiulihsan',
                'instagram'  => 'https://instagram.com/mamabadiulihsan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    // ============================================================
    // BAKAT MINAT
    // ============================================================

    private function seederBakat()
    {
        $this->bersihkanFolder(['bakat']);

        $guru = $this->db->table('guru_staff')->select('id')->where('kategori', 'guru')->orderBy('id', 'ASC')->get()->getResultArray();

        $bakat = [
            ['judul' => 'Futsal', 'deskripsi' => 'Pembinaan tim futsal madrasah dengan latihan rutin dan mengikuti berbagai turnamen antar sekolah.', 'jadwal' => 'Senin & Kamis, 15.30-17.00 WIB', 'tipe' => 'guru', 'guru' => $guru[7]['id'] ?? null, 'manual' => null],
            ['judul' => 'Tahfidz Al-Qur\'an', 'deskripsi' => 'Program menghafal Al-Qur\'an dengan metode yang menyenangkan, bersanad, dan didampingi pembina berpengalaman.', 'jadwal' => 'Setiap Hari, 05.00-06.00 WIB', 'tipe' => 'manual', 'guru' => null, 'manual' => 'Ustadz Muhammad Ridho, Lc.'],
            ['judul' => 'Robotik', 'deskripsi' => 'Eksplorasi sains dan teknologi melalui perakitan serta pemrograman robot untuk lomba maupun kreativitas.', 'jadwal' => 'Sabtu, 09.00-11.00 WIB', 'tipe' => 'manual', 'guru' => null, 'manual' => 'Bapak Andi Pratama, S.T.'],
            ['judul' => 'Jurnalistik', 'deskripsi' => 'Pengembangan keterampilan menulis, reportase, dan produksi konten digital majalah dinding madrasah.', 'jadwal' => 'Rabu, 15.30-17.00 WIB', 'tipe' => 'guru', 'guru' => $guru[1]['id'] ?? null, 'manual' => null],
        ];

        foreach ($bakat as $i => $b) {
            $gambar = $this->buatGambar('bakat', 'bakat-' . ($i + 1) . '.png', 800, 600, $b['judul']);

            $this->db->table('bakat_minat')->insert([
                'judul'               => $b['judul'],
                'deskripsi'           => $b['deskripsi'],
                'jadwal'              => $b['jadwal'],
                'tipe_pembina'        => $b['tipe'],
                'guru_id'             => $b['guru'],
                'nama_pembina_manual' => $b['manual'],
                'gambar'              => $gambar,
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s'),
            ]);
        }
    }

    // ============================================================
    // FASILITAS
    // ============================================================

    private function seederFasilitas()
    {
        $this->bersihkanFolder(['fasilitas', 'fasilitas/galeri']);

        $fasilitas = [
            ['judul' => 'Perpustakaan Digital', 'icon' => 'fa-book-open-reader', 'deskripsi' => 'Perpustakaan dengan koleksi ribuan buku cetak dan digital yang dapat diakses santri untuk menunjang literasi.'],
            ['judul' => 'Laboratorium Komputer', 'icon' => 'fa-laptop-code', 'deskripsi' => 'Lab komputer modern dengan 40 unit PC untuk pembelajaran TIK, robotik, dan ujian berbasis komputer.'],
            ['judul' => 'Masjid & Pondok', 'icon' => 'fa-mosque', 'deskripsi' => 'Masjid kapasitas 1.000 jamaah sebagai pusat kegiatan ibadah, tahfidz, dan pembinaan spiritual.'],
            ['judul' => 'Aula Serbaguna', 'icon' => 'fa-building-columns', 'deskripsi' => 'Aula luas yang digunakan untuk kegiatan resmi, seminar, wisuda, dan pentas seni santri.'],
        ];

        foreach ($fasilitas as $i => $f) {
            $cover = $this->buatGambar('fasilitas', 'fasilitas-' . ($i + 1) . '.png', 800, 600, $f['judul']);

            $this->db->table('fasilitas')->insert([
                'judul'      => $f['judul'],
                'icon'       => $f['icon'],
                'deskripsi'  => $f['deskripsi'],
                'foto_cover' => $cover,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $idFas = $this->db->insertID();

            for ($g = 1; $g <= 2; $g++) {
                $foto = $this->buatGambar('fasilitas/galeri', 'fasilitas-' . ($i + 1) . '-galeri-' . $g . '.png', 1024, 768, $f['judul'], 'Foto ' . $g);
                $this->db->table('fasilitas_galeri')->insert([
                    'fasilitas_id' => $idFas,
                    'foto'         => $foto,
                    'created_at'   => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    // ============================================================
    // PPDB
    // ============================================================

    private function seederPpdb()
    {
        $this->bersihkanFolder(['ppdb']);

        $poster = $this->buatGambar('ppdb', 'poster-ppdb-2026.png', 600, 850, 'PPDB 2026/2027', 'Membuka Pendaftaran');
        $brosur = $this->buatPdf('ppdb', 'brosur-ppdb-2026.pdf', 'Brosur PPDB Tahun Ajaran 2026/2027');

        $this->db->table('pendaftaran')->insert([
            'poster'         => $poster,
            'brosur'         => $brosur,
            'tipe_daftar'    => 'internal',
            'link_daftar'    => '',
            'status_ppdb'    => 'buka',
            'pesan_tutup'    => 'Mohon maaf, pendaftaran peserta didik baru saat ini telah ditutup. Silakan hubungi admin melalui WhatsApp untuk informasi lebih lanjut.',
            'link_admin_ppdb' => 'https://wa.me/6281234567890',
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);
    }

    // ============================================================
    // UNIVERSITAS & ALUMNI
    // ============================================================

    private function seederUniversitas()
    {
        $this->bersihkanFolder(['universitas', 'gedung']);

        $univ = [
            'Universitas Gadjah Mada',
            'Universitas Airlangga',
            'Institut Pertanian Bogor',
            'Universitas Negeri Jember',
            'Institut Teknologi Sepuluh Nopember',
        ];

        foreach ($univ as $i => $nama) {
            $logo  = $this->buatGambar('universitas', 'univ-' . ($i + 1) . '-logo.png', 400, 400, 'Kampus', ($i + 1));
            $gedung = $this->buatGambar('gedung', 'gedung-' . ($i + 1) . '.png', 800, 600, $nama);

            $this->db->table('universitas')->insert([
                'nama_universitas' => $nama,
                'logo'             => $logo,
                'gambar_gedung'    => $gedung,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ]);
        }
    }

    private function seederAlumni()
    {
        $this->bersihkanFolder(['alumni']);

        $univ = $this->db->table('universitas')->select('id_universitas, nama_universitas')->orderBy('id_universitas', 'ASC')->get()->getResultArray();

        $alumni = [
            ['nama' => 'Ahmad Fauzi', 'tahun' => '2025', 'univ' => $univ[0]['id_universitas'], 'jurusan' => 'Matematika', 'featured' => 1, 'pesan' => 'Terima kasih MA Mabadi\'ul Ihsan atas segala bimbingan dan doanya. Berkat madrasah, saya bisa menembus kampus impian.'],
            ['nama' => 'Siti Nurhaliza', 'tahun' => '2025', 'univ' => $univ[1]['id_universitas'], 'jurusan' => 'Kedokteran', 'featured' => 1, 'pesan' => 'Madrasah mengajarkan saya disiplin dan ikhlas dalam belajar. Sekarang saya kuliah di fakultas yang saya impikan sejak dulu.'],
            ['nama' => 'Muhammad Rizal', 'tahun' => '2024', 'univ' => $univ[3]['id_universitas'], 'jurusan' => 'Hukum', 'featured' => 0, 'pesan' => 'Kegiatan keagamaan dan organisasi di madrasah membentuk jiwa kepemimpinan saya hingga sekarang.'],
            ['nama' => 'Dewi Lestari', 'tahun' => '2024', 'univ' => $univ[1]['id_universitas'], 'jurusan' => 'Ilmu Komunikasi', 'featured' => 0, 'pesan' => 'Pembiasaan bilingual di madrasah sangat membantu kuliah dan berorganisasi.'],
            ['nama' => 'Budi Santoso', 'tahun' => '2023', 'univ' => $univ[4]['id_universitas'], 'jurusan' => 'Teknik Informatika', 'featured' => 1, 'pesan' => 'Dari lab komputer madrasah, saya jatuh cinta pada dunia pemrograman. Kini saya belajar di kampus teknik favorit.'],
            ['nama' => 'Fitri Handayani', 'tahun' => '2023', 'univ' => $univ[2]['id_universitas'], 'jurusan' => 'Agribisnis', 'featured' => 0, 'pesan' => 'Nilai-nilai kejujuran dan kerja keras yang ditanamkan madrasah sangat berguna di bangku kuliah.'],
            ['nama' => 'Rizki Ramadhan', 'tahun' => '2022', 'univ' => $univ[0]['id_universitas'], 'jurusan' => 'Teknik Sipil', 'featured' => 0, 'pesan' => 'Alhamdulillah, saya lulusan yang bangga menyandang nama MA Mabadi\'ul Ihsan.'],
            ['nama' => 'Nur Aini', 'tahun' => '2022', 'univ' => $univ[3]['id_universitas'], 'jurusan' => 'Farmasi', 'featured' => 0, 'pesan' => 'Terima kasih para guru yang selalu sabar membimbing. Doa dan dukungan kalian mengantarkan saya sukses.'],
        ];

        foreach ($alumni as $i => $a) {
            $foto = $this->buatGambar('alumni', 'alumni-' . ($i + 1) . '.png', 600, 750, $a['nama']);

            $this->db->table('alumni')->insert([
                'nama_alumni'        => $a['nama'],
                'tahun_lulus'        => $a['tahun'],
                'id_universitas'     => $a['univ'],
                'usulan_universitas' => null,
                'jurusan'            => $a['jurusan'],
                'foto'               => $foto,
                'pesan_kesan'        => $a['pesan'],
                'is_featured'        => $a['featured'],
                'status'             => 'approved',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ]);
        }
    }

    // ============================================================
    // AKSES CEPAT & PESAN KONTAK
    // ============================================================

    private function seederAksesCepat()
    {
        $link = [
            ['nama_link' => 'Kementerian Agama RI', 'url_link' => 'https://www.kemenag.go.id'],
            ['nama_link' => 'EMIS Pendis', 'url_link' => 'https://emispendis.kemenag.go.id'],
            ['nama_link' => 'Pangkalan Data Madrasah', 'url_link' => 'https://madrasah.kemenag.go.id'],
            ['nama_link' => 'PDSS SNPMB', 'url_link' => 'https://pdss-snpmb.id'],
            ['nama_link' => 'Portal E-Learning', 'url_link' => 'https://elearning.kemenag.go.id'],
        ];

        foreach ($link as $l) {
            $this->db->table('akses_cepat')->insert([
                'nama_link' => $l['nama_link'],
                'url_link'  => $l['url_link'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    private function seederPesanKontak()
    {
        $pesan = [
            ['nama' => 'Bapak Hendra Gunawan', 'email' => 'hendra@gmail.com', 'no_wa' => '081234567801', 'kategori' => 'PPDB', 'pesan' => 'Selamat siang, saya ingin menanyakan informasi pendaftaran siswa baru untuk anak saya. Apa saja persyaratannya?', 'status' => 'belum dibaca'],
            ['nama' => 'Ibu Rina Wahyuni', 'email' => 'rina@yahoo.com', 'no_wa' => '081234567802', 'kategori' => 'Kerjasama', 'pesan' => 'Kami dari lembaga bimbingan belajar ingin mengajukan kerjasama program pelatihan di madrasah. Mohon info lebih lanjut.', 'status' => 'sudah dibaca'],
            ['nama' => 'Ustadz Ridwan', 'email' => 'ridwan@gmail.com', 'no_wa' => '081234567803', 'kategori' => 'Lainnya', 'pesan' => 'Terima kasih atas penyelenggaraan kajian yang sangat bermanfaat. Semoga madrasah semakin maju dan berkah.', 'status' => 'belum dibaca'],
        ];

        foreach ($pesan as $p) {
            $this->db->table('pesan_kontak')->insert([
                'nama'       => $p['nama'],
                'email'      => $p['email'],
                'no_wa'      => $p['no_wa'],
                'kategori'   => $p['kategori'],
                'pesan'      => $p['pesan'],
                'status'     => $p['status'],
                'created_at' => date('Y-m-d H:i:s', strtotime("-" . random_int(1, 10) . " days")),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
