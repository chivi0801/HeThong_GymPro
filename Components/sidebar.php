<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$chuGymId = isset($_SESSION['chu_gym_id']) ? (int) $_SESSION['chu_gym_id'] : 0;
$tenPhong = isset($_SESSION['chu_gym_ten_phong']) ? (string) $_SESSION['chu_gym_ten_phong'] : 'GymPro';
$hoTenChu = isset($_SESSION['chu_gym_ho_ten']) ? (string) $_SESSION['chu_gym_ho_ten'] : 'Admin';
$emailChuGym = isset($_SESSION['chu_gym_email']) ? (string) $_SESSION['chu_gym_email'] : 'admin@gympro.local';
$avatarLabel = strtoupper(substr(trim($hoTenChu), 0, 1));
if ($avatarLabel === '') {
    $avatarLabel = 'A';
}
?>
<style>
    .sidebar {
        width: 260px;
        height: 100vh;
        background-color: var(--bg-sidebar);
        border-right: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        padding: 24px 16px;
        flex-shrink: 0;
        box-sizing: border-box;
    }

    .sidebar .logo {
        display: flex;
        flex-direction: column; /* xếp dọc */
        align-items: center;    /* căn giữa ngang */
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 40px;
        padding-left: 10px;
    }


    .sidebar .logo span {
        display: block;
        font-size: 11px;
        font-weight: 500;
        color: var(--text-muted);
        text-transform: uppercase;
        margin-top: 2px;
    }

    .sidebar .nav-menu {
        flex: 1;
        list-style: none;
        overflow-y: auto;
        /* margin-bottom: 20px; */
    }

    .sidebar .nav-menu::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar .nav-menu::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar .nav-menu::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 10px;
    }

    .sidebar .nav-menu li {
        margin-bottom: 8px;
    }

    .sidebar .nav-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: 0.3s;
    }

    .sidebar .nav-menu a:hover {
        color: var(--text-main);
        background: rgba(255, 255, 255, 0.05);
    }

    .sidebar .nav-menu a i {
        font-size: 16px;
        width: 20px;
        text-align: center;
    }

    .sidebar .nav-menu li.active a {
        background: rgba(139, 92, 246, 0.1);
        border: 1px solid rgba(139, 92, 246, 0.3);
        color: var(--text-main);
        box-shadow: inset 0 0 20px rgba(139, 92, 246, 0.05);
    }

    .sidebar .nav-menu li.active a i {
        color: var(--purple);
    }

    .sidebar .user-profile {
        margin-top: auto;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 10px 0;
        border-top: 1px solid var(--border-color);
        cursor: pointer;
        transition: 0.25s;
    }

    .sidebar .user-profile:hover {
        transform: translateY(-1px);
        opacity: 0.95;
    }

    .sidebar .avatar-fallback {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }

    .sidebar .user-info h4 {
        font-size: 14px;
        font-weight: 600;
    }

    .sidebar .user-info p {
        font-size: 12px;
        color: var(--text-muted);
    }

    .gym-popup-overlay {
        position: fixed;
        inset: 0;
        background: rgba(6, 8, 15, 0.7);
        backdrop-filter: blur(2px);
        z-index: 2500;
        opacity: 0;
        pointer-events: none;
        transition: 0.2s ease;
    }

    .gym-popup-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }

    .gym-profile-popup {
        position: fixed;
        left: 24px;
        bottom: 24px;
        width: 360px;
        max-width: calc(100vw - 32px);
        background: #171b2a;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 16px;
        z-index: 2600;
        color: #fff;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.4);
        opacity: 0;
        transform: translateY(10px);
        pointer-events: none;
        transition: 0.2s ease;
        overflow: hidden;
    }

    .gym-profile-popup.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    .gym-profile-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.14), rgba(139, 92, 246, 0.14));
    }

    .gym-profile-header h3 {
        font-size: 14px;
        margin: 0;
    }

    .gym-profile-close {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        background: transparent;
        color: #cbd5e1;
        cursor: pointer;
    }

    .gym-profile-content {
        padding: 16px;
        display: grid;
        gap: 10px;
    }

    .gym-profile-item {
        display: grid;
        gap: 4px;
    }

    .gym-profile-item span {
        font-size: 11px;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        color: #94a3b8;
    }

    .gym-profile-item strong {
        font-size: 14px;
        color: #fff;
        word-break: break-word;
    }

    .gym-profile-footer {
        padding: 14px 16px 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .btn-logout {
        width: 100%;
        height: 42px;
        border-radius: 10px;
        border: 1px solid rgba(239, 68, 68, 0.45);
        background: rgba(239, 68, 68, 0.14);
        color: #fecaca;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .gym-profile-popup {
            left: 12px;
            right: 12px;
            width: auto;
            bottom: 12px;
        }
    }
