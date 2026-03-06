<?php
// ==========================================
// 1. KẾT NỐI DATABASE
// ==========================================
$servername = "localhost";
$username = "dev_user";
$password = "123"; 
$dbname = "gym_pro"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}

// ---------------------------------------------------------
// FIX CHỖ NÀY: Lấy danh sách Gói Tập (Chỉ lưu vào mảng thôi, cấm nhét logic hội viên vào đây)
$sql_goi = "SELECT id, ten_goi, thoi_han_ngay FROM goi_tap";
$result_goi = $conn->query($sql_goi);
$danh_sach_goi = [];
if ($result_goi && $result_goi->num_rows > 0) {
    while($row_goi = $result_goi->fetch_assoc()) {
        $danh_sach_goi[] = $row_goi; 
    }
}
// ---------------------------------------------------------

// Lấy danh sách Hội Viên để lát xuống dưới <tbody> đổ ra bảng
$sql = "SELECT hv.*, gt.ten_goi as ten_goi_tap, gt.loai_goi 
        FROM hoi_vien hv 
        LEFT JOIN goi_tap gt ON hv.goi_tap_id = gt.id";
$result = $conn->query($sql);



?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Quản lý hội viên</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #121521;
            --bg-panel: #1a1e2d;
            --bg-sidebar: #151825;
            --bg-input: #23283c;
            --text-main: #ffffff;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.08);
            --primary: #3b82f6;
            --purple: #8b5cf6;
            --warning: #f97316;
            --danger: #ef4444;
            --success: #10b981;
            --gradient-btn: linear-gradient(90deg, #3b82f6, #8b5cf6);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* === SCROLLBAR === */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }

        /* ================= SIDEBAR ================= */
        .sidebar {
            width: 260px; background-color: var(--bg-sidebar); border-right: 1px solid var(--border-color);
            display: flex; flex-direction: column; padding: 24px 16px; flex-shrink: 0;
        }

        .logo {
            display: flex; align-items: center; gap: 12px; font-size: 20px; font-weight: 700; margin-bottom: 40px; padding-left: 10px;
        }
        .logo .icon {
            background: var(--gradient-btn); width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; font-size: 14px; transform: rotate(-45deg);
        }
        .logo span { display: block; font-size: 11px; font-weight: 500; color: var(--text-muted); text-transform: uppercase; margin-top: 2px;}

        .nav-menu { flex: 1; list-style: none; }
        .nav-menu li { margin-bottom: 8px; }
        .nav-menu a {
            display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px;
            color: var(--text-muted); text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.3s;
        }
        .nav-menu a:hover { color: var(--text-main); background: rgba(255,255,255,0.05); }
        .nav-menu a i { font-size: 16px; width: 20px; text-align: center; }

        /* Active Nav Item - Quáº£n lÃ½ há»™i viÃªn */
        .nav-menu li.active a {
            background: rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.3);
            color: var(--text-main); box-shadow: inset 0 0 20px rgba(139, 92, 246, 0.05);
        }
        .nav-menu li.active a i { color: var(--purple); }

        .user-profile {
            display: flex; align-items: center; gap: 12px; padding: 16px 10px 0; border-top: 1px solid var(--border-color);
        }
        .user-profile img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .user-info h4 { font-size: 14px; font-weight: 600; }
        .user-info p { font-size: 12px; color: var(--text-muted); }

        /* ================= MAIN CONTENT WRAPPER ================= */
        /* ÄÃ£ Ä‘Æ°á»£c sá»­a láº¡i giá»‘ng há»‡t file DoanhThu.php */
        .main-content { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            overflow: hidden; /* KhÃ³a cuá»™n á»Ÿ Ä‘Ã¢y Ä‘á»ƒ Header Ä‘á»©ng im */
        }

        .page-content {
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            overflow-y: auto; /* Chá»‰ pháº§n nÃ y Ä‘Æ°á»£c phÃ©p cuá»™n */
            padding: 24px 40px;
        }

        /* ================= PAGE TITLE & EXPORT (Kiá»ƒu giá»‘ng Doanh Thu) ================= */
        .page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; }
        .page-title h1 { font-size: 28px; font-weight: 700; margin-bottom: 5px; }
        .page-title p { color: var(--text-muted); font-size: 14px; }
        
        .page-actions { display: flex; gap: 12px; align-items: center; }
        .btn-date-filter {
            display: flex; align-items: center; gap: 8px; 
            background: var(--bg-panel); border: 1px solid var(--border-color);
            color: var(--text-muted); padding: 10px 16px; border-radius: 10px; 
            font-size: 13px; font-weight: 500; cursor: pointer; transition: 0.3s;
        }
        .btn-date-filter:hover { background: var(--bg-input); color: white; }
        
        .btn-primary {
            display: flex; align-items: center; gap: 8px; 
            background: var(--gradient-btn); border: none;
            color: white; padding: 10px 20px; border-radius: 10px; 
            font-size: 14px; font-weight: 600; cursor: pointer; 
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.25); transition: 0.3s;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }

        /* ================= MEMBER STATS GRID ================= */
        .member-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px; flex-shrink: 0; }
        .stat-card-m {
            background: var(--bg-panel); border: 1px solid var(--border-color); border-radius: 16px;
            padding: 24px; display: flex; flex-direction: column; justify-content: space-between; position: relative;
        }
        .stat-card-m .top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .stat-card-m .title { font-size: 13px; color: var(--text-muted); font-weight: 500; }
        .stat-card-m .icon-s { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; }
        
        .stat-card-m.blue .icon-s { background: rgba(59, 130, 246, 0.1); color: var(--primary); }
        .stat-card-m.purple .icon-s { background: rgba(139, 92, 246, 0.1); color: var(--purple); }
        .stat-card-m.warning .icon-s { background: rgba(249, 115, 22, 0.1); color: var(--warning); }
        
        .stat-card-m .value { font-size: 28px; font-weight: 700; margin-bottom: 4px; }
        .stat-card-m .desc { font-size: 12px; color: var(--text-muted); }
        .stat-card-m .desc.blue-text { color: var(--primary); }
        .stat-card-m .desc.warning-text { color: var(--warning); font-weight: 500;}

        /* ================= DATA TABLE AREA ================= */
        .table-panel {
            background: var(--bg-panel); border: 1px solid var(--border-color); border-radius: 16px; padding: 20px; flex: 1; display: flex; flex-direction: column; min-height: 0;
        }

        /* Tabs & Controls */
        .table-header-controls {
            display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 15px;
        }
        .tabs { display: flex; gap: 24px; }
        .tab { color: var(--text-muted); font-size: 14px; font-weight: 500; cursor: pointer; padding-bottom: 15px; margin-bottom: -16px; position: relative; }
        .tab.active { color: white; border-bottom: 2px solid var(--purple); }

        .filters { display: flex; gap: 10px; }
        .btn-filter {
            background: transparent; border: 1px solid var(--border-color); color: var(--text-muted);
            padding: 8px 12px; border-radius: 6px; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px;
        }

        /* Table Styles */
        .table-wrapper { flex: 1; overflow-y: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th { text-align: left; padding: 12px 16px; color: var(--text-muted); font-size: 11px; text-transform: uppercase; font-weight: 600; border-bottom: 1px solid var(--border-color); position: sticky; top: 0; background: var(--bg-panel); z-index: 1;}
        td { padding: 16px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; }
        
        tr:hover td { background: rgba(255,255,255,0.02); }

        /* User Info Column */
        .user-col { display: flex; align-items: center; gap: 12px; }
        .user-col .avatar { width: 32px; height: 32px; border-radius: 50%; background: #334155; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; }
        .user-col .avatar.purple { background: rgba(139, 92, 246, 0.2); color: #c4b5fd; }
        
        .code-col { color: var(--text-muted); font-family: monospace; font-size: 13px; }
        
        /* Badges */
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; display: inline-block; }
        .badge.active { background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }
        .badge.warning { background: rgba(249, 115, 22, 0.1); color: #fb923c; border: 1px solid rgba(249, 115, 22, 0.2); }

        /* Actions */
        .action-btns { display: flex; gap: 12px; color: var(--text-muted); }
        .action-btns i { cursor: pointer; transition: 0.2s; }
        .action-btns i:hover { color: white; }

        /* Warning Row Highlight */
        tr.row-warning td { background: rgba(249, 115, 22, 0.02); }
        tr.row-warning td.date-col { color: var(--warning); font-weight: 500; }

        /* Pagination */
        .pagination-area { display: flex; justify-content: space-between; align-items: center; padding-top: 20px; border-top: 1px solid var(--border-color); margin-top: auto; }
        .page-info { font-size: 13px; color: var(--text-muted); display: flex; align-items: center; gap: 8px; }
        .page-info select { background: var(--bg-input); border: 1px solid var(--border-color); color: white; padding: 4px 8px; border-radius: 4px; outline: none; }
        
        .pagination { display: flex; gap: 6px; align-items: center; }
        .page-btn {
            width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
            border-radius: 6px; border: 1px solid transparent; color: var(--text-muted); font-size: 13px; cursor: pointer;
        }
        .page-btn:hover { background: var(--bg-input); }
        .page-btn.active { background: var(--purple); color: white; font-weight: 600; }
        .page-text { font-size: 13px; color: var(--text-muted); margin: 0 8px; cursor: pointer; }

        /* ================= GIAO DIỆN MODAL & POPUP ================= */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px);
            z-index: 999; display: flex; align-items: center; justify-content: center;
        }
        .modal-overlay.hidden { display: none !important; }

        .modal-box {
            background: var(--bg-panel); border: 1px solid var(--border-color);
            border-radius: 16px; padding: 24px; position: relative; color: white;
        }
        .modal-box.hidden { display: none !important; }

        .modal-close {
            position: absolute; top: 16px; right: 16px; background: none; border: none;
            color: var(--text-muted); font-size: 18px; cursor: pointer; transition: 0.2s;
        }
        .modal-close:hover { color: white; }

        .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color); }

        /* Custom cho Popup Xem Chi Tiết */
        .view-info p { margin-bottom: 12px; font-size: 14px; display: flex;}
        .view-info .lbl { width: 100px; color: var(--text-muted); }
        .view-info .val { font-weight: 500; }
        .text-orange { color: var(--warning); }
        .text-purple { color: var(--purple); font-family: monospace; }

        /* Custom cho Popup Chỉnh Sửa (Form) */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group label { display: block; font-size: 13px; color: var(--text-muted); margin-bottom: 6px; }
        .form-control {
            width: 100%; background: var(--bg-input); border: 1px solid var(--border-color);
            color: white; padding: 10px 12px; border-radius: 8px; outline: none; transition: 0.2s; font-size: 14px;
        }
        .form-control:focus { border-color: var(--purple); }

        .modal-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border-color); }
        .btn-cancel { background: transparent; border: 1px solid var(--border-color); color: var(--text-muted); padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 14px;}
        .btn-cancel:hover { background: rgba(255,255,255,0.05); color: white; }
        .btn-save { background: var(--primary); border: none; color: white; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-weight: 500; font-size: 14px;}
        .btn-save:hover { opacity: 0.9; }

    </style>
