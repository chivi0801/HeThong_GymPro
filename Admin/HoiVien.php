<?php require_once __DIR__ . '/../actions/xuly_HoiVien.php'; ?>
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
            --input-text: #ffffff;
        }

        :root[data-theme="light"] {
            --bg-dark: #f1f5f9;
            --bg-panel: #ffffff;
            --bg-sidebar: #e2e8f0;
            --bg-input: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: rgba(15, 23, 42, 0.12);
            --primary: #2563eb;
            --purple: #7c3aed;
            --warning: #ea580c;
            --danger: #dc2626;
            --success: #059669;
            --gradient-btn: linear-gradient(90deg, #2563eb, #7c3aed);
            --input-text: #0f172a;
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
        .member-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px; flex-shrink: 0; }
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
        .badge.expired { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }
        .badge.reserved { background: rgba(14, 165, 233, 0.1); color: #38bdf8; border: 1px solid rgba(14, 165, 233, 0.25); }
        .badge.paused { background: rgba(148, 163, 184, 0.1); color: #cbd5e1; border: 1px solid rgba(148, 163, 184, 0.25); }

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

        .toast-success {
            position: fixed;
            top: 92px;
            right: 24px;
            z-index: 5000;
            background: rgba(16, 185, 129, 0.95);
            color: #ffffff;
            border: 1px solid rgba(16, 185, 129, 0.6);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.25);
            opacity: 0;
            transform: translateY(-8px);
            pointer-events: none;
            transition: opacity 0.25s ease, transform 0.25s ease;
        }

        .toast-success.show {
            opacity: 1;
            transform: translateY(0);
        }

        .member-detail-overlay {
            position: fixed;
            inset: 0;
            background: rgba(6, 8, 15, 0.72);
            backdrop-filter: blur(3px);
            z-index: 4600;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .member-detail-overlay.show {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }
        .member-detail-card {
            width: min(92vw, 640px);
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            position: relative;
        }
        .member-detail-close {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-dark);
            cursor: pointer;
        }
        .member-detail-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .member-detail-sub {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 16px;
        }
        .member-detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px 16px;
            margin-bottom: 14px;
        }
        .member-detail-item {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.02);
        }
        .member-detail-item .label {
            display: block;
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 4px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .member-detail-item .value {
            font-size: 14px;
            font-weight: 600;
        }
        .member-face-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px;
            margin-top: 10px;
        }
        .member-face-status {
            font-size: 14px;
            font-weight: 600;
        }
        .btn-face-action {
            border: none;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            background: var(--primary);
            color: white;
        }

    </style>
