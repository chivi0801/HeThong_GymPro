-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: gym_pro
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.24.04.1

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
-- Table structure for table `chi_tiet_hoa_don`
--

DROP TABLE IF EXISTS `chi_tiet_hoa_don`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chi_tiet_hoa_don` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hoa_don_id` int NOT NULL,
  `san_pham_id` int NOT NULL,
  `so_luong` int NOT NULL,
  `don_gia` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hoa_don_id` (`hoa_don_id`),
  CONSTRAINT `chi_tiet_hoa_don_ibfk_1` FOREIGN KEY (`hoa_don_id`) REFERENCES `hoa_don_ban_le` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chi_tiet_hoa_don`
--

LOCK TABLES `chi_tiet_hoa_don` WRITE;
/*!40000 ALTER TABLE `chi_tiet_hoa_don` DISABLE KEYS */;
INSERT INTO `chi_tiet_hoa_don` VALUES (1,1,5,1,60000.00),(2,1,4,1,150000.00),(3,1,3,1,2100000.00),(4,2,5,1,60000.00),(5,2,4,1,150000.00),(6,3,1,10,10000.00),(7,4,1,2,10000.00),(8,4,3,1,2100000.00),(9,4,4,2,150000.00),(10,5,5,1,60000.00),(11,5,4,1,150000.00),(12,6,5,3,60000.00),(13,7,5,10,60000.00),(14,7,3,5,2100000.00);
/*!40000 ALTER TABLE `chi_tiet_hoa_don` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chu_gym`
--

DROP TABLE IF EXISTS `chu_gym`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chu_gym` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten_phong` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ho_ten_chu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sdt` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mat_khau` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_tao` date DEFAULT NULL,
  `trang_thai` enum('active','expired','pending') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chu_gym`
--

LOCK TABLES `chu_gym` WRITE;
/*!40000 ALTER TABLE `chu_gym` DISABLE KEYS */;
INSERT INTO `chu_gym` VALUES (1,'Gym Fitness Pro','Nguyễn Văn A','chugyma@gmail.com','0909000001','123456','2026-03-03','active'),(2,'Titan Gym','Trần Văn B','chugymb@gmail.com','0909000002','123456','2026-03-03','active');
/*!40000 ALTER TABLE `chu_gym` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dang_ky_goi`
--

DROP TABLE IF EXISTS `dang_ky_goi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dang_ky_goi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hoi_vien_id` int NOT NULL,
  `goi_tap_id` int NOT NULL,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `trang_thai` enum('active','expired','paused','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `hoi_vien_id` (`hoi_vien_id`),
  KEY `goi_tap_id` (`goi_tap_id`),
  CONSTRAINT `dang_ky_goi_ibfk_1` FOREIGN KEY (`hoi_vien_id`) REFERENCES `hoi_vien` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dang_ky_goi_ibfk_2` FOREIGN KEY (`goi_tap_id`) REFERENCES `goi_tap` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dang_ky_goi`
--

LOCK TABLES `dang_ky_goi` WRITE;
/*!40000 ALTER TABLE `dang_ky_goi` DISABLE KEYS */;
INSERT INTO `dang_ky_goi` VALUES (1,1,1,'2026-03-01','2026-04-01','active'),(2,2,2,'2026-03-01','2026-06-01','expired'),(3,3,3,'2026-03-01','2026-04-01','paused'),(4,4,1,'2026-03-02','2026-04-02','expired'),(5,5,2,'2026-03-02','2026-06-02','active'),(6,6,4,'2026-03-02','2026-09-02','paused'),(7,7,3,'2026-03-02','2026-04-02','expired'),(8,8,6,'2026-03-02','2026-09-02','active'),(9,9,7,'2026-03-02','2026-12-02','paused'),(10,1,1,'2026-03-05','2026-04-05','active'),(11,2,1,'2026-03-05','2026-04-05','active'),(12,4,1,'2026-03-05','2026-04-05','active'),(13,5,1,'2026-03-05','2026-04-05','active'),(14,6,1,'2026-03-05','2026-04-05','active'),(15,10,1,'2026-03-05','2026-04-05','active'),(16,11,1,'2026-03-05','2026-04-05','active'),(17,12,1,'2026-03-05','2026-04-05','active'),(18,13,1,'2026-03-05','2026-04-05','active'),(19,14,1,'2026-03-05','2026-04-05','active'),(20,15,1,'2026-03-05','2026-04-05','active'),(21,16,1,'2026-03-05','2026-04-05','active'),(22,17,1,'2026-03-05','2026-04-05','active'),(23,18,1,'2026-03-05','2026-04-05','active'),(24,19,1,'2026-03-05','2026-04-05','active'),(25,3,3,'2026-03-05','2026-04-05','active'),(26,7,3,'2026-03-05','2026-04-05','active'),(27,8,3,'2026-03-05','2026-04-05','active'),(28,9,3,'2026-03-05','2026-04-05','active'),(29,20,3,'2026-03-05','2026-04-05','active'),(30,21,3,'2026-03-05','2026-04-05','active'),(31,22,3,'2026-03-05','2026-04-05','active'),(32,23,3,'2026-03-05','2026-04-05','active'),(33,24,3,'2026-03-05','2026-04-05','active'),(34,25,3,'2026-03-05','2026-04-05','active'),(35,26,3,'2026-03-05','2026-04-05','active'),(36,27,3,'2026-03-05','2026-04-05','active'),(37,28,3,'2026-03-05','2026-04-05','active'),(38,29,3,'2026-03-05','2026-04-05','active'),(39,30,3,'2026-03-05','2026-04-05','active'),(40,31,3,'2026-03-05','2026-04-05','active'),(41,32,3,'2026-03-05','2026-04-05','active'),(42,33,3,'2026-03-05','2026-04-05','active'),(43,34,3,'2026-03-05','2026-04-05','active'),(44,35,3,'2026-03-05','2026-04-05','active'),(45,36,3,'2026-03-05','2026-04-05','active'),(46,37,3,'2026-03-05','2026-04-05','active'),(47,38,3,'2026-03-05','2026-04-05','active'),(48,39,3,'2026-03-05','2026-04-05','active'),(65,10,1,'2025-12-01','2026-01-01','expired'),(66,11,1,'2025-11-01','2025-12-01','expired'),(67,20,3,'2025-12-01','2026-01-01','expired'),(68,21,3,'2025-11-01','2025-12-01','expired'),(69,12,1,'2026-02-10','2026-03-08','expired'),(70,13,1,'2026-02-10','2026-03-09','expired'),(71,22,3,'2026-02-10','2026-03-08','expired'),(72,23,3,'2026-02-10','2026-03-09','expired'),(73,14,1,'2026-02-01','2026-04-01','paused'),(74,15,1,'2026-02-01','2026-04-01','paused'),(75,24,3,'2026-02-01','2026-04-01','paused'),(76,25,3,'2026-02-01','2026-04-01','paused'),(77,16,1,'2026-02-01','2026-04-01','cancelled'),(78,17,1,'2026-02-01','2026-04-01','cancelled'),(79,26,3,'2026-02-01','2026-04-01','cancelled'),(80,27,3,'2026-02-01','2026-04-01','cancelled'),(81,56,1,'2026-03-06','2026-04-05','active'),(82,57,2,'2026-03-06','2026-06-04','active'),(83,58,4,'2026-03-06','2026-09-02','active'),(84,59,1,'2026-03-19','2026-04-18','active'),(85,60,2,'2026-03-19','2026-06-17','active'),(86,61,2,'2026-03-19','2026-06-17','active'),(87,62,4,'2026-03-19','2026-09-15','active'),(88,63,2,'2026-03-19','2026-06-17','active'),(89,64,2,'2026-03-19','2026-06-17','active'),(90,65,5,'2026-03-19','2027-03-14','active'),(91,66,8,'2026-03-20','2026-06-18','active'),(92,67,5,'2026-03-20','2027-03-15','active');
/*!40000 ALTER TABLE `dang_ky_goi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dang_ky_he_thong`
--

DROP TABLE IF EXISTS `dang_ky_he_thong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dang_ky_he_thong` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chu_gym_id` int NOT NULL,
  `goi_he_thong_id` int NOT NULL,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `trang_thai` enum('active','expired','pending') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `so_thang` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chu_gym_id` (`chu_gym_id`),
  KEY `goi_he_thong_id` (`goi_he_thong_id`),
  CONSTRAINT `dang_ky_he_thong_ibfk_1` FOREIGN KEY (`chu_gym_id`) REFERENCES `chu_gym` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dang_ky_he_thong_ibfk_2` FOREIGN KEY (`goi_he_thong_id`) REFERENCES `goi_he_thong` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dang_ky_he_thong`
--

LOCK TABLES `dang_ky_he_thong` WRITE;
/*!40000 ALTER TABLE `dang_ky_he_thong` DISABLE KEYS */;
INSERT INTO `dang_ky_he_thong` VALUES (1,1,2,'2026-03-01','2026-09-01','active',6),(2,2,1,'2026-03-01','2026-09-01','active',6);
/*!40000 ALTER TABLE `dang_ky_he_thong` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diem_danh`
--

DROP TABLE IF EXISTS `diem_danh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diem_danh` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hoi_vien_id` int NOT NULL,
  `thoi_gian` datetime DEFAULT CURRENT_TIMESTAMP,
  `hinh_anh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hoi_vien_id` (`hoi_vien_id`),
  CONSTRAINT `diem_danh_ibfk_1` FOREIGN KEY (`hoi_vien_id`) REFERENCES `hoi_vien` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diem_danh`
--

LOCK TABLES `diem_danh` WRITE;
/*!40000 ALTER TABLE `diem_danh` DISABLE KEYS */;
INSERT INTO `diem_danh` VALUES (1,1,'2026-03-03 11:36:49','khang_01032026.jpg'),(2,2,'2026-03-03 11:36:49','lan_01032026.jpg'),(3,1,'2026-03-03 11:36:49','khang_02032026.jpg'),(4,4,'2026-03-04 07:20:00','bao_0403.jpg'),(5,5,'2026-03-04 08:15:00','mai_0403.jpg'),(6,6,'2026-03-04 17:30:00','tam_0403.jpg'),(7,7,'2026-03-04 18:00:00','tung_0403.jpg'),(8,8,'2026-03-04 19:10:00','hoa_0403.jpg'),(9,9,'2026-03-04 20:00:00','phuc_0403.jpg'),(10,1,'2026-03-05 07:10:00','check1.jpg'),(11,2,'2026-03-05 07:15:00','check2.jpg'),(12,3,'2026-03-05 07:20:00','check3.jpg'),(13,4,'2026-03-05 07:30:00','check4.jpg'),(14,5,'2026-03-05 07:45:00','check5.jpg'),(15,6,'2026-03-05 08:00:00','check6.jpg'),(16,7,'2026-03-05 08:10:00','check7.jpg'),(17,8,'2026-03-05 08:20:00','check8.jpg'),(18,9,'2026-03-05 08:30:00','check9.jpg'),(19,10,'2026-03-05 08:40:00','check10.jpg'),(20,11,'2026-03-05 09:00:00','check11.jpg'),(21,12,'2026-03-05 09:10:00','check12.jpg'),(22,13,'2026-03-05 09:20:00','check13.jpg'),(23,14,'2026-03-05 09:40:00','check14.jpg'),(24,15,'2026-03-05 10:00:00','check15.jpg'),(25,56,'2026-03-07 00:13:21',NULL),(26,56,'2026-03-09 11:06:41',NULL),(27,57,'2026-03-09 11:16:11',NULL),(28,56,'2026-03-19 09:02:20',NULL),(29,59,'2026-03-19 09:03:04',NULL),(30,59,'2026-03-20 18:56:22',NULL),(31,57,'2026-03-20 19:18:28',NULL),(32,56,'2026-03-20 20:05:30',NULL),(33,59,'2026-03-21 13:12:06',NULL),(34,56,'2026-03-21 13:24:07',NULL);
/*!40000 ALTER TABLE `diem_danh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goi_he_thong`
--

DROP TABLE IF EXISTS `goi_he_thong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goi_he_thong` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten_goi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gia` decimal(10,2) NOT NULL,
  `thoi_han_thang` int NOT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goi_he_thong`
--

LOCK TABLES `goi_he_thong` WRITE;
/*!40000 ALTER TABLE `goi_he_thong` DISABLE KEYS */;
INSERT INTO `goi_he_thong` VALUES (1,'Cơ bản',300000.00,1,'Quản lý hội viên cơ bản'),(2,'Nâng cao',500000.00,1,'Có báo cáo và thống kê'),(3,'Chuyên nghiệp',1000000.00,1,'Full tính năng + nhận diện khuôn mặt');
/*!40000 ALTER TABLE `goi_he_thong` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goi_tap`
--

DROP TABLE IF EXISTS `goi_tap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goi_tap` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten_goi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thoi_han_thang` int NOT NULL,
  `gia` decimal(10,2) NOT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `chu_gym_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chu_gym_id` (`chu_gym_id`),
  CONSTRAINT `goi_tap_ibfk_1` FOREIGN KEY (`chu_gym_id`) REFERENCES `chu_gym` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goi_tap`
--

LOCK TABLES `goi_tap` WRITE;
/*!40000 ALTER TABLE `goi_tap` DISABLE KEYS */;
INSERT INTO `goi_tap` VALUES (1,'Gói 1 tháng',1,400000.00,'Tập tự do',1),(2,'Gói 3 tháng',3,1000000.00,'Giảm giá ưu đãi',1),(3,'Gói 1 tháng',1,350000.00,'Tập tự do',2),(4,'Gói 6 tháng',6,1800000.00,'Ưu đãi dài hạn',1),(5,'Gói VIP 12 tháng',12,3200000.00,'Có PT hỗ trợ',1),(6,'Gói 3 tháng',3,900000.00,'Ưu đãi giảm giá',2),(7,'Gói 6 tháng',6,1600000.00,'Tập tự do',2),(8,'Gói Platinum 3 tháng',3,500000.00,'',1);
/*!40000 ALTER TABLE `goi_tap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hoa_don_ban_le`
--

DROP TABLE IF EXISTS `hoa_don_ban_le`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoa_don_ban_le` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chu_gym_id` int NOT NULL,
  `hoi_vien_id` int DEFAULT NULL,
  `tong_tien` decimal(10,2) NOT NULL,
  `ngay_tao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoa_don_ban_le`
--

LOCK TABLES `hoa_don_ban_le` WRITE;
/*!40000 ALTER TABLE `hoa_don_ban_le` DISABLE KEYS */;
INSERT INTO `hoa_don_ban_le` VALUES (1,1,NULL,2310000.00,'2026-03-19 03:31:43'),(2,1,NULL,210000.00,'2026-03-19 11:41:34'),(3,1,NULL,100000.00,'2026-03-20 12:20:52'),(4,1,NULL,2420000.00,'2026-03-20 12:21:14'),(5,1,NULL,210000.00,'2026-03-20 13:27:04'),(6,1,NULL,180000.00,'2026-03-21 06:13:32'),(7,1,NULL,11100000.00,'2026-03-21 06:22:45');
/*!40000 ALTER TABLE `hoa_don_ban_le` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hoi_vien`
--

DROP TABLE IF EXISTS `hoi_vien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoi_vien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ho_ten` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sdt` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `gioi_tinh` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_dang_ky` date DEFAULT NULL,
  `trang_thai` enum('active','expired') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `chu_gym_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chu_gym_id` (`chu_gym_id`),
  CONSTRAINT `hoi_vien_ibfk_1` FOREIGN KEY (`chu_gym_id`) REFERENCES `chu_gym` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoi_vien`
--

LOCK TABLES `hoi_vien` WRITE;
/*!40000 ALTER TABLE `hoi_vien` DISABLE KEYS */;
INSERT INTO `hoi_vien` VALUES (1,'Lê Minh Khang','0911000001','khang@gmail.com',NULL,'Nam','2026-03-03','active',1),(2,'Phạm Thị Lan','0911000002','lan@gmail.com',NULL,'Nữ','2026-03-03','active',1),(3,'Đỗ Quốc Huy','0911000003','huy@gmail.com',NULL,'Nam','2026-03-03','active',2),(4,'Nguyễn Quốc Bảo','0911000004','bao@gmail.com',NULL,'Nam','2026-03-05','active',1),(5,'Trần Thị Mai','0911000005','mai@gmail.com',NULL,'Nữ','2026-03-05','active',1),(6,'Phạm Minh Tâm','0911000006','tam@gmail.com',NULL,'Nam','2026-03-05','active',1),(7,'Lê Thanh Tùng','0911000007','tung@gmail.com',NULL,'Nam','2026-03-05','active',2),(8,'Nguyễn Thị Hoa','0911000008','hoa@gmail.com',NULL,'Nữ','2026-03-05','active',2),(9,'Võ Hoàng Phúc','0911000009','phuc@gmail.com',NULL,'Nam','2026-03-05','active',2),(10,'Nguyễn Văn Nam','0911000004','nam@gmail.com',NULL,'Nam','2026-03-05','active',1),(11,'Trần Minh Phúc','0911000005','phuc@gmail.com',NULL,'Nam','2026-03-05','active',1),(12,'Lê Thị Mai','0911000006','mai@gmail.com',NULL,'Nữ','2026-03-05','active',1),(13,'Phạm Quốc Bảo','0911000007','bao@gmail.com',NULL,'Nam','2026-03-05','active',1),(14,'Đỗ Minh Tuấn','0911000008','tuan@gmail.com',NULL,'Nam','2026-03-05','active',1),(15,'Nguyễn Thị Hạnh','0911000009','hanh@gmail.com',NULL,'Nữ','2026-03-05','active',1),(16,'Trần Anh Khoa','0911000010','khoa@gmail.com',NULL,'Nam','2026-03-05','active',1),(17,'Lê Văn Long','0911000011','long@gmail.com',NULL,'Nam','2026-03-05','active',1),(18,'Phạm Thị Ly','0911000012','ly@gmail.com',NULL,'Nữ','2026-03-05','active',1),(19,'Hoàng Minh Đức','0911000013','duc@gmail.com',NULL,'Nam','2026-03-05','active',1),(20,'Nguyễn Văn Hùng','0912000001','hung@gmail.com',NULL,'Nam','2026-03-05','active',2),(21,'Trần Thị Nga','0912000002','nga@gmail.com',NULL,'Nữ','2026-03-05','active',2),(22,'Lê Văn Dũng','0912000003','dung@gmail.com',NULL,'Nam','2026-03-05','active',2),(23,'Phạm Minh Quân','0912000004','quan@gmail.com',NULL,'Nam','2026-03-05','active',2),(24,'Đỗ Thị Lan','0912000005','lan2@gmail.com',NULL,'Nữ','2026-03-05','active',2),(25,'Nguyễn Thành Đạt','0912000006','dat@gmail.com',NULL,'Nam','2026-03-05','active',2),(26,'Trần Quốc Khánh','0912000007','khanh@gmail.com',NULL,'Nam','2026-03-05','active',2),(27,'Lê Thị Thảo','0912000008','thao@gmail.com',NULL,'Nữ','2026-03-05','active',2),(28,'Phạm Văn Trung','0912000009','trung@gmail.com',NULL,'Nam','2026-03-05','active',2),(29,'Đỗ Minh Hiếu','0912000010','hieu@gmail.com',NULL,'Nam','2026-03-05','active',2),(30,'Nguyễn Quốc Anh','0912000011','anh@gmail.com',NULL,'Nam','2026-03-05','active',2),(31,'Trần Thị Bích','0912000012','bich@gmail.com',NULL,'Nữ','2026-03-05','active',2),(32,'Lê Văn Hải','0912000013','hai@gmail.com',NULL,'Nam','2026-03-05','active',2),(33,'Phạm Thị Nhung','0912000014','nhung@gmail.com',NULL,'Nữ','2026-03-05','active',2),(34,'Đỗ Văn Lâm','0912000015','lam@gmail.com',NULL,'Nam','2026-03-05','active',2),(35,'Nguyễn Minh Tuấn','0912000016','tuan2@gmail.com',NULL,'Nam','2026-03-05','active',2),(36,'Trần Thanh Sơn','0912000017','son@gmail.com',NULL,'Nam','2026-03-05','active',2),(37,'Lê Thị Ngọc','0912000018','ngoc@gmail.com',NULL,'Nữ','2026-03-05','active',2),(38,'Phạm Văn Bình','0912000019','binh@gmail.com',NULL,'Nam','2026-03-05','active',2),(39,'Đỗ Minh Tâm','0912000020','tam@gmail.com',NULL,'Nam','2026-03-05','active',2),(56,'Lưu Chí Vỹ','0398556524',NULL,NULL,'Nam','2026-03-06','active',1),(57,'Trịnh Bình Khang','0123456678',NULL,NULL,'Nam','2026-03-06','active',1),(58,'Trịnh Bình Khinh','0123456678',NULL,NULL,'Khác','2026-03-06','active',1),(59,'Nguyễn Trung Kiên','019230953',NULL,'2001-03-19',NULL,'2026-03-19','active',1),(60,'Nguyễn Văn B','02949834',NULL,NULL,NULL,'2026-03-19','active',1),(61,'Lưu Chí Khang','092374943',NULL,NULL,NULL,'2026-03-19','active',1),(62,'Trịnh Bình Vỹ','2328823',NULL,NULL,NULL,'2026-03-19','active',1),(63,'Test Doanh Thu','23982983',NULL,NULL,NULL,'2026-03-19','active',1),(64,'Nguyễn Văn AA','23982398',NULL,NULL,NULL,'2026-03-19','active',1),(65,'Lưu Bình Vỹ','05409390',NULL,NULL,NULL,'2026-03-19','active',1),(66,'Nguyễn Văn C','029930923',NULL,'2026-03-10',NULL,'2026-03-20','active',1),(67,'Nguyễn Văn AAA','09349348',NULL,'2026-03-03',NULL,'2026-03-20','active',1);
/*!40000 ALTER TABLE `hoi_vien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `khuon_mat_hoi_vien`
--

DROP TABLE IF EXISTS `khuon_mat_hoi_vien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `khuon_mat_hoi_vien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hoi_vien_id` int NOT NULL,
  `embedding` longblob NOT NULL,
  `embedding_size` smallint NOT NULL DEFAULT '128',
  `anh_mau` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT '1',
  `ngay_tao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_km_hv_trang_thai` (`hoi_vien_id`,`trang_thai`),
  CONSTRAINT `fk_khuon_mat_hoi_vien_hoi_vien` FOREIGN KEY (`hoi_vien_id`) REFERENCES `hoi_vien` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `khuon_mat_hoi_vien`
--

LOCK TABLES `khuon_mat_hoi_vien` WRITE;
/*!40000 ALTER TABLE `khuon_mat_hoi_vien` DISABLE KEYS */;
INSERT INTO `khuon_mat_hoi_vien` VALUES (1,56,_binary '\\���.�=\�P@=>��\�B ��\Z�\�ה�\�\r�P��=�|�\�q>\Z�\�~Q5�7Tɽ\�$\'��g+>\�\���\r���?��Q\�;ѥ�=�.�=\�v-=\�< :\�\�C��\�<(�\�L�\r}U<\�\\�&>�����=@W�;T:�&\�=�\�=�b�p�\�<�\�>�ʾ;�����X�=1�\�<=�>�\�@>���=`�q:�\���?\�\�=��!�@s=4>A�=V%=<\� ��Jؽ\�b;;��=�C\�#\r�<\�>\�\�۽iē�\�n�Z6U>Sx1<�	�\�\��+9}=�\���dԽ\�\�,=\�\�\'��M;��f��4f0=��\�>@�>\�8�Ј�;�<�2\�<��=g\Z\'>�u9�2I?=w�r�\�)\�<Ta>z�J���d��>^��;\�X�=#ޮ;~^2=�dK��\�<@\�νh�=��\�;���̜ =\"J\r>�\��\�`5>��`�Fm\�=�\�c=��=gn��K\�^|�=B#E�9l>\�o>\�C\�=	l\�=�o>\�U�=�e���HV={\�[�]\�#�\�n\�=�a���B\�=>�=',128,NULL,0,'2026-03-07 00:13:19'),(2,56,_binary 'H���F>�=rU�<�.@�b<\�=]J�h��xz\�5�l=�\�����>p@8�:�7��i��\�弻?></8�\���������8<�=@��=�}<�\�=�2��$��}\�P�`�뼰��<���\�x�|\� =|_�\�U�H�=,�w=l�5�c�h�YY>t�;k2���c\�=�H=-�>�\�J>]ˈ=\0���\0�\�s�=\�6:�\�\�\�<Z�\0>���=`��=dռ7\�\��`\�\"=E�==���\�ȧ;:`\�=\�m��\�v�<o½ծi>_\�<Vr�2\�����=�\��29��\�{=\�6�\�1�»����<%T�>�>��H�\�]=!���bg\�<�~%>n�>#1��ģ<����2I\�<\�y>J`�k�I�-^�>JRt< ��=8�5=�0=§½�j�:�3ý\ne=�b2=�y��\�<\�\�>��\�N>6�\0�5��=-h�=�=Z��\�%��{��=˪Q��Po> 2>+��=\�g\�=\�>r�d=(m�\�\�?=X\�Y���D�f\�=p�����>\�\�~:',128,NULL,1,'2026-03-07 00:16:19'),(3,57,_binary '�7�|�\�=5f�=�\�;VQC�\���w\Z��\�\0\�\�=��\�,v>\�l۽�Ah�\'\���.�_��\�\">\��Mͽ\\\�K�\r1���%\�=ޤ�\�Y�;�\�=x\\��$������X���\�=m���\�e��kX_=\�om������cѼpc�=z\0U�O�<��>��߼\'0D�r᳼��\�;VZ�>ZC>	u\�=Vy�oS��Q�=9\�w�K\�,=\�>\�˺=\�P�=(��\n�W��\�͗=�\����<\\=�,=\�{ؽ\�z�\��:K�>P�==\�C,�\�\�\�\�\�=^9,��<�0ԅ=\�\�\���}%�\�̾\�\�\�=[\�>\�\�\�=4T�n��:\�����\�<\�\�\�=r�\�=\�[�.<�\n��b�\�m6>�b��3\���vc>H\�����=ٙ��h\�C=�IL�F\\��ϽH=\�F\�<\�7��{\�:��#\�=�\�����\�=u&i<�F=F�\�<bI<�2�H\"ս:c�=\��l��\�c>b!8>�}�=\�	>{\�=8[�=>���bh\�;O��5��h6>\���\�;:=�x~�',128,NULL,1,'2026-03-09 11:16:09'),(4,57,_binary 'z�\Z�{\�>)S4=D�~�S;\�zü_���Y�潴�>��@�s\nf>f��\�L�o\�|���4\�,>������4�\�\�D�$�`=t>����G\�<�\�t=u������i�j�EN���\"S=�S�k��tF;�⃾~ĕ�\�0y<p�\n>���=���\\1\Z>����ɥ��H\�=ن9��3�>�\�L>\�K\�=\�kV=�q͟=D?�x�=��:>�\�\�=�=��\��\�:�\��=0��\�\�<ܺ�=k.����\��$Z\\>\��V=�\�\0�ɟB���>\���w��<@\�=�\���\�4�\���E>C=^�>8\�>d\�Y��΂���/��i�=n�N=$�=�v&�9vN=R\�����H�s>Z�k�J\�4��\�]>p|\�<\�h�=*޲;�\�\�=aLf�ӌ\�<��\�ƙ�\�_6=\rJ��\�\"�<�\��=!��f1>�2��=\�	�~�\�<6\�������F�=\�-Y����>]b>׽�=34\�=\� >ũ�=s\'�N�!<\�#\'�U���1\�\�=Ԋ�\0\�=��)=',128,NULL,1,'2026-03-09 11:16:13'),(5,57,_binary '�k�\�<>z�=\�ܣ<l���O\n��ښ�\�O���V\�=C[żۈv>E\��v�e�\�\�#�1t�\��<>}\�#�\�\n�\\�!�B\0=\�J>t/��LLU<쌃=\�D��y渾x��61>���H=%R����c�\�<<\�r�\�$���#�\n��=\�$2<N\�e<-�>\�\r�:�O��\�\�<�&��)�>-\�p>�Ϳ=L=�\�9Tk=�`��\�	=C0>\�\�=y{�=7��\�L�\�p;��\0\�<B�!�\�\�<��<�_��:O�ƽ�!\\>|�y=���,�;�h�\0>�%�vƀ��-u=���/\Z�\�\�þq�=d\�>m=�=7\�x�#�\�<\�ý�B<��=1A�=\�#�\ZG�<�\�\��:~Ѽ�\�H>��a��.�]�l>\�y�;H�=�\�C<?=\�=\�\�;�j=\�\�\�̒�<\�R=����1<\��\�=�\�\��>~\�\�:�\�=Q~I=\�t-<�JC���\�2�>\�C�/\�w>�fD>�\�c=\\\�\�=`{7>p>\\�J�jPs;\�9!�X�%�X\�	>\�o���g�= )=',128,NULL,1,'2026-03-09 11:16:18'),(6,57,_binary '=���dV*>�tj=�\�r����f��\�}�\�w\�.O>g6{�ad}>�i\�\�@��\�\��\\	\�b!>\��:�\ZB��\�e�B7S=#=%>�\��N-�=�q\��Y̾���s5�Qi<z����q��i1\�<!�Q�M�Z�\�큼\�e=\�+�H2$��>�\�=�n�\"\�\�<�E��؈>�| >�\�=�a�={&�\�\�\�=\�m8�\�\�=\�[>��\�=׶5=p	\0�\�ܽG�D��*>�g3��=L�W=����\�\\����%��\�D>�[\�=\��\�_	��\�>\��������;=]\��V\Z;�\����҄%=\"\�\�>7\n>S0?�\�a��l\�\�=}��=\��\�=6����bM={�罐o=Y9L>z������\�iT>\\\�ټ\�\�\�=\��ܼ�\�\�<�\�ӽF\�Q=\�*��\�ϼ;\�\�~<�H*���9��\�=X�\0�\Z��=L��<\�7<��;�<�Sݽrн�\�\�=�(]��_`>\�\�<>�\�\�=�\��=.$\�=v|=&|żJ㼽\���h弣1>B\Z;�\�\�=ӕf�',128,NULL,1,'2026-03-09 11:16:22'),(7,57,_binary '�F��\�=\�r�=\�:��t���w�������\�\�\�\�>LZ��s>����\�\�f�\�˽U�P� >\�\��\�\�ݽ\�0!��*�\ZV\�=zW\�<�c\�;%�\�=[�\r�s�������>0ݽ\�\�仟\�ِ��\�ś=\�\�X�9׽g\\7���=\�\��<���=/��=�>,�\�\�A�vW<A\�<\�׍>?H(>F5�=�K\�45s�OG;X:��\�Ӳ=7\�\�=���=0�z=�\�:�|;�\�xr�\�Ѽ=\�\\��~\�=\�\r[=\�v�#=\���-��Wy�>pC\�=)\�1��#J�x�=I_Q������\"�;�ҽ\�4�\�ƾ$c�=�\�\�>!2&>e\\�\Z���/ڶ�U��=}�\�=\�Á=\�쑽\�o==0���W+c�8%>(���\�2�X��>�:�x��=7H<A>�==\���y!�\�_	�w�\�<Bc��J=��\�#M��~\�=u=�F\�>���`��<t\�O����=<\��\�e��[>K�;�X>C\�d>?�=�/>�\�=��-=I|%�	�\n��~\�\��,B	>H�߽\�\�=E\�7=',128,NULL,1,'2026-03-09 11:16:25'),(8,57,_binary 'Դ�7��=~��=K���\rw��ф��J\�d\�\�͹=���N[�>G\�ݽ\�Uu���\n���\�0>\0��\�Ͻ6V���ûZ�\�=\�o=<�����\�\�=Qn��8�������o��\�;\�<jR�����V�=)p�\����\�\�0�pܭ=���<e\�<0j�=;H�gbL�lC�_�Y<\�v�>\�3>-\�=�]�:R騽\��=f�x��\�	=�S>��=M/�=��E������燏=Z\��ע=��B=���\�mG�Wl\n��s�>:�\�<9�2�-������=0�*��/o�ڻ�=\��潁n\n�\�\�Ѿ\�\n\�=8�\�>J�\�=ǉi�\�\� <40\�h$R=7�=dE�=\��$>�<�V\��M�l\nB>�#��w3��؁l>(J@�\�P\�=:\"��=\�\�k�	�N�T���\�f$=\�Q\�<Ӑ��x�;\�\�=ؔ��>᭓�\�=\�� =m��<^ �+z\�\�\�\�=�v��\�L><a>>nY\�=4A\r>w\��=�\�=�I���<�\��y�V�`�7>T��[ȁ=Ee;',128,NULL,1,'2026-03-09 11:16:34'),(9,59,_binary '<3��\�\�>L\�=3�L�\�Y��\��;9�����)>�\��+ny>�\�Ի\�\�k���̽׋�+�R>8cP��_�\�ي��<f{�=k�;\�K=\�y\\=\�e��2��ţ\�W*\��55Q�\�Y*�⮇��S��_f�z�q�<\�u�j�%�ew��JF˽.{N>Π2=\�A�\�<F\�;\"�w> ` >�.\�<R\�k=\�\�\r�\'\�=�\'�z��<~�>\��=3~=�fӻI)��w<\�V�=0����\�\�<G�=?\�\\����\�꽄�>b4�=���\\�&�\�z\�=r�ս�LY�|�d=}\\G��\�O��h�����<\�ȣ>\�\�=[(>�P��\n�\�!�=c��=g>�V���a=0�����\�<zX]>l\�\�^\�(����>\�B���?z=�\�\�9(!�bax�n���ҽ\�L\�<M\�8=�k�l�ż��\�=��\�R0=(�Ļ��9=�g�;\�.�[�.��|�Z\�\�=8\�>�\�\�E> ?1>Z�=�V�=\�n\�=�\�=*�����\�;��_����<5�)><�<Gx�=\�\�\n�',128,NULL,1,'2026-03-19 09:02:59'),(10,59,_binary 'X�Ƚ\�u\�=1$W=�C��\�ٽ�\���\�vY������U>\"0ý��\\>\�\�:�_w�\�Ƚ\�\�\n�P�`>\�o��нBN���xD\�=@X\�<i�\�<��;��������창\�L���U�SK�|���\0�29@�<��O:��񿻍�t=iΔ�Ζq�N\�\'>\�X1=\�\�D�Y\"�<}�:<��>�e8>m~9=�=\�\�ҽ�\�=\�y3���\�<\rk\0>d��=碍=Q/g�Z���2!=6��=w\� �ǉ3<���=@�\�h���19��v�>:��=W�I\���ʦ=\�B���<�*�N\Z8�);���\�f=�%\�>\r\�\�=rBP�d-H�^ʅ�P@5=�L\'>�\r>Z��<\�.<��\�\�=\0<%QR>.�\�{�?�@~>�\"�<�^\�=�����\�<\�\�=���\�<[\�ǽ�� ��=>?=�(yz:��=	\��{��=��<TN�=\�0^=]���\0&���޽:�\�=�\r?�_�S>\�5>˼\�<x8\�=([\�=\"\�\�=\�U�\�Fż�iI����H�\�=Ԓ<tc\�=@/��',128,NULL,1,'2026-03-19 09:03:19'),(11,59,_binary 'mG��;��=\\�=\�\������5+��^��_���\�\n><B��\�d>S���\�l�\�-��`���4>b�@��\��M/�y{=C\�=\�\�\�ڙH�2�\r<Zߏ�\�Ǿ\�h�����Ô�Z\�4��uC�-\0�\�@j�a��\�?�;\�^<=gf>�l���(>��\�<΂Y�ϾL=i�<�Uw>\�>q��=�\�^:2�ѽ��\�=#*�\\\0�<\�h2>���=.\�=��\�\�\�\";�</�\�=\�T=�B&�<��0=-\�Ľ\�^H�_\0���E> [�=�)ܽ\�9d�DD�=\�\�\�O6q�Ԧں-\�)�\�!a�\�כ�[�B=Yר>r[\�=8G��©<�������;n�=�S�=B\�K=4T�=�G��P�[��\�P>\���\�\�\��>\���\'\�<�s><|\����Cr�\�=\0����м�\�\'=\�\��P�V<f\�=x\�\n��?�=\�+<]�=��=�?���\�&�$�\��\�>A�P��u>>>�\�\�=�f�=L`\�=�9�=�¡�c��1\�b�\�ʁ�ե=\�(�<��=\�2;',128,NULL,1,'2026-03-19 09:03:24'),(12,59,_binary 'R6����=`\�Z;����2;��p�(���!�xC��\�f>>����t%g>\�!꼤\�<�\�߽�F�\�_A>X�YL�,_�<�\�<hК=�ڃ;\�Ռ:�r�=\�۴�Ϸ��I�f����#�<$��ӽ��2=-\�5�����\�\�\�:\��=��\�s��\�>�u�=;&7���=�\�\n=/4�>�\�?>W\�=1\�\�<\�̽?�=-\�����=%\�>B,\�=ذ=\�*� \�ɽ\��q�\�9�=\�\�X�\�d\\=5��=E:�X	���l։>�p>ܐ����=�C��=*O�}�ͽ�X=:\�\"�GC*�i=b�^�=\�\�\�>Ӧ\�=��2��?=�ٳ�|���W\�=#�>4��0�=g����#4=qY>f��C\���\\b>I�ܽ�=P�<_;\�<D�b�t-�=ca�\n\���\�}p�\"�iԼ\Z��=^\' �Ԯ&>kBV=䘩<�\Z�ڱ=\�\����d��>�C_�0\�w>y�&>Y��=RW\�=h\�\�=���=\�z<ӵ�#-K�\�&V<&>\�٤�\�>侱;',128,NULL,1,'2026-03-19 09:03:32'),(13,59,_binary 'A���{0>i\�p=���Z&I�?X\�\Z��%���#)>�\�,����>\"�~�C-7���ݽS�Re>\"_�\"��6!h���n��3�=<���]���<=�\���з��<ɽ\���g�>e��ՠ���vS��m8�\�=��P�9�|\�;\Z4�\nZ�EM6>\��Y=J�Y��<\�K��\'[�>�P>\�+=VT\�<�\��F\Z>\n�L�	1\Z=��\�=�\�\�=�|\�=\�\�m<\����f=�c�=co�{I=?��=\�~��\�@N�=�\�-~�>9J\�=~a��ws	�\�\�=�I\�mـ�3�y�\�4\"��)N�\�0��p\�=���>^L>\�\�^�\\�<Qq����<B�>_\�=0�T,==�����!�<�U >\�!{�\��6��`�>\�k�^@\�<@�鹼���bŤ����<��ֽ4Io<B�<E��\����W�=\r~�>�>��	�ݤ=e�g�=^d<�1�:p��)�\�=\�4�K\Z>\\D>!\�<��\0>[�>�\�<\�5��|S��ҒS�e֘��\�=\'(=�\�\n>��=',128,NULL,1,'2026-03-19 09:03:40'),(14,59,_binary '\���B�\0>\�K)<�(�{\'�w>�\����\0��Z$>�\��1Ke>\�w6�X\�A��\�[E�N3g>\��j�>`\0�\�޽\��\"��\"�=\��< %=�(:=�7��ly���\�ڽ�ݽ��5��0<��l��\\��\�\nX�gZ��\���;lޭ;�ԼVf����0>pB:\�(%��z=%q!=�ֈ>4#P>�l=\�!=U���}\�	>5���\�=\�\�\�=9\�=��=�e%�`\0��n0=�#\�=9\�\��\�/@<\�Ǥ=k���M�������\�-�>���=^�\�M\�4�\r\�\�=!�\�}#������\\�5��D+��ҙ�g<d��>\�\�=*Q�hQ�=s����-�<eV!>�k$>\�If��q8=5�����=\�\�l>|l���ނ����>BJ��V�\"=z��<\�^ͼ\�\�(�H�-=I:\�G�<���=\��\�\��ݽ�=z�Ƚy`�=2\�;�4\�=\�\�`=j�ؼۿ\Z��B\�.�=`<�g>W\�\">[7=��\�=\�F\�=x\\\�=00\�/E6��|�2�;\�7>\��3<�\��=~�.;',128,NULL,1,'2026-03-19 09:03:51'),(15,59,_binary '�½�h6\�=\�x�<��=�X\�@�\�K=�\�pz�˪۽\�\��=�?ν\�l>5[ܼ?OD�\�@ͽ.��\�?>�YX�`\���[ʆ��Zi<\�2�=%�H=K>=J6m<\'㚽[���;�ս�\�½\�b��\�\'��n�ǽ`\�|nR�\����e\0=}\�R��\�X���̽6\\>@j\�:UF�Q��=\�=qj>\��N>9\�B=*ݟ<\�h3�_\�	>F뽰=&�=�8�=\�\�=�����Q\�\�<�\��=s�D.�<Y��=�2��,�ϼ\�x���j_>\��#=f�ֽ��6�\�=��\\���L��<��NwP�r��\0�\�;VG�>XM\�=��O�f=?ч����<ݮ>��,>?\n�<OQ\�<j=��-ŀ<Ą>\������b��5�>OM�\�^o=\�\�\�<\�:i�\�7�If=�g۽\�S;PU=7��HI��\�U\�=�\n\"�=q&]����=\��=\���?۽@]��A\�\�=C\�P�HP�>\�\�>/x�=E�\�=��=\Z�\�=�LF���55�����\�j>F�<�\�=�ʞ�',128,NULL,1,'2026-03-19 09:04:01');
/*!40000 ALTER TABLE `khuon_mat_hoi_vien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lich_su_nhap_kho`
--

DROP TABLE IF EXISTS `lich_su_nhap_kho`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lich_su_nhap_kho` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chu_gym_id` int NOT NULL,
  `san_pham_id` int NOT NULL,
  `so_luong_nhap` int NOT NULL,
  `don_gia_nhap` decimal(10,2) NOT NULL,
  `tong_tien_chi` decimal(10,2) NOT NULL,
  `ghi_chu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_nhap` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lich_su_nhap_kho`
--

LOCK TABLES `lich_su_nhap_kho` WRITE;
/*!40000 ALTER TABLE `lich_su_nhap_kho` DISABLE KEYS */;
INSERT INTO `lich_su_nhap_kho` VALUES (1,1,5,10,36000.00,360000.00,'','2026-03-19 03:30:38'),(2,1,3,10,1260000.00,12600000.00,'','2026-03-19 03:30:38'),(3,1,1,12,6000.00,72000.00,'','2026-03-19 03:30:54'),(4,1,5,10,36000.00,360000.00,'Xe tải','2026-03-19 11:19:56'),(5,1,3,10,1260000.00,12600000.00,'','2026-03-20 11:58:19'),(6,1,4,10,90000.00,900000.00,'','2026-03-20 11:58:19'),(7,1,5,10,36000.00,360000.00,'','2026-03-20 13:25:41');
/*!40000 ALTER TABLE `lich_su_nhap_kho` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phieu_thu_chi`
--

DROP TABLE IF EXISTS `phieu_thu_chi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phieu_thu_chi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chu_gym_id` int NOT NULL,
  `loai_phieu` enum('THU','CHI') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Xác định đây là dòng tiền vào hay ra',
  `danh_muc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'VD: Tiền điện, Trả lương, Thanh lý, Khác...',
  `so_tien` decimal(10,2) NOT NULL,
  `nguoi_giao_dich` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Người nhận hoặc người nộp tiền',
  `ghi_chu` text COLLATE utf8mb4_unicode_ci,
  `ngay_tao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phieu_thu_chi`
--

LOCK TABLES `phieu_thu_chi` WRITE;
/*!40000 ALTER TABLE `phieu_thu_chi` DISABLE KEYS */;
INSERT INTO `phieu_thu_chi` VALUES (1,1,'CHI','Tiền điện',1000000.00,'Anh A','','2026-03-19 11:17:51');
/*!40000 ALTER TABLE `phieu_thu_chi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `san_pham`
--

DROP TABLE IF EXISTS `san_pham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `san_pham` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chu_gym_id` int NOT NULL,
  `ma_sp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_sp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phan_loai` enum('Thực phẩm bổ sung','Nước giải khát','Phụ kiện') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Nước giải khát',
  `gia_ban` decimal(10,2) NOT NULL,
  `ton_kho` int DEFAULT '0',
  `trang_thai` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `san_pham`
--

LOCK TABLES `san_pham` WRITE;
/*!40000 ALTER TABLE `san_pham` DISABLE KEYS */;
INSERT INTO `san_pham` VALUES (1,1,'WAT-001','Nước suối Aquafina','Nước giải khát',10000.00,50,1),(2,1,'WAT-002','Nước khoáng Lavie','Nước giải khát',10000.00,0,0),(3,1,'WHEY-01','Iso 100 5lbs','Thực phẩm bổ sung',2100000.00,23,1),(4,1,'ACC-001','Găng tay tập tạ Nam','Phụ kiện',150000.00,25,1),(5,1,'KP-001','Kẹo Protein 001','Thực phẩm bổ sung',60000.00,14,1);
/*!40000 ALTER TABLE `san_pham` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thanh_toan`
--

DROP TABLE IF EXISTS `thanh_toan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thanh_toan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dang_ky_id` int NOT NULL,
  `so_tien` decimal(10,2) NOT NULL,
  `ngay_thanh_toan` date DEFAULT NULL,
  `phuong_thuc` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dang_ky_id` (`dang_ky_id`),
  CONSTRAINT `thanh_toan_ibfk_1` FOREIGN KEY (`dang_ky_id`) REFERENCES `dang_ky_goi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thanh_toan`
--

LOCK TABLES `thanh_toan` WRITE;
/*!40000 ALTER TABLE `thanh_toan` DISABLE KEYS */;
INSERT INTO `thanh_toan` VALUES (1,1,400000.00,'2026-03-03','Tiền mặt'),(2,2,1000000.00,'2026-03-03','Chuyển khoản'),(3,3,350000.00,'2026-03-03','Tiền mặt'),(4,4,400000.00,'2026-03-05','Tiền mặt'),(5,5,1000000.00,'2026-03-05','Chuyển khoản'),(6,6,1800000.00,'2026-03-05','Tiền mặt'),(7,7,350000.00,'2026-03-05','Tiền mặt'),(8,8,1600000.00,'2026-03-05','Chuyển khoản'),(9,9,900000.00,'2026-03-05','Tiền mặt'),(10,88,1000000.00,'2026-03-19','Tiền mặt'),(11,89,1000000.00,'2026-03-19','Tiền mặt'),(12,90,3200000.00,'2026-03-19','Tiền mặt'),(13,91,500000.00,'2026-03-20','Tiền mặt'),(14,92,3200000.00,'2026-03-20','Tiền mặt');
/*!40000 ALTER TABLE `thanh_toan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thanh_toan_he_thong`
--

DROP TABLE IF EXISTS `thanh_toan_he_thong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thanh_toan_he_thong` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dang_ky_he_thong_id` int NOT NULL,
  `so_tien` decimal(10,2) NOT NULL,
  `ngay_thanh_toan` date DEFAULT NULL,
  `phuong_thuc` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dang_ky_he_thong_id` (`dang_ky_he_thong_id`),
  CONSTRAINT `thanh_toan_he_thong_ibfk_1` FOREIGN KEY (`dang_ky_he_thong_id`) REFERENCES `dang_ky_he_thong` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thanh_toan_he_thong`
--

LOCK TABLES `thanh_toan_he_thong` WRITE;
/*!40000 ALTER TABLE `thanh_toan_he_thong` DISABLE KEYS */;
INSERT INTO `thanh_toan_he_thong` VALUES (1,1,3000000.00,'2026-03-03','Chuyển khoản'),(2,2,1800000.00,'2026-03-03','Tiền mặt');
/*!40000 ALTER TABLE `thanh_toan_he_thong` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-21 13:40:17
