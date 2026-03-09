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
  `nama_link` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `url_link` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akses_cepat`
--

LOCK TABLES `akses_cepat` WRITE;
/*!40000 ALTER TABLE `akses_cepat` DISABLE KEYS */;
INSERT INTO `akses_cepat` VALUES (1,'Raport Digital Madrasah','https://rdmmiha.mamabadiulihsan.sch.id','2026-03-07 21:23:11','2026-03-07 21:23:11'),(2,'E-Learning','https://www.quipper.com/id/','2026-03-09 02:22:23','2026-03-09 02:22:23');
/*!40000 ALTER TABLE `akses_cepat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hero_slider`
--

DROP TABLE IF EXISTS `hero_slider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hero_slider` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
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
  `btn2_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hero_slider`
--

LOCK TABLES `hero_slider` WRITE;
/*!40000 ALTER TABLE `hero_slider` DISABLE KEYS */;
INSERT INTO `hero_slider` VALUES (6,'1772999226_fdff74389d491b6d8f33.jpg','1773022762_ebd1e8945cc6ed1e9b2d.jpeg','Pengumuan','Sistem Manjemen Pendfataran Telah Dibuka','Ayo Gabung segera sebelum kehabisan kuota nya','2026-03-08 19:47:06','2026-03-09 02:19:22','Ayo Buruan Daftar Keburu Tutup nih','https://ppdb.ponpesmiha.online/','Profil Madrasah','www.youtube.com'),(7,'1773000267_398cb8c262509d2f536b.jpg','1773000267_0c0cce7906be7c8a7ad6.jpg','Selamat Datang di','MA Mabadi\'ul Ihsan','Sekarang karena Hero Banner sudah selesai 100% dan sangat dinamis, kita akan bergeser sedikit ke bawah untuk membuat Section Statistik / Keunggulan.','2026-03-08 20:04:27','2026-03-08 20:05:34','Daftar Sekarang Juga','https://ppdb.ponpesmiha.online/','Profil Madrasah','www.youtube.com');
/*!40000 ALTER TABLE `hero_slider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kegiatan`
--

DROP TABLE IF EXISTS `kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kegiatan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `konten` text COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kegiatan`
--

LOCK TABLES `kegiatan` WRITE;
/*!40000 ALTER TABLE `kegiatan` DISABLE KEYS */;
INSERT INTO `kegiatan` VALUES (2,'Halal Bihalal','halal-bihalal','salam salaman','1772883766_375f5a534efa6ed439ac.jpeg','2026-03-07 11:42:46','2026-03-07 11:42:46'),(5,'Halal Bihalal 2026','halal-bihalal-2026','salam salaman','1772884119_77c066068e76098c982f.png','2026-03-07 11:48:39','2026-03-07 11:48:39'),(6,'PPDB','ppdb','Pendaftaran sudah dibuka','1772884263_5e4d58dcfc1b110cb782.jpeg','2026-03-07 11:51:03','2026-03-07 14:57:30');
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
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026-03-07-111109','App\\Database\\Migrations\\Kegiatan','default','App',1772882613,1),(2,'2026-03-07-164546','App\\Database\\Migrations\\SetupPengaturan','default','App',1772902006,2),(3,'2026-03-07-165848','App\\Database\\Migrations\\TambahFaviconMeta','default','App',1772902754,3),(4,'2026-03-07-174029','App\\Database\\Migrations\\TambahLogoPengaturan','default','App',1772905257,4),(5,'2026-03-07-180706','App\\Database\\Migrations\\TambahSloganAlamat','default','App',1772906855,5),(6,'2026-03-07-183511','App\\Database\\Migrations\\TambahLinkAkses','default','App',1772908535,6),(7,'2026-03-07-191237','App\\Database\\Migrations\\CreatePendaftaranTable','default','App',1772910778,7),(8,'2026-03-07-194551','App\\Database\\Migrations\\TambahTiktok','default','App',1772912769,8),(9,'2026-03-07-205846','App\\Database\\Migrations\\TambahPengaturanTutupPPDB','default','App',1772917175,9),(10,'2026-03-07-211333','App\\Database\\Migrations\\BuatAksesCepat','default','App',1772918031,10),(11,'2026-03-08-084953','App\\Database\\Migrations\\BuatHeroSlider','default','App',1772959839,11),(12,'2026-03-08-191017','App\\Database\\Migrations\\UpdateHeroSlider','default','App',1772997070,12),(13,'2026-03-08-193229','App\\Database\\Migrations\\TambahGambarMobile','default','App',1772998388,13);
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
  `poster` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brosur` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipe_daftar` enum('internal','eksternal') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'internal',
  `link_daftar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_ppdb` enum('buka','tutup') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tutup',
  `updated_at` datetime DEFAULT NULL,
  `pesan_tutup` text COLLATE utf8mb4_general_ci,
  `link_admin_ppdb` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendaftaran`
--

LOCK TABLES `pendaftaran` WRITE;
/*!40000 ALTER TABLE `pendaftaran` DISABLE KEYS */;
INSERT INTO `pendaftaran` VALUES (1,'1772911284_55d203b9c0d819609abe.jpeg','1772911284_a6a647841ec512e96835.jpeg','eksternal','https://ppdb.ponpesmiha.online/','tutup','2026-03-09 15:54:39','Maaf ya kak, kuota gelombang 1 sudah full! Hubungi panitia untuk gelombang 2','https://wa.me/6281235110171');
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
  `tiktok` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaturan`
--

LOCK TABLES `pengaturan` WRITE;
/*!40000 ALTER TABLE `pengaturan` DISABLE KEYS */;
INSERT INTO `pengaturan` VALUES (1,'MA Mabadi\'ul Ihsan','Jl. KH. Achmad Musayyidi RT.01 RW.02 Desa Karangdoro Kec. Tegalsari Kab. Banyuwangi','+62857-4691-0126','ma.mabadiulihsan@gmail.com','Mencetak generasi yang unggul dalam IPTEK, kokoh dalam IMTAQ, dan berakhlakul karimah.\r\nMadrasah Kreatif, Inovatif, Inspiratif\r\nKarangdoro, Tegalsari, Banyuwangi','https://facebook.com/mamiha','https://instagram.com/mamiha','https://youtube.com/mamiha','2026-03-08 08:05:33','1772904046_a4b48a60368e067fbb58.png','MA Mabadi\'ul Ihsan, madrasah berbasis asrama pencetak lulusan berprestasi akademik & non-akademik. Bekali masa depan dengan ilmu agama & lolos PTN favorit.','Mabadiul Ihsan, Mabadi\'ul Ihsan, MA Mabadi\'ul Ihsan, MA Mabadiul Ihsan, ma miha, MA Miha, Pondok Pesantren Mabadi\'ul Ihsan, Pondok Pesantren Mabadiul Ihsan, Ponpes Miha, Madrasah Aliyah','1772905610_a55bf8d5b3b5c09d265a.png','Kreatif, Inovatif, Berprestasi','Karangdoro - Tegalsari - Banyuwangi','https://maps.app.goo.gl/m3G5Et43f68w25bJ8','https://wa.me/6285746910126','https://tiktok.com/mamiha');
/*!40000 ALTER TABLE `pengaturan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-10  0:15:16
