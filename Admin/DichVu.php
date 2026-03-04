<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Quản lý gói dịch vụ</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* 1. BIẾN MÀU HỆ THỐNG */
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
        }

        /* 2. RESET & LAYOUT */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background-color: var(--bg-dark);
        }

        .page-body {
            flex: 1;
            padding: 32px 40px;
            overflow-y: auto;
        }

        /* 3. TYPOGRAPHY & UTILS */
        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mb-1 {
            margin-bottom: 4px;
        }

        .mb-4 {
            margin-bottom: 24px;
        }

        .text-muted {
            color: var(--text-muted);
            font-size: 14px;
        }

        .fw-bold {
            font-weight: 700;
        }

        h2 {
            font-size: 24px;
            letter-spacing: -0.5px;
            color: #fff;
        }

        /* 4. CUSTOM TABLE (KHÔNG BOOTSTRAP) */
        .data-card {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table thead {
            background: rgba(255, 255, 255, 0.02);
        }

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
        }

        .custom-table tr:last-child td {
            border-bottom: none;
        }

        /* 5. BUTTONS & BADGES */
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

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px var(--primary-glow);
        }

        .status-badge {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        /* --- CSS CHO MODAL THUẦN --- */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 20px;
        }

        .modal-content {
            background: #1e2235;
            width: 100%;
            max-width: 480px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.07);
            box-shadow: 0 24px 60px rgba(0,0,0,0.5);
            animation: modalFadeUp 0.3s ease-out;
            overflow: hidden;
        }

        @keyframes modalFadeUp {
            from { transform: translateY(24px); opacity: 0; }
            to   { transform: translateY(0);   opacity: 1; }
        }

        /* Header */
        .modal-header {
            padding: 24px 24px 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .modal-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modal-icon {
            font-size: 22px;
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }

        .modal-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        .close-btn {
            background: rgba(255,255,255,0.06);
            border: none;
            color: var(--text-muted);
            font-size: 18px;
            cursor: pointer;
            line-height: 1;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .close-btn:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }

        /* Form */
        .modal-form {
            padding: 20px 24px 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-row {
            display: flex;
            gap: 14px;
            margin-bottom: 16px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .modal-form label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            font-size: 14px;
            pointer-events: none;
        }

        .input-suffix {
            position: absolute;
            right: 14px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
            pointer-events: none;
        }

        .input-control {
            width: 100%;
            background: #272c3f;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 12px 16px;
            color: #fff;
            font-size: 14px;
            transition: all 0.2s;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
        }

        .input-control.has-icon {
            padding-left: 38px;
        }

        .input-control.has-suffix {
            padding-right: 52px;
        }

        .input-control:focus {
            border-color: rgba(99, 102, 241, 0.6);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        .input-control::placeholder {
            color: rgba(148,163,184,0.45);
        }

        /* Select with caret */
        .select-wrapper {
            position: relative;
        }

        .select-wrapper .input-control {
            cursor: pointer;
        }

        .select-caret {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 13px;
            pointer-events: none;
        }

        /* Status toggle */
        .status-toggle {
            display: flex;
            gap: 10px;
        }

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
            border-color: rgba(255,255,255,0.12);
            color: var(--text-muted);
        }

        .status-btn.inactive-status:hover {
            border-color: rgba(255,255,255,0.25);
            color: #fff;
        }

        /* Submit */
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
            box-shadow: 0 6px 20px rgba(99,102,241,0.35);
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

        .btn-cancel-text:hover {
            color: #fff;
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
                <button class="btn-add" onclick="openModal()">
                    <i class="fa-solid fa-plus"></i> Thêm gói mới
                </button>
            </div>

            <div class="data-card">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tên gói tập</th>
                            <th>Thời hạn</th>
                            <th>Đơn giá</th>
                            <th>Trạng thái</th>
                            <th style="text-align: right;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="fw-bold">Gói VIP 12 Tháng</span></td>
                            <td>365 ngày</td>
                            <td>5.500.000đ</td>
                            <td><span class="status-badge">Kinh doanh</span></td>
                            <td style="text-align: right;">
                                <i class="fa-solid fa-ellipsis-vertical"
                                    style="color: var(--text-muted); cursor: pointer;"></i>
                            </td>
                        </tr>
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
                        <h3>Thêm gói dịch vụ mới</h3>
                        <p>Thiết lập thông tin gói tập</p>
                    </div>
                </div>
                <button class="close-btn" onclick="closeModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form class="modal-form" onsubmit="return false;">

                <!-- Tên gói tập -->
                <div class="form-group">
                    <label>Tên gói tập</label>
                    <div class="input-wrapper">
                        <i class="input-icon fa-regular fa-gem"></i>
                        <input type="text" placeholder="VD: Gói Platinum 3 Tháng" class="input-control has-icon">
                    </div>
                </div>

                <!-- Giá + Thời hạn -->
                <div class="form-row">
                    <div class="form-group">
                        <label>Giá niêm yết</label>
                        <div class="input-wrapper">
                            <i class="input-icon fa-regular fa-credit-card"></i>
                            <input type="text" placeholder="0" class="input-control has-icon has-suffix">
                            <span class="input-suffix">VNĐ</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Thời hạn gói</label>
                        <div class="input-wrapper select-wrapper">
                            <i class="input-icon fa-regular fa-calendar"></i>
                            <select class="input-control has-icon">
                                <option>30 ngày</option>
                                <option>60 ngày</option>
                                <option>90 ngày</option>
                                <option>180 ngày</option>
                                <option>365 ngày</option>
                            </select>
                            <i class="select-caret fa-solid fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Số lượng hội viên -->
                <div class="form-group">
                    <label>Số lượng hội viên</label>
                    <div class="input-wrapper select-wrapper">
                        <i class="input-icon fa-regular fa-user"></i>
                        <select class="input-control has-icon">
                            <option>1</option>
                            <option>2</option>
                            <option>5</option>
                            <option>10</option>
                            <option>Không giới hạn</option>
                        </select>
                        <i class="select-caret fa-solid fa-chevron-down"></i>
                    </div>
                </div>

                <!-- Mô tả ngắn -->
                <div class="form-group">
                    <label>Mô tả ngắn</label>
                    <div class="input-wrapper">
                        <i class="input-icon fa-regular fa-align-left" style="top: 14px; transform: none; position: absolute;"></i>
                        <textarea rows="3" placeholder="Nhập mô tả về đặc quyền của gói..."
                            class="input-control has-icon" style="resize: none; padding-top: 12px;"></textarea>
                    </div>
                </div>

                <!-- Trạng thái -->
                <div class="form-group">
                    <label>Trạng thái</label>
                    <div class="status-toggle">
                        <button type="button" class="status-btn active-status" id="btn-active"
                            onclick="setStatus('active')">Đang bán</button>
                        <button type="button" class="status-btn inactive-status" id="btn-paused"
                            onclick="setStatus('paused')">Tạm dừng</button>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-circle-check"></i> Xác nhận tạo gói
                </button>
                <button type="button" class="btn-cancel-text" onclick="closeModal()">Hủy bỏ</button>
            </form>
        </div>
    </div>

    <script>
        // Xử lý nạp Component
        fetch('../Components/header.php')
            .then(res => res.text())
            .then(data => document.getElementById('header-placeholder').innerHTML = data);

        fetch('../Components/sidebar.php')
            .then(res => res.text())
            .then(data => {
                document.getElementById('sidebar-placeholder').innerHTML = data;
                // Active menu
                const currentPage = 'DichVu.php';
                document.querySelectorAll('.nav-menu a').forEach(link => {
                    if (link.getAttribute('href').includes(currentPage)) {
                        link.parentElement.classList.add('active');
                    }
                });
                if (typeof initSidebarProfilePopup === 'function') initSidebarProfilePopup();
            });

        // Xử lý Modal
        function openModal() {
            document.getElementById('packageModal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('packageModal').style.display = 'none';
        }
        function setStatus(status) {
            const btnActive = document.getElementById('btn-active');
            const btnPaused = document.getElementById('btn-paused');
            if (status === 'active') {
                btnActive.className = 'status-btn active-status';
                btnPaused.className = 'status-btn inactive-status';
            } else {
                btnActive.className = 'status-btn inactive-status';
                btnPaused.className = 'status-btn active-status';
            }
        }
        // Đóng modal khi bấm ra ngoài
        window.onclick = function (event) {
            let modal = document.getElementById('packageModal');
            if (event.target == modal) closeModal();
        }
    </script>
</body>

</html>