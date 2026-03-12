-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2026 at 05:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym_pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `chu_gym`
--

CREATE TABLE `chu_gym` (
  `id` int(11) NOT NULL,
  `ten_phong` varchar(100) NOT NULL,
  `ho_ten_chu` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sdt` varchar(15) DEFAULT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `ngay_tao` date DEFAULT curdate(),
  `trang_thai` enum('active','expired','pending') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chu_gym`
--

INSERT INTO `chu_gym` (`id`, `ten_phong`, `ho_ten_chu`, `email`, `sdt`, `mat_khau`, `ngay_tao`, `trang_thai`) VALUES
(1, 'Gym Fitness Pro', 'Nguyễn Văn A', 'chugyma@gmail.com', '0909000001', '123456', '2026-03-03', 'active'),
(2, 'Titan Gym', 'Trần Văn B', 'chugymb@gmail.com', '0909000002', '123456', '2026-03-03', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `dang_ky_goi`
--

CREATE TABLE `dang_ky_goi` (
  `id` int(11) NOT NULL,
  `hoi_vien_id` int(11) NOT NULL,
  `goi_tap_id` int(11) NOT NULL,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `trang_thai` enum('active','expired','paused','cancelled') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dang_ky_goi`
--

INSERT INTO `dang_ky_goi` (`id`, `hoi_vien_id`, `goi_tap_id`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`) VALUES
(1, 1, 1, '2026-03-01', '2026-04-01', 'active'),
(2, 2, 2, '2026-03-01', '2026-06-01', 'expired'),
(3, 3, 3, '2026-03-01', '2026-04-01', 'paused'),
(4, 4, 1, '2026-03-02', '2026-04-02', 'expired'),
(5, 5, 2, '2026-03-02', '2026-06-02', 'active'),
(6, 6, 4, '2026-03-02', '2026-09-02', 'paused'),
(7, 7, 3, '2026-03-02', '2026-04-02', 'expired'),
(8, 8, 6, '2026-03-02', '2026-09-02', 'active'),
(9, 9, 7, '2026-03-02', '2026-12-02', 'paused'),
(10, 1, 1, '2026-03-05', '2026-04-05', 'active'),
(11, 2, 1, '2026-03-05', '2026-04-05', 'active'),
(12, 4, 1, '2026-03-05', '2026-04-05', 'active'),
(13, 5, 1, '2026-03-05', '2026-04-05', 'active'),
(14, 6, 1, '2026-03-05', '2026-04-05', 'active'),
(15, 10, 1, '2026-03-05', '2026-04-05', 'active'),
(16, 11, 1, '2026-03-05', '2026-04-05', 'active'),
(17, 12, 1, '2026-03-05', '2026-04-05', 'active'),
(18, 13, 1, '2026-03-05', '2026-04-05', 'active'),
(19, 14, 1, '2026-03-05', '2026-04-05', 'active'),
(20, 15, 1, '2026-03-05', '2026-04-05', 'active'),
(21, 16, 1, '2026-03-05', '2026-04-05', 'active'),
(22, 17, 1, '2026-03-05', '2026-04-05', 'active'),
(23, 18, 1, '2026-03-05', '2026-04-05', 'active'),
(24, 19, 1, '2026-03-05', '2026-04-05', 'active'),
(25, 3, 3, '2026-03-05', '2026-04-05', 'active'),
(26, 7, 3, '2026-03-05', '2026-04-05', 'active'),
(27, 8, 3, '2026-03-05', '2026-04-05', 'active'),
(28, 9, 3, '2026-03-05', '2026-04-05', 'active'),
(29, 20, 3, '2026-03-05', '2026-04-05', 'active'),
(30, 21, 3, '2026-03-05', '2026-04-05', 'active'),
(31, 22, 3, '2026-03-05', '2026-04-05', 'active'),
(32, 23, 3, '2026-03-05', '2026-04-05', 'active'),
(33, 24, 3, '2026-03-05', '2026-04-05', 'active'),
(34, 25, 3, '2026-03-05', '2026-04-05', 'active'),
(35, 26, 3, '2026-03-05', '2026-04-05', 'active'),
(36, 27, 3, '2026-03-05', '2026-04-05', 'active'),
(37, 28, 3, '2026-03-05', '2026-04-05', 'active'),
(38, 29, 3, '2026-03-05', '2026-04-05', 'active'),
(39, 30, 3, '2026-03-05', '2026-04-05', 'active'),
(40, 31, 3, '2026-03-05', '2026-04-05', 'active'),
(41, 32, 3, '2026-03-05', '2026-04-05', 'active'),
(42, 33, 3, '2026-03-05', '2026-04-05', 'active'),
(43, 34, 3, '2026-03-05', '2026-04-05', 'active'),
(44, 35, 3, '2026-03-05', '2026-04-05', 'active'),
(45, 36, 3, '2026-03-05', '2026-04-05', 'active'),
(46, 37, 3, '2026-03-05', '2026-04-05', 'active'),
(47, 38, 3, '2026-03-05', '2026-04-05', 'active'),
(48, 39, 3, '2026-03-05', '2026-04-05', 'active'),
(65, 10, 1, '2025-12-01', '2026-01-01', 'expired'),
(66, 11, 1, '2025-11-01', '2025-12-01', 'expired'),
(67, 20, 3, '2025-12-01', '2026-01-01', 'expired'),
(68, 21, 3, '2025-11-01', '2025-12-01', 'expired'),
(69, 12, 1, '2026-02-10', '2026-03-08', 'expired'),
(70, 13, 1, '2026-02-10', '2026-03-09', 'active'),
(71, 22, 3, '2026-02-10', '2026-03-08', 'expired'),
(72, 23, 3, '2026-02-10', '2026-03-09', 'active'),
(73, 14, 1, '2026-02-01', '2026-04-01', 'paused'),
(74, 15, 1, '2026-02-01', '2026-04-01', 'paused'),
(75, 24, 3, '2026-02-01', '2026-04-01', 'paused'),
(76, 25, 3, '2026-02-01', '2026-04-01', 'paused'),
(77, 16, 1, '2026-02-01', '2026-04-01', 'cancelled'),
(78, 17, 1, '2026-02-01', '2026-04-01', 'cancelled'),
(79, 26, 3, '2026-02-01', '2026-04-01', 'cancelled'),
(80, 27, 3, '2026-02-01', '2026-04-01', 'cancelled'),
(81, 56, 1, '2026-03-06', '2026-04-05', 'active'),
(82, 57, 2, '2026-03-06', '2026-06-04', 'active'),
(83, 58, 4, '2026-03-06', '2026-09-02', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `dang_ky_he_thong`
--

CREATE TABLE `dang_ky_he_thong` (
  `id` int(11) NOT NULL,
  `chu_gym_id` int(11) NOT NULL,
  `goi_he_thong_id` int(11) NOT NULL,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `trang_thai` enum('active','expired','pending') DEFAULT 'pending',
  `so_thang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dang_ky_he_thong`
--

INSERT INTO `dang_ky_he_thong` (`id`, `chu_gym_id`, `goi_he_thong_id`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`, `so_thang`) VALUES
(1, 1, 2, '2026-03-01', '2026-09-01', 'active', 6),
(2, 2, 1, '2026-03-01', '2026-09-01', 'active', 6);

-- --------------------------------------------------------

--
-- Table structure for table `diem_danh`
--

CREATE TABLE `diem_danh` (
  `id` int(11) NOT NULL,
  `hoi_vien_id` int(11) NOT NULL,
  `thoi_gian` datetime DEFAULT current_timestamp(),
  `hinh_anh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diem_danh`
--

INSERT INTO `diem_danh` (`id`, `hoi_vien_id`, `thoi_gian`, `hinh_anh`) VALUES
(1, 1, '2026-03-03 11:36:49', 'khang_01032026.jpg'),
(2, 2, '2026-03-03 11:36:49', 'lan_01032026.jpg'),
(3, 1, '2026-03-03 11:36:49', 'khang_02032026.jpg'),
(4, 4, '2026-03-04 07:20:00', 'bao_0403.jpg'),
(5, 5, '2026-03-04 08:15:00', 'mai_0403.jpg'),
(6, 6, '2026-03-04 17:30:00', 'tam_0403.jpg'),
(7, 7, '2026-03-04 18:00:00', 'tung_0403.jpg'),
(8, 8, '2026-03-04 19:10:00', 'hoa_0403.jpg'),
(9, 9, '2026-03-04 20:00:00', 'phuc_0403.jpg'),
(10, 1, '2026-03-05 07:10:00', 'check1.jpg'),
(11, 2, '2026-03-05 07:15:00', 'check2.jpg'),
(12, 3, '2026-03-05 07:20:00', 'check3.jpg'),
(13, 4, '2026-03-05 07:30:00', 'check4.jpg'),
(14, 5, '2026-03-05 07:45:00', 'check5.jpg'),
(15, 6, '2026-03-05 08:00:00', 'check6.jpg'),
(16, 7, '2026-03-05 08:10:00', 'check7.jpg'),
(17, 8, '2026-03-05 08:20:00', 'check8.jpg'),
(18, 9, '2026-03-05 08:30:00', 'check9.jpg'),
(19, 10, '2026-03-05 08:40:00', 'check10.jpg'),
(20, 11, '2026-03-05 09:00:00', 'check11.jpg'),
(21, 12, '2026-03-05 09:10:00', 'check12.jpg'),
(22, 13, '2026-03-05 09:20:00', 'check13.jpg'),
(23, 14, '2026-03-05 09:40:00', 'check14.jpg'),
(24, 15, '2026-03-05 10:00:00', 'check15.jpg'),
(25, 56, '2026-03-07 00:13:21', NULL),
(26, 56, '2026-03-09 11:06:41', NULL),
(27, 57, '2026-03-09 11:16:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `goi_he_thong`
--

CREATE TABLE `goi_he_thong` (
  `id` int(11) NOT NULL,
  `ten_goi` varchar(100) NOT NULL,
  `gia` decimal(10,2) NOT NULL,
  `thoi_han_thang` int(11) NOT NULL,
  `mo_ta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goi_he_thong`
--

INSERT INTO `goi_he_thong` (`id`, `ten_goi`, `gia`, `thoi_han_thang`, `mo_ta`) VALUES
(1, 'Cơ bản', 300000.00, 1, 'Quản lý hội viên cơ bản'),
(2, 'Nâng cao', 500000.00, 1, 'Có báo cáo và thống kê'),
(3, 'Chuyên nghiệp', 1000000.00, 1, 'Full tính năng + nhận diện khuôn mặt');

-- --------------------------------------------------------

--
-- Table structure for table `goi_tap`
--

CREATE TABLE `goi_tap` (
  `id` int(11) NOT NULL,
  `ten_goi` varchar(100) NOT NULL,
  `thoi_han_thang` int(11) NOT NULL,
  `gia` decimal(10,2) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `chu_gym_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goi_tap`
--

INSERT INTO `goi_tap` (`id`, `ten_goi`, `thoi_han_thang`, `gia`, `mo_ta`, `chu_gym_id`) VALUES
(1, 'Gói 1 tháng', 1, 400000.00, 'Tập tự do', 1),
(2, 'Gói 3 tháng', 3, 1000000.00, 'Giảm giá ưu đãi', 1),
(3, 'Gói 1 tháng', 1, 350000.00, 'Tập tự do', 2),
(4, 'Gói 6 tháng', 6, 1800000.00, 'Ưu đãi dài hạn', 1),
(5, 'Gói VIP 12 tháng', 12, 3200000.00, 'Có PT hỗ trợ', 1),
(6, 'Gói 3 tháng', 3, 900000.00, 'Ưu đãi giảm giá', 2),
(7, 'Gói 6 tháng', 6, 1600000.00, 'Tập tự do', 2);

-- --------------------------------------------------------

--
-- Table structure for table `hoi_vien`
--

CREATE TABLE `hoi_vien` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `sdt` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `gioi_tinh` varchar(10) DEFAULT NULL,
  `ngay_dang_ky` date DEFAULT curdate(),
  `trang_thai` enum('active','expired') DEFAULT 'active',
  `chu_gym_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hoi_vien`
--

INSERT INTO `hoi_vien` (`id`, `ho_ten`, `sdt`, `email`, `ngay_sinh`, `gioi_tinh`, `ngay_dang_ky`, `trang_thai`, `chu_gym_id`) VALUES
(1, 'Lê Minh Khang', '0911000001', 'khang@gmail.com', NULL, 'Nam', '2026-03-03', 'active', 1),
(2, 'Phạm Thị Lan', '0911000002', 'lan@gmail.com', NULL, 'Nữ', '2026-03-03', 'active', 1),
(3, 'Đỗ Quốc Huy', '0911000003', 'huy@gmail.com', NULL, 'Nam', '2026-03-03', 'active', 2),
(4, 'Nguyễn Quốc Bảo', '0911000004', 'bao@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 1),
(5, 'Trần Thị Mai', '0911000005', 'mai@gmail.com', NULL, 'Nữ', '2026-03-05', 'active', 1),
(6, 'Phạm Minh Tâm', '0911000006', 'tam@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 1),
(7, 'Lê Thanh Tùng', '0911000007', 'tung@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(8, 'Nguyễn Thị Hoa', '0911000008', 'hoa@gmail.com', NULL, 'Nữ', '2026-03-05', 'active', 2),
(9, 'Võ Hoàng Phúc', '0911000009', 'phuc@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(10, 'Nguyễn Văn Nam', '0911000004', 'nam@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 1),
(11, 'Trần Minh Phúc', '0911000005', 'phuc@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 1),
(12, 'Lê Thị Mai', '0911000006', 'mai@gmail.com', NULL, 'Nữ', '2026-03-05', 'active', 1),
(13, 'Phạm Quốc Bảo', '0911000007', 'bao@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 1),
(14, 'Đỗ Minh Tuấn', '0911000008', 'tuan@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 1),
(15, 'Nguyễn Thị Hạnh', '0911000009', 'hanh@gmail.com', NULL, 'Nữ', '2026-03-05', 'active', 1),
(16, 'Trần Anh Khoa', '0911000010', 'khoa@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 1),
(17, 'Lê Văn Long', '0911000011', 'long@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 1),
(18, 'Phạm Thị Ly', '0911000012', 'ly@gmail.com', NULL, 'Nữ', '2026-03-05', 'active', 1),
(19, 'Hoàng Minh Đức', '0911000013', 'duc@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 1),
(20, 'Nguyễn Văn Hùng', '0912000001', 'hung@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(21, 'Trần Thị Nga', '0912000002', 'nga@gmail.com', NULL, 'Nữ', '2026-03-05', 'active', 2),
(22, 'Lê Văn Dũng', '0912000003', 'dung@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(23, 'Phạm Minh Quân', '0912000004', 'quan@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(24, 'Đỗ Thị Lan', '0912000005', 'lan2@gmail.com', NULL, 'Nữ', '2026-03-05', 'active', 2),
(25, 'Nguyễn Thành Đạt', '0912000006', 'dat@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(26, 'Trần Quốc Khánh', '0912000007', 'khanh@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(27, 'Lê Thị Thảo', '0912000008', 'thao@gmail.com', NULL, 'Nữ', '2026-03-05', 'active', 2),
(28, 'Phạm Văn Trung', '0912000009', 'trung@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(29, 'Đỗ Minh Hiếu', '0912000010', 'hieu@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(30, 'Nguyễn Quốc Anh', '0912000011', 'anh@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(31, 'Trần Thị Bích', '0912000012', 'bich@gmail.com', NULL, 'Nữ', '2026-03-05', 'active', 2),
(32, 'Lê Văn Hải', '0912000013', 'hai@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(33, 'Phạm Thị Nhung', '0912000014', 'nhung@gmail.com', NULL, 'Nữ', '2026-03-05', 'active', 2),
(34, 'Đỗ Văn Lâm', '0912000015', 'lam@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(35, 'Nguyễn Minh Tuấn', '0912000016', 'tuan2@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(36, 'Trần Thanh Sơn', '0912000017', 'son@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(37, 'Lê Thị Ngọc', '0912000018', 'ngoc@gmail.com', NULL, 'Nữ', '2026-03-05', 'active', 2),
(38, 'Phạm Văn Bình', '0912000019', 'binh@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(39, 'Đỗ Minh Tâm', '0912000020', 'tam@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2),
(56, 'Lưu Chí Vỹ', '0398556524', NULL, NULL, 'Nam', '2026-03-06', 'active', 1),
(57, 'Trịnh Bình Khang', '0123456678', NULL, NULL, 'Nam', '2026-03-06', 'active', 1),
(58, 'Trịnh Bình Khinh', '0123456678', NULL, NULL, 'Khác', '2026-03-06', 'active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `khuon_mat_hoi_vien`
--

CREATE TABLE `khuon_mat_hoi_vien` (
  `id` int(11) NOT NULL,
  `hoi_vien_id` int(11) NOT NULL,
  `embedding` longblob NOT NULL,
  `embedding_size` smallint(6) NOT NULL DEFAULT 128,
  `anh_mau` varchar(255) DEFAULT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT 1,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khuon_mat_hoi_vien`
--

INSERT INTO `khuon_mat_hoi_vien` (`id`, `hoi_vien_id`, `embedding`, `embedding_size`, `anh_mau`, `trang_thai`, `ngay_tao`) VALUES
(1, 56, 0x5c8b07bebf2e983de950403d3e058fbcd14220beb91a1cbdced794bdf3830dbe5090903da67c01be14dc713e1aaae3bc7e5135be3754c9bdc52427bda3672b3eeaf41bbe970dfbbd983f94bd0e51e43bd1a5aa3dc02e8d3deb762d3dc31b133c203ae0bddf43c0bec53c28bdf64c17bd0d7d553c1bec5cbd263ea8bdc1ae8e3d400f57be3b543abd26c41f3d17aae63d951062bc70bff53c96ee143e90cabe3ba0bb90befa58a23d31abc23c3d0e8e3eabcd403eaaaea63d60c1713a8cefffbd3fcdca3dab8221be401d733d0234183e411b8c3d560b253d3ceb20bd804ad8bde8a1623b3baba23dfd43ecbd230dbe3cf295143ef5c7dbbd69c493bbca6e05be5a36553e5378313cac0409bef5f71bbe2b397d3db3ea1dbeae64d4bdf2c52c3dc2ed27be9a4d3bbe8166b2be3466303dbda1c23e40bd083e15ca38bed088883bba163cbc3218cb3c1cb4ff3d671a273ea07539bb32493f3d77bd72bde829d83c5415613e7a904abd13f91ebd64f9853e5eaea93bf458af3d23deae3b7e5e323d9b644bbd01c0f53c40f4cebd68a1053dfa9dcb3b1fb29fbdcc9c203d224a0d3e82ea13bed060353e85fb60bd466dd53d98f4633dafff043d676eb5bd4b1fe3bd5e7cad3d422345be39126c3eef1b6f3ed943ec3d096cef3d966f0b3ef155a83db265b0bc8448563d7bdb5bbe5ded23bddf6eec3d8a6189bdc042db3d3e8f1f3d, 128, NULL, 0, '2026-03-07 00:13:19'),
(2, 56, 0x48b2adbd463ea63d7255913cb42e40bd623cecbd3d5d4abd01689bbd787aecbd359f6c3da6da04bea4a0813e704038bd3aa937be8d69a3bdf507e5bcbb3f1c3e3c2f38bec2fba2bd8190acbd980e383c1b13ac3d4099913d960e7d3cb1c20e3da43202be9524b4be7dc550bd608febbcb09abc3c1ea71dbdaac278bd7cf2203d7c045fbee1bb55bd48ab1f3d2cab773d6c9335bd638e68bc59591c3e18749c3b6b3285beae63c73da806483d2d18893ebfea4a3e5dcb883d00031dbc8fb700bef173fe3dd9363abef3e3ca3c5ab4003e8aa38a3d60fd813d6418d5bc37dff6bd60de223d0245953d3dfdfbbdccc8a73b3a60c23dda6dbcbdec76bd3c106fc2bdd5ae693e5fd50e3c56720bbe32df0fbe848f833dacdd1bbe32399abd05d17b3dc23605be0ccd31bec2bbadbe10b1ac3c2554b73e1b85063e9dbf48bee65d023d21faf9bc6267c93cb57e253e6e82113e23310ebcafc4a33c81988bbd3249e53c0bf0793e4a1d60bd6ba149bd2d5e8c3e4a52743c2080ac3d38a7353da030143dc2a7c2bdbe6a963a9c33c3bd0a65173dbc62323dbd7988bd121bcf3cdae61e3eaf0419beda184e3e368500bd35b6be3d2d689e3df91c123d5a7fb2bdcd25bdbd7b8b933dcbaa51be92506f3e0420323e2b9abc3dc467ea3dd3050b3e7281643d28146dbddcde3f3d58e859be818344bd1e66e63d70a581bd80f8103ee8d67e3a, 128, NULL, 1, '2026-03-07 00:16:19'),
(3, 57, 0xbd371bbe7c9bcc3d3566a63d02b7eb3b565143bde71d8cbd771a0bbd018be9bd00c7de3d110283bdca2c763eee6cdbbda74168be27e5fabd2ebd5fbd85d0223ee5b110be194dcdbd5cdc4bbd0d31ffbb8825c93d1fdea4baf19459bc3bf8cd3d785cabbd0c24b3be8ab48ebd1858adbd9df4193d6d8fb4bcf365afbd6b585f3de36f6dbefbb6b4bdaf63d1bc7063853d7a0055bc194fa03c97a6033eba87dfbc273044be72e1b3bca189db3b565a863e5a15433e0975dd3d567914bb6f5397bd510fa33d39e677be4bcf2c3d13ea143ef3cbba3dca50b03d280299bc080a1ebe57981fbdeacd973d96c3fabdae3c5c3da32c063dcf7bd8bddf7a1bbde39208be3a4b883e50c13d3dcc432cbeefe3e6bddf1edc3d5e392cbeb8133cbd30d4853ddae6f4bda17d25be1cf6ccbee4cddc3d195bcc3edfdde13d0f3454be6eb3bf3a01f7abbd8a9ef33ce1edd33d7290df3df5185bbc057f2e3cbe0ab0bd620212bdc26d363e926286bd33e215bd9f76633e48d31fbdbe85c13dd999c1bc68f3433dad494cbd465c04bb0cb7cfbd1e11483dd446ca3ceb37a3bc7bf33abca523c43d92d0fcbd99b5f73d7526693cfa08463d46ffda3c6249193c0eff32be4822d5bd3a63fc3dcffc6cbe8dd0633e6221383ec17da33dd605093e017be23d385bb63d3ea2b0bc6268ea3b0c4f17be12fd35bda868363ee00381bde33b3a3db6787ebb, 128, NULL, 1, '2026-03-09 11:16:09'),
(4, 57, 0x7a901abe7be8173e2953343d44b67ebc533bf0bdaf7ac3bc5fc0afbd59a4e6bdb4b2033e99ac40bd730a663e66020bbdaae54cbe6f11e1bd7c969abd34d22c3ea6fefcbdfac034bedbec44bd24b4603d0f74103e88878cbc4712d33cfde8743d75f907be8dfcbabe69bf6abd454ebbbc9e22533d97530bbd6b1d99bd7416463ba0e283be7ec495bdee30793c70a10a3ea419b0bc3d9db1bb5c311a3e868bbfbbc9a58abe48c97f3dd98639bc8033823e8cd24c3ece4be73ddc6b563d100511be71cd9f3d10443fbe0c788a3dfafa3a3e9eddd43d181c923dba7f1dbdebba18be0b10cf3aa9f7be3d30fc0bbeece7a03cdcba8d3d6b2e8cbd1904bebcd8131ebe245a5c3ee0fb563dc1c700bec99f42bea5bb073e14e717be877797bd3c40d73db3dc07be8fd034bee4b2c1be453e433d085ec03e38d1073e64e359beb0ce82bb82942fbdbb69953d6e884e3d1824b93da97626bd39764e3d52f601be930799bc488f733e5a8f6bbd4ae034bd93c75d3e707cee3cf268a33d2adeb23bc1c9c73d614c66bdd38ce43cb299eabdc69904bbd95f363d0d4aa5bcd922843cfdeafb3d21b011be6631153ea9320fbd7f18903dc30903b87ea3d13c36ec08be8d83bcbd8346f83df32d59bea68f843e5d19623ed7bdaf3d3334c63debb4203ec5a9bc3d732706bd4ea3213ce62327be55838fbd31eece3d06d48abd1c00d13df8bf293d, 128, NULL, 1, '2026-03-09 11:16:13'),
(5, 57, 0xb56b10bee29e3c3e7a14af3df1dca33c1f6cbcbc904f0abd9bda9abdf54fb9bd8656dc3d435bc5bcdb88763e45d60cbd768665becfc723be0f3174bdf6bd3c3e7dd723becf060abe5c9221bd4216003dc64a053e742f94bb4c4c553cec8c833dea44bebd79e6b8be789f1cbd36313ebda5ad483d250f52bdb11c9ebd639ed73c3cf572bee72495bd02a123bd0ab2903ddc24323c4ee9653c2dab1e3ec20df93a14fe4fbe89d4ee3c9326bfbc0529843e2dec703ea6cdbf3d4c01183d9f19e7bd39546b3d920760be81c8093d4317303e05c6e33d797b8e3d0e378ebdc64c1ebec7703bbd9b00c93c42af21be04d9ed3c1ba9fc3c805fb4bd3a084fbdc29cc6bda7215c3e7cf9793db8820cbe2cae3bbe68be003ea61725be76c680bda32d753daa13bfbd2f1d1abef1cec3be0171883d64e1a93e6d3da13d37d978be2380de3ce6aec3bd1d97423c1881853d3141ba3df38d23bd1a47823c94f5f5bd3a7ed1bcf8e0483ebcb061bd1caf2ebd5db96c3ec879923b480eb33da0f1433c3f3dc33df0d53bbd06016a3df2ecebbdcc92953cc311523d9b07b3bc0cbc313cc2fec93d9be1eebdfc0e0e3e7ee4f13a8ce7a43d517e493de2742d3ca94a43beaa9fe5bd32b3123e07d443be2fd1773e8266443e9aec633d5cebcc3d607b373e0470023e5c914abc6a50733bd13921be58a225bd58d6093eef6f81bd90678c3d2029033d, 128, NULL, 1, '2026-03-09 11:16:18'),
(6, 57, 0x3dc0a6bd64562a3ea9746a3dffe772bd9a1ca6bd116688bdee807dbdf277e5bd2e4f123e67367bbd61647d3e8069ebbdcf4086be0ff7edbd5c09ebbd62211d3ef3fd3abe1a4208beffe365bc4237533d233d253e190b02bdda1215bb4e2db53d9971e2bdfc59ccbefb16babd730135bd5104693c7aad82bda471aebd6931ee3c219151be4da55abde4ed81bc02f6653dec8b2bbc483224bdb91c063ea5c7023d03bb6ebe22e9e43c08ad45bdfed8883e937c203e8deca53db3618b3d047b26becae0ce3de96d38bef1df0f3ded845b3eba8ed03dd7b6353d700900bd17e5dcbd47fb44bda02a1b3eb96733be9e12183d4cbf573d8b9badbdcb5c84bcb79925be9ff4443e995bd43df1b119beee5f09be9bd50f3ec21311bea3898cbdb2b63b3d5dec03be561a3bbed1fca9bed284253d22c5d33e37010a3e53303fbeda6102bd956cecbdf3bf073d7da1a53dd4fad53d36aea2bda5624d3d7b97e7bd906f0e3d59394c3e7abaa8bd98a117bdcb69543e5cf2d9bcc9e1e03df6a7dcbc9bcbea3c94e7d3bd46ee513df22ab1bdf0cfbc3be1df7e3cb5482abd8e18c139a193df3d58a900be1ac1bc3d4c8aba3c17ea373c0f80b13b0bfa193c9253ddbd7207d0bdb8ece13d95285dbe8f5f603edcc73c3ea9c9d93d81dffc3d2e24d83d76167c3d267cc5bc4ae3bcbdf70704beb668e5bca331143e02421a3b94c7d23dd39566bd, 128, NULL, 1, '2026-03-09 11:16:22'),
(7, 57, 0x86460cbe07a6d93dc8728a3de13ab8bc74b897bd778784bda8089ebb81dcebbdcdee133e4c5a8ebd0f02733ec1b4b4bdd4cf66beec03cbbd55a250bd0520113ec8d103bedac2ddbde03021bd8a1f2abd1a56c43d7a57dc3cf963e13b25fdef3d5b820dbe739cafbea1a98ebd3e30ddbde3cfe4bb9f1bf1bcd990acbdd9c59b3dcdcd58be3901d7bd675c37bc1680af3dddf49b3c8bb4823d2fae843d813e2cbccef641be7657173c1341e93cf5d78d3e3f48283e4635f93da54be3ba343573bd174f473b583a88bedfd3b23d37cfe33d91fa903d30c07a3d0896c33aab7c3bbece7872bdd2d1bc3dc85c15be8e7edd3de30d5b3de11b76bd233df7bb8d2dbbbd5779813e7043f13d29f431be84234abd7813aa3d495f51be938389bdc022b43bb21dd2bde18034beee91c6be24639c3d90f5d13e2132263e1c655cbe1a85f9bc2fdab6bd558c8e3d7d8fc53de0c3813dcbec91bdde6f3d3d3097b5bd572b63bb381c253e2803f8b9b1d132bd58a4913e9c123abd78a3b03d371c483c413e8c3d3de67fbd947921bde35f09be77adc43c426383bc4a3d9bbdc8234dbca77ee93d7f753dbe46d9023e1faaa3ba60acbd3c74e94fbc8691a53d3cc80ebeed659dbd1f5b183e1c024bbe3b9a583e43d8643e0b3fa83d06932f3e9512e83d91b72d3d497c25bc099d0abdfb7ef1bd19e21bbd2c42093e48a8dfbdcbe2ac3d45ee373d, 128, NULL, 1, '2026-03-09 11:16:25'),
(8, 57, 0xd4b41dbe37aa8c3d7efa983d4bb19cbc0d778dbdd1849dbd1b4af2bc6416e0bdc3cdb93d7fbf8cbd4e5b853e47e1ddbdc35575be9a0103be0afea1bd16c3303e008b13be0fe4cfbd361256bdb4a1c3bb5abbcf3de76f3d3cfffdc0bc99ddd13d516eb9bd38a7b0bea21792bdbe6f83bdd53bee3c6a5202bd92aa98bd561ca23d291f70bee1ff8dbdc7cd30bc70dcad3dffaf9c3c6507cb3c306afc3d3b1648bb67624cbe056c43bc5fa4593cd3768b3ee798333e1f2dd53d865db43a52e9a8bde202a13d66be78be98c7093da753053eb915fb3d4d2f893d809d45bda6ab1fbe1e16b1bce7878f3d5ae102bed7a21d3dbc8f423d859605beee6d47bd576c0abefd738c3e3a89d73c398032be2d9efebdbd9cf93d30902abeba2f6fbddabb863dcafae6bd816e0abed6c8d1bece0ad33d3893cf3e4a83e43dc78969bed9d0203c3430e4bd6824523d0437a33d6445bc3de28304bd243efd3c9456ecbdfd4d1fbd6c0a423efa2391bd7733a1bcd8816c3e284a40bccb50da3d3a1522bc1d9a063ddff66bbd09aa4ebc54b8aabde466243df451e53cd39014bdfd78bd3b19f4d93dd89418be0682183ee1ad93bbc7020c3df0ff203d6df8ac3c5e0720be2b7ae9bdf6f4f13db90576be8ff64c3e3c613e3e6e59db3d34410d3e77e1fe3d8203d23d1bb049bda4a81b3c9cf614be79fb56bd60a0373e0b54b0bd5bc8813d4518653b, 128, NULL, 1, '2026-03-09 11:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `thanh_toan`
--

CREATE TABLE `thanh_toan` (
  `id` int(11) NOT NULL,
  `dang_ky_id` int(11) NOT NULL,
  `so_tien` decimal(10,2) NOT NULL,
  `ngay_thanh_toan` date DEFAULT curdate(),
  `phuong_thuc` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thanh_toan`
--

INSERT INTO `thanh_toan` (`id`, `dang_ky_id`, `so_tien`, `ngay_thanh_toan`, `phuong_thuc`) VALUES
(1, 1, 400000.00, '2026-03-03', 'Tiền mặt'),
(2, 2, 1000000.00, '2026-03-03', 'Chuyển khoản'),
(3, 3, 350000.00, '2026-03-03', 'Tiền mặt'),
(4, 4, 400000.00, '2026-03-05', 'Tiền mặt'),
(5, 5, 1000000.00, '2026-03-05', 'Chuyển khoản'),
(6, 6, 1800000.00, '2026-03-05', 'Tiền mặt'),
(7, 7, 350000.00, '2026-03-05', 'Tiền mặt'),
(8, 8, 1600000.00, '2026-03-05', 'Chuyển khoản'),
(9, 9, 900000.00, '2026-03-05', 'Tiền mặt');

-- --------------------------------------------------------

--
-- Table structure for table `thanh_toan_he_thong`
--

CREATE TABLE `thanh_toan_he_thong` (
  `id` int(11) NOT NULL,
  `dang_ky_he_thong_id` int(11) NOT NULL,
  `so_tien` decimal(10,2) NOT NULL,
  `ngay_thanh_toan` date DEFAULT curdate(),
  `phuong_thuc` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thanh_toan_he_thong`
--

INSERT INTO `thanh_toan_he_thong` (`id`, `dang_ky_he_thong_id`, `so_tien`, `ngay_thanh_toan`, `phuong_thuc`) VALUES
(1, 1, 3000000.00, '2026-03-03', 'Chuyển khoản'),
(2, 2, 1800000.00, '2026-03-03', 'Tiền mặt');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chu_gym`
--
ALTER TABLE `chu_gym`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `dang_ky_goi`
--
ALTER TABLE `dang_ky_goi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hoi_vien_id` (`hoi_vien_id`),
  ADD KEY `goi_tap_id` (`goi_tap_id`);

--
-- Indexes for table `dang_ky_he_thong`
--
ALTER TABLE `dang_ky_he_thong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chu_gym_id` (`chu_gym_id`),
  ADD KEY `goi_he_thong_id` (`goi_he_thong_id`);

--
-- Indexes for table `diem_danh`
--
ALTER TABLE `diem_danh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hoi_vien_id` (`hoi_vien_id`);

--
-- Indexes for table `goi_he_thong`
--
ALTER TABLE `goi_he_thong`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goi_tap`
--
ALTER TABLE `goi_tap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chu_gym_id` (`chu_gym_id`);

--
-- Indexes for table `hoi_vien`
--
ALTER TABLE `hoi_vien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chu_gym_id` (`chu_gym_id`);

--
-- Indexes for table `khuon_mat_hoi_vien`
--
ALTER TABLE `khuon_mat_hoi_vien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_km_hv_trang_thai` (`hoi_vien_id`,`trang_thai`);

--
-- Indexes for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dang_ky_id` (`dang_ky_id`);

--
-- Indexes for table `thanh_toan_he_thong`
--
ALTER TABLE `thanh_toan_he_thong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dang_ky_he_thong_id` (`dang_ky_he_thong_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chu_gym`
--
ALTER TABLE `chu_gym`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dang_ky_goi`
--
ALTER TABLE `dang_ky_goi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `dang_ky_he_thong`
--
ALTER TABLE `dang_ky_he_thong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `diem_danh`
--
ALTER TABLE `diem_danh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `goi_he_thong`
--
ALTER TABLE `goi_he_thong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `goi_tap`
--
ALTER TABLE `goi_tap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hoi_vien`
--
ALTER TABLE `hoi_vien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `khuon_mat_hoi_vien`
--
ALTER TABLE `khuon_mat_hoi_vien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `thanh_toan_he_thong`
--
ALTER TABLE `thanh_toan_he_thong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dang_ky_goi`
--
ALTER TABLE `dang_ky_goi`
  ADD CONSTRAINT `dang_ky_goi_ibfk_1` FOREIGN KEY (`hoi_vien_id`) REFERENCES `hoi_vien` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dang_ky_goi_ibfk_2` FOREIGN KEY (`goi_tap_id`) REFERENCES `goi_tap` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dang_ky_he_thong`
--
ALTER TABLE `dang_ky_he_thong`
  ADD CONSTRAINT `dang_ky_he_thong_ibfk_1` FOREIGN KEY (`chu_gym_id`) REFERENCES `chu_gym` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dang_ky_he_thong_ibfk_2` FOREIGN KEY (`goi_he_thong_id`) REFERENCES `goi_he_thong` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diem_danh`
--
ALTER TABLE `diem_danh`
  ADD CONSTRAINT `diem_danh_ibfk_1` FOREIGN KEY (`hoi_vien_id`) REFERENCES `hoi_vien` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goi_tap`
--
ALTER TABLE `goi_tap`
  ADD CONSTRAINT `goi_tap_ibfk_1` FOREIGN KEY (`chu_gym_id`) REFERENCES `chu_gym` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hoi_vien`
--
ALTER TABLE `hoi_vien`
  ADD CONSTRAINT `hoi_vien_ibfk_1` FOREIGN KEY (`chu_gym_id`) REFERENCES `chu_gym` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `khuon_mat_hoi_vien`
--
ALTER TABLE `khuon_mat_hoi_vien`
  ADD CONSTRAINT `fk_khuon_mat_hoi_vien_hoi_vien` FOREIGN KEY (`hoi_vien_id`) REFERENCES `hoi_vien` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD CONSTRAINT `thanh_toan_ibfk_1` FOREIGN KEY (`dang_ky_id`) REFERENCES `dang_ky_goi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thanh_toan_he_thong`
--
ALTER TABLE `thanh_toan_he_thong`
  ADD CONSTRAINT `thanh_toan_he_thong_ibfk_1` FOREIGN KEY (`dang_ky_he_thong_id`) REFERENCES `dang_ky_he_thong` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
