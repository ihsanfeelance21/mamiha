-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 12, 2026 at 05:31 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mamiha_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses_cepat`
--

CREATE TABLE `akses_cepat` (
  `id` int UNSIGNED NOT NULL,
  `nama_link` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `url_link` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bakat_minat`
--

CREATE TABLE `bakat_minat` (
  `id` int UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `jadwal` varchar(255) NOT NULL,
  `tipe_pembina` enum('guru','manual') NOT NULL DEFAULT 'guru',
  `guru_id` int UNSIGNED DEFAULT NULL,
  `nama_pembina_manual` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bakat_minat`
--

INSERT INTO `bakat_minat` (`id`, `judul`, `deskripsi`, `jadwal`, `tipe_pembina`, `guru_id`, `nama_pembina_manual`, `gambar`, `created_at`, `updated_at`) VALUES
(2, 'Pramuka', 'Kegiatan ekstra setiap sabtu', 'Sabtu, 08.00 - 09.00 WIB', 'manual', NULL, 'Bpk, Satria', '1773286523_d03b3ce85bfae2acd067.jpg', '2026-03-12 03:35:23', '2026-03-12 04:07:34'),
(4, 'Ko-Kurikuler', 'apaja ok', 'Sabtu, 08.00 - 09.00 WIB', 'guru', 14, NULL, '1773289179_c1e48680553199b0fd5a.jpg', '2026-03-12 04:19:39', '2026-03-12 04:19:39'),
(7, 'PMR', 'sda', 'Jum\'at, 09.00', 'guru', 14, NULL, '1773289974_7b128eece46e74d617c7.jpg', '2026-03-12 04:32:54', '2026-03-12 04:32:54'),
(8, 'Pramuk', 'daadawdaw', 'Sabtu, 08.00 - 09.00 WIB', 'manual', NULL, 'Bpk, Satria', '1773290004_ec74889faa07ca47f863.jpg', '2026-03-12 04:33:24', '2026-03-12 04:33:24'),
(9, 'Ko-Kurikuler', 'wfaqw2gqgq', 'Jum\'at, 09.00', 'guru', 1, NULL, '1773290033_afe73a8b62a185b5bd2d.png', '2026-03-12 04:33:53', '2026-03-12 04:33:53'),
(10, 'Tari', '14221', 'Sabtu, 08.00 - 09.00 WIB', 'manual', NULL, 'Bpk, Satria', '1773290068_eac8a502652f413074a8.jpg', '2026-03-12 04:34:28', '2026-03-12 04:34:28'),
(11, 'Tari', 'dawgagaw', 'Sabtu, 08.00 - 09.00 WIB', 'manual', NULL, 'Bpk, Satria\'', '1773290266_aa52c1ffe8e3dc1d361c.png', '2026-03-12 04:37:46', '2026-03-12 04:37:46');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` int UNSIGNED NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `foto_cover` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `icon`, `judul`, `deskripsi`, `foto_cover`, `created_at`, `updated_at`) VALUES
(1, 'fa-solid fa-chalkboard-user', 'Ruang Kelas yang nyaman', 'Kelas memadai adalah lingkungan fisik atau virtual yang menyediakan fasilitas lengkap, nyaman, dan fungsional seperti ventilasi, pencahayaan, meja-kursi ergonomis, serta proyektor untuk menunjang proses pembelajaran yang efektif dan kondusif. Ini adalah ruang belajar yang memenuhi standar keamanan dan kebersihan, sehingga meningkatkan fokus dan semangat belajar.', '1773206237_37dbb4b3545b1e0c8452.jpg', '2026-03-11 05:17:17', '2026-03-11 05:17:17'),
(2, 'fa-solid fa-computer', 'Laboratorium Komputer', 'Lab komputer adalah sebuah ruangan khusus yang dilengkapi berbagai perangkat keras (komputer, printer) dan lunak (aplikasi, sistem operasi) untuk mendukung kegiatan pendidikan, pelatihan, penelitian, dan praktik ilmiah terkait ilmu komputer atau teknologi informasi, berfungsi sebagai sarana praktikum, pusat pembelajaran digital, dan tempat pengembangan keterampilan TIK bagi siswa, mahasiswa, atau peneliti di sekolah, kampus, dan perkantoran.', '1773206473_3af1b89ea15655c3c53b.jpg', '2026-03-11 05:21:13', '2026-03-11 05:21:13'),
(3, 'fa-solid fa-microscope', 'Laboratorium IPA', 'Laboratorium IPA adalah fasilitas pendidikan untuk praktikum sains (fisika, kimia, biologi) yang dilengkapi peralatan khusus seperti mikroskop, tabung reaksi, dan bahan kimia. Tempat ini berfungsi membuktikan teori, mengembangkan keterampilan ilmiah, dan menunjang pembelajaran melalui eksperimen langsung dengan standar keamanan yang tinggi', '1773206552_85b8ef49103e4590c18c.jpg', '2026-03-11 05:22:32', '2026-03-11 05:22:32'),
(4, 'fa-solid fa-headset', 'Ruang Podcast', 'Ruang podcast sekolah adalah studio khusus yang dirancang untuk merekam konten audio maupun video berkualitas tinggi guna mendukung pembelajaran, kreativitas, dan pengembangan kemampuan komunikasi (publik speaking) siswa dan guru. Fasilitas ini dilengkapi peralatan modern, peredam suara, dan internet untuk memproduksi konten edukatif atau siaran langsung', '1773206654_3f2331f6d514ea14c4c8.jpg', '2026-03-11 05:24:14', '2026-03-11 05:24:14'),
(5, 'fa-solid fa-book-bookmark', 'Perpustakaan Digital', 'Ruang perpustakaan digital adalah sistem berbasis teknologi atau area khusus yang menyediakan akses ke koleksi bahan pustaka berbentuk elektronik seperti e-book, jurnal, video, dan audio—yang dapat diakses kapan saja dan di mana saja melalui jaringan internet. Ini mencakup baik repositori online maupun fasilitas fisik (komputer/gadget) untuk membaca dokumen digital.', '1773206742_44d713c84e0364097abc.jpg', '2026-03-11 05:25:42', '2026-03-11 05:26:44'),
(6, 'fa-solid fa-volleyball', 'Sarana Olahraga', 'Sarana olahraga sekolah adalah seluruh peralatan, perlengkapan, dan alat bantu yang digunakan secara langsung dalam pelaksanaan aktivitas pendidikan jasmani maupun keolahragaan, yang umumnya bersifat mudah dipindah-pindahkan. Sarana ini berfungsi menunjang pembelajaran fisik dan pengembangan keterampilan gerak siswa', '1773206877_b2fbe5ee297798ff49f9.jpg', '2026-03-11 05:27:57', '2026-03-11 05:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_galeri`
--

CREATE TABLE `fasilitas_galeri` (
  `id` int UNSIGNED NOT NULL,
  `fasilitas_id` int UNSIGNED NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guru_staff`
--

CREATE TABLE `guru_staff` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` enum('pimpinan','guru','staff') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'guru',
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sambutan` text COLLATE utf8mb4_general_ci,
  `urutan` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `pendidikan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tiktok` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cv_file` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru_staff`
--

INSERT INTO `guru_staff` (`id`, `nama`, `jabatan`, `kategori`, `foto`, `sambutan`, `urutan`, `created_at`, `updated_at`, `pendidikan`, `youtube`, `facebook`, `instagram`, `tiktok`, `linkedin`, `cv_file`) VALUES
(1, 'Vladimir Putin ', 'Kepala Madrasah', 'pimpinan', '1773209896_c2d155b0ce8c5f1ab4a8.jpg', 'Selamat datang di sekolah kami. Kami berkomitmen untuk menyediakan lingkungan belajar yang inspiratif, didukung oleh tenaga pendidik profesional dan fasilitas modern. Kami percaya bahwa setiap anak memiliki potensi unik yang siap untuk dikembangkan demi menyongsong masa depan yang cerah.', 1, '2026-03-11 06:18:16', '2026-03-11 06:18:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Muhamad Ihsan Kurniawan', 'Kepala Tata Usaha', 'staff', '1773235460_123d0c8b6770f0242ec7.jpg', 'Move fast and break things\" philosophy, the importance of tackling big risks (like not innovating), focusing on building, and the idea that relevance comes from what you build, not just what you say.', 1, '2026-03-11 13:24:20', '2026-03-11 18:44:43', 'S1 - Universitas Siber Muhammadiyah', 'https://www.youtube.com/@mamabadiulihsan.official', 'https://www.facebook.com/people/MA-Mabadiul-Ihsan/100095492828391/?_rdc=2&_rdr#', 'http://www.linked.com/in/muhamad-ihsan-kurniawan-413632335', 'https://www.tiktok.com/@mamabadiulihsan.official?_r=1&_t=ZS-92PQJCA3g2f', 'https://linked.com/in/muhamad-ihsan-kurniawan-413632335', '1773236118_3b3980a0e8aa40f831ef.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `hero_slider`
--

CREATE TABLE `hero_slider` (
  `id` int UNSIGNED NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gambar_mobile` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `label` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subjudul` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `btn1_teks` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `btn1_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `btn2_teks` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `btn2_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_slider`
--

INSERT INTO `hero_slider` (`id`, `gambar`, `gambar_mobile`, `label`, `judul`, `subjudul`, `created_at`, `updated_at`, `btn1_teks`, `btn1_url`, `btn2_teks`, `btn2_url`) VALUES
(1, '1773207794_4384b2955303e71800df.jpg', '1773207794_12ba39bd762fd5953e77.jpg', 'Selamat Datang di', 'MA Mabadiul Ihsan', 'MA Mabadi’ul Ihsan adalah Madrasah Aliyah berbasis pesantren Islam yang berdiri sejak 08 Mei 2020 di bawah naungan Yayasan Pondok Pesantren Mabadi’ul Ihsan. Kami menggabungkan pendidikan agama dan umum modern untuk membentuk siswa berkarakter qur’ani, berprestasi, dan siap bersaing.', '2026-03-11 05:43:14', '2026-03-11 05:47:20', 'Daftar Sekarang', 'https://bit.ly/FormMAMiha', 'Tentang Kami', 'https://youtu.be/OgPy3qSWKiU?si=H_9Vmds4h8-cKcYb'),
(2, '1773207812_fe68c8360934ef9b6e60.jpg', NULL, '', '', '', '2026-03-11 05:43:32', '2026-03-11 05:43:32', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `konten` text COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-03-07-111109', 'App\\Database\\Migrations\\Kegiatan', 'default', 'App', 1773202102, 1),
(2, '2026-03-07-164546', 'App\\Database\\Migrations\\SetupPengaturan', 'default', 'App', 1773202102, 1),
(3, '2026-03-07-165848', 'App\\Database\\Migrations\\TambahFaviconMeta', 'default', 'App', 1773202102, 1),
(4, '2026-03-07-174029', 'App\\Database\\Migrations\\TambahLogoPengaturan', 'default', 'App', 1773202102, 1),
(5, '2026-03-07-180706', 'App\\Database\\Migrations\\TambahSloganAlamat', 'default', 'App', 1773202102, 1),
(6, '2026-03-07-183511', 'App\\Database\\Migrations\\TambahLinkAkses', 'default', 'App', 1773202102, 1),
(7, '2026-03-07-191237', 'App\\Database\\Migrations\\CreatePendaftaranTable', 'default', 'App', 1773202102, 1),
(8, '2026-03-07-194551', 'App\\Database\\Migrations\\TambahTiktok', 'default', 'App', 1773202102, 1),
(9, '2026-03-07-205846', 'App\\Database\\Migrations\\TambahPengaturanTutupPPDB', 'default', 'App', 1773202102, 1),
(10, '2026-03-07-211333', 'App\\Database\\Migrations\\BuatAksesCepat', 'default', 'App', 1773202102, 1),
(11, '2026-03-08-084953', 'App\\Database\\Migrations\\BuatHeroSlider', 'default', 'App', 1773202102, 1),
(12, '2026-03-08-191017', 'App\\Database\\Migrations\\UpdateHeroSlider', 'default', 'App', 1773202102, 1),
(13, '2026-03-08-193229', 'App\\Database\\Migrations\\TambahGambarMobile', 'default', 'App', 1773202102, 1),
(14, '2026-03-09-211749', 'App\\Database\\Migrations\\Profil', 'default', 'App', 1773202102, 1),
(15, '2026-03-09-211807', 'App\\Database\\Migrations\\Testimoni', 'default', 'App', 1773202102, 1),
(16, '2026-03-09-211826', 'App\\Database\\Migrations\\Fasilitas', 'default', 'App', 1773202102, 1),
(17, '2026-03-10-180246', 'App\\Database\\Migrations\\SetupProfilFasilitas', 'default', 'App', 1773202103, 1),
(18, '2026-03-11-060328', 'App\\Database\\Migrations\\CreateGuruStaffTable', 'default', 'App', 1773209488, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int UNSIGNED NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brosur` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipe_daftar` enum('internal','eksternal') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'internal',
  `link_daftar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_ppdb` enum('buka','tutup') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tutup',
  `updated_at` datetime DEFAULT NULL,
  `pesan_tutup` text COLLATE utf8mb4_general_ci,
  `link_admin_ppdb` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `poster`, `brosur`, `tipe_daftar`, `link_daftar`, `status_ppdb`, `updated_at`, `pesan_tutup`, `link_admin_ppdb`) VALUES
(1, '1773203704_5c01aa3caf8c397b3c80.jpg', '1773203440_53aa8138df8ce082b452.pdf', 'eksternal', 'https://bit.ly/FormMAMiha', 'buka', '2026-03-11 04:35:04', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int UNSIGNED NOT NULL,
  `nama_sekolah` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi_footer` text COLLATE utf8mb4_general_ci NOT NULL,
  `facebook` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instagram` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `youtube` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_deskripsi` text COLLATE utf8mb4_general_ci,
  `meta_keywords` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `slogan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat_singkat` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_maps` text COLLATE utf8mb4_general_ci,
  `link_whatsapp` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tiktok` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama_sekolah`, `alamat`, `telepon`, `email`, `deskripsi_footer`, `facebook`, `instagram`, `youtube`, `updated_at`, `favicon`, `meta_deskripsi`, `meta_keywords`, `logo`, `slogan`, `alamat_singkat`, `link_maps`, `link_whatsapp`, `tiktok`) VALUES
(1, 'MA Mabadi\'ul Ihsan', 'Jl. K.H. Achmad Musayyidi No. 177\r\nDesa Karangdoro Kec. Tegalsari\r\nKab.  Banyuwangi, Jawa Timur Kode Pos 68485', '+6285746910126', 'ma.mabadiulihsan@gmail.com', 'Mencetak generasi yang unggul dalam IPTEK, kokoh dalam IMTAQ, dan berakhlakul karimah.', 'https://www.facebook.com/people/MA-Mabadiul-Ihsan/100095492828391/?_rdc=2&_rdr#', 'https://www.instagram.com/mamabadiulihsan.official/', 'https://www.youtube.com/@mamabadiulihsan.official', '2026-03-12 05:29:42', '1773207052_0134b5f6d50a4da73b3a.png', 'Website Resmi MA Mabadi\'ul Ihsan. Mencetak generasi unggul berwawasan global.', 'madrasah, sekolah, mamiha, banyuwangi', '1773207052_d5f19eea07e03795176c.png', 'Kreatif, Inovatis, Berprestasi', 'Karangdoro - Tegalsari - Banyuwangi', 'https://maps.app.goo.gl/gS242Snfp2S1jQJq8', 'https://wa.me/6285746910126', 'https://www.tiktok.com/@mamabadiulihsan.official?_r=1&_t=ZS-92PQJCA3g2f');

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id` int UNSIGNED NOT NULL,
  `tentang_judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tentang_deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `tentang_video` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sejarah_deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `sejarah_foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `visi` text COLLATE utf8mb4_general_ci NOT NULL,
  `misi` text COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profil_website`
--

CREATE TABLE `profil_website` (
  `id` int UNSIGNED NOT NULL,
  `kilas_balik_deskripsi` text COLLATE utf8mb4_general_ci,
  `kilas_balik_foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `visi` text COLLATE utf8mb4_general_ci,
  `misi` text COLLATE utf8mb4_general_ci,
  `tentang_kami_judul` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tentang_kami_deskripsi` text COLLATE utf8mb4_general_ci,
  `tentang_kami_video_tipe` enum('upload','link') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'link',
  `tentang_kami_video` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profil_website`
--

INSERT INTO `profil_website` (`id`, `kilas_balik_deskripsi`, `kilas_balik_foto`, `visi`, `misi`, `tentang_kami_judul`, `tentang_kami_deskripsi`, `tentang_kami_video_tipe`, `tentang_kami_video`, `updated_at`) VALUES
(1, 'MA Mabadi’ul Ihsan adalah Madrasah Aliyah berbasis pesantren Islam yang berdiri sejak 08 Mei 2020 di bawah naungan Yayasan Pondok Pesantren Mabadi’ul Ihsan. Kami menggabungkan pendidikan agama dan umum modern untuk membentuk siswa berkarakter qur’ani, berprestasi, dan siap bersaing. MA Mabadi’ul Ihsan memiliki 3 jurusan unggulan: Agama, IPA, dan IPS, serta kurikulum terpadu dengan program Tahfidzul Qur’an, English & Arabic Day, dan pembinaan prestasi akademik & non-akademik. Madrasah kami telah meraih Akreditasi A dan dikenal peduli lingkungan melalui kegiatan Madrasah Adiwiyata. Daftarkan putra-putri Anda untuk pendidikan yang bermutu, berakhlak mulia, dan unggul di era global.', '1773206039_d34719e27981c2fdf794.jpg', 'TERWUJUDNYA LULUSAN YANG BERKEPRIBADIAN QUR’ANI, INOVATIF, BERPRESTASI, BERBUDAYA LINGKUNGAN, DAN BERWAWASAN GLOBAL BERLANDASKAN PROFIL PELAJAR PANCASILA', 'Mewujudkan Visi dan Misi Yayasan Pondok Pesantren Mabadi’ul Ihsan;\r\nMenyelenggarakan program Tahfidzul Qur’an dan pembelajaran yang terintegrasi dengan nilai-nilai keislaman;\r\nMembekali peserta didik dengan program Life Skill;\r\nMenyelenggarakan program peningkatan prestasi dan persiapan masuk perguruan tinggi;\r\nMenyelenggarakan program berbasis Eco-green;\r\nMenyelenggarakan program Arabic dan English Day;\r\nMenyelenggarakan Program Penguatan Profil Pelajar Pancasila (P5) dan Profil Pelajar Rahmatan Lil Alamin (PPRA).', 'Video Profil Kami', 'Kami dengan bangga mempersembahkan profil pengenalan kami kepada Anda. Madrasah Aliyah Mabadi’ul Ihsan merupakan unit pendidikan dibawah naungan yayasan pondok pesantren Mabadi’ul Ihsan. Berdiri sejak tahun 2020 dan bertempat di Jln. KH. Achmad Musayyidi RT/RW 01/02 Karangdoro, Tegalsari, Banyuwangi.\r\n\r\nMadrasah Aliyah Mabadi’ul Ihsan, akan memberikan gambaran lengkap tentang kegiatan, program, dan fasilitas kami. Kami menyediakan lingkungan belajar yang variatif, dengan tenaga pendidik kami yang berkualifikasi tinggi dengan antusiasme memberikan pengajaran yang inovatif dan interaktif.', 'link', 'https://youtu.be/OgPy3qSWKiU?si=H_9Vmds4h8-cKcYb', '2026-03-11 05:49:43'),
(2, 'MA Mabadi\'ul Ihsan didirikan dengan semangat untuk mencetak generasi muslim yang tangguh.', 'default.jpg', 'Terwujudnya generasi muslim yang Berakhlakul Karimah dan Unggul.', 'Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.', 'Menjelajahi Lingkungan Belajar yang Inspiratif', 'Kami tidak hanya mengajarkan ilmu pengetahuan, tetapi juga menanamkan nilai-nilai karakter yang kuat.', '', 'https://www.youtube.com/watch?v=aqz-KE-bpKQ', '2026-03-11 04:10:11'),
(3, 'MA Mabadi\'ul Ihsan didirikan dengan semangat untuk mencetak generasi muslim yang tangguh.', 'default.jpg', 'Terwujudnya generasi muslim yang Berakhlakul Karimah dan Unggul.', 'Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.', 'Menjelajahi Lingkungan Belajar yang Inspiratif', 'Kami tidak hanya mengajarkan ilmu pengetahuan, tetapi juga menanamkan nilai-nilai karakter yang kuat.', '', 'https://www.youtube.com/watch?v=aqz-KE-bpKQ', '2026-03-11 04:10:38'),
(4, 'MA Mabadi\'ul Ihsan didirikan dengan semangat untuk mencetak generasi muslim yang tangguh.', 'default.jpg', 'Terwujudnya generasi muslim yang Berakhlakul Karimah dan Unggul.', 'Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.', 'Menjelajahi Lingkungan Belajar yang Inspiratif', 'Kami tidak hanya mengajarkan ilmu pengetahuan, tetapi juga menanamkan nilai-nilai karakter yang kuat.', '', 'https://www.youtube.com/watch?v=aqz-KE-bpKQ', '2026-03-11 04:12:57'),
(5, 'MA Mabadi\'ul Ihsan didirikan dengan semangat untuk mencetak generasi muslim yang tangguh.', 'default.jpg', 'Terwujudnya generasi muslim yang Berakhlakul Karimah dan Unggul.', 'Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.', 'Menjelajahi Lingkungan Belajar yang Inspiratif', 'Kami tidak hanya mengajarkan ilmu pengetahuan, tetapi juga menanamkan nilai-nilai karakter yang kuat.', '', 'https://www.youtube.com/watch?v=aqz-KE-bpKQ', '2026-03-11 04:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
--

CREATE TABLE `testimoni` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `status_user` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `rating` int NOT NULL,
  `isi_testimoni` text COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimoni`
--

INSERT INTO `testimoni` (`id`, `nama`, `status_user`, `rating`, `isi_testimoni`, `foto`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 'Muhamad Ihsan Kurniawan', 'Tenaga Pendidik MA Tahun 2020-2027', 5, 'Pengalaman yang sangat menyenangkan. Timnya ramah, komunikatif, dan hasilnya benar-benar memuaskan. Terima kasih atas pelayanannya!', '1773207174_637a3a832de9635e3c64.jpg', 1, '2026-03-11 05:32:54', '2026-03-11 05:33:47'),
(2, 'Bill Gates', ' Pendiri Microsoft', 5, 'Pelayanannya sangat memuaskan! Proses cepat, hasil sesuai harapan, dan timnya responsif. Sangat direkomendasikan bagi siapa pun yang mencari kualitas dan profesionalitas.', '1773207219_ecceed8f6b7447452ea0.jpg', 1, '2026-03-11 05:33:39', '2026-03-11 05:33:49'),
(3, 'Mark Zuckerberg ', 'CEO Meta Platforms', 5, 'Belajar di MA Mabadi’ul Ihsan memberikan pengalaman yang luar biasa. Tidak hanya ilmu akademik, tetapi juga nilai-nilai agama yang kuat.', '1773207341_db01e9a4582e1dfd9a71.jpg', 1, '2026-03-11 05:35:41', '2026-03-11 05:36:18'),
(4, 'Jeff Bezos', ' Aktor Hollywood', 5, 'MA Mabadi’ul Ihsan sangat direkomendasikan. Pendidikan akademik dan keagamaan berjalan seimbang dengan bimbingan guru yang profesional.', '1773207372_6193d1f44078367ee35d.jpg', 1, '2026-03-11 05:36:12', '2026-03-11 05:36:20'),
(5, 'Vladimir Putin ', 'President of Russia', 5, 'Saya bangga menjadi bagian dari MA Mabadi’ul Ihsan. Lingkungan sekolahnya positif dan mendukung perkembangan siswa.', '1773207473_f79f660ba3a3a1ec118f.jpg', 1, '2026-03-11 05:37:53', '2026-03-11 05:40:32'),
(6, 'Donald Trump', 'U.S. President', 5, 'Senang sekali bisa berkunjung ke MA Mabadi’ul Ihsan. Lingkungannya nyaman, suasananya religius, dan para guru serta siswanya sangat ramah.', '1773207625_719638a6c24e86fa2bf3.jpg', 1, '2026-03-11 05:40:25', '2026-03-11 05:40:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses_cepat`
--
ALTER TABLE `akses_cepat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bakat_minat`
--
ALTER TABLE `bakat_minat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fasilitas_galeri`
--
ALTER TABLE `fasilitas_galeri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fasilitas_galeri_fasilitas_id_foreign` (`fasilitas_id`);

--
-- Indexes for table `guru_staff`
--
ALTER TABLE `guru_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_slider`
--
ALTER TABLE `hero_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profil_website`
--
ALTER TABLE `profil_website`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses_cepat`
--
ALTER TABLE `akses_cepat`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bakat_minat`
--
ALTER TABLE `bakat_minat`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fasilitas_galeri`
--
ALTER TABLE `fasilitas_galeri`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guru_staff`
--
ALTER TABLE `guru_staff`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `hero_slider`
--
ALTER TABLE `hero_slider`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profil_website`
--
ALTER TABLE `profil_website`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fasilitas_galeri`
--
ALTER TABLE `fasilitas_galeri`
  ADD CONSTRAINT `fasilitas_galeri_fasilitas_id_foreign` FOREIGN KEY (`fasilitas_id`) REFERENCES `fasilitas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
