-- Migration don gian: luu mau khuon mat hoi vien de so khop
-- Khong luu DB khi khong nhan dien duoc (chi hien thi "nguoi la" tren man hinh)
-- Database target: gym_pro (MariaDB/MySQL)

START TRANSACTION;

CREATE TABLE IF NOT EXISTS `khuon_mat_hoi_vien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hoi_vien_id` int(11) NOT NULL,
  `embedding` longblob NOT NULL,
  `embedding_size` smallint(6) NOT NULL DEFAULT 128,
  `anh_mau` varchar(255) DEFAULT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT 1,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_km_hv_trang_thai` (`hoi_vien_id`, `trang_thai`),
  CONSTRAINT `fk_khuon_mat_hoi_vien_hoi_vien`
    FOREIGN KEY (`hoi_vien_id`) REFERENCES `hoi_vien` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

