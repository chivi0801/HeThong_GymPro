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
            --bg-input: #23283c;
            --text-main: #ffffff;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.08);
            --primary: #3b82f6;
            --primary-glow: rgba(59, 130, 246, 0.4);
            --gradient-btn: linear-gradient(90deg, #3b82f6, #8b5cf6);
            --sidebar-width: 260px;
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
            background: rgba(0, 0, 0, 0.6);
            /* Nền mờ */
            backdrop-filter: blur(8px);
            /* Làm mờ hậu cảnh */
            display: none;
            /* Ẩn mặc định */
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 20px;
        }

        .modal-content {
            background: var(--bg-panel);
            width: 100%;
            max-width: 550px;
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            animation: modalFadeUp 0.3s ease-out;
            overflow: hidden;
        }

        @keyframes modalFadeUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Header Popup */
        .modal-header {
            padding: 32px 32px 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header-title {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .icon-box {
            width: 48px;
            height: 48px;
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .header-title h3 {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
        }

        .header-title p {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        .close-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 30px;
            cursor: pointer;
            line-height: 1;
        }

        /* Form Styling */
        .modal-form {
            padding: 0 32px 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .modal-form label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .input-control {
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 14px 16px;
            color: #fff;
            font-size: 15px;
            transition: all 0.2s;
            outline: none;
        }

        .input-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        /* Nút bấm */
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }

        .btn-submit {
            flex: 2;
            background: var(--gradient-btn);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-cancel {
            flex: 1;
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.05);
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
                <div class="header-title">
                    <div class="icon-box">
                        <i class="fa-solid fa-gem"></i>
                    </div>
                    <div>
                        <h3>Thêm gói dịch vụ mới</h3>
                        <p>Thiết lập thông tin và quyền lợi cho gói tập</p>
                    </div>
                </div>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>

            <form class="modal-form">
                <div class="form-group">
                    <label>Tên gói dịch vụ</label>
                    <input type="text" placeholder="VD: Gói Hội Viên Diamond" class="input-control">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Thời hạn (Tháng)</label>
                        <input type="number" value="1" class="input-control">
                    </div>
                    <div class="form-group">
                        <label>Giá tiền (VNĐ)</label>
                        <input type="text" placeholder="0" class="input-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>Quyền lợi & Mô tả</label>
                    <textarea rows="4" placeholder="- Tập luyện không giới hạn&#10;- Miễn phí khăn tập..."
                        class="input-control"></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Hủy bỏ</button>
                    <button type="submit" class="btn-submit">Xác nhận tạo gói</button>
                </div>
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
        // Đóng modal khi bấm ra ngoài
        window.onclick = function (event) {
            let modal = document.getElementById('packageModal');
            if (event.target == modal) closeModal();
        }
    </script>
</body>

</html>