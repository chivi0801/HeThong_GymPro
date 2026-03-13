<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['chu_gym_id'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit;
}

$chuGymId = (int)$_SESSION['chu_gym_id'];
$action = $_GET['action'] ?? $_POST['action'] ?? '';

$conn = new mysqli('localhost', 'root', '', 'gym_pro');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Lỗi kết nối CSDL']);
    exit;
}
$conn->set_charset('utf8mb4');

function checkUsage($conn, $id, $chuGymId) {
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM dang_ky_goi dkg JOIN goi_tap gt ON dkg.goi_tap_id = gt.id WHERE gt.id = ? AND gt.chu_gym_id = ?");
    $stmt->bind_param("ii", $id, $chuGymId);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return $res['cnt'] > 0;
}

if ($action === 'get') {
    $id = (int)($_GET['id'] ?? 0);
    $stmt = $conn->prepare("SELECT * FROM goi_tap WHERE id = ? AND chu_gym_id = ?");
    $stmt->bind_param("ii", $id, $chuGymId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    if ($data) {
        $data['is_used'] = checkUsage($conn, $id, $chuGymId);
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy']);
    }

} elseif ($action === 'save') {
    $id = (int)($_POST['id'] ?? 0);
    $ten_goi = $_POST['ten_goi'] ?? '';
    $gia = (float)($_POST['gia'] ?? 0);
    $thoi_han_ngay = (int)($_POST['thoi_han_ngay'] ?? 0);
    $so_luong_hoi_vien = (int)($_POST['so_luong_hoi_vien'] ?? 1);
    $mo_ta = $_POST['mo_ta'] ?? '';
    $trang_thai = $_POST['trang_thai'] ?? 'active';

    if ($id > 0) {
        $isUsed = checkUsage($conn, $id, $chuGymId);
        if ($isUsed) {
            $stmt = $conn->prepare("UPDATE goi_tap SET ten_goi=?, so_luong_hoi_vien=?, mo_ta=?, trang_thai=? WHERE id=? AND chu_gym_id=?");
            $stmt->bind_param("sissii", $ten_goi, $so_luong_hoi_vien, $mo_ta, $trang_thai, $id, $chuGymId);
        } else {
            $stmt = $conn->prepare("UPDATE goi_tap SET ten_goi=?, gia=?, thoi_han_ngay=?, so_luong_hoi_vien=?, mo_ta=?, trang_thai=? WHERE id=? AND chu_gym_id=?");
            $stmt->bind_param("sdiissii", $ten_goi, $gia, $thoi_han_ngay, $so_luong_hoi_vien, $mo_ta, $trang_thai, $id, $chuGymId);
        }
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Cập nhật thành công']);
    } else {
        $stmt = $conn->prepare("INSERT INTO goi_tap (chu_gym_id, ten_goi, gia, thoi_han_ngay, so_luong_hoi_vien, mo_ta, trang_thai) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdiiss", $chuGymId, $ten_goi, $gia, $thoi_han_ngay, $so_luong_hoi_vien, $mo_ta, $trang_thai);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Thêm thành công']);
    }

} elseif ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if (checkUsage($conn, $id, $chuGymId)) {
        echo json_encode(['success' => false, 'message' => 'Không thể xóa gói đã có người đăng ký']);
    } else {
        $stmt = $conn->prepare("DELETE FROM goi_tap WHERE id = ? AND chu_gym_id = ?");
        $stmt->bind_param("ii", $id, $chuGymId);
        $stmt->execute();
        echo json_encode(['success' => true]);
    }

} elseif ($action === 'toggle_status') {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = $conn->prepare("UPDATE goi_tap SET trang_thai = IF(trang_thai='active', 'paused', 'active') WHERE id = ? AND chu_gym_id = ?");
    $stmt->bind_param("ii", $id, $chuGymId);
    $stmt->execute();
    echo json_encode(['success' => true]);
}

$conn->close();