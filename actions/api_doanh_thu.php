<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// --- TẠM THỜI MỞ ÉP SESSION ĐỂ TEST NẾU CHƯA QUA TRANG ĐĂNG NHẬP ---
if (!isset($_SESSION['chu_gym_id'])) {
    $_SESSION['chu_gym_id'] = 1; 
}

require_once __DIR__ . '/../database/db_connect.php';

$chu_gym_id = (int)$_SESSION['chu_gym_id'];
$action = $_REQUEST['action'] ?? '';

// ==============================================
// 1. API LẤY TẤT CẢ GIAO DỊCH (THU & CHI CHUNG)
// ==============================================
if ($action === 'fetch') {
    $transactions = [];
    $tong_thu = 0; $tong_chi = 0;

    // --- NGUỒN 1: TỪ BẢNG SỔ QUỸ (THU CHI THỦ CÔNG) ---
    $query_thu_chi = "SELECT id, loai_phieu as type, danh_muc as category, so_tien as amount, nguoi_giao_dich as person, ngay_tao as date FROM phieu_thu_chi WHERE chu_gym_id = $chu_gym_id";
    $res1 = $conn->query($query_thu_chi);
    if($res1) {
        while($r = $res1->fetch_assoc()) {
            $prefix = ($r['type'] == 'THU') ? 'PT-' : 'PC-';
            $transactions[] = [
                'id' => $r['id'], 'type' => $r['type'], 'category' => $r['category'],
                'amount' => (float)$r['amount'], 'person' => $r['person'] ?? 'Không rõ', 'date' => $r['date'],
                'code' => $prefix . str_pad($r['id'], 4, '0', STR_PAD_LEFT), 
                'is_sys' => false // false: Cho phép Xóa
            ];
            if ($r['type'] == 'THU') $tong_thu += $r['amount']; else $tong_chi += $r['amount'];
        }
    }

    // --- NGUỒN 2: TỪ BẢNG HÓA ĐƠN BÁN LẺ (HỆ THỐNG - TỰ ĐỘNG THU) ---
    $query_ban_le = "SELECT id, tong_tien as amount, ngay_tao as date FROM hoa_don_ban_le WHERE chu_gym_id = $chu_gym_id";
    $res2 = $conn->query($query_ban_le);
    if($res2) {
        while($r = $res2->fetch_assoc()) {
            $transactions[] = [
                'id' => $r['id'], 'type' => 'THU', 'category' => 'Bán lẻ',
                'amount' => (float)$r['amount'], 'person' => 'Khách mua sản phẩm', 'date' => $r['date'],
                'code' => 'BL-' . str_pad($r['id'], 4, '0', STR_PAD_LEFT), 
                'is_sys' => true // true: Do hệ thống sinh, CẤM XÓA ở trang Doanh Thu
            ];
            $tong_thu += $r['amount'];
        }
    }

    // --- NGUỒN 3: TỪ BẢNG LỊCH SỬ NHẬP KHO (HỆ THỐNG - TỰ ĐỘNG CHI) ---
    $query_nhap_kho = "SELECT id, tong_tien_chi as amount, ngay_nhap as date FROM lich_su_nhap_kho WHERE chu_gym_id = $chu_gym_id";
    $res3 = $conn->query($query_nhap_kho);
    if($res3) {
        while($r = $res3->fetch_assoc()) {
            $transactions[] = [
                'id' => $r['id'], 'type' => 'CHI', 'category' => 'Nhập hàng',
                'amount' => (float)$r['amount'], 'person' => 'Nhà cung cấp', 'date' => $r['date'],
                'code' => 'NK-' . str_pad($r['id'], 4, '0', STR_PAD_LEFT), 
                'is_sys' => true // true: CẤM XÓA
            ];
            $tong_chi += $r['amount'];
        }
    }

    // --- NGUỒN 4: TỪ BẢNG THANH TOÁN (HỆ THỐNG - TỰ ĐỘNG THU TỪ BÁN GÓI TẬP) ---
    $query_the = "SELECT tt.id, tt.so_tien as amount, tt.ngay_thanh_toan as date, hv.ho_ten as person 
                  FROM thanh_toan tt 
                  INNER JOIN dang_ky_goi dkg ON tt.dang_ky_id = dkg.id
                  INNER JOIN hoi_vien hv ON dkg.hoi_vien_id = hv.id
                  WHERE hv.chu_gym_id = $chu_gym_id";
    $res4 = $conn->query($query_the);
    if($res4) {
        while($r = $res4->fetch_assoc()) {
            $transactions[] = [
                'id' => $r['id'], 
                'type' => 'THU', 
                'category' => 'Đăng ký gói tập',
                'amount' => (float)$r['amount'], 
                'person' => 'HV: ' . $r['person'], 
                'date' => $r['date'] . ' 00:00:00', // Sửa cho JS khỏi lỗi
                'code' => 'DK-' . str_pad($r['id'], 4, '0', STR_PAD_LEFT), 
                'is_sys' => true
            ];
            $tong_thu += $r['amount'];
        }
    }

    // SẮP XẾP MẢNG TỔNG HỢP THEO NGÀY GIẢM DẦN (MỚI NHẤT LÊN ĐẦU)
    usort($transactions, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    echo json_encode([
        'success' => true,
        'data' => $transactions,
        'summary' => [
            'thu' => $tong_thu,
            'chi' => $tong_chi,
            'loi_nhuan' => $tong_thu - $tong_chi
        ]
    ]);
    exit;
}

// ==============================================
// 2. API THÊM PHIẾU THU / CHI THỦ CÔNG
// ==============================================
if ($action === 'add_manual') {
    $type = trim($_POST['type'] ?? ''); // 'THU' hoặc 'CHI'
    $category = trim($_POST['category'] ?? 'Khác');
    $amount = (float)($_POST['amount'] ?? 0);
    $person = trim($_POST['person'] ?? '');
    $note = trim($_POST['note'] ?? '');
    $now = date('Y-m-d H:i:s');

    if (!in_array($type, ['THU', 'CHI']) || $amount <= 0) {
        echo json_encode(['success' => false, 'message' => 'Số tiền không hợp lệ.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO phieu_thu_chi (chu_gym_id, loai_phieu, danh_muc, so_tien, nguoi_giao_dich, ghi_chu, ngay_tao) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdsss", $chu_gym_id, $type, $category, $amount, $person, $note, $now);

    if ($stmt->execute()) {
        $loai_chu = ($type == 'THU') ? 'Thu' : 'Chi';
        echo json_encode(['success' => true, 'message' => "Đã tạo phiếu $loai_chu thành công!"]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi kết nối CSDL.']);
    }
    exit;
}
?>