</head>
<body>

    <div id="sidebar-placeholder"></div>

    <main class="main-content">
        
        <div id="header-placeholder"></div>

        <div class="page-content">
            
            <div class="page-header">
                <div class="page-title">
                    <h1>Quản lý hội viên</h1>
                    <p>Quản lý thông tin chi tiết và trạng thái đăng ký của hội viên.</p>
                </div>
                <div class="page-actions">
                    <button class="btn-date-filter">
                        <i class="fa-regular fa-calendar"></i> Tháng này 
                        <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 4px;"></i>
                    </button>
                    <button class="btn-primary">
                        <i class="fa-solid fa-download"></i> Tải Báo Cáo
                    </button>
                </div>
            </div>
           <?php
            // Khởi tạo mặc định bằng 0 để lỡ lỗi thì web vẫn không bị trắng bóc
            $tong_hoi_vien = 0;
            $dang_hoat_dong = 0;
            $sap_het_han = 0;

            // Bọc Try-Catch để lỡ sai tên cột trong Database thì trang web KHÔNG BỊ SẬP
            try {
                if (isset($conn)) {
                    // 1. Đếm tổng
                    $kq_tong = $conn->query("SELECT COUNT(id) as total FROM hoi_vien");
                    if ($kq_tong) $tong_hoi_vien = $kq_tong->fetch_assoc()['total'] ?? 0;

                    // 2. Đếm hoạt động
                    $sql_hoat_dong = "SELECT COUNT(id) as active_count FROM hoi_vien WHERE trang_thai = 'active' AND (ngay_het_han >= CURDATE() OR so_buoi_con_lai > 0)";
                    $kq_hoat_dong = $conn->query($sql_hoat_dong);
                    if ($kq_hoat_dong) $dang_hoat_dong = $kq_hoat_dong->fetch_assoc()['active_count'] ?? 0;

                    // 3. Đếm sắp hết hạn (Đã gỡ bỏ điều kiện loai_goi gây lỗi)
                    $sql_sap_het = "SELECT COUNT(id) as warning_count FROM hoi_vien WHERE trang_thai = 'active' AND ngay_het_han BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
                    $kq_sap_het = $conn->query($sql_sap_het);
                    if ($kq_sap_het) $sap_het_han = $kq_sap_het->fetch_assoc()['warning_count'] ?? 0;
                }
            } catch (Exception $e) {
                // Nếu dính lỗi SQL (ví dụ sai tên cột, sai bảng), nó sẽ nhảy vào đây
                // Mình chỉ cần im lặng bỏ qua để giao diện HTML bên dưới vẫn được vẽ ra bình thường
            }
            ?>
