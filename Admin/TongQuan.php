<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Tổng quan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #121521;
            --bg-panel: #1a1e2d;
            --bg-input: #23283c;
            --text-main: #ffffff;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.08);
            --primary: #3b82f6;
            --primary-glow: rgba(59, 130, 246, 0.4);
            --purple: #8b5cf6;
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
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }

        /* ================= SIDEBAR ================= */
        .sidebar {
            width: 260px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            flex-shrink: 0;
        }

        .logo {
            display: flex; align-items: center; gap: 12px;
            font-size: 20px; font-weight: 700; margin-bottom: 40px; padding-left: 10px;
        }
        .logo .icon {
            background: var(--gradient-btn); width: 32px; height: 32px;
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
        }
        .logo span { display: block; font-size: 11px; font-weight: 500; color: var(--text-muted); text-transform: uppercase; margin-top: 2px;}

        .nav-menu { flex: 1; list-style: none; }
        .nav-menu li { margin-bottom: 8px; }
        .nav-menu a {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px; border-radius: 12px;
            color: var(--text-muted); text-decoration: none;
            font-size: 14px; font-weight: 500; transition: 0.3s;
        }
        .nav-menu a:hover { color: var(--text-main); background: rgba(255,255,255,0.05); }
        .nav-menu a i { font-size: 16px; width: 20px; text-align: center; }

        /* Active Nav Item */
        .nav-menu li.active a {
            background: rgba(139, 92, 246, 0.1);
            border: 1px solid rgba(139, 92, 246, 0.3);
            color: var(--text-main);
            box-shadow: inset 0 0 20px rgba(139, 92, 246, 0.05);
        }
        .nav-menu li.active a i { color: var(--purple); }

        .user-profile {
            display: flex; align-items: center; gap: 12px;
            padding: 16px 10px 0; border-top: 1px solid var(--border-color);
        }
        .user-profile img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .user-info h4 { font-size: 14px; font-weight: 600; }
        .user-info p { font-size: 12px; color: var(--text-muted); }

        /* ================= MAIN CONTENT WRAPPER ================= */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* KhÃ³a cuá»™n á»Ÿ khung ngoÃ i Ä‘á»ƒ Header Ä‘á»©ng im */
        }

        .page-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto; /* Chá»‰ cho phÃ©p cuá»™n ná»™i dung trang */
            padding: 24px 40px;
        }

        /* PAGE TITLE */
        .page-title h1 { font-size: 28px; font-weight: 700; margin-bottom: 5px; }
        .page-title p { color: var(--text-muted); font-size: 14px; margin-bottom: 30px; }

        /* ================= DASHBOARD GRIDS ================= */
        
        /* 1. STATS GRID */
        .stats-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 20px; flex-shrink: 0;
        }
        .stat-card {
            background: var(--bg-panel); border: 1px solid var(--border-color);
            border-radius: 16px; padding: 24px; position: relative;
        }
        .stat-icon {
            width: 40px; height: 40px; border-radius: 10px; background: rgba(255,255,255,0.05);
            display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
            color: var(--primary); font-size: 18px;
        }
        .stat-card.purple .stat-icon { color: var(--purple); }
        .stat-card.orange .stat-icon { color: #f97316; }
        
        .stat-title { font-size: 12px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 8px; }
        .stat-value { font-size: 28px; font-weight: 700; }
        .badge-percent {
            position: absolute; top: 24px; right: 24px;
            background: rgba(59, 130, 246, 0.15); color: var(--primary);
            padding: 4px 8px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }

        /* 2. CHARTS GRID */
        .charts-grid {
            display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px; flex-shrink: 0;
        }
        .card-panel {
            background: var(--bg-panel); border: 1px solid var(--border-color);
            border-radius: 16px; padding: 24px;
        }
        .card-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;
        }
        .card-header h3 { font-size: 16px; font-weight: 600; }
        .select-filter {
            background: var(--bg-input); border: 1px solid var(--border-color);
            color: var(--text-muted); padding: 6px 12px; border-radius: 8px; font-size: 12px; outline: none;
        }

        /* Biá»ƒu Ä‘á»“ Ä‘Æ°á»ng (Line Chart) mÃ´ phá»ng báº±ng SVG */
        .line-chart-area { width: 100%; height: 200px; position: relative; }
        .chart-labels { display: flex; justify-content: space-between; margin-top: 10px; color: var(--text-muted); font-size: 11px; }

        /* Biá»ƒu Ä‘á»“ cá»™t (Bar Chart) mÃ´ phá»ng báº±ng CSS */
        .bar-chart-area {
            display: flex; align-items: flex-end; justify-content: space-between;
            height: 140px; gap: 8px; margin-bottom: 10px;
        }
        .bar {
            flex: 1; background: linear-gradient(180deg, rgba(139, 92, 246, 0.8) 0%, rgba(59, 130, 246, 0.2) 100%);
            border-radius: 4px 4px 0 0; position: relative; transition: 0.3s;
        }
        .bar:hover { filter: brightness(1.2); box-shadow: 0 0 15px var(--primary-glow); }
        .bar-info { text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border-color); }
        .bar-info span { color: var(--text-muted); font-size: 12px; }
        .bar-info strong { color: var(--primary); font-size: 14px; margin-left: 10px; }

        /* Danh sÃ¡ch hoáº¡t Ä‘á»™ng */
        .activity-list { display: flex; flex-direction: column; gap: 16px; }
        .activity-item {
            display: flex; justify-content: space-between; align-items: center;
            padding-bottom: 16px; border-bottom: 1px solid var(--border-color);
        }
        .activity-item:last-child { border: none; padding-bottom: 0; }
        .act-user { display: flex; align-items: center; gap: 12px; }
        .act-avatar {
            width: 40px; height: 40px; border-radius: 50%; background: #fed7aa;
            display: flex; align-items: center; justify-content: center; color: #ea580c; font-weight: bold;
        }
        .act-details h4 { font-size: 14px; font-weight: 500; margin-bottom: 2px; }
        .act-details p { font-size: 12px; color: var(--text-muted); }
        .act-time { text-align: right; }
        .act-time p { font-size: 12px; color: var(--text-muted); margin-bottom: 4px; }
        .status-badge {
            background: rgba(59, 130, 246, 0.1); color: var(--primary);
            padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: 600;
        }

        /* Danh sÃ¡ch gia háº¡n */
        .renewal-list { margin-top: 15px; display: flex; flex-direction: column; gap: 15px; }
        .renewal-item { display: flex; align-items: center; gap: 12px; }
        .renewal-item img { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }
        .ren-info { flex: 1; }
        .ren-info h4 { font-size: 13px; font-weight: 500; margin-bottom: 5px; }
        .progress-bar { width: 100%; height: 4px; background: #334155; border-radius: 2px; overflow: hidden; }
        .progress-fill { height: 100%; background: #f97316; width: 80%; }
        .btn-mail {
            width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border-color);
            background: transparent; color: var(--text-muted); cursor: pointer;
        }
        .btn-mail:hover { background: rgba(255,255,255,0.05); color: white; }
        .btn-full-purple {
            width: 100%; background: var(--gradient-btn); border: none; padding: 12px;
            border-radius: 10px; color: white; font-weight: 600; margin-top: 20px; cursor: pointer;
        }
        
    </style>
</head>
<body>

    <div id="sidebar-placeholder"></div>

    <main class="main-content">
        
        <div id="header-placeholder"></div>

        <div class="page-content">
            
            <div class="page-title">
                <h1>Tổng quan</h1>
                <p>Chào mừng quay trở lại, đây là tình hình phòng tập hôm nay.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa-solid fa-user-group"></i></div>
                    <div class="badge-percent">+12.5%</div>
                    <div class="stat-title">Tổng số hội viên</div>
                    <div class="stat-value">1,284</div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-icon"><i class="fa-solid fa-money-bill"></i></div>
                    <div class="badge-percent">+8.2%</div>
                    <div class="stat-title">DOANH THU THÁNG NAY</div>
                    <div class="stat-value">312.450.000đ</div>
                </div>
                <div class="stat-card orange">
                    <div class="stat-icon"><i class="fa-solid fa-box-open"></i></div>
                    <div class="stat-title">Tổng số gói dịch vụ</div>
                    <div class="stat-value">86</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa-solid fa-check-double"></i></div>
                    <div class="badge-percent">+5.1%</div>
                    <div class="stat-title">LƯU CHECK-IN HÔM NAY</div>
                    <div class="stat-value">142</div>
                </div>
            </div>

            <div class="charts-grid">
                <div class="card-panel">
                    <div class="card-header">
                        <h3>Biểu đồ doanh thu</h3>
                        <select class="select-filter"><option>7 tháng gần nhất</option></select>
                    </div>
                    <div class="line-chart-area">
                        <svg width="100%" height="100%" viewBox="0 0 500 150" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="glow" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="rgba(59, 130, 246, 0.4)" />
                                    <stop offset="100%" stop-color="rgba(59, 130, 246, 0)" />
                                </linearGradient>
                                <filter id="shadow">
                                    <feDropShadow dx="0" dy="5" stdDeviation="5" flood-color="#3b82f6" flood-opacity="0.5"/>
                                </filter>
                            </defs>
                            <path d="M0,120 C50,110 80,140 150,110 C220,80 250,20 300,50 C350,80 380,140 420,100 C460,60 480,40 500,50 L500,150 L0,150 Z" fill="url(#glow)"/>
                            <path d="M0,120 C50,110 80,140 150,110 C220,80 250,20 300,50 C350,80 380,140 420,100 C460,60 480,40 500,50" fill="none" stroke="#3b82f6" stroke-width="4" filter="url(#shadow)"/>
                        </svg>
                    </div>
                    <div class="chart-labels">
                        <span>THÁNG 1</span><span>THÁNG 2</span><span>THÁNG 3</span>
                        <span>THÁNG 4</span><span>THÁNG 5</span><span>THÁNG 6</span><span>THÁNG 7</span>
                    </div>
                </div>

                <div class="card-panel">
                    <div class="card-header">
                        <h3>Lượng khách trong tuần</h3>
                    </div>
                    <div class="bar-chart-area">
                        <div class="bar" style="height: 40%;"></div>
                        <div class="bar" style="height: 55%;"></div>
                        <div class="bar" style="height: 45%;"></div>
                        <div class="bar" style="height: 80%;"></div>
                        <div class="bar" style="height: 60%;"></div>
                        <div class="bar" style="height: 95%;"></div>
                        <div class="bar" style="height: 50%;"></div>
                    </div>
                    <div class="chart-labels" style="margin-bottom: 15px;">
                        <span>T2</span><span>T3</span><span>T4</span><span>T5</span><span>T6</span><span>T7</span><span>CN</span>
                    </div>
                    <div class="bar-info">
                        <span>Trung bình ngày</span> <strong>320 hội viên</strong>
                    </div>
                </div>
            </div>

            <div class="charts-grid" style="margin-bottom: 0;"> 
                <div class="card-panel">
                    <div class="card-header">
                        <h3>Hoạt động gần đây</h3>
                        <a href="#" style="color: var(--primary); font-size: 13px; text-decoration: none;">Xem tất cả</a>
                    </div>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="act-user">
                                <div class="act-avatar">B</div>
                                <div class="act-details">
                                    <h4>Nguyễn Văn B</h4>
                                    <p>Gói Standard • Check-in khuôn mặt</p>
                                </div>
                            </div>
                            <div class="act-time">
                                <p>2 phút trước</p>
                                <span class="status-badge">THÀNH CÔNG</span>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="act-user">
                                <div class="act-avatar" style="background: #fde047; color: #ca8a04;">M</div>
                                <div class="act-details">
                                    <h4>David Miller</h4>
                                    <p>Gói Dùng thử • Đăng ký tại quầy</p>
                                </div>
                            </div>
                            <div class="act-time">
                                <p>42 phút trước</p>
                                <span class="status-badge">THÀNH CÔNG</span>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="act-user">
                                <div class="act-avatar" style="background: #fed7aa; color: #ea580c;">C</div>
                                <div class="act-details">
                                    <h4>Bùi Thị C</h4>
                                    <p>Gói Premium • Check-in khuôn mặt</p>
                                </div>
                            </div>
                            <div class="act-time">
                                <p>15 phút trước</p>
                                <span class="status-badge">THÀNH CÔNG</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-panel">
                    <div class="card-header" style="margin-bottom: 5px;">
                        <h3>Gia hạn sắp tới</h3>
                    </div>
                    <p style="font-size: 12px; color: var(--text-muted);">12 hội viên sắp hết hạn trong 72h</p>
                    
                    <div class="renewal-list">
                        <div class="renewal-item">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=100&auto=format&fit=crop" alt="Customer">
                            <div class="ren-info">
                                <h4>Customer 3</h4>
                                <div class="progress-bar"><div class="progress-fill" style="width: 85%;"></div></div>
                            </div>
                            <button class="btn-mail"><i class="fa-regular fa-envelope"></i></button>
                        </div>

                        <div class="renewal-item">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=100&auto=format&fit=crop" alt="Customer">
                            <div class="ren-info">
                                <h4>Customer 4</h4>
                                <div class="progress-bar"><div class="progress-fill" style="width: 95%;"></div></div>
                            </div>
                            <button class="btn-mail"><i class="fa-regular fa-envelope"></i></button>
                        </div>
                    </div>

                    <button class="btn-full-purple">Gửi nhắc nhở hàng loạt</button>
                    <div style="text-align: center; margin-top: 15px;">
                        <a href="#" style="color: var(--text-muted); font-size: 13px; text-decoration: none;">Xem tất cả</a>
                    </div>
                </div>
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

        fetch('header.php')
            .then(response => response.text())
            .then(data => document.getElementById('header-placeholder').innerHTML = data);

        fetch('sidebar.php')
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
