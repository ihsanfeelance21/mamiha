-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: mamiha_db
-- ------------------------------------------------------
-- Server version	8.0.45-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `akses_cepat`
--

DROP TABLE IF EXISTS `akses_cepat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akses_cepat` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akses_cepat`
--

LOCK TABLES `akses_cepat` WRITE;
/*!40000 ALTER TABLE `akses_cepat` DISABLE KEYS */;
/*!40000 ALTER TABLE `akses_cepat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bakat_minat`
--

DROP TABLE IF EXISTS `bakat_minat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bakat_minat` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `jadwal` varchar(255) NOT NULL,
  `tipe_pembina` enum('guru','manual') NOT NULL DEFAULT 'guru',
  `guru_id` int unsigned DEFAULT NULL,
  `nama_pembina_manual` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bakat_minat`
--

LOCK TABLES `bakat_minat` WRITE;
/*!40000 ALTER TABLE `bakat_minat` DISABLE KEYS */;
INSERT INTO `bakat_minat` VALUES (2,'Pramuka','Kegiatan ekstra setiap sabtu','Sabtu, 08.00 - 09.00 WIB','manual',NULL,'Bpk, Satria','1773286523_d03b3ce85bfae2acd067.jpg','2026-03-12 03:35:23','2026-03-12 04:07:34'),(4,'Ko-Kurikuler','apaja ok','Sabtu, 08.00 - 09.00 WIB','guru',14,NULL,'1773289179_c1e48680553199b0fd5a.jpg','2026-03-12 04:19:39','2026-03-12 04:19:39'),(7,'PMR','sda','Jum\'at, 09.00','guru',14,NULL,'1773289974_7b128eece46e74d617c7.jpg','2026-03-12 04:32:54','2026-03-12 04:32:54'),(8,'Pramuk','daadawdaw','Sabtu, 08.00 - 09.00 WIB','manual',NULL,'Bpk, Satria','1773290004_ec74889faa07ca47f863.jpg','2026-03-12 04:33:24','2026-03-12 04:33:24'),(9,'Ko-Kurikuler','wfaqw2gqgq','Jum\'at, 09.00','guru',1,NULL,'1773290033_afe73a8b62a185b5bd2d.png','2026-03-12 04:33:53','2026-03-12 04:33:53'),(10,'Tari','14221','Sabtu, 08.00 - 09.00 WIB','manual',NULL,'Bpk, Satria','1773290068_eac8a502652f413074a8.jpg','2026-03-12 04:34:28','2026-03-12 04:34:28'),(11,'Tari','dawgagaw','Sabtu, 08.00 - 09.00 WIB','manual',NULL,'Bpk, Satria\'','1773290266_aa52c1ffe8e3dc1d361c.png','2026-03-12 04:37:46','2026-03-12 04:37:46');
/*!40000 ALTER TABLE `bakat_minat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `berita`
--

DROP TABLE IF EXISTS `berita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `berita` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_kategori` int unsigned NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `konten` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `layout` enum('split','block','immersive') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'split',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `berita_id_kategori_foreign` (`id_kategori`),
  CONSTRAINT `berita_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_berita` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `berita`
--

LOCK TABLES `berita` WRITE;
/*!40000 ALTER TABLE `berita` DISABLE KEYS */;
INSERT INTO `berita` VALUES (1,1,'Permohonan surat keterangan mahasiswa aktif ','permohonan-surat-keterangan-mahasiswa-aktif','<p>apa aja bolehkan??</p>','1773425450_c4ce0dfcd6524990f113.webp','immersive','2026-03-13 18:10:50','2026-03-13 18:10:50'),(2,1,'Perpindahan dari Paruh Waktu ke Penuh Waktu','perpindahan-dari-paruh-waktu-ke-penuh-waktu','<p>dwadadwdaw</p>','1773460351_5c69add592c0e992088c.webp','block','2026-03-14 03:52:31','2026-03-14 03:52:31'),(3,1,'MA Mabadi\'ul Ihsan','ma-mabadiul-ihsan','<p>dadwadwad</p><table style=\"border: 1px solid #000;\"><tbody><tr><td data-row=\"row-slte\">dadsd</td><td data-row=\"row-slte\">dasd</td><td data-row=\"row-slte\">dswa</td></tr><tr><td data-row=\"row-5577\">sdasd</td><td data-row=\"row-5577\">as</td><td data-row=\"row-5577\"></td></tr></tbody></table><p>adscas</p>','1773468851_a6609aa35b32a47a3957.webp','immersive','2026-03-14 06:14:11','2026-03-14 06:14:11'),(4,1,'cadaddawsd','cadaddawsd','<p>&lt;p&gt;czcszsa&lt;/p&gt;</p>','1773469063_e54acaf781d1884002a2.webp','split','2026-03-14 06:17:44','2026-03-14 06:17:44'),(5,2,'Laboratorium IPA','laboratorium-ipa','<p>dwadwadwad</p>','1773469081_1365559ff4e478fe8640.webp','block','2026-03-14 06:18:01','2026-03-14 06:18:01'),(6,1,'apa akad','apa-akad','<p>dawdaw</p>','1773469096_c2fcbea96bbe34cccdca.webp','immersive','2026-03-14 06:18:17','2026-03-14 06:18:17');
/*!40000 ALTER TABLE `berita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fasilitas`
--

DROP TABLE IF EXISTS `fasilitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fasilitas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `foto_cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fasilitas`
--

LOCK TABLES `fasilitas` WRITE;
/*!40000 ALTER TABLE `fasilitas` DISABLE KEYS */;
INSERT INTO `fasilitas` VALUES (1,'fa-solid fa-chalkboard-user','Ruang Kelas yang nyaman','Kelas memadai adalah lingkungan fisik atau virtual yang menyediakan fasilitas lengkap, nyaman, dan fungsional seperti ventilasi, pencahayaan, meja-kursi ergonomis, serta proyektor untuk menunjang proses pembelajaran yang efektif dan kondusif. Ini adalah ruang belajar yang memenuhi standar keamanan dan kebersihan, sehingga meningkatkan fokus dan semangat belajar.','1773206237_37dbb4b3545b1e0c8452.jpg','2026-03-11 05:17:17','2026-03-11 05:17:17'),(2,'fa-solid fa-computer','Laboratorium Komputer','Lab komputer adalah sebuah ruangan khusus yang dilengkapi berbagai perangkat keras (komputer, printer) dan lunak (aplikasi, sistem operasi) untuk mendukung kegiatan pendidikan, pelatihan, penelitian, dan praktik ilmiah terkait ilmu komputer atau teknologi informasi, berfungsi sebagai sarana praktikum, pusat pembelajaran digital, dan tempat pengembangan keterampilan TIK bagi siswa, mahasiswa, atau peneliti di sekolah, kampus, dan perkantoran.','1773206473_3af1b89ea15655c3c53b.jpg','2026-03-11 05:21:13','2026-03-11 05:21:13'),(3,'fa-solid fa-microscope','Laboratorium IPA','Laboratorium IPA adalah fasilitas pendidikan untuk praktikum sains (fisika, kimia, biologi) yang dilengkapi peralatan khusus seperti mikroskop, tabung reaksi, dan bahan kimia. Tempat ini berfungsi membuktikan teori, mengembangkan keterampilan ilmiah, dan menunjang pembelajaran melalui eksperimen langsung dengan standar keamanan yang tinggi','1773206552_85b8ef49103e4590c18c.jpg','2026-03-11 05:22:32','2026-03-11 05:22:32'),(4,'fa-solid fa-headset','Ruang Podcast','Ruang podcast sekolah adalah studio khusus yang dirancang untuk merekam konten audio maupun video berkualitas tinggi guna mendukung pembelajaran, kreativitas, dan pengembangan kemampuan komunikasi (publik speaking) siswa dan guru. Fasilitas ini dilengkapi peralatan modern, peredam suara, dan internet untuk memproduksi konten edukatif atau siaran langsung','1773206654_3f2331f6d514ea14c4c8.jpg','2026-03-11 05:24:14','2026-03-11 05:24:14'),(5,'fa-solid fa-book-bookmark','Perpustakaan Digital','Ruang perpustakaan digital adalah sistem berbasis teknologi atau area khusus yang menyediakan akses ke koleksi bahan pustaka berbentuk elektronik seperti e-book, jurnal, video, dan audio—yang dapat diakses kapan saja dan di mana saja melalui jaringan internet. Ini mencakup baik repositori online maupun fasilitas fisik (komputer/gadget) untuk membaca dokumen digital.','1773206742_44d713c84e0364097abc.jpg','2026-03-11 05:25:42','2026-03-11 05:26:44'),(6,'fa-solid fa-volleyball','Sarana Olahraga','Sarana olahraga sekolah adalah seluruh peralatan, perlengkapan, dan alat bantu yang digunakan secara langsung dalam pelaksanaan aktivitas pendidikan jasmani maupun keolahragaan, yang umumnya bersifat mudah dipindah-pindahkan. Sarana ini berfungsi menunjang pembelajaran fisik dan pengembangan keterampilan gerak siswa','1773206877_b2fbe5ee297798ff49f9.jpg','2026-03-11 05:27:57','2026-03-11 05:28:21');
/*!40000 ALTER TABLE `fasilitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fasilitas_galeri`
--

DROP TABLE IF EXISTS `fasilitas_galeri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fasilitas_galeri` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fasilitas_id` int unsigned NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fasilitas_galeri_fasilitas_id_foreign` (`fasilitas_id`),
  CONSTRAINT `fasilitas_galeri_fasilitas_id_foreign` FOREIGN KEY (`fasilitas_id`) REFERENCES `fasilitas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fasilitas_galeri`
--

LOCK TABLES `fasilitas_galeri` WRITE;
/*!40000 ALTER TABLE `fasilitas_galeri` DISABLE KEYS */;
/*!40000 ALTER TABLE `fasilitas_galeri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guru_staff`
--

DROP TABLE IF EXISTS `guru_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guru_staff` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` enum('pimpinan','guru','staff') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'guru',
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sambutan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `urutan` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `pendidikan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `youtube` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facebook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tiktok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `linkedin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cv_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru_staff`
--

LOCK TABLES `guru_staff` WRITE;
/*!40000 ALTER TABLE `guru_staff` DISABLE KEYS */;
INSERT INTO `guru_staff` VALUES (1,'Vladimir Putin ','Kepala Madrasah','pimpinan','1773209896_c2d155b0ce8c5f1ab4a8.jpg','Selamat datang di sekolah kami. Kami berkomitmen untuk menyediakan lingkungan belajar yang inspiratif, didukung oleh tenaga pendidik profesional dan fasilitas modern. Kami percaya bahwa setiap anak memiliki potensi unik yang siap untuk dikembangkan demi menyongsong masa depan yang cerah.',1,'2026-03-11 06:18:16','2026-03-11 06:18:16',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,'Muhamad Ihsan Kurniawan','Kepala Tata Usaha','staff','1773235460_123d0c8b6770f0242ec7.jpg','Move fast and break things\" philosophy, the importance of tackling big risks (like not innovating), focusing on building, and the idea that relevance comes from what you build, not just what you say.',1,'2026-03-11 13:24:20','2026-03-11 18:44:43','S1 - Universitas Siber Muhammadiyah','https://www.youtube.com/@mamabadiulihsan.official','https://www.facebook.com/people/MA-Mabadiul-Ihsan/100095492828391/?_rdc=2&_rdr#','http://www.linked.com/in/muhamad-ihsan-kurniawan-413632335','https://www.tiktok.com/@mamabadiulihsan.official?_r=1&_t=ZS-92PQJCA3g2f','https://linked.com/in/muhamad-ihsan-kurniawan-413632335','1773236118_3b3980a0e8aa40f831ef.pdf');
/*!40000 ALTER TABLE `guru_staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hero_slider`
--

DROP TABLE IF EXISTS `hero_slider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hero_slider` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gambar_mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `label` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subjudul` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `btn1_teks` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `btn1_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `btn2_teks` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `btn2_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hero_slider`
--

LOCK TABLES `hero_slider` WRITE;
/*!40000 ALTER TABLE `hero_slider` DISABLE KEYS */;
INSERT INTO `hero_slider` VALUES (1,'1773207794_4384b2955303e71800df.jpg','1773207794_12ba39bd762fd5953e77.jpg','Selamat Datang di','MA Mabadiul Ihsan','MA Mabadi’ul Ihsan adalah Madrasah Aliyah berbasis pesantren Islam yang berdiri sejak 08 Mei 2020 di bawah naungan Yayasan Pondok Pesantren Mabadi’ul Ihsan. Kami menggabungkan pendidikan agama dan umum modern untuk membentuk siswa berkarakter qur’ani, berprestasi, dan siap bersaing.','2026-03-11 05:43:14','2026-03-11 05:47:20','Daftar Sekarang','https://bit.ly/FormMAMiha','Tentang Kami','https://youtu.be/OgPy3qSWKiU?si=H_9Vmds4h8-cKcYb'),(2,'1773207812_fe68c8360934ef9b6e60.jpg',NULL,'','','','2026-03-11 05:43:32','2026-03-11 05:43:32','','','','');
/*!40000 ALTER TABLE `hero_slider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_berita`
--

DROP TABLE IF EXISTS `kategori_berita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori_berita` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `slug_kategori` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_kategori` (`slug_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_berita`
--

LOCK TABLES `kategori_berita` WRITE;
/*!40000 ALTER TABLE `kategori_berita` DISABLE KEYS */;
INSERT INTO `kategori_berita` VALUES (1,'Berita','berita','2026-03-13 18:05:15','2026-03-13 18:05:15'),(2,'Kegiatan Siswa','kegiatan-siswa','2026-03-13 18:16:28','2026-03-13 18:16:28');
/*!40000 ALTER TABLE `kategori_berita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kegiatan`
--

DROP TABLE IF EXISTS `kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kegiatan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `konten` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kegiatan`
--

LOCK TABLES `kegiatan` WRITE;
/*!40000 ALTER TABLE `kegiatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026-03-07-111109','App\\Database\\Migrations\\Kegiatan','default','App',1773202102,1),(2,'2026-03-07-164546','App\\Database\\Migrations\\SetupPengaturan','default','App',1773202102,1),(3,'2026-03-07-165848','App\\Database\\Migrations\\TambahFaviconMeta','default','App',1773202102,1),(4,'2026-03-07-174029','App\\Database\\Migrations\\TambahLogoPengaturan','default','App',1773202102,1),(5,'2026-03-07-180706','App\\Database\\Migrations\\TambahSloganAlamat','default','App',1773202102,1),(6,'2026-03-07-183511','App\\Database\\Migrations\\TambahLinkAkses','default','App',1773202102,1),(7,'2026-03-07-191237','App\\Database\\Migrations\\CreatePendaftaranTable','default','App',1773202102,1),(8,'2026-03-07-194551','App\\Database\\Migrations\\TambahTiktok','default','App',1773202102,1),(9,'2026-03-07-205846','App\\Database\\Migrations\\TambahPengaturanTutupPPDB','default','App',1773202102,1),(10,'2026-03-07-211333','App\\Database\\Migrations\\BuatAksesCepat','default','App',1773202102,1),(11,'2026-03-08-084953','App\\Database\\Migrations\\BuatHeroSlider','default','App',1773202102,1),(12,'2026-03-08-191017','App\\Database\\Migrations\\UpdateHeroSlider','default','App',1773202102,1),(13,'2026-03-08-193229','App\\Database\\Migrations\\TambahGambarMobile','default','App',1773202102,1),(14,'2026-03-09-211749','App\\Database\\Migrations\\Profil','default','App',1773202102,1),(15,'2026-03-09-211807','App\\Database\\Migrations\\Testimoni','default','App',1773202102,1),(16,'2026-03-09-211826','App\\Database\\Migrations\\Fasilitas','default','App',1773202102,1),(17,'2026-03-10-180246','App\\Database\\Migrations\\SetupProfilFasilitas','default','App',1773202103,1),(18,'2026-03-11-060328','App\\Database\\Migrations\\CreateGuruStaffTable','default','App',1773209488,2),(19,'2026-03-13-175948','App\\Database\\Migrations\\KategoriBerita','default','App',1773424857,3),(20,'2026-03-13-180022','App\\Database\\Migrations\\Berita','default','App',1773424857,3),(21,'2026-03-13-180042','App\\Database\\Migrations\\Prestasi','default','App',1773424858,3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pendaftaran`
--

DROP TABLE IF EXISTS `pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendaftaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `poster` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brosur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipe_daftar` enum('internal','eksternal') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'internal',
  `link_daftar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_ppdb` enum('buka','tutup') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tutup',
  `updated_at` datetime DEFAULT NULL,
  `pesan_tutup` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `link_admin_ppdb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendaftaran`
--

LOCK TABLES `pendaftaran` WRITE;
/*!40000 ALTER TABLE `pendaftaran` DISABLE KEYS */;
INSERT INTO `pendaftaran` VALUES (1,'1773425832_f9e7e347bf5a9f608cb4.jpeg','1773203440_53aa8138df8ce082b452.pdf','eksternal','https://bit.ly/FormMAMiha','buka','2026-03-13 18:17:12','','');
/*!40000 ALTER TABLE `pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaturan`
--

DROP TABLE IF EXISTS `pengaturan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengaturan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_sekolah` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telepon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi_footer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `facebook` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instagram` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `youtube` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `favicon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `meta_keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `slogan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat_singkat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_maps` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `link_whatsapp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tiktok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaturan`
--

LOCK TABLES `pengaturan` WRITE;
/*!40000 ALTER TABLE `pengaturan` DISABLE KEYS */;
INSERT INTO `pengaturan` VALUES (1,'MA Mabadi\'ul Ihsan','Jl. K.H. Achmad Musayyidi No. 177\r\nDesa Karangdoro Kec. Tegalsari\r\nKab.  Banyuwangi, Jawa Timur Kode Pos 68485','+6285746910126','ma.mabadiulihsan@gmail.com','Mencetak generasi yang unggul dalam IPTEK, kokoh dalam IMTAQ, dan berakhlakul karimah.','https://www.facebook.com/people/MA-Mabadiul-Ihsan/100095492828391/?_rdc=2&_rdr#','https://www.instagram.com/mamabadiulihsan.official/','https://www.youtube.com/@mamabadiulihsan.official','2026-03-12 05:29:42','1773207052_0134b5f6d50a4da73b3a.png','Website Resmi MA Mabadi\'ul Ihsan. Mencetak generasi unggul berwawasan global.','madrasah, sekolah, mamiha, banyuwangi','1773207052_d5f19eea07e03795176c.png','Kreatif, Inovatis, Berprestasi','Karangdoro - Tegalsari - Banyuwangi','https://maps.app.goo.gl/gS242Snfp2S1jQJq8','https://wa.me/6285746910126','https://www.tiktok.com/@mamabadiulihsan.official?_r=1&_t=ZS-92PQJCA3g2f');
/*!40000 ALTER TABLE `pengaturan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestasi`
--

DROP TABLE IF EXISTS `prestasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestasi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kategori_prestasi` enum('Siswa','Guru','Madrasah') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Siswa',
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `konten` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `layout` enum('split','block','immersive') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'split',
  `juara` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_lomba` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_pemenang` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kelas` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_guru` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_penghargaan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun_perolehan` year DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestasi`
--

LOCK TABLES `prestasi` WRITE;
/*!40000 ALTER TABLE `prestasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profil`
--

DROP TABLE IF EXISTS `profil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profil` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tentang_judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tentang_deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tentang_video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sejarah_deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sejarah_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `visi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `misi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profil`
--

LOCK TABLES `profil` WRITE;
/*!40000 ALTER TABLE `profil` DISABLE KEYS */;
/*!40000 ALTER TABLE `profil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profil_website`
--

DROP TABLE IF EXISTS `profil_website`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profil_website` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kilas_balik_deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `kilas_balik_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `visi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `misi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tentang_kami_judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tentang_kami_deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tentang_kami_video_tipe` enum('upload','link') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'link',
  `tentang_kami_video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profil_website`
--

LOCK TABLES `profil_website` WRITE;
/*!40000 ALTER TABLE `profil_website` DISABLE KEYS */;
INSERT INTO `profil_website` VALUES (1,'MA Mabadi’ul Ihsan adalah Madrasah Aliyah berbasis pesantren Islam yang berdiri sejak 08 Mei 2020 di bawah naungan Yayasan Pondok Pesantren Mabadi’ul Ihsan. Kami menggabungkan pendidikan agama dan umum modern untuk membentuk siswa berkarakter qur’ani, berprestasi, dan siap bersaing. MA Mabadi’ul Ihsan memiliki 3 jurusan unggulan: Agama, IPA, dan IPS, serta kurikulum terpadu dengan program Tahfidzul Qur’an, English & Arabic Day, dan pembinaan prestasi akademik & non-akademik. Madrasah kami telah meraih Akreditasi A dan dikenal peduli lingkungan melalui kegiatan Madrasah Adiwiyata. Daftarkan putra-putri Anda untuk pendidikan yang bermutu, berakhlak mulia, dan unggul di era global.','1773206039_d34719e27981c2fdf794.jpg','TERWUJUDNYA LULUSAN YANG BERKEPRIBADIAN QUR’ANI, INOVATIF, BERPRESTASI, BERBUDAYA LINGKUNGAN, DAN BERWAWASAN GLOBAL BERLANDASKAN PROFIL PELAJAR PANCASILA','Mewujudkan Visi dan Misi Yayasan Pondok Pesantren Mabadi’ul Ihsan;\r\nMenyelenggarakan program Tahfidzul Qur’an dan pembelajaran yang terintegrasi dengan nilai-nilai keislaman;\r\nMembekali peserta didik dengan program Life Skill;\r\nMenyelenggarakan program peningkatan prestasi dan persiapan masuk perguruan tinggi;\r\nMenyelenggarakan program berbasis Eco-green;\r\nMenyelenggarakan program Arabic dan English Day;\r\nMenyelenggarakan Program Penguatan Profil Pelajar Pancasila (P5) dan Profil Pelajar Rahmatan Lil Alamin (PPRA).','Video Profil Kami','Kami dengan bangga mempersembahkan profil pengenalan kami kepada Anda. Madrasah Aliyah Mabadi’ul Ihsan merupakan unit pendidikan dibawah naungan yayasan pondok pesantren Mabadi’ul Ihsan. Berdiri sejak tahun 2020 dan bertempat di Jln. KH. Achmad Musayyidi RT/RW 01/02 Karangdoro, Tegalsari, Banyuwangi.\r\n\r\nMadrasah Aliyah Mabadi’ul Ihsan, akan memberikan gambaran lengkap tentang kegiatan, program, dan fasilitas kami. Kami menyediakan lingkungan belajar yang variatif, dengan tenaga pendidik kami yang berkualifikasi tinggi dengan antusiasme memberikan pengajaran yang inovatif dan interaktif.','link','https://youtu.be/OgPy3qSWKiU?si=H_9Vmds4h8-cKcYb','2026-03-11 05:49:43'),(2,'MA Mabadi\'ul Ihsan didirikan dengan semangat untuk mencetak generasi muslim yang tangguh.','default.jpg','Terwujudnya generasi muslim yang Berakhlakul Karimah dan Unggul.','Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.','Menjelajahi Lingkungan Belajar yang Inspiratif','Kami tidak hanya mengajarkan ilmu pengetahuan, tetapi juga menanamkan nilai-nilai karakter yang kuat.','','https://www.youtube.com/watch?v=aqz-KE-bpKQ','2026-03-11 04:10:11'),(3,'MA Mabadi\'ul Ihsan didirikan dengan semangat untuk mencetak generasi muslim yang tangguh.','default.jpg','Terwujudnya generasi muslim yang Berakhlakul Karimah dan Unggul.','Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.','Menjelajahi Lingkungan Belajar yang Inspiratif','Kami tidak hanya mengajarkan ilmu pengetahuan, tetapi juga menanamkan nilai-nilai karakter yang kuat.','','https://www.youtube.com/watch?v=aqz-KE-bpKQ','2026-03-11 04:10:38'),(4,'MA Mabadi\'ul Ihsan didirikan dengan semangat untuk mencetak generasi muslim yang tangguh.','default.jpg','Terwujudnya generasi muslim yang Berakhlakul Karimah dan Unggul.','Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.','Menjelajahi Lingkungan Belajar yang Inspiratif','Kami tidak hanya mengajarkan ilmu pengetahuan, tetapi juga menanamkan nilai-nilai karakter yang kuat.','','https://www.youtube.com/watch?v=aqz-KE-bpKQ','2026-03-11 04:12:57'),(5,'MA Mabadi\'ul Ihsan didirikan dengan semangat untuk mencetak generasi muslim yang tangguh.','default.jpg','Terwujudnya generasi muslim yang Berakhlakul Karimah dan Unggul.','Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.','Menjelajahi Lingkungan Belajar yang Inspiratif','Kami tidak hanya mengajarkan ilmu pengetahuan, tetapi juga menanamkan nilai-nilai karakter yang kuat.','','https://www.youtube.com/watch?v=aqz-KE-bpKQ','2026-03-11 04:21:42');
/*!40000 ALTER TABLE `profil_website` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimoni`
--

DROP TABLE IF EXISTS `testimoni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimoni` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rating` int NOT NULL,
  `isi_testimoni` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimoni`
--

LOCK TABLES `testimoni` WRITE;
/*!40000 ALTER TABLE `testimoni` DISABLE KEYS */;
INSERT INTO `testimoni` VALUES (1,'Muhamad Ihsan Kurniawan','Tenaga Pendidik MA Tahun 2020-2027',5,'Pengalaman yang sangat menyenangkan. Timnya ramah, komunikatif, dan hasilnya benar-benar memuaskan. Terima kasih atas pelayanannya!','1773207174_637a3a832de9635e3c64.jpg',1,'2026-03-11 05:32:54','2026-03-11 05:33:47'),(2,'Bill Gates',' Pendiri Microsoft',5,'Pelayanannya sangat memuaskan! Proses cepat, hasil sesuai harapan, dan timnya responsif. Sangat direkomendasikan bagi siapa pun yang mencari kualitas dan profesionalitas.','1773207219_ecceed8f6b7447452ea0.jpg',1,'2026-03-11 05:33:39','2026-03-11 05:33:49'),(3,'Mark Zuckerberg ','CEO Meta Platforms',5,'Belajar di MA Mabadi’ul Ihsan memberikan pengalaman yang luar biasa. Tidak hanya ilmu akademik, tetapi juga nilai-nilai agama yang kuat.','1773207341_db01e9a4582e1dfd9a71.jpg',1,'2026-03-11 05:35:41','2026-03-11 05:36:18'),(4,'Jeff Bezos',' Aktor Hollywood',5,'MA Mabadi’ul Ihsan sangat direkomendasikan. Pendidikan akademik dan keagamaan berjalan seimbang dengan bimbingan guru yang profesional.','1773207372_6193d1f44078367ee35d.jpg',1,'2026-03-11 05:36:12','2026-03-11 05:36:20'),(5,'Vladimir Putin ','President of Russia',5,'Saya bangga menjadi bagian dari MA Mabadi’ul Ihsan. Lingkungan sekolahnya positif dan mendukung perkembangan siswa.','1773207473_f79f660ba3a3a1ec118f.jpg',1,'2026-03-11 05:37:53','2026-03-11 05:40:32'),(6,'Donald Trump','U.S. President',5,'Senang sekali bisa berkunjung ke MA Mabadi’ul Ihsan. Lingkungannya nyaman, suasananya religius, dan para guru serta siswanya sangat ramah.','1773207625_719638a6c24e86fa2bf3.jpg',1,'2026-03-11 05:40:25','2026-03-11 05:40:30');
/*!40000 ALTER TABLE `testimoni` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-15  0:51:09
