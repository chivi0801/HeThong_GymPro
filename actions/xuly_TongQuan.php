<?php
// - Khoi tao session neu chua bat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// - Kiem tra dang nhap chu gym, neu chua co session thi quay ve trang dang nhap
if (!isset($_SESSION['chu_gym_id'])) {
    header('Location: ../Auth/DangNhap.php');
    exit;
}

// - Khai bao bien mac dinh cho dashboard
$tongHoiVien = 0;
$tongHoiVienFormatted = '0';
$hoiVienDangHoatDong = 0;
$hoiVienDangHoatDongFormatted = '0';
$luotCheckInHomNay = 0;
$luotCheckInHomNayFormatted = '0';
$chuGymId = (int) $_SESSION['chu_gym_id'];

// - Ket noi CSDL
$conn = @new mysqli('localhost', 'root', '', 'gym_pro');
if (!$conn->connect_error) {
    $conn->set_charset('utf8mb4');

    // - Dem tong so hoi vien theo chu gym dang dang nhap
    $sql = "SELECT COUNT(*) AS tong_hoi_vien FROM hoi_vien WHERE chu_gym_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $chuGymId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;

        if ($row && isset($row['tong_hoi_vien'])) {
            $tongHoiVien = (int) $row['tong_hoi_vien'];
        }

        $stmt->close();
    }

    // - Dem hoi vien dang hoat dong dua tren trang thai goi tap da dang ky
    $sqlHoiVienHoatDong = "SELECT COUNT(DISTINCT hv.id) AS hoi_vien_dang_hoat_dong
                           FROM hoi_vien hv
                           INNER JOIN dang_ky_goi dkg ON dkg.hoi_vien_id = hv.id
                           WHERE hv.chu_gym_id = ? AND dkg.trang_thai = 'active'";
    $stmtHoiVienHoatDong = $conn->prepare($sqlHoiVienHoatDong);

    if ($stmtHoiVienHoatDong) {
        $stmtHoiVienHoatDong->bind_param('i', $chuGymId);
        $stmtHoiVienHoatDong->execute();
        $resultHoiVienHoatDong = $stmtHoiVienHoatDong->get_result();
        $rowHoiVienHoatDong = $resultHoiVienHoatDong ? $resultHoiVienHoatDong->fetch_assoc() : null;

        if ($rowHoiVienHoatDong && isset($rowHoiVienHoatDong['hoi_vien_dang_hoat_dong'])) {
            $hoiVienDangHoatDong = (int) $rowHoiVienHoatDong['hoi_vien_dang_hoat_dong'];
        }

        $stmtHoiVienHoatDong->close();
    }

    // - Dem luot check-in hom nay tu bang diem_danh (theo chu gym)
    $sqlCheckIn = "SELECT COUNT(*) AS luot_check_in_hom_nay
                   FROM diem_danh dd
                   INNER JOIN hoi_vien hv ON hv.id = dd.hoi_vien_id
                   WHERE hv.chu_gym_id = ? AND DATE(dd.thoi_gian) = CURDATE()";
    $stmtCheckIn = $conn->prepare($sqlCheckIn);

    if ($stmtCheckIn) {
        $stmtCheckIn->bind_param('i', $chuGymId);
        $stmtCheckIn->execute();
        $resultCheckIn = $stmtCheckIn->get_result();
        $rowCheckIn = $resultCheckIn ? $resultCheckIn->fetch_assoc() : null;

        if ($rowCheckIn && isset($rowCheckIn['luot_check_in_hom_nay'])) {
            $luotCheckInHomNay = (int) $rowCheckIn['luot_check_in_hom_nay'];
        }

        $stmtCheckIn->close();
    }

    $conn->close();
}

// - Dinh dang so de hien thi len giao dien
$tongHoiVienFormatted = number_format($tongHoiVien, 0, ',', '.');
$hoiVienDangHoatDongFormatted = number_format($hoiVienDangHoatDong, 0, ',', '.');
$luotCheckInHomNayFormatted = number_format($luotCheckInHomNay, 0, ',', '.');
?>
