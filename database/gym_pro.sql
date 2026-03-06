-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2026 at 05:37 PM
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
  `ngay_tao` DATETIME DEFAULT CURRENT_TIMESTAMP,
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
(48, 39, 3, '2026-03-05', '2026-04-05', 'active');

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
(24, 15, '2026-03-05 10:00:00', 'check15.jpg');

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
  `ngay_sinh` DATE DEFAULT NULL,
  `gioi_tinh` varchar(10) DEFAULT NULL,
  `ngay_dang_ky` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `trang_thai` enum('active','expired','pending') DEFAULT 'active',
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
(39, 'Đỗ Minh Tâm', '0912000020', 'tam@gmail.com', NULL, 'Nam', '2026-03-05', 'active', 2);

-- --------------------------------------------------------

--
-- Table structure for table `thanh_toan`
--

CREATE TABLE `thanh_toan` (
  `id` int(11) NOT NULL,
  `dang_ky_id` int(11) NOT NULL,
  `so_tien` decimal(10,2) NOT NULL,
  `ngay_thanh_toan`  DATETIME DEFAULT CURRENT_TIMESTAMP,
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
  `ngay_thanh_toan` DATETIME DEFAULT CURRENT_TIMESTAMP,
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `dang_ky_he_thong`
--
ALTER TABLE `dang_ky_he_thong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `diem_danh`
--
ALTER TABLE `diem_danh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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

ALTER TABLE hoi_vien
ADD COLUMN ma_id VARCHAR(50) AFTER id,
ADD COLUMN goi_tap VARCHAR(100) AFTER email,
ADD COLUMN ngay_het_han DATE AFTER ngay_dang_ky;

UPDATE hoi_vien 
SET ma_id = '#FF-2026-001', goi_tap = 'Premium Annual', ngay_het_han = '2027-03-03', trang_thai = 'Hoạt động' 
WHERE id = 1;

UPDATE hoi_vien 
SET ma_id = '#FF-2026-002', goi_tap = 'Premium Annual', ngay_het_han = '2027-03-03', trang_thai = 'Hoạt động' 
WHERE id = 2;

UPDATE hoi_vien 
SET ma_id = '#FF-2026-003', goi_tap = 'Monthly Standard', ngay_het_han = '2026-03-10', trang_thai = 'Sắp hết hạn' 
WHERE id = 3;

-- 1. Sửa lại cột trang_thai để nhận các giá trị Tiếng Anh mới
ALTER TABLE hoi_vien 
MODIFY trang_thai ENUM('active', 'expiring', 'expired', 'reserved', 'paused') DEFAULT 'active';

-- 2. Cập nhật lại dữ liệu cho chuẩn Tiếng Anh (không xài 'Hoạt động' hay 'Sắp hết hạn' trong DB nữa)
UPDATE hoi_vien SET ma_id = '#FF-2026-001', goi_tap = 'Premium Annual', ngay_het_han = '2027-03-03', trang_thai = 'active' WHERE id = 1;
UPDATE hoi_vien SET ma_id = '#FF-2026-002', goi_tap = 'Premium Annual', ngay_het_han = '2027-03-03', trang_thai = 'active' WHERE id = 2;
UPDATE hoi_vien SET ma_id = '#FF-2026-003', goi_tap = 'Monthly Standard', ngay_het_han = '2026-03-10', trang_thai = 'expiring' WHERE id = 3;


-- Xóa cột cũ
ALTER TABLE hoi_vien DROP COLUMN goi_tap;

-- Thêm cột mới là số nguyên để chứa ID gói tập
ALTER TABLE hoi_vien ADD COLUMN goi_tap_id INT AFTER email;

-- Cập nhật lại dữ liệu mẫu cho khớp với bảng goi_tap của mày
UPDATE hoi_vien SET goi_tap_id = 1 WHERE id = 1;
UPDATE hoi_vien SET goi_tap_id = 2 WHERE id = 2;
UPDATE hoi_vien SET goi_tap_id = 3 WHERE id = 3;


-- 1. Cập nhật bảng Gói Tập (Thêm loại gói và số buổi)
ALTER TABLE goi_tap 
ADD COLUMN loai_goi ENUM('thoi_gian', 'so_buoi') DEFAULT 'thoi_gian' AFTER gia,
ADD COLUMN so_buoi INT DEFAULT 0 AFTER loai_goi;

-- (Mẫu: Set thử gói số 3 thành gói 10 buổi lẻ)
UPDATE goi_tap SET loai_goi = 'so_buoi', so_buoi = 10, thoi_han_thang = 0 WHERE id = 3;

-- 2. Cập nhật bảng Hội Viên (Lưu số buổi còn lại và hạn bảo lưu)
ALTER TABLE hoi_vien 
ADD COLUMN so_buoi_con_lai INT DEFAULT 0 AFTER ngay_het_han,
ADD COLUMN ngay_het_bao_luu DATE NULL AFTER so_buoi_con_lai;


-- 1. Đổi tên cột thoi_han_thang thành thoi_han_ngay (vì UI frontend để là 30 ngày, 60 ngày...)
ALTER TABLE goi_tap CHANGE COLUMN thoi_han_thang thoi_han_ngay INT NOT NULL DEFAULT 30;

-- 2. Thêm cột số lượng người (cho phép chọn 1, 2, 5... người tập chung 1 gói)
ALTER TABLE goi_tap ADD COLUMN so_luong_nguoi INT NOT NULL DEFAULT 1 AFTER gia;

-- 3. Thêm cột trạng thái (Đang bán = 'active', Tạm dừng = 'paused')
ALTER TABLE goi_tap ADD COLUMN trang_thai VARCHAR(20) NOT NULL DEFAULT 'active' AFTER mo_ta;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

