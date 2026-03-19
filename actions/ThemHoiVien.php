<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['chu_gym_id'])) {
    header('Location: ../Auth/DangNhap.php');
    exit;
}

function themHoiVienColumnExists(mysqli $conn, string $table, string $column): bool
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

function redirectHoiVien(bool $isSuccess = false): void
{
    $url = '../Admin/HoiVien.php';
    if ($isSuccess) {
        $url .= '?register_success=1';
    }
    header('Location: ' . $url);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectHoiVien();
}

$chuGymId = (int) $_SESSION['chu_gym_id'];
$hoTen = trim((string) ($_POST['ho_ten'] ?? ''));
$sdt = trim((string) ($_POST['sdt'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$ngaySinh = trim((string) ($_POST['ngay_sinh'] ?? ''));
$gioiTinh = trim((string) ($_POST['gioi_tinh'] ?? ''));
$goiTapId = (int) ($_POST['goi_tap_id'] ?? 0);

if ($hoTen === '' || $sdt === '' || $goiTapId <= 0) {
    redirectHoiVien();
}

$conn = @new mysqli('localhost', 'root', '', 'gym_pro');
if ($conn->connect_error) {
    redirectHoiVien();
}
$conn->set_charset('utf8mb4');

$hasThoiHanNgay = themHoiVienColumnExists($conn, 'goi_tap', 'thoi_han_ngay');
$hasThoiHanThang = themHoiVienColumnExists($conn, 'goi_tap', 'thoi_han_thang');

$soNgayExpr = '30';
if ($hasThoiHanNgay) {
    $soNgayExpr = 'IFNULL(NULLIF(thoi_han_ngay, 0), 30)';
} elseif ($hasThoiHanThang) {
    $soNgayExpr = 'IFNULL(NULLIF(thoi_han_thang, 0) * 30, 30)';
}

// Sửa câu SQL để lấy thêm cột `gia`
$sqlGoi = "SELECT id, gia, {$soNgayExpr} AS so_ngay
           FROM goi_tap
           WHERE id = ? AND chu_gym_id = ?";
$stmtGoi = $conn->prepare($sqlGoi);

if (!$stmtGoi) {
    $conn->close();
    redirectHoiVien();
}

$stmtGoi->bind_param('ii', $goiTapId, $chuGymId);
$stmtGoi->execute();
$goiResult = $stmtGoi->get_result();
$goi = $goiResult ? $goiResult->fetch_assoc() : null;
$stmtGoi->close();

if (!$goi) {
    $conn->close();
    redirectHoiVien();
}

$soNgay = (int) ($goi['so_ngay'] ?? 30);
if ($soNgay <= 0) {
    $soNgay = 30;
}
// Lấy giá tiền của gói tập
$giaGoi = (float)($goi['gia'] ?? 0);

$ngayBatDau = date('Y-m-d');
$ngayKetThuc = date('Y-m-d', strtotime('+' . $soNgay . ' day'));

$hasMaId = themHoiVienColumnExists($conn, 'hoi_vien', 'ma_id');
$hasGoiTapId = themHoiVienColumnExists($conn, 'hoi_vien', 'goi_tap_id');
$hasNgayHetHan = themHoiVienColumnExists($conn, 'hoi_vien', 'ngay_het_han');

$emailValue = $email !== '' ? $email : null;
$ngaySinhValue = $ngaySinh !== '' ? $ngaySinh : null;
$gioiTinhValue = $gioiTinh !== '' ? $gioiTinh : null;

$insertCols = "ho_ten, sdt, email, ngay_sinh, gioi_tinh, ngay_dang_ky, trang_thai, chu_gym_id";
$insertPlaceholders = "?, ?, ?, ?, ?, CURDATE(), 'active', ?";
$bindTypes = 'sssssi';
$bindValues = [&$hoTen, &$sdt, &$emailValue, &$ngaySinhValue, &$gioiTinhValue, &$chuGymId];

if ($hasGoiTapId) {
    $insertCols .= ", goi_tap_id";
    $insertPlaceholders .= ", ?";
    $bindTypes .= 'i';
    $bindValues[] = &$goiTapId;
}

if ($hasNgayHetHan) {
    $insertCols .= ", ngay_het_han";
    $insertPlaceholders .= ", ?";
    $bindTypes .= 's';
    $bindValues[] = &$ngayKetThuc;
}

$sqlInsertHoiVien = "INSERT INTO hoi_vien ($insertCols) VALUES ($insertPlaceholders)";
$stmtInsertHoiVien = $conn->prepare($sqlInsertHoiVien);
if (!$stmtInsertHoiVien) {
    $conn->close();
    redirectHoiVien();
}

$bindParams = array_merge([$bindTypes], $bindValues);
$tmp = [];
foreach ($bindParams as $key => $value) {
    $tmp[$key] = &$bindParams[$key];
}
call_user_func_array([$stmtInsertHoiVien, 'bind_param'], $tmp);

$okInsertHoiVien = $stmtInsertHoiVien->execute();
$hoiVienId = $okInsertHoiVien ? (int) $stmtInsertHoiVien->insert_id : 0;
$stmtInsertHoiVien->close();

if (!$okInsertHoiVien || $hoiVienId <= 0) {
    $conn->close();
    redirectHoiVien();
}

if ($hasMaId) {
    $maId = sprintf('#HV-%s-%03d', date('Y'), $hoiVienId);
    $stmtMaId = $conn->prepare("UPDATE hoi_vien SET ma_id = ? WHERE id = ?");
    if ($stmtMaId) {
        $stmtMaId->bind_param('si', $maId, $hoiVienId);
        $stmtMaId->execute();
        $stmtMaId->close();
    }
}

$stmtDangKy = $conn->prepare("INSERT INTO dang_ky_goi (hoi_vien_id, goi_tap_id, ngay_bat_dau, ngay_ket_thuc, trang_thai) VALUES (?, ?, ?, ?, 'active')");
if ($stmtDangKy) {
    $stmtDangKy->bind_param('iiss', $hoiVienId, $goiTapId, $ngayBatDau, $ngayKetThuc);
    $stmtDangKy->execute();
    
    // Lấy ID của gói đăng ký vừa tạo
    $dangKyId = $stmtDangKy->insert_id; 
    $stmtDangKy->close();

    // TẠO PHIẾU THANH TOÁN (Ghi nhận Doanh Thu)
    if ($dangKyId > 0 && $giaGoi > 0) {
        $stmtThanhToan = $conn->prepare("INSERT INTO thanh_toan (dang_ky_id, so_tien, ngay_thanh_toan, phuong_thuc) VALUES (?, ?, CURDATE(), 'Tiền mặt')");
        if ($stmtThanhToan) {
            $stmtThanhToan->bind_param('id', $dangKyId, $giaGoi);
            $stmtThanhToan->execute();
            $stmtThanhToan->close();
        }
    }
}

$conn->close();
redirectHoiVien(true);
?>