</head>
<body>

    <?php $registerSuccess = isset($_GET['register_success']) && $_GET['register_success'] === '1'; ?>
    <div id="register-success-toast" class="toast-success<?php echo $registerSuccess ? ' show' : ''; ?>">
        Đăng ký thành công
    </div>
    <div id="member-detail-overlay" class="member-detail-overlay">
        <div class="member-detail-card">
            <button type="button" id="member-detail-close" class="member-detail-close" aria-label="Đóng popup">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="member-detail-title">Thông tin hội viên</div>
            <div class="member-detail-sub">Thông tin cơ bản và gói tập gần đây nhất.</div>

            <div class="member-detail-grid">
                <div class="member-detail-item"><span class="label">Họ tên</span><span class="value" id="md-ho-ten">--</span></div>
                <div class="member-detail-item"><span class="label">Mã ID</span><span class="value" id="md-ma-id">--</span></div>
                <div class="member-detail-item"><span class="label">Số điện thoại</span><span class="value" id="md-sdt">--</span></div>
                <div class="member-detail-item"><span class="label">Email</span><span class="value" id="md-email">--</span></div>
                <div class="member-detail-item"><span class="label">Ngày sinh</span><span class="value" id="md-ngay-sinh">--</span></div>
                <div class="member-detail-item"><span class="label">Giới tính</span><span class="value" id="md-gioi-tinh">--</span></div>
                <div class="member-detail-item"><span class="label">Gói gần đây</span><span class="value" id="md-goi-tap">--</span></div>
                <div class="member-detail-item"><span class="label">Bắt đầu - Kết thúc</span><span class="value" id="md-thoi-han">--</span></div>
                <div class="member-detail-item"><span class="label">Trạng thái gói</span><span class="value" id="md-trang-thai">--</span></div>
            </div>

            <div class="member-face-row">
                <div>
                    <div class="member-detail-sub" style="margin-bottom: 4px;">Đăng ký khuôn mặt</div>
                    <div class="member-face-status" id="md-face-status">Chưa đăng ký</div>
                </div>
                <button type="button" class="btn-face-action" id="md-face-action-btn">Đăng ký khuôn mặt</button>
            </div>
        </div>
    </div>

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

            <div class="member-stats">
                <div class="stat-card-m blue">
                    <div class="top">
                        <span class="title">Tổng hội viên</span>
                        <div class="icon-s"><i class="fa-solid fa-users"></i></div>
                    </div>
                    <div class="value"><?php echo htmlspecialchars($tongHoiVienFormatted, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="desc blue-text"><i class="fa-solid fa-arrow-trend-up"></i> +12% tháng này</div>
                </div>
                
                <div class="stat-card-m purple">
                    <div class="top">
                        <span class="title">Gói tập hoạt động</span>
                        <div class="icon-s"><i class="fa-solid fa-shield-halved"></i></div>
                    </div>
                    <div class="value"><?php echo htmlspecialchars($hoiVienDangHoatDongFormatted, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="desc blue-text"><i class="fa-solid fa-arrow-trend-up"></i> +5% so với tuần trước</div>
                </div>

                <div class="stat-card-m warning">
                    <div class="top">
                        <span class="title">Sắp Hết Hạn (trong 3 ngày)</span>
                        <div class="icon-s"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    </div>
                    <div class="value"><?php echo htmlspecialchars($hoiVienSapHetHanFormatted, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="desc warning-text">Gửi nhắc nhở</div>
                </div>

                <div class="stat-card-m warning">
                    <div class="top">
                        <span class="title">Đã Hết Hạn</span>
                        <div class="icon-s"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    </div>
                    <div class="value"><?php echo htmlspecialchars($hoiVienDaHetHanFormatted, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="desc warning-text">Gia hạn ngay</div>
                </div>
                
            </div>

            <div class="table-panel">
                
                <div class="table-header-controls">
                    <div class="tabs">
                        <div class="tab active" data-status-filter="all">Tất cả</div>
                        <div class="tab" data-status-filter="active">Đang hoạt động</div>
                        <div class="tab" data-status-filter="expiring">Sắp hết hạn</div>
                        <div class="tab" data-status-filter="expired">Đã hết hạn</div>
                        <div class="tab" data-status-filter="reserved">Bảo lưu</div>
                        <div class="tab" data-status-filter="paused">Tạm dừng</div>
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
                                <th>Ngày bắt đầu</th>
                                <th>Ngày hết hạn</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($hoiVienRows)): ?>
                                <?php foreach ($hoiVienRows as $member): ?>
                                    <?php
                                        $statusKey = $member['normalized_status'] ?? 'active';
                                        $statusMeta = $statusDisplayMap[$statusKey] ?? ['label' => 'Khong xac dinh', 'badgeClass' => 'paused', 'warningRow' => false];
                                        $memberName = trim((string) ($member['ho_ten'] ?? ''));
                                        $avatarChar = strtoupper(substr($memberName, 0, 1));
                                        $rowClass = !empty($statusMeta['warningRow']) ? 'row-warning' : '';
                                    ?>
                                    <tr
                                        class="<?php echo $rowClass; ?> member-row"
                                        data-member-id="<?php echo (int) ($member['id'] ?? 0); ?>"
                                        data-status="<?php echo htmlspecialchars($statusKey, ENT_QUOTES, 'UTF-8'); ?>"
                                        data-ho-ten="<?php echo htmlspecialchars($memberName !== '' ? $memberName : 'Chua cap nhat', ENT_QUOTES, 'UTF-8'); ?>"
                                        data-ma-id="<?php echo htmlspecialchars((string) ($member['ma_id'] ?? '--'), ENT_QUOTES, 'UTF-8'); ?>"
                                        data-sdt="<?php echo htmlspecialchars((string) ($member['sdt'] ?? '--'), ENT_QUOTES, 'UTF-8'); ?>"
                                        data-email="<?php echo htmlspecialchars((string) (!empty($member['email']) ? $member['email'] : '--'), ENT_QUOTES, 'UTF-8'); ?>"
                                        data-ngay-sinh="<?php echo htmlspecialchars((string) ($member['ngay_sinh_fmt'] ?? '--/--/----'), ENT_QUOTES, 'UTF-8'); ?>"
                                        data-gioi-tinh="<?php echo htmlspecialchars((string) (!empty($member['gioi_tinh']) ? $member['gioi_tinh'] : '--'), ENT_QUOTES, 'UTF-8'); ?>"
                                        data-goi-tap="<?php echo htmlspecialchars((string) ($member['ten_goi'] ?? 'Chua co goi'), ENT_QUOTES, 'UTF-8'); ?>"
                                        data-ngay-bat-dau="<?php echo htmlspecialchars((string) ($member['ngay_bat_dau_fmt'] ?? '--/--/----'), ENT_QUOTES, 'UTF-8'); ?>"
                                        data-ngay-het-han="<?php echo htmlspecialchars((string) ($member['ngay_het_han_fmt'] ?? '--/--/----'), ENT_QUOTES, 'UTF-8'); ?>"
                                        data-trang-thai-label="<?php echo htmlspecialchars((string) $statusMeta['label'], ENT_QUOTES, 'UTF-8'); ?>"
                                        data-face-registered="<?php echo !empty($member['da_dang_ky_khuon_mat']) ? '1' : '0'; ?>"
                                    >
                                        <td>
                                            <div class="user-col">
                                                <div class="avatar <?php echo $statusKey === 'active' ? 'purple' : ''; ?>"><?php echo htmlspecialchars($avatarChar !== '' ? $avatarChar : '?', ENT_QUOTES, 'UTF-8'); ?></div>
                                                <span><?php echo htmlspecialchars($memberName !== '' ? $memberName : 'Chua cap nhat', ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </td>
                                        <td class="code-col"><?php echo htmlspecialchars((string) ($member['ma_id'] ?? '--'), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($member['ten_goi'] ?? 'Chua co goi'), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($member['ngay_bat_dau_fmt'] ?? '--/--/----'), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="<?php echo $rowClass !== '' ? 'date-col' : ''; ?>"><?php echo htmlspecialchars((string) ($member['ngay_het_han_fmt'] ?? '--/--/----'), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><span class="badge <?php echo htmlspecialchars((string) $statusMeta['badgeClass'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars((string) $statusMeta['label'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                                        <td>
                                            <div class="action-btns">
                                                <i class="fa-regular fa-eye js-open-member-detail" title="Xem chi tiết"></i>
                                                <i class="fa-solid fa-pen js-open-member-detail" title="Xem/Cập nhật"></i>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 32px 16px;">
                                        Chưa có dữ liệu hội viên để hiển thị.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <tr id="status-empty-row" style="display: none;">
                                <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 32px 16px;">
                                    Không có hội viên nào ở trạng thái này.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pagination-area">
                    <div class="page-info" id="member-page-info">
                        Hiển thị tất cả <?php echo htmlspecialchars($tongHoiVienFormatted, ENT_QUOTES, 'UTF-8'); ?> hội viên
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

    </main>
    <script>
        const ADMIN_THEME_KEY = 'gympro-admin-theme';

        function syncThemeToggleButton(theme) {
            const themeBtn = document.getElementById('adminThemeToggle');
            if (!themeBtn) {
                return;
            }

            if (theme === 'light') {
                themeBtn.innerHTML = '<i class="fa-solid fa-moon"></i> Chế độ tối';
                themeBtn.setAttribute('aria-label', 'Chuyển sang chế độ tối');
            } else {
                themeBtn.innerHTML = '<i class="fa-solid fa-sun"></i> Chế độ sáng';
                themeBtn.setAttribute('aria-label', 'Chuyển sang chế độ sáng');
            }
        }

        function applyAdminTheme(theme) {
            const nextTheme = theme === 'light' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', nextTheme);
            localStorage.setItem(ADMIN_THEME_KEY, nextTheme);
            syncThemeToggleButton(nextTheme);
        }

        function initAdminTheme() {
            const savedTheme = localStorage.getItem(ADMIN_THEME_KEY) || 'dark';
            applyAdminTheme(savedTheme);
        }

        function bindAdminThemeToggle() {
            const themeBtn = document.getElementById('adminThemeToggle');
            if (!themeBtn || themeBtn.dataset.bound === '1') {
                return;
            }

            themeBtn.dataset.bound = '1';
            themeBtn.addEventListener('click', function () {
                const currentTheme = document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
                applyAdminTheme(currentTheme === 'light' ? 'dark' : 'light');
            });

            syncThemeToggleButton(document.documentElement.getAttribute('data-theme'));
        }

        function initHoiVienStatusTabs() {
            const tabs = document.querySelectorAll('.tabs .tab');
            const rows = document.querySelectorAll('tbody .member-row');
            const emptyRow = document.getElementById('status-empty-row');
            const pageInfo = document.getElementById('member-page-info');

            if (!tabs.length || !pageInfo) {
                return;
            }

            const totalRows = rows.length;

            const updatePageInfo = (visibleCount, filterKey) => {
                if (filterKey === 'all') {
                    pageInfo.textContent = `Hien thi tat ca ${visibleCount} hoi vien`;
                    return;
                }
                pageInfo.textContent = `Hien thi ${visibleCount}/${totalRows} hoi vien`;
            };

            const applyFilter = (filterKey) => {
                let visibleCount = 0;

                rows.forEach((row) => {
                    const rowStatus = row.getAttribute('data-status');
                    const isVisible = filterKey === 'all' || rowStatus === filterKey;
                    row.style.display = isVisible ? '' : 'none';
                    if (isVisible) {
                        visibleCount++;
                    }
                });

                if (emptyRow) {
                    emptyRow.style.display = visibleCount === 0 ? '' : 'none';
                }

                updatePageInfo(visibleCount, filterKey);
            };

            tabs.forEach((tab) => {
                tab.addEventListener('click', function () {
                    tabs.forEach((item) => item.classList.remove('active'));
                    this.classList.add('active');
                    applyFilter(this.getAttribute('data-status-filter') || 'all');
                });
            });

            applyFilter('all');
        }

        function initRegisterSuccessToast() {
            const toast = document.getElementById('register-success-toast');
            if (!toast || !toast.classList.contains('show')) {
                return;
            }

            window.setTimeout(() => {
                toast.classList.remove('show');
            }, 2200);
        }

        function initMemberDetailPopup() {
            const overlay = document.getElementById('member-detail-overlay');
            const closeBtn = document.getElementById('member-detail-close');
            const actionIcons = document.querySelectorAll('.js-open-member-detail');
            const faceActionBtn = document.getElementById('md-face-action-btn');
            let currentMemberId = 0;

            if (!overlay || !closeBtn || !actionIcons.length) {
                return;
            }

            const fields = {
                hoTen: document.getElementById('md-ho-ten'),
                maId: document.getElementById('md-ma-id'),
                sdt: document.getElementById('md-sdt'),
                email: document.getElementById('md-email'),
                ngaySinh: document.getElementById('md-ngay-sinh'),
                gioiTinh: document.getElementById('md-gioi-tinh'),
                goiTap: document.getElementById('md-goi-tap'),
                thoiHan: document.getElementById('md-thoi-han'),
                trangThai: document.getElementById('md-trang-thai'),
                faceStatus: document.getElementById('md-face-status')
            };

            const closePopup = () => {
                overlay.classList.remove('show');
            };

            const openPopupByRow = (row) => {
                fields.hoTen.textContent = row.dataset.hoTen || '--';
                fields.maId.textContent = row.dataset.maId || '--';
                fields.sdt.textContent = row.dataset.sdt || '--';
                fields.email.textContent = row.dataset.email || '--';
                fields.ngaySinh.textContent = row.dataset.ngaySinh || '--';
                fields.gioiTinh.textContent = row.dataset.gioiTinh || '--';
                fields.goiTap.textContent = row.dataset.goiTap || '--';
                fields.thoiHan.textContent = `${row.dataset.ngayBatDau || '--/--/----'} - ${row.dataset.ngayHetHan || '--/--/----'}`;
                fields.trangThai.textContent = row.dataset.trangThaiLabel || '--';

                const isFaceRegistered = row.dataset.faceRegistered === '1';
                fields.faceStatus.textContent = isFaceRegistered ? 'Đã đăng ký' : 'Chưa đăng ký';
                currentMemberId = Number(row.dataset.memberId || 0);
                if (faceActionBtn) {
                    faceActionBtn.textContent = isFaceRegistered ? 'Cập nhật khuôn mặt' : 'Đăng ký khuôn mặt';
                }

                overlay.classList.add('show');
            };

            actionIcons.forEach((icon) => {
                icon.addEventListener('click', function () {
                    const row = this.closest('.member-row');
                    if (!row) {
                        return;
                    }
                    openPopupByRow(row);
                });
            });

            closeBtn.addEventListener('click', closePopup);
            if (faceActionBtn) {
                faceActionBtn.addEventListener('click', function () {
                    if (!currentMemberId) {
                        return;
                    }
                    window.location.href = `../Admin/DiemDanh.php?mode=enroll&member_id=${currentMemberId}`;
                });
            }
            overlay.addEventListener('click', function (event) {
                if (event.target === overlay) {
                    closePopup();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closePopup();
                }
            });
        }

        initAdminTheme();
        initHoiVienStatusTabs();
        initRegisterSuccessToast();
        initMemberDetailPopup();

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
                bindAdminThemeToggle();
            });
    </script>
</body>
</html>

