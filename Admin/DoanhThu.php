<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Doanh thu</title>
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

        /* Active Nav Item - Doanh thu */
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
        .main-content { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            overflow: hidden; /* Giữ layout cứng, không cuộn ở đây */
        }

        /* HEADER TOP (CỐ ĐỊNH, CÓ MÀU NỀN & VIỀN) */
        .top-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 0 40px;
            height: 80px; 
            flex-shrink: 0;
            background-color: var(--bg-panel); /* Màu nền riêng biệt */
            border-bottom: 1px solid var(--border-color); /* Đường viền tách biệt */
        }
        .search-box { position: relative; width: 350px; }
        .search-box i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        .search-box input {
            width: 100%; background: var(--bg-input); border: 1px solid var(--border-color);
            padding: 10px 16px 10px 40px; border-radius: 10px; color: white; outline: none; font-size: 14px;
        }

        .header-actions { display: flex; align-items: center; gap: 16px; }
        .icon-btn {
            width: 40px; height: 40px; border-radius: 10px; background: var(--bg-dark);
            border: 1px solid var(--border-color); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer;
        }
        .btn-scan {
            display: flex; align-items: center; gap: 8px; background: var(--bg-dark); border: 1px solid var(--border-color);
            color: var(--text-muted); padding: 10px 16px; border-radius: 10px; font-size: 14px; font-weight: 500; cursor: pointer;
        }
        .btn-add-primary {
            display: flex; align-items: center; gap: 8px; background: var(--primary); border: none;
            color: white; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer;
        }

        /* VÙNG CHỨA NỘI DUNG CUỘN */
        .page-content {
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            overflow-y: auto; 
            padding: 24px 40px;
        }

        /* ================= REVENUE TOP CARDS ================= */
        .revenue-top { display: flex; gap: 24px; margin-bottom: 24px; flex-shrink: 0;}
        
        .finance-stats { display: flex; flex: 1; gap: 20px; }
        .f-card {
            background: var(--bg-panel); border: 1px solid var(--border-color); border-radius: 16px;
            padding: 24px; flex: 1; display: flex; flex-direction: column; justify-content: center;
        }
        .f-card .f-title { font-size: 13px; color: var(--text-muted); font-weight: 500; display: flex; align-items: center; gap: 8px; margin-bottom: 12px; text-transform: uppercase;}
        .f-card .f-value { font-size: 28px; font-weight: 700; }
        
        .f-card.thu .f-title i { color: var(--primary); }
        .f-card.thu .f-value { color: var(--primary); }
        
        .f-card.chi .f-title i { color: var(--danger); }
        .f-card.chi .f-value { color: var(--danger); }

        .f-card.phatsinh .f-title i { color: var(--purple); }
        .f-card.phatsinh .f-value { color: var(--purple); }

        .finance-actions { display: flex; flex-direction: column; gap: 12px; width: 220px; }
        .btn-action-purple {
            background: rgba(139, 92, 246, 0.85); border: none; color: white; padding: 15px; border-radius: 12px;
            font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.2s;
        }
        .btn-action-purple:hover { background: var(--purple); }
        .btn-action-purple i { font-size: 16px; }

        /* ================= SPLIT LAYOUT (TABLE + FILTER) ================= */
        .content-split { display: flex; gap: 24px; flex: 1; min-height: 0; }

        /* LEFT PANEL: TABLE */
        .data-panel {
            background: var(--bg-panel); border: 1px solid var(--border-color); border-radius: 16px;
            flex: 1; display: flex; flex-direction: column; padding: 20px; overflow: hidden;
        }
        
        .table-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .table-toolbar .search-box { width: 300px; }
        .view-toggles { display: flex; gap: 8px; }
        .view-toggles .icon-btn { width: 36px; height: 36px; border-radius: 8px; }

        .table-wrapper { flex: 1; overflow-y: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 700px; }
        th { text-align: left; padding: 14px 16px; color: var(--text-muted); font-size: 11px; text-transform: uppercase; font-weight: 600; border-bottom: 1px solid var(--border-color); }
        td { padding: 16px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; }
        
        tr:hover td { background: rgba(255,255,255,0.02); }
        
        .col-id { color: var(--primary); font-family: monospace; font-size: 14px; font-weight: 500;}
        .col-val-red { color: var(--danger); font-weight: 600; }
        .status-badge { background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; display: inline-block; }

        .pagination-footer { display: flex; justify-content: space-between; align-items: center; padding-top: 20px; border-top: 1px solid var(--border-color); }
        .total-records { font-size: 13px; color: var(--text-muted); }
        .total-records span { color: var(--primary); font-weight: 600; }
        
        .page-controls { display: flex; gap: 6px; }
        .p-btn { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: transparent; border-radius: 8px; color: var(--text-muted); cursor: pointer; border: none; font-size: 13px; }
        .p-btn:hover { background: rgba(255,255,255,0.05); }
        .p-btn.active { background: var(--primary); color: white; font-weight: bold; }

        /* RIGHT PANEL: FILTERS */
        .filter-panel {
            background: var(--bg-panel); border: 1px solid var(--border-color); border-radius: 16px;
            width: 280px; padding: 24px; display: flex; flex-direction: column; overflow-y: auto;
        }

        .filter-group { margin-bottom: 24px; }
        .filter-label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-bottom: 12px; letter-spacing: 0.5px; }
        
        /* Filter Inputs */
        .date-picker {
            display: flex; align-items: center; gap: 10px; background: var(--bg-input); border: 1px solid var(--border-color);
            padding: 12px; border-radius: 8px; color: var(--text-muted); font-size: 13px; cursor: pointer;
        }
        
        /* Custom Radio */
        .radio-list { display: flex; flex-direction: column; gap: 12px; }
        .radio-item { display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; color: white;}
        .radio-item input[type="radio"] { appearance: none; width: 16px; height: 16px; border: 2px solid var(--text-muted); border-radius: 50%; outline: none; position: relative; cursor: pointer; }
        .radio-item input[type="radio"]:checked { border-color: var(--primary); }
        .radio-item input[type="radio"]:checked::after { content: ''; width: 8px; height: 8px; background: var(--primary); border-radius: 50%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }

        /* Filter Buttons (Pills/Blocks) */
        .filter-btns-column { display: flex; flex-direction: column; gap: 8px; }
        .filter-btn {
            background: transparent; border: 1px solid var(--border-color); color: var(--text-muted);
            padding: 10px 16px; border-radius: 8px; font-size: 13px; text-align: left; cursor: pointer; transition: 0.2s;
        }
        .filter-btn:hover { background: rgba(255,255,255,0.05); color: white; }
        .filter-btn.active { background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.3); color: white; }
        
        .filter-btns-row { display: flex; flex-wrap: wrap; gap: 8px; }
        .filter-badge {
            background: transparent; border: 1px solid var(--border-color); color: var(--text-muted);
            padding: 8px 14px; border-radius: 20px; font-size: 13px; cursor: pointer;
        }
        .filter-badge.active { background: rgba(59, 130, 246, 0.15); border-color: transparent; color: #60a5fa; }

    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="logo">
            <div class="icon"><i class="fa-solid fa-dumbbell"></i></div>
            <div>GymPro<br><span>Hệ thống quản lý</span></div>
        </div>

        <ul class="nav-menu">
            <li><a href="#"><i class="fa-solid fa-border-all"></i> Tổng quan</a></li>
            <li><a href="#"><i class="fa-solid fa-users"></i> Quản lý hội viên</a></li>
            <li><a href="#"><i class="fa-solid fa-box"></i> Quản lý gói dịch vụ</a></li>
            <li><a href="#"><i class="fa-solid fa-user-tie"></i> Quản lý nhân viên</a></li>
            <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> Bán hàng</a></li>
            <li class="active"><a href="#"><i class="fa-solid fa-money-bill-trend-up"></i> Doanh thu</a></li>
            <li><a href="#"><i class="fa-solid fa-chart-column"></i> Báo cáo</a></li>
        </ul>

        <div class="user-profile">
            <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=100&auto=format&fit=crop" alt="Admin">
            <div class="user-info">
                <h4>ADMIN</h4>
                <p>Quản trị viên</p>
            </div>
        </div>
    </aside>

    <main class="main-content">
        
        <!-- <header class="top-header">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Tìm kiếm hội viên hoặc bản ghi...">
            </div>
            <div class="header-actions">
                <button class="icon-btn"><i class="fa-regular fa-bell"></i></button>
                <button class="icon-btn"><i class="fa-solid fa-gear"></i></button>
                <button class="btn-scan"><i class="fa-solid fa-expand"></i> Quét khuôn mặt</button>
                <button class="btn-add-primary"><i class="fa-solid fa-user-plus"></i> Đăng ký mới</button>
            </div>
        </header> -->
        <div id="header-placeholder"></div>

        <div class="page-content">
            <div class="revenue-top">
                <div class="finance-stats">
                    <div class="f-card thu">
                        <div class="f-title"><i class="fa-solid fa-wallet"></i> Tổng thu</div>
                        <div class="f-value">312.450.000đ</div>
                    </div>
                    <div class="f-card chi">
                        <div class="f-title"><i class="fa-solid fa-money-bill-transfer"></i> Tổng chi</div>
                        <div class="f-value">400.000đ</div>
                    </div>
                    <div class="f-card phatsinh">
                        <div class="f-title"><i class="fa-solid fa-arrow-trend-up"></i> Phát sinh</div>
                        <div class="f-value">295.000đ</div>
                    </div>
                </div>
                
                <div class="finance-actions">
                    <button class="btn-action-purple"><i class="fa-solid fa-plus"></i> Thêm phiếu thu</button>
                    <button class="btn-action-purple"><i class="fa-solid fa-plus"></i> Thêm phiếu chi</button>
                </div>
            </div>

            <div class="content-split">
                
                <div class="data-panel">
                    <div class="table-toolbar">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Tìm kiếm mã phiếu, người nộp...">
                        </div>
                        <div class="view-toggles">
                            <button class="icon-btn"><i class="fa-solid fa-grip"></i></button>
                            <button class="icon-btn" style="background: rgba(59, 130, 246, 0.1); color: var(--primary); border-color: rgba(59, 130, 246, 0.2);"><i class="fa-solid fa-list-ul"></i></button>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã phiếu</th>
                                    <th>Thời gian</th>
                                    <th>Loại thu chi</th>
                                    <th>Người nộp/Nhận</th>
                                    <th>Giá trị</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-id">XXXXXXX</td>
                                    <td>25/02/2026</td>
                                    <td>Chi đối tác</td>
                                    <td>Công ty ABC</td>
                                    <td class="col-val-red">400,000</td>
                                    <td><span class="status-badge">Đã thanh toán</span></td>
                                </tr>
                                <tr>
                                    <td class="col-id">XXXXXXX</td>
                                    <td>25/02/2026</td>
                                    <td>Chi đối tác</td>
                                    <td>Công ty ABC</td>
                                    <td class="col-val-red">400,000</td>
                                    <td><span class="status-badge">Đã thanh toán</span></td>
                                </tr>
                                <tr>
                                    <td class="col-id">XXXXXXX</td>
                                    <td>25/02/2026</td>
                                    <td>Chi đối tác</td>
                                    <td>Công ty ABC</td>
                                    <td class="col-val-red">400,000</td>
                                    <td><span class="status-badge">Đã thanh toán</span></td>
                                </tr>
                                <tr>
                                    <td class="col-id">XXXXXXX</td>
                                    <td>25/02/2026</td>
                                    <td>Chi đối tác</td>
                                    <td>Công ty ABC</td>
                                    <td class="col-val-red">400,000</td>
                                    <td><span class="status-badge">Đã thanh toán</span></td>
                                </tr>
                                <tr>
                                    <td class="col-id">XXXXXXX</td>
                                    <td>25/02/2026</td>
                                    <td>Chi đối tác</td>
                                    <td>Công ty ABC</td>
                                    <td class="col-val-red">400,000</td>
                                    <td><span class="status-badge">Đã thanh toán</span></td>
                                </tr>
                                <tr>
                                    <td class="col-id">XXXXXXX</td>
                                    <td>25/02/2026</td>
                                    <td>Chi đối tác</td>
                                    <td>Công ty ABC</td>
                                    <td class="col-val-red">400,000</td>
                                    <td><span class="status-badge">Đã thanh toán</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-footer">
                        <div class="total-records">Tổng số bản ghi <span>5</span></div>
                        <div class="page-controls">
                            <button class="p-btn"><i class="fa-solid fa-angle-left"></i></button>
                            <button class="p-btn active">1</button>
                            <button class="p-btn"><i class="fa-solid fa-angle-right"></i></button>
                        </div>
                    </div>
                </div>

                <div class="filter-panel">
                    
                    <div class="filter-group">
                        <div class="filter-label">Thời gian</div>
                        <div class="date-picker">
                            <i class="fa-regular fa-calendar"></i>
                            <span>01/02/2026 - 26/02/2026</span>
                        </div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-label">Nhân viên</div>
                        <div class="radio-list">
                            <label class="radio-item">
                                <input type="radio" name="employee" checked> Của tôi
                            </label>
                            <label class="radio-item">
                                <input type="radio" name="employee"> Tất cả
                            </label>
                        </div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-label">Loại chứng từ</div>
                        <div class="filter-btns-column">
                            <button class="filter-btn active">Tất cả</button>
                            <button class="filter-btn">Phiếu thu</button>
                            <button class="filter-btn">Phiếu chi</button>
                        </div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-label">Trạng thái</div>
                        <div class="filter-btns-row">
                            <button class="filter-badge active">Đã thanh toán</button>
                            <button class="filter-badge">Chưa thanh toán</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>
    <script>
        // 1. Gọi Header
        fetch('header.php')
            .then(response => response.text())
            .then(data => document.getElementById('header-placeholder').innerHTML = data);

        // 2. Gọi Sidebar và thiết lập Active Menu
        fetch('sidebar.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('sidebar-placeholder').innerHTML = data;
                
                // --- Logic tự động sáng menu (Active) ---
                // Lấy tên file hiện tại trên thanh URL (VD: TongQuan.html)
                let currentPage = window.location.pathname.split('/').pop(); 
                if (currentPage === '') currentPage = 'TongQuan.html'; // Mặc định nếu là trang chủ
                
                // Quét tất cả thẻ <a> trong menu
                const navLinks = document.querySelectorAll('.nav-menu a');
                navLinks.forEach(link => {
                    // Lấy href của thẻ a
                    const linkHref = link.getAttribute('href');
                    
                    // Nếu href trùng với tên file hiện tại thì add class 'active'
                    if (linkHref === currentPage) {
                        link.parentElement.classList.add('active');
                    }
                });
            });
    </script>
</body>
</html>