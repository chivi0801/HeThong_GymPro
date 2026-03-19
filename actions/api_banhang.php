<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// --- THÊM DÒNG NÀY ĐỂ ÉP SESSION KHI DỰ ÁN ĐANG TEST ---
$_SESSION['chu_gym_id'] = 1; 

if (!isset($_SESSION['chu_gym_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập lại.']);
    exit;
}

// Cập nhật lại đường dẫn include DB nếu cần
require_once __DIR__ . '/../database/db_connect.php';

$chu_gym_id = (int)$_SESSION['chu_gym_id'];
$action = $_REQUEST['action'] ?? '';

// 1. LẤY DANH SÁCH SẢN PHẨM (Chỉ lấy sản phẩm chưa bị xóa)
if ($action === 'fetch') {
    $stmt = $conn->prepare("SELECT id, ten_sp as name, ma_sp as code, gia_ban as price, ton_kho as stock, phan_loai as cat FROM san_pham WHERE chu_gym_id = ? AND trang_thai = 1 ORDER BY id DESC");
    $stmt->bind_param("i", $chu_gym_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $products = [];
    while($row = $res->fetch_assoc()) {
        $products[] = [
            'id' => (int)$row['id'],
            'name' => $row['name'],
            'code' => $row['code'],
            'price' => (float)$row['price'],
            'stock' => (int)$row['stock'],
            'cat' => $row['cat']
        ];
    }
    echo json_encode(['success' => true, 'data' => $products]);
    exit;
}

// 2. XỬ LÝ BÁN HÀNG (Hỗ trợ nhiều món)
if ($action === 'sell') {
    $cart_json = $_POST['cart'] ?? '[]';
    $cart = json_decode($cart_json, true);
    
    if (empty($cart) || !is_array($cart)) {
        echo json_encode(['success' => false, 'message' => 'Giỏ hàng trống.']);
        exit;
    }

    $conn->begin_transaction();
    try {
        $total_bill = 0;
        $items_to_insert = [];

        // Kiểm tra tồn kho hàng loạt và lấy giá gốc
        foreach ($cart as $item) {
            $prod_id = (int)$item['prod_id'];
            $qty = (int)$item['qty'];
            
            if ($prod_id <= 0 || $qty <= 0) throw new Exception("Dữ liệu giỏ hàng không hợp lệ.");

            // Dùng FOR UPDATE để khóa dòng khi đang giao dịch (Race Condition)
            $stmt = $conn->prepare("SELECT ten_sp, gia_ban, ton_kho FROM san_pham WHERE id = ? AND chu_gym_id = ? FOR UPDATE");
            $stmt->bind_param("ii", $prod_id, $chu_gym_id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();

            if (!$row) throw new Exception("Không tìm thấy SP ID $prod_id.");
            if ($row['ton_kho'] < $qty) throw new Exception("SP '{$row['ten_sp']}' chỉ còn {$row['ton_kho']} chiếc, không đủ múc.");

            $price = $row['gia_ban'];
            $items_to_insert[] = ['prod_id' => $prod_id, 'qty' => $qty, 'price' => $price];
            $total_bill += ($price * $qty);
        }

        $now = date('Y-m-d H:i:s');
        // Tạo hóa đơn
        $stmt_hd = $conn->prepare("INSERT INTO hoa_don_ban_le (chu_gym_id, tong_tien, ngay_tao) VALUES (?, ?, ?)");
        $stmt_hd->bind_param("ids", $chu_gym_id, $total_bill, $now);
        $stmt_hd->execute();
        $hoa_don_id = $stmt_hd->insert_id;

        // Lưu chi tiết từng món + Trừ tồn kho
        $stmt_ct = $conn->prepare("INSERT INTO chi_tiet_hoa_don (hoa_don_id, san_pham_id, so_luong, don_gia) VALUES (?, ?, ?, ?)");
        $stmt_up = $conn->prepare("UPDATE san_pham SET ton_kho = ton_kho - ? WHERE id = ? AND chu_gym_id = ?");

        foreach ($items_to_insert as $it) {
            $stmt_ct->bind_param("iiid", $hoa_don_id, $it['prod_id'], $it['qty'], $it['price']);
            $stmt_ct->execute();

            $stmt_up->bind_param("iii", $it['qty'], $it['prod_id'], $chu_gym_id);
            $stmt_up->execute();
        }

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Bán hàng thành công!']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// 3. XỬ LÝ NHẬP HÀNG (Hỗ trợ nhiều món)
if ($action === 'import') {
    $cart_json = $_POST['cart'] ?? '[]';
    $cart = json_decode($cart_json, true);
    $note = trim($_POST['note'] ?? '');

    if (empty($cart) || !is_array($cart)) {
        echo json_encode(['success' => false, 'message' => 'Danh sách nhập rỗng.']);
        exit;
    }

    $conn->begin_transaction();
    try {
        $now = date('Y-m-d H:i:s');
        $stmt_in = $conn->prepare("INSERT INTO lich_su_nhap_kho (chu_gym_id, san_pham_id, so_luong_nhap, don_gia_nhap, tong_tien_chi, ghi_chu, ngay_nhap) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_up = $conn->prepare("UPDATE san_pham SET ton_kho = ton_kho + ? WHERE id = ? AND chu_gym_id = ?");

        foreach ($cart as $item) {
            $prod_id = (int)$item['prod_id'];
            $qty = (int)$item['qty'];
            $price = (float)$item['price'];

            if ($prod_id <= 0 || $qty <= 0 || $price <= 0) throw new Exception("Số lượng và giá nhập phải lớn hơn 0.");

            $total_cost = $qty * $price;
            
            // Ghi Lịch sử
            $stmt_in->bind_param("iiiddss", $chu_gym_id, $prod_id, $qty, $price, $total_cost, $note, $now);
            $stmt_in->execute();

            // Cộng Tồn kho
            $stmt_up->bind_param("iii", $qty, $prod_id, $chu_gym_id);
            $stmt_up->execute();
        }

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Nhập lô hàng thành công!']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// 4. QUẢN LÝ SẢN PHẨM (THÊM / SỬA)
if ($action === 'save_product') {
    $id = (int)($_POST['id'] ?? 0);
    $ma_sp = trim($_POST['ma_sp'] ?? '');
    $ten_sp = trim($_POST['ten_sp'] ?? '');
    $phan_loai = trim($_POST['phan_loai'] ?? 'Nước giải khát');
    $gia_ban = (float)($_POST['gia_ban'] ?? 0);

    if ($ma_sp === '' || $ten_sp === '' || $gia_ban <= 0) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đủ thông tin và giá hợp lệ.']);
        exit;
    }

    if ($id > 0) {
        $stmt = $conn->prepare("UPDATE san_pham SET ma_sp=?, ten_sp=?, phan_loai=?, gia_ban=? WHERE id=? AND chu_gym_id=?");
        $stmt->bind_param("sssdii", $ma_sp, $ten_sp, $phan_loai, $gia_ban, $id, $chu_gym_id);
        $msg = "Cập nhật thành công!";
    } else {
        // Check trùng mã
        $check = $conn->prepare("SELECT id FROM san_pham WHERE ma_sp=? AND chu_gym_id=? AND trang_thai=1");
        $check->bind_param("si", $ma_sp, $chu_gym_id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Mã sản phẩm đã tồn tại!']);
            exit;
        }
        $stmt = $conn->prepare("INSERT INTO san_pham (chu_gym_id, ma_sp, ten_sp, phan_loai, gia_ban, ton_kho) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("isssd", $chu_gym_id, $ma_sp, $ten_sp, $phan_loai, $gia_ban);
        $msg = "Thêm sản phẩm thành công!";
    }
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => $msg]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống!']);
    }
    exit;
}

// 5. XÓA MỀM SẢN PHẨM
if ($action === 'delete_product') {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = $conn->prepare("UPDATE san_pham SET trang_thai = 0 WHERE id = ? AND chu_gym_id = ?");
    $stmt->bind_param("ii", $id, $chu_gym_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Đã xóa sản phẩm.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể xóa.']);
    }
    exit;
}
?>