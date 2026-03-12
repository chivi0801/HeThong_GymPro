<?php

session_start();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Quản lý nhân viên</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* BIẾN MÀU – giống DichVu.php */
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
            --danger: #ef4444;
            --success: #10b981;
            --gradient-btn: linear-gradient(90deg, #3b82f6, #8b5cf6);
            --input-text: #ffffff;
            --overlay-bg: rgba(0, 0, 0, 0.65);
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
            --danger: #dc2626;
            --success: #059669;
            --gradient-btn: linear-gradient(90deg, #2563eb, #7c3aed);
            --input-text: #0f172a;
            --overlay-bg: rgba(15, 23, 42, 0.45);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        /* =========================================================
           FIX LAYOUT: body = flex row,
           sidebar bên trái, main-content bên phải
        ========================================================= */
        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            display: flex;          /* ← flex row quan trọng */
            flex-direction: row;    /* sidebar | main */
            height: 100vh;
        }

        /* sidebar.php render ra <aside class="sidebar"> — để nó tự chiếm width */
        /* KHÔNG override width/height ở đây, sidebar.php đã có CSS riêng */

        /* main-content bọc header + page-body */
        .main-content {
            flex: 1;                /* chiếm phần còn lại sau sidebar */
            display: flex;
            flex-direction: column; /* header trên, body dưới */
            overflow: hidden;
            min-width: 0;           /* fix flex overflow */
            background-color: var(--bg-dark);
        }

        /* header.php render ra <header class="top-header"> bên trong main-content */

        .page-body {
            flex: 1;
            padding: 32px 40px;
            overflow-y: auto;
        }

        /* =========================================================
           UTILS
        ========================================================= */
        .flex-between { display: flex; justify-content: space-between; align-items: center; }
        .mb-4 { margin-bottom: 24px; }
        .text-muted { color: var(--text-muted); font-size: 14px; }
        .fw-bold { font-weight: 700; }

        h1 {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        /* =========================================================
           TOOLBAR
        ========================================================= */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 12px;
        }

        .toolbar-left { display: flex; align-items: center; gap: 10px; }

        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 16px;
            width: 300px;
            transition: 0.2s;
        }

        .search-bar:focus-within {
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .search-bar i { color: var(--text-muted); font-size: 13px; }

        .search-bar input {
            background: none;
            border: none;
            outline: none;
            color: var(--text-main);
            font-size: 13.5px;
            width: 100%;
        }

        .search-bar input::placeholder { color: var(--text-muted); }

        .tab-filter {
            display: flex;
            gap: 4px;
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 4px;
        }

        .tab-btn {
            padding: 7px 16px;
            border-radius: 7px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
            white-space: nowrap;
        }

        .tab-btn.active { background: rgba(99, 102, 241, 0.18); color: #a5b4fc; }
        .tab-btn:hover:not(.active) { color: var(--text-main); }

        .toolbar-right { display: flex; align-items: center; gap: 10px; }

        .btn-icon-text {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: 9px;
            border: 1px solid var(--border-color);
            background: var(--bg-panel);
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-icon-text:hover { border-color: var(--primary); color: var(--text-main); }

        /* =========================================================
           TABLE – copy y chang DichVu.php
        ========================================================= */
        .data-card {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            width: 100%;
            overflow: hidden;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table thead { background: rgba(255, 255, 255, 0.02); }

        .custom-table th {
            padding: 16px 24px;
            color: var(--text-muted);
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
        }

        .custom-table td {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
            color: var(--text-main);
            vertical-align: middle;
        }

        .custom-table tr:last-child td { border-bottom: none; }
        .custom-table tbody tr { transition: background 0.15s; }
        .custom-table tbody tr:hover { background: rgba(255, 255, 255, 0.02); }

        .staff-cell { display: flex; align-items: center; gap: 12px; }

        .staff-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .role-admin        { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
        .role-receptionist { background: rgba(139, 92, 246, 0.15); color: #a78bfa; }
        .role-trainer      { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }

        .status-badge {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge.inactive {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .action-cell { display: flex; align-items: center; gap: 8px; justify-content: flex-end; }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: var(--bg-input);
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: 0.2s;
        }

        .action-btn:hover        { border-color: var(--primary); color: var(--primary); }
        .action-btn.danger:hover { border-color: var(--danger);  color: var(--danger); }

        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
        }

        .table-footer-info { font-size: 13px; color: var(--text-muted); }
        .pagination { display: flex; align-items: center; gap: 6px; }

        .page-btn {
            min-width: 32px;
            height: 32px;
            padding: 0 10px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: var(--bg-input);
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: 0.2s;
        }

        .page-btn:hover:not(:disabled) { border-color: var(--primary); color: var(--text-main); }
        .page-btn.active { background: var(--gradient-btn); border-color: transparent; color: white; }
        .page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

        /* =========================================================
           PAGE HEADER BUTTONS
        ========================================================= */
        .btn-export {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--bg-panel);
            color: var(--text-main);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-export:hover { border-color: var(--primary); }

        .btn-add {
            background: var(--gradient-btn);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3); }

        /* =========================================================
           MODAL – copy y chang DichVu.php
        ========================================================= */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: var(--overlay-bg);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 20px;
        }

        .modal-content {
            background: var(--bg-panel);
            width: 100%;
            max-width: 480px;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.5);
            animation: modalFadeUp 0.3s ease-out;
            overflow: hidden;
        }

        @keyframes modalFadeUp {
            from { transform: translateY(24px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }

        .modal-header {
            padding: 24px 24px 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .modal-header-left { display: flex; align-items: center; gap: 12px; }
        .modal-icon { font-size: 22px; }

        .modal-header h3 { font-size: 18px; font-weight: 700; color: var(--text-main); margin: 0; }
        .modal-header p  { font-size: 13px; color: var(--text-muted); margin: 2px 0 0; }

        .close-btn {
            background: var(--bg-input);
            border: none;
            color: var(--text-muted);
            font-size: 18px;
            cursor: pointer;
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .close-btn:hover { background: rgba(59, 130, 246, 0.12); color: var(--text-main); }

        .modal-form { padding: 20px 24px 24px; }
        .form-group { margin-bottom: 16px; }
        .form-row { display: flex; gap: 14px; margin-bottom: 16px; }
        .form-row .form-group { flex: 1; margin-bottom: 0; }

        .modal-form label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .input-wrapper { position: relative; display: flex; align-items: center; }

        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            font-size: 14px;
            pointer-events: none;
        }

        .input-control {
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 16px;
            color: var(--input-text);
            font-size: 14px;
            transition: all 0.2s;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
        }

        .input-control.has-icon { padding-left: 38px; }

        .input-control:focus {
            border-color: rgba(99, 102, 241, 0.6);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        .input-control::placeholder { color: var(--text-muted); }

        .select-wrapper { position: relative; }
        .select-wrapper .input-control { cursor: pointer; }

        .select-caret {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 13px;
            pointer-events: none;
        }

        .status-toggle { display: flex; gap: 10px; }

        .status-btn {
            padding: 9px 20px;
            border-radius: 20px;
            border: 1.5px solid transparent;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .status-btn.active-status {
            background: rgba(99, 102, 241, 0.18);
            border-color: #6366f1;
            color: #a5b4fc;
        }

        .status-btn.inactive-status {
            background: transparent;
            border-color: var(--border-color);
            color: var(--text-muted);
        }

        .status-btn.inactive-status:hover { border-color: var(--primary); color: var(--text-main); }

        .pw-eye-btn {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .pw-eye-btn:hover { color: var(--text-main); }

        .btn-submit {
            width: 100%;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }

        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.35);
        }

        .btn-cancel-text {
            width: 100%;
            text-align: center;
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 13px;
            cursor: pointer;
            margin-top: 12px;
            padding: 4px;
        }

        .btn-cancel-text:hover { color: var(--text-main); }
    </style>
</head>

<body>

    <?php 
    // Kiểm tra session đã start
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include '../Components/sidebar.php'; 
    ?>
    <!-- sidebar.php xuất ra: <aside class="sidebar">...</aside> -->
    <!-- CSS của sidebar đã có sẵn trong sidebar.php, không cần viết lại -->

    <main class="main-content">

        <?php include '../Components/header.php'; ?>
        <!-- header.php xuất ra: <header class="top-header">...</header> -->
        <!-- CSS của header đã có sẵn trong header.php, không cần viết lại -->

        <div class="page-body">

            <!-- Tiêu đề trang -->
            <div class="flex-between mb-4">
                <div>
                    <h1>Quản lý nhân viên</h1>
                    <p class="text-muted">Quản lý và theo dõi danh sách đội ngũ nhân sự phòng tập</p>
                </div>
                <div style="display:flex;gap:10px;align-items:center;">
                    <button class="btn-export">
                        <i class="fa-solid fa-download"></i> Xuất Dữ Liệu
                    </button>
                    <button class="btn-add" onclick="openModal()">
                        <i class="fa-solid fa-plus"></i> Thêm nhân viên
                    </button>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="toolbar">
                <div class="toolbar-left">
                    <div class="search-bar">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Tìm kiếm nhân viên ..."
                               id="searchInput" oninput="filterTable()">
                    </div>
                    <div class="tab-filter">
                        <button class="tab-btn active" onclick="filterStatus('all', this)">Tất cả</button>
                        <button class="tab-btn" onclick="filterStatus('active', this)">Đang hoạt động</button>
                        <button class="tab-btn" onclick="filterStatus('inactive', this)">Nghỉ phép</button>
                    </div>
                </div>
                <div class="toolbar-right">
                    <button class="btn-icon-text"><i class="fa-solid fa-filter"></i> Lọc</button>
                    <button class="btn-icon-text"><i class="fa-solid fa-sort"></i> Sắp xếp</button>
                </div>
            </div>

            <!-- Bảng nhân viên -->
            <div class="data-card">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Họ và tên</th>
                            <th>Số điện thoại</th>
                            <th>Chức vụ</th>
                            <th>Tài khoản</th>
                            <th>Trạng thái</th>
                            <th style="text-align:right;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="staffBody">
                        <?php
                        // TODO: Thay bằng query DB thực tế
                        $sampleStaff = [
                            ['ten' => 'NhanVien', 'sdt' => '091 234 5678', 'chuc_vu' => 'admin',        'tai_khoan' => 'admin.nv',   'trang_thai' => 'active'],
                            ['ten' => 'NhanVien', 'sdt' => '091 234 5678', 'chuc_vu' => 'receptionist', 'tai_khoan' => 'recept.nv',  'trang_thai' => 'active'],
                            ['ten' => 'NhanVien', 'sdt' => '091 234 5678', 'chuc_vu' => 'trainer',      'tai_khoan' => 'trainer.nv', 'trang_thai' => 'inactive'],
                            ['ten' => 'NhanVien', 'sdt' => '091 234 5678', 'chuc_vu' => 'trainer',      'tai_khoan' => 'trainer.nv', 'trang_thai' => 'inactive'],
                        ];

                        $roleLabel = ['admin' => 'Admin', 'receptionist' => 'Receptionist', 'trainer' => 'Trainer'];
                        $roleClass = ['admin' => 'role-admin', 'receptionist' => 'role-receptionist', 'trainer' => 'role-trainer'];
                        $avatarBg  = [
                            'admin'        => 'linear-gradient(135deg,#6366f1,#8b5cf6)',
                            'receptionist' => 'linear-gradient(135deg,#8b5cf6,#ec4899)',
                            'trainer'      => 'linear-gradient(135deg,#f59e0b,#ef4444)',
                        ];

                        foreach ($sampleStaff as $nv):
                            $initials = strtoupper(substr($nv['ten'], 0, 2));
                            $bg       = $avatarBg[$nv['chuc_vu']] ?? 'linear-gradient(135deg,#6366f1,#8b5cf6)';
                            $isActive = $nv['trang_thai'] === 'active';
                        ?>
                        <tr data-status="<?php echo $nv['trang_thai']; ?>">
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar" style="background:<?php echo $bg; ?>;">
                                        <?php echo htmlspecialchars($initials); ?>
                                    </div>
                                    <span class="fw-bold"><?php echo htmlspecialchars($nv['ten']); ?></span>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($nv['sdt']); ?></td>
                            <td>
                                <span class="role-badge <?php echo $roleClass[$nv['chuc_vu']]; ?>">
                                    <?php echo $roleLabel[$nv['chuc_vu']]; ?>
                                </span>
                            </td>
                            <td style="color:var(--text-muted);"><?php echo htmlspecialchars($nv['tai_khoan']); ?></td>
                            <td>
                                <span class="status-badge <?php echo $isActive ? '' : 'inactive'; ?>">
                                    <?php echo $isActive ? 'Hoạt động' : 'Không hoạt động'; ?>
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <div class="action-cell">
                                    <button class="action-btn" title="Chỉnh sửa"><i class="fa-solid fa-pen"></i></button>
                                    <button class="action-btn danger" title="Xóa"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="table-footer">
                    <span class="table-footer-info">
                        Hiển thị <?php echo count($sampleStaff); ?> trong tổng số <?php echo count($sampleStaff); ?> nhân viên
                    </span>
                    <div class="pagination">
                        <button class="page-btn" disabled><i class="fa-solid fa-chevron-left"></i> Trước</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">Sau <i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>

        </div><!-- end .page-body -->
    </main>

    <!-- MODAL THÊM NHÂN VIÊN – pattern y chang DichVu.php -->
    <div class="modal-overlay" id="staffModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-left">
                    <span class="modal-icon">✦</span>
                    <div>
                        <h3>Thêm nhân viên mới</h3>
                        <p>Điền thông tin để tạo tài khoản nhân viên</p>
                    </div>
                </div>
                <button class="close-btn" onclick="closeModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form class="modal-form" action="../actions/ThemNhanVien.php" method="post">

                <div class="form-group">
                    <label>Họ và tên</label>
                    <div class="input-wrapper">
                        <i class="input-icon fa-regular fa-user"></i>
                        <input type="text" name="ho_ten" placeholder="Nhập họ và tên nhân viên"
                               class="input-control has-icon" id="inp-name" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <div class="input-wrapper">
                            <i class="input-icon fa-solid fa-phone"></i>
                            <input type="text" name="sdt" placeholder="090..."
                                   class="input-control has-icon" id="inp-phone" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <div class="status-toggle">
                            <button type="button" class="status-btn active-status"
                                    id="btn-male" onclick="setGender('male')">
                                <i class="fa-solid fa-mars"></i> Nam
                            </button>
                            <button type="button" class="status-btn inactive-status"
                                    id="btn-female" onclick="setGender('female')">
                                <i class="fa-solid fa-venus"></i> Nữ
                            </button>
                        </div>
                        <input type="hidden" name="gioi_tinh" id="inp-gender" value="Nam">
                    </div>
                </div>

                <div class="form-group">
                    <label>Tên đăng nhập</label>
                    <div class="input-wrapper">
                        <i class="input-icon fa-solid fa-at"></i>
                        <input type="text" name="tai_khoan" placeholder="username_123"
                               class="input-control has-icon" id="inp-username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mật khẩu</label>
                    <div class="input-wrapper">
                        <i class="input-icon fa-solid fa-lock"></i>
                        <input type="password" name="mat_khau" placeholder="••••••••"
                               class="input-control has-icon" id="inp-password"
                               style="padding-right:44px;" required>
                        <button type="button" class="pw-eye-btn" onclick="togglePassword()">
                            <i class="fa-regular fa-eye" id="pw-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Chức vụ</label>
                    <div class="input-wrapper select-wrapper">
                        <i class="input-icon fa-solid fa-briefcase"></i>
                        <select name="chuc_vu" class="input-control has-icon" id="inp-role">
                            <option value="admin">Admin</option>
                            <option value="receptionist">Receptionist</option>
                            <option value="trainer">Trainer</option>
                        </select>
                        <i class="select-caret fa-solid fa-chevron-down"></i>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-circle-check"></i> Xác nhận thêm
                </button>
                <button type="button" class="btn-cancel-text" onclick="closeModal()">Hủy bỏ</button>
            </form>
        </div>
    </div>

    <script>
        /* Theme – y chang DichVu.php */
        const ADMIN_THEME_KEY = 'gympro-admin-theme';

        function syncThemeToggleButton(theme) {
            const btn = document.getElementById('adminThemeToggle');
            if (!btn) return;
            btn.innerHTML = theme === 'light'
                ? '<i class="fa-solid fa-moon"></i> Chế độ tối'
                : '<i class="fa-solid fa-sun"></i> Chế độ sáng';
        }

        function applyAdminTheme(theme) {
            const next = theme === 'light' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem(ADMIN_THEME_KEY, next);
            syncThemeToggleButton(next);
        }

        function bindAdminThemeToggle() {
            const btn = document.getElementById('adminThemeToggle');
            if (!btn || btn.dataset.bound === '1') return;
            btn.dataset.bound = '1';
            btn.addEventListener('click', function () {
                applyAdminTheme(document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light');
            });
            syncThemeToggleButton(document.documentElement.getAttribute('data-theme'));
        }

        function initSidebarProfilePopup() {
            const trigger  = document.getElementById('gymProfileTrigger');
            const overlay  = document.getElementById('gymProfileOverlay');
            const popup    = document.getElementById('gymProfilePopup');
            const closeBtn = document.getElementById('gymProfileClose');
            if (!trigger || !overlay || !popup || !closeBtn) return;
            const open  = () => { overlay.classList.add('show'); popup.classList.add('show'); };
            const close = () => { overlay.classList.remove('show'); popup.classList.remove('show'); };
            trigger.addEventListener('click', open);
            closeBtn.addEventListener('click', close);
            overlay.addEventListener('click', close);
            document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
        }

        /* Đánh dấu active menu */
        function setActiveMenu() {
            document.querySelectorAll('.nav-menu a').forEach(link => {
                const href = link.getAttribute('href') || '';
                if (href.includes('NhanVien.php')) {
                    link.closest('li').classList.add('active');
                } else {
                    link.closest('li').classList.remove('active');
                }
            });
        }

        /* Khởi tạo */
        applyAdminTheme(localStorage.getItem(ADMIN_THEME_KEY) || 'dark');
        initSidebarProfilePopup();
        bindAdminThemeToggle();
        setActiveMenu();

        /* Modal */
        function openModal()  { document.getElementById('staffModal').style.display = 'flex'; }
        function closeModal() { document.getElementById('staffModal').style.display = 'none'; }
        window.onclick = e => { if (e.target === document.getElementById('staffModal')) closeModal(); };

        /* Gender toggle */
        function setGender(g) {
            document.getElementById('btn-male').className   = g === 'male'   ? 'status-btn active-status' : 'status-btn inactive-status';
            document.getElementById('btn-female').className = g === 'female' ? 'status-btn active-status' : 'status-btn inactive-status';
            document.getElementById('inp-gender').value     = g === 'male' ? 'Nam' : 'Nữ';
        }

        /* Password toggle */
        function togglePassword() {
            const inp = document.getElementById('inp-password');
            const eye = document.getElementById('pw-eye');
            inp.type = inp.type === 'password' ? 'text' : 'password';
            eye.className = inp.type === 'text' ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        }

        /* Search */
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('#staffBody tr').forEach(r => {
                r.style.display = r.innerText.toLowerCase().includes(q) ? '' : 'none';
            });
        }

        /* Tab filter */
        function filterStatus(status, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('#staffBody tr').forEach(r => {
                r.style.display = (status === 'all' || r.dataset.status === status) ? '' : 'none';
            });
        }
    </script>
</body>
</html>