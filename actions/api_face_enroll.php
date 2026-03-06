<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['chu_gym_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Chua dang nhap']);
    exit;
}

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);

$memberId = (int) ($payload['member_id'] ?? 0);
$embedding = $payload['embedding'] ?? null;

if ($memberId <= 0 || !is_array($embedding) || count($embedding) < 32) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Du lieu khong hop le']);
    exit;
}

$embedding = array_map('floatval', $embedding);
$embeddingSize = count($embedding);
$embeddingBlob = pack('g*', ...$embedding);

$conn = @new mysqli('localhost', 'root', '', 'gym_pro');
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Khong ket noi duoc CSDL']);
    exit;
}
$conn->set_charset('utf8mb4');



$chuGymId = (int) $_SESSION['chu_gym_id'];
$stmtCheck = $conn->prepare("SELECT id FROM hoi_vien WHERE id = ? AND chu_gym_id = ? LIMIT 1");
if (!$stmtCheck) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Khong tao duoc truy van']);
    $conn->close();
    exit;
}
$stmtCheck->bind_param('ii', $memberId, $chuGymId);
$stmtCheck->execute();
$member = $stmtCheck->get_result()->fetch_assoc();
$stmtCheck->close();

if (!$member) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Hoi vien khong thuoc phong gym hien tai']);
    $conn->close();
    exit;
}

$conn->begin_transaction();
try {
    $stmtDisableOld = $conn->prepare("UPDATE khuon_mat_hoi_vien SET trang_thai = 0 WHERE hoi_vien_id = ? AND trang_thai = 1");
    if ($stmtDisableOld) {
        $stmtDisableOld->bind_param('i', $memberId);
        $stmtDisableOld->execute();
        $stmtDisableOld->close();
    }

    $stmtInsert = $conn->prepare("INSERT INTO khuon_mat_hoi_vien (hoi_vien_id, embedding, embedding_size, anh_mau, trang_thai) VALUES (?, ?, ?, NULL, 1)");
    if (!$stmtInsert) {
        throw new RuntimeException('Khong tao duoc lenh luu khuon mat');
    }

    $null = null;
    $stmtInsert->bind_param('ibi', $memberId, $null, $embeddingSize);
    $stmtInsert->send_long_data(1, $embeddingBlob);
    $stmtInsert->execute();
    $stmtInsert->close();

    $conn->commit();
} catch (Throwable $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Khong the luu khuon mat']);
    $conn->close();
    exit;
}

$conn->close();
echo json_encode(['success' => true, 'message' => 'Da luu khuon mat'], JSON_UNESCAPED_UNICODE);
?>