</style>

<aside class="sidebar">

    <div class="logo">

        <div>
           <img src="../image/logo.png"  style="width: 100px; height: 50px;">
             <span>Hệ thống quản lý</span>
        </div>     
 
    </div>

    <ul class="nav-menu">
        <li><a href="TongQuan.php"><i class="fa-solid fa-border-all"></i> Tổng quan</a></li>
        <li><a href="HoiVien.php"><i class="fa-solid fa-users"></i> Quản lý hội viên</a></li>
        <li><a href="DichVu.php"><i class="fa-solid fa-box"></i> Quản lý gói dịch vụ</a></li>
        <li><a href="#"><i class="fa-solid fa-user-tie"></i> Quản lý nhân viên</a></li>
        <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> Quản lý bán hàng</a></li>
        <li><a href="DoanhThu.php"><i class="fa-solid fa-money-bill-trend-up"></i> Doanh thu</a></li>
        <li><a href="#"><i class="fa-solid fa-chart-column"></i> Báo cáo</a></li>
    </ul>

    <div class="user-profile" id="gymProfileTrigger" title="Xem thông tin phòng gym">
        <div class="avatar-fallback"><?php echo htmlspecialchars($avatarLabel, ENT_QUOTES, 'UTF-8'); ?></div>
        <div class="user-info">
            <h4><?php echo htmlspecialchars($hoTenChu, ENT_QUOTES, 'UTF-8'); ?></h4>
            <p>Quản trị viên</p>
        </div>
    </div>
</aside>

<div class="gym-popup-overlay" id="gymProfileOverlay"></div>

<div class="gym-profile-popup" id="gymProfilePopup" role="dialog" aria-modal="true" aria-labelledby="gymProfileTitle">
    <div class="gym-profile-header">
        <h3 id="gymProfileTitle">Thông tin phòng gym</h3>
        <button type="button" class="gym-profile-close" id="gymProfileClose" aria-label="Dong popup">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="gym-profile-content">
        <div class="gym-profile-item">
            <span>Tên phòng</span>
            <strong><?php echo htmlspecialchars($tenPhong, ENT_QUOTES, 'UTF-8'); ?></strong>
        </div>
        <div class="gym-profile-item">
            <span>Chủ phòng</span>
            <strong><?php echo htmlspecialchars($hoTenChu, ENT_QUOTES, 'UTF-8'); ?></strong>
        </div>
        <div class="gym-profile-item">
            <span>Email</span>
            <strong><?php echo htmlspecialchars($emailChuGym, ENT_QUOTES, 'UTF-8'); ?></strong>
        </div>
        <div class="gym-profile-item">
            <span>Mã tài khoản</span>
            <strong>#GYM-<?php echo $chuGymId > 0 ? str_pad((string) $chuGymId, 4, '0', STR_PAD_LEFT) : '----'; ?></strong>
        </div>
    </div>

    <div class="gym-profile-footer">
        <a class="btn-logout" href="../Auth/DangXuat.php">
            <i class="fa-solid fa-right-from-bracket"></i>
            Đăng xuất
        </a>
    </div>
</div>
