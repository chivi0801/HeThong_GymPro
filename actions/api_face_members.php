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

function apiFaceTableExists(mysqli $conn, string $table): bool
{
    $sql = "SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('s', $table);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result && $result->num_rows > 0;
    $stmt->close();
    return $exists;
}

function apiFaceColumnExists(mysqli $conn, string $table, string $column): bool
{
    $sql = "SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = ? AND column_name = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('ss', $table, $column);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result && $result->num_rows > 0;
    $stmt->close();
    return $exists;
}

function unpackEmbedding(?string $blob, int $size): array
{
    if ($blob === null || $blob === '') {
        return [];
    }
    $unpacked = @unpack('g*', $blob);
    if (!$unpacked) {
        return [];
    }
    $values = array_values($unpacked);
    if ($size > 0 && count($values) > $size) {
        $values = array_slice($values, 0, $size);
    }
    return array_map('floatval', $values);
}

$chuGymId = (int) $_SESSION['chu_gym_id'];
$conn = @new mysqli('localhost', 'root', '', 'gym_pro');
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Khong ket noi duoc CSDL']);
    exit;
}
$conn->set_charset('utf8mb4');

if (!apiFaceTableExists($conn, 'khuon_mat_hoi_vien')) {
    echo json_encode(['success' => true, 'members' => []]);
    $conn->close();
    exit;
}

$hasMaId = apiFaceColumnExists($conn, 'hoi_vien', 'ma_id');
$memberCodeExpr = $hasMaId
    ? "COALESCE(NULLIF(TRIM(hv.ma_id), ''), CONCAT('#HV-', DATE_FORMAT(hv.ngay_dang_ky, '%Y'), '-', LPAD(hv.id, 3, '0')))"
    : "CONCAT('#HV-', DATE_FORMAT(hv.ngay_dang_ky, '%Y'), '-', LPAD(hv.id, 3, '0'))";

$sql = "
    SELECT
        hv.id,
        hv.ho_ten,
        hv.sdt,
        {$memberCodeExpr} AS ma_id,
        km.embedding,
        km.embedding_size,
        COALESCE(gt.ten_goi, 'Chua co goi') AS ten_goi,
        dkg.ngay_ket_thuc,
        dkg.trang_thai AS trang_thai_goi,
        last_dd.last_checkin,
        COUNT(km.id) OVER (PARTITION BY hv.id) AS embedding_count
    FROM hoi_vien hv
    INNER JOIN khuon_mat_hoi_vien km ON km.hoi_vien_id = hv.id AND km.trang_thai = 1
    LEFT JOIN (
        SELECT d1.hoi_vien_id, d1.goi_tap_id, d1.ngay_ket_thuc, d1.trang_thai
        FROM dang_ky_goi d1
        INNER JOIN (
            SELECT hoi_vien_id, MAX(id) AS max_id
            FROM dang_ky_goi
            GROUP BY hoi_vien_id
        ) d2 ON d2.max_id = d1.id
    ) dkg ON dkg.hoi_vien_id = hv.id
    LEFT JOIN goi_tap gt ON gt.id = dkg.goi_tap_id
    LEFT JOIN (
        SELECT hoi_vien_id, MAX(thoi_gian) AS last_checkin
        FROM diem_danh
        GROUP BY hoi_vien_id
    ) last_dd ON last_dd.hoi_vien_id = hv.id
    WHERE hv.chu_gym_id = ?
    ORDER BY hv.id, km.id
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Khong tao duoc truy van']);
    $conn->close();
    exit;
}

$stmt->bind_param('i', $chuGymId);
$stmt->execute();
$result = $stmt->get_result();

$members = [];
$memberGroups = [];

while ($row = $result ? $result->fetch_assoc() : null) {
    if (!$row) {
        break;
    }

    $memberId = (int) $row['id'];
    $embeddingSize = (int) ($row['embedding_size'] ?? 128);
    $embedding = unpackEmbedding($row['embedding'] ?? null, $embeddingSize);
    
    if (empty($embedding)) {
        continue;
    }

    if (!isset($memberGroups[$memberId])) {
        $memberGroups[$memberId] = [
            'id' => $memberId,
            'label' => 'member_' . $memberId,
            'ho_ten' => (string) $row['ho_ten'],
            'sdt' => (string) ($row['sdt'] ?? ''),
            'ma_id' => (string) ($row['ma_id'] ?? ''),
            'ten_goi' => (string) ($row['ten_goi'] ?? 'Chua co goi'),
            'ngay_ket_thuc' => !empty($row['ngay_ket_thuc']) ? (string) $row['ngay_ket_thuc'] : null,
            'trang_thai_goi' => !empty($row['trang_thai_goi']) ? (string) $row['trang_thai_goi'] : null,
            'last_checkin' => !empty($row['last_checkin']) ? (string) $row['last_checkin'] : null,
            'embeddings' => [],
            'embedding_count' => (int) ($row['embedding_count'] ?? 1)
        ];
    }

    $memberGroups[$memberId]['embeddings'][] = $embedding;
}

foreach ($memberGroups as $member) {
    $members[] = $member;
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'members' => $members], JSON_UNESCAPED_UNICODE);
?>
