<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Điểm danh khuôn mặt</title>
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
            --danger: #ef4444;
            --success: #10b981;
            --gradient-btn: linear-gradient(90deg, #3b82f6, #8b5cf6);
        }

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

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .page-content {
            flex: 1;
            overflow-y: auto;
            padding: 24px 40px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .page-title p {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 24px;
        }

        .tag-row {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
        }

        .tag {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid;
        }

        .tag.ai {
            color: #60a5fa;
            background: rgba(59, 130, 246, 0.12);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .tag.live {
            color: #22d3ee;
            background: rgba(34, 211, 238, 0.1);
            border-color: rgba(34, 211, 238, 0.3);
        }

        .dd-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .panel {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
        }

        .camera-box {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            height: 360px;
            background: #0b1120;
            margin-bottom: 16px;
        }

        .camera-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.45;
        }

        .camera-pill {
            position: absolute;
            left: 16px;
            top: 16px;
            font-size: 11px;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .dot.red { background: #ef4444; }

        .face-frame {
            position: absolute;
            width: 230px;
            height: 230px;
            border-radius: 24px;
            border: 2px solid #22d3ee;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            overflow: hidden;
            background: rgba(34, 211, 238, 0.05);
        }

        .scanner-line {
            position: absolute;
            left: 0;
            width: 100%;
            height: 3px;
            background: #22d3ee;
            box-shadow: 0 0 12px rgba(34, 211, 238, 0.7);
            animation: scan 2.3s ease-in-out infinite;
        }

        @keyframes scan {
            0% { top: 0; opacity: 0; }
            15% { opacity: 1; }
            50% { top: calc(100% - 3px); opacity: 1; }
            100% { top: 0; opacity: 0; }
        }

        .camera-footer {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 12px 16px;
            background: linear-gradient(180deg, rgba(11, 17, 32, 0) 0%, rgba(11, 17, 32, 0.9) 60%, rgba(11, 17, 32, 1) 100%);
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            color: #cbd5e1;
        }

        .recent-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .recent-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.02);
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            background: rgba(249, 115, 22, 0.2);
            color: #fb923c;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
        }

        .user-sub {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .right-col {
            text-align: right;
        }

        .time {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .status {
            font-size: 10px;
            font-weight: 700;
            color: var(--primary);
            background: rgba(59, 130, 246, 0.12);
            padding: 4px 8px;
            border-radius: 8px;
        }

        .member-card {
            display: flex;
            flex-direction: column;
        }

        .member-top {
            text-align: center;
            margin-bottom: 20px;
        }

        .member-top img {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
            margin-bottom: 10px;
        }

        .member-top h3 {
            font-size: 22px;
            margin-bottom: 6px;
        }

        .member-id {
            font-size: 12px;
            color: var(--text-muted);
            letter-spacing: 0.4px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 10px;
            background: rgba(0, 0, 0, 0.15);
            font-size: 14px;
        }

        .info-item .label { color: var(--text-muted); }
        .info-item .value { font-weight: 600; }
        .value.warn { color: #fb923c; }

        .btn {
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 12px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 10px;
        }

        .btn-primary {
            color: #fff;
            background: var(--gradient-btn);
        }

        .btn-ghost {
            color: var(--text-muted);
            background: transparent;
            border: 1px solid var(--border-color);
        }

        @media (max-width: 1200px) {
            .dd-grid { grid-template-columns: 1fr; }
            .camera-box { height: 300px; }
        }
    </style>
</head>
<body>
    <div id="sidebar-placeholder"></div>

    <main class="main-content">
        <div id="header-placeholder"></div>

        <div class="page-content">
           
            <div class="page-title">
                <h1>Check-in khuôn mặt</h1>
                <br>
            </div>

            <div class="dd-grid">
                <section class="panel">
                    <div class="camera-box">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop" alt="Gym Camera View">
                        <div class="camera-pill"><span class="dot red"></span>CAM 01 - ĐANG HOẠT ĐỘNG</div>
                        <div class="face-frame"><div class="scanner-line"></div></div>
                        <div class="camera-footer">
                            <span><i class="fa-solid fa-user"></i> Nhận diện: <strong>Bật</strong></span>
                            <span><i class="fa-solid fa-bolt"></i> Độ trễ: 18ms</span>
                        </div>
                    </div>

                    <div class="panel" style="padding: 16px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                            <h3 style="font-size:16px;">Check-in gần đây</h3>
                            <a href="#" style="color:var(--primary);font-size:13px;text-decoration:none;">Xem tất cả</a>
                        </div>

                        <div class="recent-list">
                            <div class="recent-item">
                                <div class="user-box">
                                    <div class="avatar">B</div>
                                    <div>
                                        <div class="user-name">Nguyễn Văn B</div>
                                        <div class="user-sub">Gói Standard • Check-in khuôn mặt</div>
                                    </div>
                                </div>
                                <div class="right-col">
                                    <div class="time">2 phút trước</div>
                                    <span class="status">THÀNH CÔNG</span>
                                </div>
                            </div>

                            <div class="recent-item">
                                <div class="user-box">
                                    <div class="avatar">C</div>
                                    <div>
                                        <div class="user-name">Bùi Thị C</div>
                                        <div class="user-sub">Gói Premium • Check-in khuôn mặt</div>
                                    </div>
                                </div>
                                <div class="right-col">
                                    <div class="time">15 phút trước</div>
                                    <span class="status">THÀNH CÔNG</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <aside class="panel member-card">
                    <div class="member-top">
                        <img src="" alt="Member Avatar">
                        <h3>Nguyen Van XYZ </h3>
                        <div class="member-id">MÃ THÀNH VIÊN: #GYM-99812</div>
                    </div>

                    <div class="info-item">
                        <span class="label">Gói tập</span>
                        <span class="value">Nâng cao</span>
                    </div>

                     <div class="info-item">
                        <span class="label">Đã tập</span>
                        <span class="value green">21 ngày</span>
                    </div>

                    <div class="info-item">
                        <span class="label">Ngày còn lại</span>
                        <span class="value warn">5 ngày</span>
                    </div>

                    <div class="info-item">
                        <span class="label">Lần cuối</span>
                        <span class="value">Hôm qua, 17:30</span>
                    </div>

                    <button class="btn btn-primary">XÁC NHẬN VÀO CỔNG</button>
                    <button class="btn btn-ghost">Không phải bạn? Quét lại</button>
                </aside>
            </div>
        </div>
    </main>

    <script>
        // - NOTE: Khoi tao popup profile sau khi sidebar load xong
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

        // - NOTE: Nap header component dung chung
        fetch('../Components/header.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('header-placeholder').innerHTML = data;
            });

        // - NOTE: Nap sidebar component dung chung va active menu theo trang hien tai
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
    </script>
</body>
</html>