<div class="member-stats">
                <div class="stat-card-m blue">
                    <div class="top">
                        <span class="title">Tổng hội viên</span>
                        <div class="icon-s"><i class="fa-solid fa-users"></i></div>
                    </div>
                    <div class="value"><?= number_format($tong_hoi_vien) ?></div>
                    <div class="desc blue-text"><i class="fa-solid fa-arrow-trend-up"></i> Cập nhật tự động</div>
                </div>
                
                <div class="stat-card-m purple">
                    <div class="top">
                        <span class="title">Gói tập hoạt động</span>
                        <div class="icon-s"><i class="fa-solid fa-shield-halved"></i></div>
                    </div>
                    <div class="value"><?= number_format($dang_hoat_dong) ?></div>
                    <div class="desc blue-text"><i class="fa-solid fa-check"></i> Đang tham gia tập</div>
                </div>

                <div class="stat-card-m warning">
                    <div class="top">
                        <span class="title">Sắp Hết Hạn</span>
                        <div class="icon-s"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    </div>
                    <div class="value"><?= number_format($sap_het_han) ?></div>
                    <div class="desc warning-text">Cần gọi gia hạn ngay</div>
                </div>
            </div>
            <div class="table-panel">
                
                <div class="table-header-controls">
                    <div class="tabs">
                        <div class="tab active">Tất cả</div>
                        <div class="tab">Đang hoạt động</div>
                        <div class="tab">Sắp hết hạn</div>
                        <div class="tab">Đã hết hạn</div>
                        <div class="tab">Bảo lưu</div>
                        <div class="tab">Tạm dừng</div>
                    </div>
                    <div class="filters">
                        <button class="btn-filter"><i class="fa-solid fa-filter"></i> Lọc</button>
                        <button class="btn-filter"><i class="fa-solid fa-sort"></i> Sắp xếp</button>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Tên hội viên</th>
                                <th>Mã ID</th>
                                <th>Gói tập</th>
                                <th>Ngày hết hạn</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0):
                                $today_timestamp = strtotime('today'); 

                                while($row = $result->fetch_assoc()):
                                    $db_status = strtolower($row['trang_thai']); 
                                    $loai_goi = $row['loai_goi'] ?? 'thoi_gian'; 
                                    $real_status_key = ''; 
                                    $display_status = '';

                                    // TỰ ĐỘNG MỞ BẢO LƯU (Logic hiển thị)
                                    if ($db_status == 'reserved' && !empty($row['ngay_het_bao_luu'])) {
                                        if ($today_timestamp > strtotime($row['ngay_het_bao_luu'])) {
                                            $db_status = 'active'; 
                                        }
                                    }

                                    // LOGIC XẾP LOẠI TRẠNG THÁI
                                    if ($db_status == 'reserved') {
                                        $real_status_key = 'reserved';
                                        $display_status  = 'Bảo lưu';
                                    } elseif ($db_status == 'paused') {
                                        $real_status_key = 'paused';
                                        $display_status  = 'Tạm dừng';
                                    } else {
                                        if ($loai_goi == 'so_buoi') {
                                            // LUỒNG 1: TÍNH THEO BUỔI
                                            if ($row['so_buoi_con_lai'] > 0) {
                                                $real_status_key = 'active';
                                                $display_status  = 'Đang hoạt động';
                                            } else {
                                                $real_status_key = 'expired';
                                                $display_status  = 'Hết buổi tập';
                                            }
                                        } else {
                                            // LUỒNG 2: TÍNH THEO THÁNG
                                            if (empty($row['ngay_het_han'])) {
                                                $real_status_key = 'expired';
                                                $display_status  = 'Chưa đăng ký';
                                            } else {
                                                $het_han_timestamp = strtotime($row['ngay_het_han']);
                                                $days_diff = ($het_han_timestamp - $today_timestamp) / 86400;

                                                if ($days_diff < 0) {
                                                    $real_status_key = 'expired';
                                                    $display_status  = 'Đã hết hạn';
                                                } elseif ($days_diff <= 7) {
                                                    $real_status_key = 'expiring';
                                                    $display_status  = 'Sắp hết hạn';
                                                } else {
                                                    $real_status_key = 'active';
                                                    $display_status  = 'Đang hoạt động';
                                                }
                                            }
                                        }
                                    }
                                    
                                    // Xử lý UI (Badge, Màu sắc)
                                    $is_warning = ($real_status_key == 'expiring');
                                    $tr_class = $is_warning ? 'row-warning' : '';
                                    $avatar_style = $is_warning ? 'style="background: rgba(249, 115, 22, 0.2); color: #fb923c;"' : 'class="avatar purple"';
                                    
                                    if ($real_status_key == 'active') $badge_class = 'badge active';
                                    elseif ($real_status_key == 'expiring') $badge_class = 'badge warning';
                                    elseif ($real_status_key == 'expired' || $display_status == 'Hết buổi tập') $badge_class = 'badge danger';
                                    else $badge_class = 'badge secondary'; 
                                    
                                    // Format ngày / buổi để hiển thị
                                    if ($loai_goi == 'so_buoi') {
                                        $ngay_het_han_hien_thi = "Còn " . $row['so_buoi_con_lai'] . " buổi";
                                    } else {
                                        $ngay_het_han_hien_thi = ($row['ngay_het_han']) ? date('d/m/Y', strtotime($row['ngay_het_han'])) : 'Chưa đăng ký';
                                    }
                                    
                                    // Đóng gói JSON
                                    $row['trang_thai_goc'] = $db_status; 
                                    $row['trang_thai_vn'] = $display_status; 
                                    $row['ngay_het_han_vn'] = $ngay_het_han_hien_thi;
                                    $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                                    
                                    $nameParts = explode(' ', trim($row['ho_ten']));
                                    $initial = mb_substr(end($nameParts), 0, 1, "UTF-8");
                            ?>
                            <tr class="<?= $tr_class ?> row-item" data-status="<?= $display_status ?>">
                                <td>
                                    <div class="user-col">
                                        <div <?= $avatar_style ?>><?= mb_strtoupper($initial, "UTF-8") ?></div>
                                        <span><?= htmlspecialchars($row['ho_ten']) ?></span>
                                    </div>
                                </td>
                                <td class="code-col"><?= htmlspecialchars($row['ma_id']) ?></td> <td><?= htmlspecialchars($row['ten_goi_tap'] ?? 'Chưa có gói') ?></td>
                                <td><?= $ngay_het_han_hien_thi ?></td>
                                <td><span class="<?= $badge_class ?>"><?= $display_status ?></span></td>
                                <td>
                                    <div class="action-btns">
                                        <i class="fa-regular fa-eye btn-view" title="Xem chi tiết" data-info='<?= $jsonData ?>'></i> 
                                        <i class="fa-solid fa-pen btn-edit" title="Chỉnh sửa" data-info='<?= $jsonData ?>'></i>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; else: ?>
                                <tr><td colspan="6" style="text-align: center; padding: 30px;">Chưa có dữ liệu</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="pagination-area">
                    <div class="page-info">
                        Hiển thị 
                        <select><option>5</option><option>10</option><option>20</option></select>
                    </div>
                    <div class="pagination">
                        <span class="page-text">Trước</span>
                        <div class="page-btn active">1</div>
                        <div class="page-btn">2</div>
                        <div class="page-btn">3</div>
                        <span class="page-text">Sau</span>
                    </div>
                </div>

            </div>
        </div>
        <div id="modalOverlay" class="modal-overlay hidden">
    
            <div id="viewModal" class="modal-box hidden" style="width: 400px;">
                <button class="modal-close close-modal"><i class="fa-solid fa-xmark"></i></button>
                <h2 class="modal-title">Thông tin hội viên</h2>
                <div class="view-info">
                    <p><span class="lbl">Họ Tên:</span> <span id="v_hoten" class="val"></span></p>
                    <p><span class="lbl">Mã ID:</span> <span id="v_maid" class="val text-purple"></span></p>
                    <p><span class="lbl">SĐT:</span> <span id="v_sdt" class="val"></span></p>
                    <p><span class="lbl">Email:</span> <span id="v_email" class="val"></span></p>
                    <p><span class="lbl">Gói tập:</span> <span id="v_goitap" class="val"></span></p>
                    <p><span class="lbl">Hết hạn:</span> <span id="v_hethan" class="val text-orange"></span></p>
                    <p><span class="lbl">Trạng thái:</span> <span id="v_trangthai" class="val"></span></p>
                </div>
            </div>

            <div id="editModal" class="modal-box hidden" style="width: 500px;">
                <button class="modal-close close-modal"><i class="fa-solid fa-xmark"></i></button>
                <h2 class="modal-title">Chỉnh sửa thông tin</h2>
                
                <form action="../actions/CapNhatHoiVien.php" method="POST">
                    <input type="hidden" name="id" id="e_id">
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Họ tên</label>
                            <input type="text" name="ho_ten" id="e_hoten" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="sdt" id="e_sdt" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="e_email" class="form-control">
                        </div>
                        <select id="e_goitap" name="goi_tap_id" class="form-control">
                            <option value="">-- Chọn gói tập để gia hạn --</option>
                            <?php foreach($danh_sach_goi as $goi): ?>
                                <option value="<?= htmlspecialchars($goi['id']) ?>" data-ngay="<?= htmlspecialchars($goi['thoi_han_ngay']) ?>">
                                    <?= htmlspecialchars($goi['ten_goi']) ?> (<?= $goi['thoi_han_ngay'] ?> ngày)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-group">
                            <label>Ngày hết hạn</label>
                            <input type="date" name="ngay_het_han" id="e_hethan" class="form-control" style="color-scheme: dark;">
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                                <select name="trang_thai" id="e_trangthai" class="form-control">
                                    <option value="active">Bình thường (Hệ thống tự tính hạn)</option>
                                    <option value="reserved">Bảo lưu</option>
                                    <option value="paused">Tạm dừng</option>
                                </select>
                        </div>
                    </div>
                    
                    <div class="modal-actions">
                        <button type="button" class="close-modal btn-cancel">Hủy</button>
                        <button type="submit" class="btn-save">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>                        
    </main>
    <script>
        function initSidebarProfilePopup() {
            const trigger = document.getElementById('gymProfileTrigger');
            const overlay = document.getElementById('gymProfileOverlay');
            const popup = document.getElementById('gymProfilePopup');
            const closeBtn = document.getElementById('gymProfileClose');

            if (!trigger || !overlay || !popup || !closeBtn) {
                return;
            }

            const openPopup = () => {
                overlay.classList.add('show');
                popup.classList.add('show');
            };

            const closePopup = () => {
                overlay.classList.remove('show');
                popup.classList.remove('show');
            };

            trigger.addEventListener('click', openPopup);
            closeBtn.addEventListener('click', closePopup);
            overlay.addEventListener('click', closePopup);
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closePopup();
                }
            });
        }

        fetch('../Components/header.php')
            .then(response => response.text())
            .then(data => document.getElementById('header-placeholder').innerHTML = data);

        fetch('../Components/sidebar.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('sidebar-placeholder').innerHTML = data;

                let currentPage = window.location.pathname.split('/').pop();
                if (currentPage === '') currentPage = 'TongQuan.php';

                const navLinks = document.querySelectorAll('.nav-menu a');
                navLinks.forEach(link => {
                    const linkHref = link.getAttribute('href');
                    if (linkHref === currentPage) {
                        link.parentElement.classList.add('active');
                    }
                });

                initSidebarProfilePopup();
            });
                    // 1. TÍNH NĂNG CHUYỂN TAB LỌC DỮ LIỆU
        const tabs = document.querySelectorAll('.tab');
        const rows = document.querySelectorAll('.row-item');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Xóa class active của tab cũ, gắn cho tab mới
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                const filterStatus = tab.innerText.trim(); // Lấy chữ: Tất cả, Đang hoạt động...
                
                // Duyệt từng dòng, ẩn/hiện tùy thuộc trạng thái
                rows.forEach(row => {
                    if (filterStatus === "Tất cả" || row.dataset.status === filterStatus) {
                        row.style.display = ''; // Hiện
                    } else {
                        row.style.display = 'none'; // Ẩn
                    }
                });
            });
        });

        // ==========================================
        // TÍNH NĂNG MỞ POPUP XEM & SỬA
        // ==========================================
        const modalOverlay = document.getElementById('modalOverlay');
        const viewModal = document.getElementById('viewModal');
        const editModal = document.getElementById('editModal');
        const closeBtns = document.querySelectorAll('.close-modal');

        function closeAllModals() {
            modalOverlay.classList.add('hidden');
            viewModal.classList.add('hidden');
            editModal.classList.add('hidden');
        }

        closeBtns.forEach(btn => btn.addEventListener('click', closeAllModals));
        modalOverlay.addEventListener('click', (e) => {
            if(e.target === modalOverlay) closeAllModals(); 
        });

        // GẮN SỰ KIỆN NÚT XEM (CON MẮT)
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', function() {
                const data = JSON.parse(this.getAttribute('data-info'));
                
                document.getElementById('v_hoten').innerText = data.ho_ten;
                document.getElementById('v_maid').innerText = data.ma_id; // Đã đổi thành ma_id
                document.getElementById('v_sdt').innerText = data.sdt || 'Chưa cập nhật';
                document.getElementById('v_email').innerText = data.email || 'Chưa cập nhật';
                
                document.getElementById('v_goitap').innerText = data.ten_goi_tap || 'Chưa đăng ký'; 
                document.getElementById('v_hethan').innerText = data.ngay_het_han_vn; 
                document.getElementById('v_trangthai').innerText = data.trang_thai_vn;

                modalOverlay.classList.remove('hidden');
                viewModal.classList.remove('hidden');
            });
        });

        // GẮN SỰ KIỆN NÚT SỬA (CÂY BÚT)
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const data = JSON.parse(this.getAttribute('data-info'));
                
                document.getElementById('e_id').value = data.id; // Vẫn cần ID thực để submit form update
                document.getElementById('e_hoten').value = data.ho_ten;
                document.getElementById('e_sdt').value = data.sdt;
                document.getElementById('e_email').value = data.email;
                document.getElementById('e_goitap').value = '';
                
                let ngayHetHanFormat = data.ngay_het_han ? data.ngay_het_han.split(' ')[0] : '';
                document.getElementById('e_hethan').value = ngayHetHanFormat;
                
                // Cực kì quan trọng: Lưu lại ngày cũ để lát đối chiếu gia hạn cộng dồn
                document.getElementById('e_hethan').setAttribute('data-old-expire', ngayHetHanFormat);
                document.getElementById('e_trangthai').value = data.trang_thai_goc;

                modalOverlay.classList.remove('hidden');
                editModal.classList.remove('hidden');
            });
        });

        // ==========================================
        // LOGIC GIA HẠN GÓI: CỘNG DỒN NGÀY THÔNG MINH
        // ==========================================
        document.getElementById('e_goitap').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var soNgay = selectedOption.getAttribute('data-ngay'); // Lấy số ngày từ data-ngay

            if (soNgay && parseInt(soNgay) > 0) {
                var oldExpire = document.getElementById('e_hethan').getAttribute('data-old-expire');
                var today = new Date();
                today.setHours(0, 0, 0, 0); // Reset giờ về 0 để so sánh chuẩn xác
                
                var baseDate = new Date(); // Mặc định gốc là hôm nay

                // Khách đang còn hạn -> Lấy ngày cũ làm mốc cộng dồn
                if (oldExpire) {
                    var oldExpireDate = new Date(oldExpire);
                    oldExpireDate.setHours(0, 0, 0, 0);
                    
                    // Chỉ cộng dồn nếu ngày cũ vẫn còn ở tương lai hoặc là hôm nay
                    if (oldExpireDate >= today) {
                        baseDate = oldExpireDate;
                    }
                }

                // Cộng thêm số ngày (Sử dụng getDate + số ngày mới)
                baseDate.setDate(baseDate.getDate() + parseInt(soNgay));
                
                // Format lại yyyy-mm-dd để đẩy vào input date
                var yyyy = baseDate.getFullYear();
                var mm = String(baseDate.getMonth() + 1).padStart(2, '0');
                var dd = String(baseDate.getDate()).padStart(2, '0');
                
                document.getElementById('e_hethan').value = `${yyyy}-${mm}-${dd}`;
            }
        });
        
    </script>
</body>
</html>
