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

if ($memberId <= 0) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Thieu member_id']);
    exit;
}

$conn = @new mysqli('localhost', 'root', '', 'gym_pro');
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Khong ket noi duoc CSDL']);
    exit;
}
$conn->set_charset('utf8mb4');

$chuGymId = (int) $_SESSION['chu_gym_id'];
$stmtMember = $conn->prepare("SELECT id FROM hoi_vien WHERE id = ? AND chu_gym_id = ? LIMIT 1");
if (!$stmtMember) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Khong tao duoc truy van']);
    $conn->close();
    exit;
}
$stmtMember->bind_param('ii', $memberId, $chuGymId);
$stmtMember->execute();
$member = $stmtMember->get_result()->fetch_assoc();
$stmtMember->close();

if (!$member) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Hoi vien khong hop le']);
    $conn->close();
    exit;
}

// Cooldown de tranh ghi trung lien tuc.
$stmtLast = $conn->prepare("SELECT thoi_gian FROM diem_danh WHERE hoi_vien_id = ? ORDER BY thoi_gian DESC LIMIT 1");
$canInsert = true;
if ($stmtLast) {
    $stmtLast->bind_param('i', $memberId);
    $stmtLast->execute();
    $lastRow = $stmtLast->get_result()->fetch_assoc();
    $stmtLast->close();

    if ($lastRow && !empty($lastRow['thoi_gian'])) {
        $lastTs = strtotime((string) $lastRow['thoi_gian']);
        if ($lastTs !== false && (time() - $lastTs) < 30) {
            $canInsert = false;
        }
    }
}

if ($canInsert) {
    $stmtInsert = $conn->prepare("INSERT INTO diem_danh (hoi_vien_id, thoi_gian, hinh_anh) VALUES (?, NOW(), NULL)");
    if ($stmtInsert) {
        $stmtInsert->bind_param('i', $memberId);
        $stmtInsert->execute();
        $stmtInsert->close();
    }
}

$conn->close();
echo json_encode(['success' => true, 'inserted' => $canInsert], JSON_UNESCAPED_UNICODE);
?>
