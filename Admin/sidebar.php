<style>
    /* ================= SIDEBAR STYLE ================= */
    .sidebar {
        width: 260px;
        height: 100vh; /* Thêm dòng này để sidebar cao full màn hình */
        background-color: var(--bg-sidebar);
        border-right: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        padding: 24px 16px;
        flex-shrink: 0;
        box-sizing: border-box; /* Đảm bảo padding không làm thanh sidebar bị tràn */
    }

    .sidebar .logo {
        display: flex; align-items: center; gap: 12px;
        font-size: 20px; font-weight: 700; margin-bottom: 40px; padding-left: 10px;
    }
    .sidebar .logo .icon {
        background: var(--gradient-btn); width: 32px; height: 32px;
        border-radius: 8px; display: flex; align-items: center; justify-content: center;
    }
    .sidebar .logo span { display: block; font-size: 11px; font-weight: 500; color: var(--text-muted); text-transform: uppercase; margin-top: 2px;}

    .sidebar .nav-menu { 
        flex: 1; 
        list-style: none; 
        overflow-y: auto; /* Thêm dòng này để cuộn menu nếu menu quá dài */
        margin-bottom: 20px; /* Thêm khoảng cách với phần admin ở dưới */
    }
    
    /* Làm đẹp thanh cuộn cho menu (tùy chọn) */
    .sidebar .nav-menu::-webkit-scrollbar { width: 4px; }
    .sidebar .nav-menu::-webkit-scrollbar-track { background: transparent; }
    .sidebar .nav-menu::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    .sidebar .nav-menu li { margin-bottom: 8px; }
    .sidebar .nav-menu a {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 16px; border-radius: 12px;
        color: var(--text-muted); text-decoration: none;
        font-size: 14px; font-weight: 500; transition: 0.3s;
    }
    .sidebar .nav-menu a:hover { color: var(--text-main); background: rgba(255,255,255,0.05); }
    .sidebar .nav-menu a i { font-size: 16px; width: 20px; text-align: center; }

    /* Trạng thái Active */
    .sidebar .nav-menu li.active a {
        background: rgba(139, 92, 246, 0.1);
        border: 1px solid rgba(139, 92, 246, 0.3);
        color: var(--text-main);
        box-shadow: inset 0 0 20px rgba(139, 92, 246, 0.05);
    }
    .sidebar .nav-menu li.active a i { color: var(--purple); }

    .sidebar .user-profile {
        margin-top: auto; /* Thêm dòng này để đẩy khối này xuống sát đáy */
        display: flex; 
        align-items: center; 
        gap: 12px;
        padding: 16px 10px 0; 
        border-top: 1px solid var(--border-color);
    }
    .sidebar .user-profile img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
    .sidebar .user-info h4 { font-size: 14px; font-weight: 600; }
    .sidebar .user-info p { font-size: 12px; color: var(--text-muted); }
</style>

<aside class="sidebar">
    <div class="logo">
        <div class="icon"><i class="fa-solid fa-dumbbell" style="color: white; font-size: 14px; transform: rotate(-45deg);"></i></div>
        <div>GymPro<br><span>Hệ thống quản lý</span></div>
    </div>

    <ul class="nav-menu">
        <li><a href="TongQuan.php"><i class="fa-solid fa-border-all"></i> Tổng quan</a></li>
        <li><a href="HoiVien.php"><i class="fa-solid fa-users"></i> Quản lý hội viên</a></li>
        <li><a href="#"><i class="fa-solid fa-box"></i> Quản lý gói dịch vụ</a></li>
        <li><a href="#"><i class="fa-solid fa-user-tie"></i> Quản lý nhân viên</a></li>
        <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> Bán hàng</a></li>
        <li><a href="DoanhThu.php"><i class="fa-solid fa-money-bill-trend-up"></i> Doanh thu</a></li>
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