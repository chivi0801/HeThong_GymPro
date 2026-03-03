-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2026 at 05:44 AM
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
  `trang_thai` enum('active','expired','pending') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dang_ky_goi`
--

INSERT INTO `dang_ky_goi` (`id`, `hoi_vien_id`, `goi_tap_id`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`) VALUES
(1, 1, 1, '2026-03-01', '2026-04-01', 'active'),
(2, 2, 2, '2026-03-01', '2026-06-01', 'active'),
(3, 3, 3, '2026-03-01', '2026-04-01', 'active');

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
(3, 1, '2026-03-03 11:36:49', 'khang_02032026.jpg');

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
(3, 'Gói 1 tháng', 1, 350000.00, 'Tập tự do', 2);

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
  `trang_thai` enum('active','expired','pending') DEFAULT 'active',
  `chu_gym_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hoi_vien`
--

INSERT INTO `hoi_vien` (`id`, `ho_ten`, `sdt`, `email`, `ngay_sinh`, `gioi_tinh`, `ngay_dang_ky`, `trang_thai`, `chu_gym_id`) VALUES
(1, 'Lê Minh Khang', '0911000001', 'khang@gmail.com', NULL, 'Nam', '2026-03-03', 'active', 1),
(2, 'Phạm Thị Lan', '0911000002', 'lan@gmail.com', NULL, 'Nữ', '2026-03-03', 'active', 1),
(3, 'Đỗ Quốc Huy', '0911000003', 'huy@gmail.com', NULL, 'Nam', '2026-03-03', 'active', 2);

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
(3, 3, 350000.00, '2026-03-03', 'Tiền mặt');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dang_ky_he_thong`
--
ALTER TABLE `dang_ky_he_thong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `diem_danh`
--
ALTER TABLE `diem_danh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `goi_he_thong`
--
ALTER TABLE `goi_he_thong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `goi_tap`
--
ALTER TABLE `goi_tap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hoi_vien`
--
ALTER TABLE `hoi_vien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
