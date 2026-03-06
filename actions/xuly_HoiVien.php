<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['chu_gym_id'])) {
    header('Location: ../Auth/DangNhap.php');
    exit;
}

$chuGymId = (int) $_SESSION['chu_gym_id'];

$hoiVienRows = [];
$tongHoiVien = 0;
$hoiVienDangHoatDong = 0;
$hoiVienSapHetHan = 0;
$hoiVienDaHetHan = 0;

function hoiVienColumnExists(mysqli $conn, string $table, string $column): bool
{
    $sql = "SELECT 1
            FROM information_schema.columns
            WHERE table_schema = DATABASE()
              AND table_name = ?
              AND column_name = ?
            LIMIT 1";
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

function hoiVienTableExists(mysqli $conn, string $table): bool
{
    $sql = "SELECT 1
            FROM information_schema.tables
            WHERE table_schema = DATABASE()
              AND table_name = ?
            LIMIT 1";
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

function normalizeHoiVienStatus(?string $rawPackageStatus, ?string $ngayHetHan): string
{
    $status = strtolower(trim((string) $rawPackageStatus));

    if ($status === '' || $status === 'cancelled') {
        return 'reserved';
    }

    if ($status === 'paused') {
        return 'paused';
    }

    if ($status === 'expired') {
        return 'expired';
    }

    if (!empty($ngayHetHan)) {
        $today = new DateTime('today');
        $expiredDate = DateTime::createFromFormat('Y-m-d', $ngayHetHan) ?: new DateTime($ngayHetHan);

        if ($expiredDate < $today) {
            return 'expired';
        }

        $days = (int) $today->diff($expiredDate)->format('%a');
        if ($days <= 3) {
            return 'expiring';
        }
    }

    if ($status === 'active') {
        return 'active';
    }

    return 'active';
}

function formatDateVn(?string $dateString): string
{
    if (empty($dateString)) {
        return '--/--/----';
    }

    $date = date_create($dateString);
    if (!$date) {
        return '--/--/----';
    }

    return $date->format('d/m/Y');
}

$statusDisplayMap = [
    'active' => ['label' => 'Hoạt động', 'badgeClass' => 'active', 'warningRow' => false],
    'expiring' => ['label' => 'Sắp hết hạn', 'badgeClass' => 'warning', 'warningRow' => true],
    'expired' => ['label' => 'Đã hết hạn', 'badgeClass' => 'expired', 'warningRow' => false],
    'reserved' => ['label' => 'Bảo lưu', 'badgeClass' => 'reserved', 'warningRow' => false],
    'paused' => ['label' => 'Tạm dừng', 'badgeClass' => 'paused', 'warningRow' => false],
];

$conn = @new mysqli('localhost', 'root', '', 'gym_pro');

if (!$conn->connect_error) {
    $conn->set_charset('utf8mb4');

    // Dong bo trang thai goi tap: goi active da qua han thi chuyen sang expired.
    $conn->query("
        UPDATE dang_ky_goi
        SET trang_thai = 'expired'
        WHERE ngay_ket_thuc < CURDATE()
          AND trang_thai = 'active'
    ");

    $hasMaId = hoiVienColumnExists($conn, 'hoi_vien', 'ma_id');
    $hasNgayHetHan = hoiVienColumnExists($conn, 'hoi_vien', 'ngay_het_han');
    $hasGoiTapId = hoiVienColumnExists($conn, 'hoi_vien', 'goi_tap_id');

    $memberCodeExpr = $hasMaId ? "NULLIF(TRIM(hv.ma_id), '')" : "NULL";
    $memberEndDateExpr = $hasNgayHetHan ? "hv.ngay_het_han" : "NULL";

    $memberPackageJoin = '';
    $memberPackageExpr = 'NULL';
    if ($hasGoiTapId) {
        $memberPackageJoin = 'LEFT JOIN goi_tap gt_hv ON gt_hv.id = hv.goi_tap_id';
        $memberPackageExpr = 'gt_hv.ten_goi';
    }

    $hasKhuonMatTable = hoiVienTableExists($conn, 'khuon_mat_hoi_vien');
    $faceJoin = '';
    $faceExpr = '0';
    if ($hasKhuonMatTable) {
        $faceJoin = "
            LEFT JOIN (
                SELECT hoi_vien_id, MAX(CASE WHEN trang_thai = 1 THEN 1 ELSE 0 END) AS da_dang_ky_khuon_mat
                FROM khuon_mat_hoi_vien
                GROUP BY hoi_vien_id
            ) km ON km.hoi_vien_id = hv.id
        ";
        $faceExpr = 'COALESCE(km.da_dang_ky_khuon_mat, 0)';
    }

    $sql = "
        SELECT
            hv.id,
            hv.ho_ten,
            hv.sdt,
            hv.email,
            hv.ngay_sinh,
            hv.gioi_tinh,
            hv.ngay_dang_ky,
            dkg.trang_thai AS trang_thai_goi,
            COALESCE(
                {$memberCodeExpr},
                CONCAT('#HV-', DATE_FORMAT(hv.ngay_dang_ky, '%Y'), '-', LPAD(hv.id, 3, '0'))
            ) AS ma_id,
            COALESCE(gt_dkg.ten_goi, {$memberPackageExpr}, 'Chưa có gói') AS ten_goi,
            dkg.ngay_bat_dau,
            COALESCE(dkg.ngay_ket_thuc, {$memberEndDateExpr}) AS ngay_het_han,
            {$faceExpr} AS da_dang_ky_khuon_mat
        FROM hoi_vien hv
        LEFT JOIN (
            SELECT d1.hoi_vien_id, d1.goi_tap_id, d1.ngay_bat_dau, d1.ngay_ket_thuc, d1.trang_thai
            FROM dang_ky_goi d1
            INNER JOIN (
                SELECT hoi_vien_id, MAX(id) AS max_id
                FROM dang_ky_goi
                GROUP BY hoi_vien_id
            ) latest ON latest.max_id = d1.id
        ) dkg ON dkg.hoi_vien_id = hv.id
        LEFT JOIN goi_tap gt_dkg ON gt_dkg.id = dkg.goi_tap_id
        {$memberPackageJoin}
        {$faceJoin}
        WHERE hv.chu_gym_id = ?
        ORDER BY hv.id DESC
    ";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('i', $chuGymId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result ? $result->fetch_assoc() : null) {
            if (!$row) {
                break;
            }

            $normalizedStatus = normalizeHoiVienStatus($row['trang_thai_goi'] ?? null, $row['ngay_het_han'] ?? null);
            $row['normalized_status'] = $normalizedStatus;
            $row['ngay_sinh_fmt'] = formatDateVn($row['ngay_sinh'] ?? null);
            $row['ngay_bat_dau_fmt'] = formatDateVn($row['ngay_bat_dau'] ?? null);
            $row['ngay_het_han_fmt'] = formatDateVn($row['ngay_het_han'] ?? null);
            $hoiVienRows[] = $row;
        }

        $stmt->close();
    }

    $conn->close();
}

$tongHoiVien = count($hoiVienRows);
foreach ($hoiVienRows as $member) {
    $status = $member['normalized_status'] ?? 'active';
    if ($status === 'active') {
        $hoiVienDangHoatDong++;
    }
    if ($status === 'expiring') {
        $hoiVienSapHetHan++;
    }
    if ($status === 'expired') {
        $hoiVienDaHetHan++;
    }
}

$tongHoiVienFormatted = number_format($tongHoiVien, 0, ',', '.');
$hoiVienDangHoatDongFormatted = number_format($hoiVienDangHoatDong, 0, ',', '.');
$hoiVienSapHetHanFormatted = number_format($hoiVienSapHetHan, 0, ',', '.');
$hoiVienDaHetHanFormatted = number_format($hoiVienDaHetHan, 0, ',', '.');
?>
