-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: perpus_sekola
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `anggota`
--

DROP TABLE IF EXISTS `anggota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(20) NOT NULL,
  `nama_anggota` varchar(255) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'anggota',
  `alamat` text NOT NULL,
  `no_wa` varchar(15) NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `foto` varchar(255) DEFAULT 'default.png',
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggota`
--

LOCK TABLES `anggota` WRITE;
/*!40000 ALTER TABLE `anggota` DISABLE KEYS */;
INSERT INTO `anggota` VALUES (24,'3456547','ifan','ifan','$2y$10$TT.y0HxvtHu4AK3Jni.Yp.YpaG9hB/VL11cLyXIWouZS3FAh4Ie.W','anggota','surian','0845631525','0000-00-00','1777293765_a05d618ad206c9b30312.jpg');
/*!40000 ALTER TABLE `anggota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buku`
--

DROP TABLE IF EXISTS `buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `isbn` varchar(50) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_penulis` int(11) NOT NULL,
  `id_penerbit` int(11) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tersedia` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `cover` varchar(255) NOT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (3,'521654','Home Sweet Loan',1,2,1,2021,6,6,'21324','1776483365_006b403599ec4fa2b526.jpg'),(4,'25346','Aroma Karsa',1,3,3,2023,6,7,'3454','1776483463_42c6ee6c13ddf726aadd.jpg'),(5,'2342354','Dilan 1990',1,6,4,2000,6,7,'4353456','1776484175_ee5c167d4e986510b90c.jpg'),(6,'43687','Cantik itu Luka',1,7,2,2024,6,3,'3454','1776484285_661748c1a5b43198a772.jpg'),(11,' 9789794335475','Perahu Kertas',1,3,2,2009,5,4,'perahu kertas','1777295500_c1b04fbb2d3eb36e22ad.jpg');
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buku_rak`
--

DROP TABLE IF EXISTS `buku_rak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku_rak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_buku` int(11) NOT NULL,
  `id_rak` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku_rak`
--

LOCK TABLES `buku_rak` WRITE;
/*!40000 ALTER TABLE `buku_rak` DISABLE KEYS */;
INSERT INTO `buku_rak` VALUES (3,3,2),(4,4,1),(5,5,2),(6,6,2),(11,11,2);
/*!40000 ALTER TABLE `buku_rak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denda`
--

DROP TABLE IF EXISTS `denda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `denda` (
  `id_denda` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengembalian` int(11) NOT NULL,
  `jumlah_denda` decimal(40,2) NOT NULL,
  `status` varchar(55) NOT NULL,
  `tgl_pembayaran` datetime DEFAULT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT 'Tunai',
  PRIMARY KEY (`id_denda`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denda`
--

LOCK TABLES `denda` WRITE;
/*!40000 ALTER TABLE `denda` DISABLE KEYS */;
INSERT INTO `denda` VALUES (29,43,7000.00,'lunas',NULL,NULL,'Tunai'),(30,44,19000.00,'lunas',NULL,NULL,'Tunai'),(32,2,40000.00,'lunas','2026-04-23 16:45:01',NULL,'Tunai'),(36,8,24000.00,'lunas','2026-04-24 00:00:00','1777050079_d17bedf5079ee201e7e4.png','DANA'),(37,9,16000.00,'lunas','2026-04-24 00:00:00','1777059341_5f90d286e6c5a67127cf.png','DANA'),(38,10,22000.00,'lunas','2026-04-25 00:00:00',NULL,'Tunai'),(39,11,20000.00,'lunas','2026-04-26 00:00:00','1777198249_88a5007099964e4184f5.png','DANA'),(40,12,6000.00,'lunas','2026-04-26 00:00:00','1777199271_b2af5eff12e8102a5cee.png','DANA'),(41,13,22000.00,'lunas','2026-04-26 00:00:00',NULL,'Tunai'),(42,14,12000.00,'lunas','2026-04-28 00:00:00','1777363009_bee325919cbae1d54525.png','DANA');
/*!40000 ALTER TABLE `denda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'novel'),(2,'Pendidikan');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_aktivitas`
--

DROP TABLE IF EXISTS `log_aktivitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_users` int(11) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `status_verifikasi` enum('pending','diverifikasi','ditolak') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_aktivitas`
--

LOCK TABLES `log_aktivitas` WRITE;
/*!40000 ALTER TABLE `log_aktivitas` DISABLE KEYS */;
INSERT INTO `log_aktivitas` VALUES (79,24,'ifan mengajukan pinjaman: Aroma Karsa','pending','2026-04-28 13:54:22'),(80,24,'Admin menyetujui pinjaman buku ID: 4','diverifikasi','2026-04-28 13:55:04'),(81,24,'Buku telah dikembalikan.','diverifikasi','2026-04-28 13:55:13');
/*!40000 ALTER TABLE `log_aktivitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT,
  `id_anggota` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('di pinjam','di kembalikan','menunggu verifikasi','') NOT NULL,
  PRIMARY KEY (`id_peminjaman`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (8,6,1,3,'2026-04-18','2026-04-09','di kembalikan'),(21,6,1,2,'2026-04-20','2026-04-19','di kembalikan'),(22,7,0,2,'2026-04-20','2026-04-27','di kembalikan'),(23,7,0,4,'2026-04-21','2026-04-28',''),(24,7,0,1,'2026-04-21','2026-04-28',''),(26,9,1,2,'2026-04-21','2026-04-20','di kembalikan'),(27,9,1,3,'2026-04-21','2026-04-20','di kembalikan'),(39,17,1,1,'2026-04-22','2026-04-08','di kembalikan'),(40,17,1,2,'2026-04-22','2026-04-18','di kembalikan'),(41,17,1,2,'2026-04-22','2026-04-29','di kembalikan'),(43,17,1,1,'2026-04-23','2026-04-16','di kembalikan'),(45,16,1,1,'2026-04-23','2026-04-30','di kembalikan'),(46,17,1,7,'2026-04-23','2026-04-30','di kembalikan'),(47,17,1,6,'2026-04-23','2026-04-30','di kembalikan'),(48,16,1,2,'2026-04-23','2026-04-30','di kembalikan'),(49,16,1,5,'2026-04-23','2026-04-30','di kembalikan'),(50,16,1,2,'2026-04-23','2026-04-30','di kembalikan'),(51,16,1,1,'2026-04-23','2026-04-30','di kembalikan'),(52,16,1,1,'2026-04-23','2026-04-30','di kembalikan'),(58,23,1,1,'2026-04-23','2026-04-30','di kembalikan'),(59,23,1,4,'2026-04-23','2026-04-15','di kembalikan'),(60,23,1,1,'2026-04-23','2026-04-30','di kembalikan'),(61,23,1,3,'2026-04-24','2026-04-20','di kembalikan'),(62,23,1,6,'2026-04-24','2026-04-12','di kembalikan'),(63,23,1,3,'2026-04-24','2026-04-22','di kembalikan'),(64,23,1,5,'2026-04-24','2026-04-16','di kembalikan'),(66,24,0,4,'2026-04-25','2026-04-15','di kembalikan'),(67,24,1,3,'2026-04-26','2026-04-16','di kembalikan'),(68,24,1,3,'2026-04-26','2026-04-23','di kembalikan'),(69,24,1,4,'2026-04-28','2026-04-22','di kembalikan');
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penerbit`
--

DROP TABLE IF EXISTS `penerbit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penerbit` (
  `id_penerbit` int(11) NOT NULL AUTO_INCREMENT,
  `nama_penerbit` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  PRIMARY KEY (`id_penerbit`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penerbit`
--

LOCK TABLES `penerbit` WRITE;
/*!40000 ALTER TABLE `penerbit` DISABLE KEYS */;
INSERT INTO `penerbit` VALUES (1,'PT Mizan Pustaka',' Golden Plaza (Kompleks Golden Truly) Blok G No. 15-16, Jl. R.S. Fatmawati, Jakarta 12410.'),(2,'Penerbit Diroz Pustaka','Jl. Marsam No. 09, Ngabul, Tahunan, Jepara 59428.'),(3,'Penerbit Matahati',' Plaza Karinda no. B1.17, Jl. Karang Tengah No.6 Jakarta 12440.'),(4,'Penerbit Widina','Komplek Purimelia Asri Blok C 3 No 17, Desa Bojong Emas, Kecamatan Solokan Jeruk, Kabupaten Bandung.');
/*!40000 ALTER TABLE `penerbit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengembalian`
--

DROP TABLE IF EXISTS `pengembalian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT,
  `id_peminjaman` int(11) NOT NULL,
  `tanggal_dikembalikan` date NOT NULL,
  `denda` decimal(40,2) NOT NULL,
  `status` varchar(20) DEFAULT 'Kembali',
  PRIMARY KEY (`id_pengembalian`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengembalian`
--

LOCK TABLES `pengembalian` WRITE;
/*!40000 ALTER TABLE `pengembalian` DISABLE KEYS */;
INSERT INTO `pengembalian` VALUES (1,55,'2026-04-23',14000.00,'Kembali'),(2,56,'2026-04-23',40000.00,'Kembali'),(3,57,'2026-04-23',14000.00,'Kembali'),(4,58,'2026-04-23',0.00,'Kembali'),(5,59,'2026-04-23',16000.00,'Kembali'),(6,60,'2026-04-24',0.00,'Kembali'),(8,62,'2026-04-24',24000.00,'Selesai'),(9,64,'2026-04-24',16000.00,'Selesai'),(10,65,'2026-04-25',22000.00,'Selesai'),(11,67,'2026-04-26',20000.00,'Selesai'),(12,68,'2026-04-26',6000.00,'Selesai'),(13,66,'2026-04-26',22000.00,'Selesai'),(14,69,'2026-04-28',12000.00,'Selesai');
/*!40000 ALTER TABLE `pengembalian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penulis`
--

DROP TABLE IF EXISTS `penulis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penulis` (
  `id_penulis` int(11) NOT NULL AUTO_INCREMENT,
  `nama_penulis` varchar(100) NOT NULL,
  PRIMARY KEY (`id_penulis`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penulis`
--

LOCK TABLES `penulis` WRITE;
/*!40000 ALTER TABLE `penulis` DISABLE KEYS */;
INSERT INTO `penulis` VALUES (2,' Almira Bastari'),(3,' Dee Lestari'),(4,' Pidi Baiq'),(6,' Pidi Baiq'),(7,'Eka Kurniawan');
/*!40000 ALTER TABLE `penulis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rak`
--

DROP TABLE IF EXISTS `rak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rak` (
  `id_rak` int(11) NOT NULL AUTO_INCREMENT,
  `nama_rak` varchar(50) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  PRIMARY KEY (`id_rak`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rak`
--

LOCK TABLES `rak` WRITE;
/*!40000 ALTER TABLE `rak` DISABLE KEYS */;
INSERT INTO `rak` VALUES (1,'A-Z','Pendidikan'),(2,'A-Z','Hiburan');
/*!40000 ALTER TABLE `rak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` enum('admin','petugas','anggota','') NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` enum('aktif','nonaktif','','') NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'jimin','jimin@gmil.com','jimin','admin','1777293407_552292fbc84bb9f81862.jpg','aktif','$2y$10$0xW3JwAc0N2r600t5Qm9b.j26AcyAUBX0jhjDl8ZMcrkpITGDvxx2'),(20,'dadanr','dr011ramdani@gmail.com','user','petugas','1777130580_c2132a40c70f9a0fb547.jpg','aktif','$2y$10$HjnPT./SnGy0kKK6DPHPFOY8UTpn8qnH1nqpOwsTY3ZUv8wKTyxqy'),(21,'Dadan Ramdani User','Joko123@gmail.com','danx','petugas','1777195767_6b45393612ebe216b637.jpg','aktif','$2y$10$gwl7BXLhrKB4A34fkPX8peOD.LQ0AG9FteVrjtKbKvaNyNGxyaw0K');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-28 15:01:56
