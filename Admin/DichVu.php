<?php
// Cấu hình kết nối DB
$servername = "localhost";
$username = "dev_user";
$password = "123"; 
$dbname = "gym_pro"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}

// ==========================================
// 1. XỬ LÝ GET: XÓA VÀ ĐỔI TRẠNG THÁI
// ==========================================
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    if ($_GET['action'] == 'delete') {
        // LƯU Ý: Thực tế nên check xem có hội viên đang dùng gói này không trước khi xóa
        $conn->query("DELETE FROM goi_tap WHERE id = $id");
    } 
    elseif ($_GET['action'] == 'toggle') {
        // Đảo ngược trạng thái
        $conn->query("UPDATE goi_tap SET trang_thai = IF(trang_thai='active', 'paused', 'active') WHERE id = $id");
    }
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?')); // Load lại trang bỏ GET
    exit();
}

// ==========================================
// 2. XỬ LÝ POST: THÊM VÀ SỬA GÓI TẬP
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $ten_goi = $_POST['ten_goi'];
    $gia = (float) preg_replace("/[^0-9]/", "", $_POST['gia']);
    $thoi_han_ngay = $_POST['thoi_han_ngay'];
    $so_luong_nguoi = intval($_POST['so_luong_nguoi']);
    $mo_ta = $_POST['mo_ta'] ?? '';
    $trang_thai = $_POST['trang_thai'] ?? 'active';
    
    if ($_POST['action'] == 'add_package') {
        $loai_goi = 'thoi_gian'; $so_buoi = 0; $chu_gym_id = 1; 
        $stmt = $conn->prepare("INSERT INTO goi_tap (ten_goi, thoi_han_ngay, gia, so_luong_nguoi, mo_ta, trang_thai, loai_goi, so_buoi, chu_gym_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sidisssii", $ten_goi, $thoi_han_ngay, $gia, $so_luong_nguoi, $mo_ta, $trang_thai, $loai_goi, $so_buoi, $chu_gym_id);
        $stmt->execute();
    } 
    elseif ($_POST['action'] == 'edit_package') {
        $id = intval($_POST['package_id']);
        $stmt = $conn->prepare("UPDATE goi_tap SET ten_goi=?, thoi_han_ngay=?, gia=?, so_luong_nguoi=?, mo_ta=?, trang_thai=? WHERE id=?");
        $stmt->bind_param("sidissi", $ten_goi, $thoi_han_ngay, $gia, $so_luong_nguoi, $mo_ta, $trang_thai, $id);
        $stmt->execute();
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// ==========================================
// 3. LẤY DỮ LIỆU ĐỔ RA BẢNG
// ==========================================
$result_goi = null;
$sql_goi = "SELECT * FROM goi_tap ORDER BY id DESC";
$result_goi = $conn->query($sql_goi);

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Quản lý gói dịch vụ</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* CSS CŨ GIỮ NGUYÊN */
        :root { --bg-dark: #121521; --bg-panel: #1a1e2d; --bg-sidebar: #151825; --bg-input: #23283c; --text-main: #ffffff; --text-muted: #94a3b8; --border-color: rgba(255, 255, 255, 0.08); --primary: #3b82f6; --purple: #8b5cf6; --danger: #ef4444; --success: #10b981; --gradient-btn: linear-gradient(90deg, #3b82f6, #8b5cf6); }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-main); display: flex; height: 100vh; overflow: hidden; }
        .main-content { flex: 1; display: flex; flex-direction: column; overflow: hidden; background-color: var(--bg-dark); }
        .page-body { flex: 1; padding: 32px 40px; overflow-y: auto; }
        .flex-between { display: flex; justify-content: space-between; align-items: center; }
        .mb-1 { margin-bottom: 4px; } .mb-4 { margin-bottom: 24px; }
        .text-muted { color: var(--text-muted); font-size: 14px; } .fw-bold { font-weight: 700; }
        h2 { font-size: 24px; letter-spacing: -0.5px; color: #fff; }
        .data-card { background: var(--bg-panel); border: 1px solid var(--border-color); border-radius: 16px; width: 100%; border-collapse: collapse; overflow: hidden; }
        .custom-table { width: 100%; border-collapse: collapse; text-align: left; }
        .custom-table thead { background: rgba(255, 255, 255, 0.02); }
        .custom-table th { padding: 16px 24px; color: var(--text-muted); font-size: 12px; text-transform: uppercase; font-weight: 600; border-bottom: 1px solid var(--border-color); }
        .custom-table td { padding: 20px 24px; border-bottom: 1px solid var(--border-color); font-size: 14px; color: var(--text-main); }
        .btn-add { background: var(--gradient-btn); border: none; color: white; padding: 10px 20px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 8px; }
        .status-badge { padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; }
        .badge-active { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .badge-paused { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        
        /* Modal CSS */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.65); backdrop-filter: blur(8px); display: none; justify-content: center; align-items: center; z-index: 9999; padding: 20px; }
        .modal-content { background: #1e2235; width: 100%; max-width: 480px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5); }
        .modal-header { padding: 24px 24px 0; display: flex; justify-content: space-between; align-items: flex-start; }
        .modal-header h3 { font-size: 18px; font-weight: 700; color: #fff; margin: 0; }
        .modal-header p { font-size: 13px; color: var(--text-muted); margin: 2px 0 0; }
        .close-btn { background: rgba(255,255,255,0.06); border: none; color: var(--text-muted); font-size: 18px; cursor: pointer; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .modal-form { padding: 20px 24px 24px; }
        .form-group { margin-bottom: 16px; }
        .form-row { display: flex; gap: 14px; margin-bottom: 16px; }
        .form-row .form-group { flex: 1; margin-bottom: 0; }
        .modal-form label { display: block; font-size: 13px; font-weight: 500; color: var(--text-muted); margin-bottom: 8px; }
        .input-wrapper { position: relative; display: flex; align-items: center; }
        .input-icon { position: absolute; left: 14px; color: var(--text-muted); font-size: 14px; }
        .input-suffix, .select-caret { position: absolute; right: 14px; color: var(--text-muted); font-size: 13px; }
        .input-control { width: 100%; background: #272c3f; border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 12px 16px; color: #fff; font-size: 14px; outline: none; }
        .input-control.has-icon { padding-left: 38px; }
        .input-control.has-suffix { padding-right: 52px; }
        .select-wrapper .input-control { appearance: none; cursor: pointer; }
        .status-toggle { display: flex; gap: 10px; }
        .status-toggle input[type="radio"] { display: none; }
        .status-toggle label.status-btn { padding: 9px 20px; border-radius: 20px; border: 1.5px solid rgba(255,255,255,0.12); font-size: 13px; font-weight: 600; cursor: pointer; color: var(--text-muted); }
        .status-toggle input[type="radio"]:checked + label.status-btn { background: rgba(99, 102, 241, 0.18); border-color: #6366f1; color: #a5b4fc; }
        .btn-submit { width: 100%; background: linear-gradient(90deg, #6366f1, #8b5cf6); color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 700; font-size: 15px; cursor: pointer; margin-top: 24px; }
        .btn-cancel-text { width: 100%; background: none; border: none; color: var(--text-muted); font-size: 13px; cursor: pointer; margin-top: 12px; }

        /* =========================================
           CSS CHO DROPDOWN MENU (3 CHẤM)
        ========================================= */
        .action-cell { text-align: right; position: relative; }
        .btn-action { background: none; border: none; color: var(--text-muted); font-size: 18px; cursor: pointer; padding: 4px 8px; border-radius: 6px; }
        .btn-action:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .unlimited-text {
            color: #10b981; /* Màu xanh lá hiện đại */
            font-weight: 600;
            background: rgba(16, 185, 129, 0.1);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        
        .dropdown-menu {
            display: none; position: absolute; right: 24px; top: 100%;
            background-color: var(--bg-input); min-width: 150px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5); z-index: 100;
            border-radius: 10px; border: 1px solid var(--border-color);
            overflow: hidden; text-align: left;
        }
        .dropdown-menu.show { display: block; animation: fadeIn 0.15s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
        
        .dropdown-item {
            display: flex; align-items: center; gap: 10px; padding: 12px 16px;
            color: var(--text-main); text-decoration: none; font-size: 13px; font-weight: 500;
            border: none; background: none; width: 100%; cursor: pointer;
        }
        .dropdown-item:hover { background-color: rgba(255,255,255,0.05); }
        .dropdown-item.danger { color: var(--danger); }
        .dropdown-item.danger:hover { background-color: rgba(239, 68, 68, 0.1); }
        .badge-unlimited {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div id="sidebar-placeholder"></div>

    <main class="main-content">
        <div id="header-placeholder"></div>

        <div class="page-body">
            <div class="flex-between mb-4">
                <div>
                    <h2 class="mb-1">Quản lý gói dịch vụ</h2>
                    <p class="text-muted">Thiết lập và quản lý danh sách gói tập tại phòng gym</p>
                </div>
                <button class="btn-add" onclick="openAddModal()">
                    <i class="fa-solid fa-plus"></i> Thêm gói mới
                </button>
            </div>

            <div class="data-card">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tên gói tập</th>
                            <th>Thời hạn</th>
                            <th>Người tập</th>
                            <th>Đơn giá</th>
                            <th>Trạng thái</th>
                            <th style="text-align: right;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_goi && $result_goi->num_rows > 0): ?>
                            <?php while($row = $result_goi->fetch_assoc()): ?>
                                <tr>
                                    <td><span class="fw-bold"><?= htmlspecialchars($row['ten_goi']) ?></span></td>
                                    <td><?= htmlspecialchars($row['thoi_han_ngay']) ?> ngày</td>
                                    
                                    <td>
                                        <?php if ($row['so_luong_nguoi'] == 0): ?>
                                            <span class="unlimited-text">Không giới hạn</span>
                                        <?php else: ?>
                                            <?= htmlspecialchars($row['so_luong_nguoi']) ?> người
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td><?= number_format($row['gia'], 0, ',', '.') ?>đ</td>
                                    <td>
                                        <?php if(isset($row['trang_thai']) && $row['trang_thai'] == 'paused'): ?>
                                            <span class="status-badge badge-paused">Tạm dừng</span>
                                        <?php else: ?>
                                            <span class="status-badge badge-active">Kinh doanh</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="action-cell">
                                        <button class="btn-action" onclick="toggleMenu(event, 'menu-<?= $row['id'] ?>')">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        
                                        <div id="menu-<?= $row['id'] ?>" class="dropdown-menu">
                                            <button class="dropdown-item" onclick="openEditModal(
                                                <?= $row['id'] ?>, 
                                                '<?= htmlspecialchars(addslashes($row['ten_goi'])) ?>',
                                                '<?= $row['gia'] ?>',
                                                '<?= $row['thoi_han_ngay'] ?>',
                                                '<?= $row['so_luong_nguoi'] ?>',
                                                '<?= htmlspecialchars(addslashes($row['mo_ta'] ?? '')) ?>',
                                                '<?= $row['trang_thai'] ?>'
                                            )">
                                                <i class="fa-solid fa-pen"></i> Chỉnh sửa
                                            </button>
                                            
                                            <a href="?action=toggle&id=<?= $row['id'] ?>" class="dropdown-item">
                                                <i class="fa-solid fa-power-off"></i> <?= ($row['trang_thai'] == 'active') ? 'Tạm dừng bán' : 'Mở bán lại' ?>
                                            </a>
                                            
                                            <a href="?action=delete&id=<?= $row['id'] ?>" class="dropdown-item danger" onclick="return confirm('Bạn có chắc chắn muốn xóa gói này? Dữ liệu không thể khôi phục!')">
                                                <i class="fa-solid fa-trash"></i> Xóa gói
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" style="text-align:center; padding: 20px;">Chưa có gói tập nào</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="modal-overlay" id="packageModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-left">
                    <span class="modal-icon">✦</span>
                    <div>
                        <h3 id="modal-title">Thêm gói dịch vụ mới</h3>
                        <p id="modal-desc">Thiết lập thông tin gói tập</p>
                    </div>
                </div>
                <button class="close-btn" onclick="closeModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form class="modal-form" method="POST" action="">
                <input type="hidden" name="action" id="form-action" value="add_package">
                <input type="hidden" name="package_id" id="package_id" value="">

                <div class="form-group">
                    <label>Tên gói tập</label>
                    <div class="input-wrapper">
                        <i class="input-icon fa-regular fa-gem"></i>
                        <input type="text" name="ten_goi" id="input_ten_goi" required placeholder="VD: Gói Platinum 3 Tháng" class="input-control has-icon">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Giá niêm yết</label>
                        <div class="input-wrapper">
                            <i class="input-icon fa-regular fa-credit-card"></i>
                            <input type="text" name="gia" id="input_gia" required placeholder="500000" class="input-control has-icon has-suffix">
                            <span class="input-suffix">VNĐ</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Thời hạn gói (Ngày)</label>
                        <div class="input-wrapper select-wrapper">
                            <i class="input-icon fa-regular fa-calendar"></i>
                            <input type="number" name="thoi_han_ngay" id="input_thoi_han_ngay" required value="30" class="input-control has-icon has-suffix" style="padding-right: 60px;">
                            <span class="input-suffix">ngày</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Số lượng hội viên</label>
                    <div class="input-wrapper select-wrapper">
                        <i class="input-icon fa-regular fa-user"></i>
                        <select name="so_luong_nguoi" id="input_so_luong_nguoi" class="input-control has-icon">
                            <option value="1">1 người</option>
                            <option value="2">2 người</option>
                            <option value="5">5 người</option>
                            <option value="10">10 người</option>
                            <option value="0">Không giới hạn</option>
                        </select>
                        <i class="select-caret fa-solid fa-chevron-down"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mô tả ngắn</label>
                    <div class="input-wrapper">
                        <i class="input-icon fa-regular fa-align-left" style="top: 14px; transform: none; position: absolute;"></i>
                        <textarea name="mo_ta" id="input_mo_ta" rows="3" placeholder="Nhập mô tả về đặc quyền của gói..."
                            class="input-control has-icon" style="resize: none; padding-top: 12px;"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label>Trạng thái</label>
                    <div class="status-toggle">
                        <input type="radio" id="stt-active" name="trang_thai" value="active" checked>
                        <label for="stt-active" class="status-btn">Đang bán</label>
                        
                        <input type="radio" id="stt-paused" name="trang_thai" value="paused">
                        <label for="stt-paused" class="status-btn">Tạm dừng</label>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-circle-check"></i> <span id="btn-submit-text">Xác nhận tạo gói</span>
                </button>
                <button type="button" class="btn-cancel-text" onclick="closeModal()">Hủy bỏ</button>
            </form>
        </div>
    </div>

    <script>
        // ... (Component Loads giữ nguyên) ...
        fetch('../Components/header.php').then(res => { if(res.ok) return res.text(); return ''; }).then(data => { if(data) document.getElementById('header-placeholder').innerHTML = data; });
        fetch('../Components/sidebar.php').then(res => { if(res.ok) return res.text(); return ''; }).then(data => { if(data) { document.getElementById('sidebar-placeholder').innerHTML = data; document.querySelectorAll('.nav-menu a').forEach(link => { if (link.getAttribute('href').includes('DichVu.php')) link.parentElement.classList.add('active'); }); }});

        // =====================================
        // XỬ LÝ DROPDOWN 3 CHẤM
        // =====================================
        function toggleMenu(event, menuId) {
            event.stopPropagation(); // Chặn click lan ra ngoài
            // Đóng tất cả menu khác đang mở
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if(menu.id !== menuId) menu.classList.remove('show');
            });
            // Bật tắt menu hiện tại
            document.getElementById(menuId).classList.toggle('show');
        }

        // Bấm ra ngoài là tự đóng menu
        window.onclick = function(event) {
            if (!event.target.matches('.btn-action') && !event.target.closest('.btn-action')) {
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
            // Đóng luôn modal nếu bấm ngoài viền
            let modal = document.getElementById('packageModal');
            if (event.target == modal) closeModal();
        }

        // =====================================
        // XỬ LÝ MODAL (MỞ FORM THÊM / SỬA)
        // =====================================
        function openAddModal() {
            document.getElementById('modal-title').innerText = "Thêm gói dịch vụ mới";
            document.getElementById('modal-desc').innerText = "Thiết lập thông tin gói tập";
            document.getElementById('form-action').value = "add_package";
            document.getElementById('btn-submit-text').innerText = "Xác nhận tạo gói";
            
            // Reset form
            document.getElementById('package_id').value = "";
            document.getElementById('input_ten_goi').value = "";
            document.getElementById('input_gia').value = "";
            document.getElementById('input_thoi_han_ngay').value = "30";
            document.getElementById('input_so_luong_nguoi').value = "1";
            document.getElementById('input_mo_ta').value = "";
            document.getElementById('stt-active').checked = true;

            document.getElementById('packageModal').style.display = 'flex';
        }

        function openEditModal(id, ten_goi, gia, thoi_han_ngay, so_luong_nguoi, mo_ta, trang_thai) {
            // Đổi tiêu đề UI
            document.getElementById('modal-title').innerText = "Cập nhật gói dịch vụ";
            document.getElementById('modal-desc').innerText = "Chỉnh sửa thông tin gói tập đang chọn";
            document.getElementById('form-action').value = "edit_package";
            document.getElementById('btn-submit-text').innerText = "Lưu thay đổi";
            
            // Đổ dữ liệu vào form
            document.getElementById('package_id').value = id;
            document.getElementById('input_ten_goi').value = ten_goi;
            document.getElementById('input_gia').value = gia;
            document.getElementById('input_thoi_han_ngay').value = thoi_han_ngay;
            document.getElementById('input_so_luong_nguoi').value = so_luong_nguoi;
            document.getElementById('packageModal').style.display = 'flex';
            document.getElementById('input_mo_ta').value = mo_ta;
            
            if(trang_thai === 'paused') {
                document.getElementById('stt-paused').checked = true;
            } else {
                document.getElementById('stt-active').checked = true;
            }

            document.getElementById('packageModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('packageModal').style.display = 'none';
        }
    </script>
</body>

</html>