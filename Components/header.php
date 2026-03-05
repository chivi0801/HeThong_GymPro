<style>
    /* ================= HEADER STYLE ================= */
    .top-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 40px;
        height: 80px;
        flex-shrink: 0;
        background-color: var(--bg-panel);
        border-bottom: 1px solid var(--border-color);
    }

    .top-header .search-box { position: relative; width: 350px; }
    .top-header .search-box i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
    .top-header .search-box input {
<<<<<<< HEAD
        width: 100%; background: var(--bg-input); border: 1px solid var(--border-color);
        padding: 10px 16px 10px 40px; border-radius: 10px; color: var(--input-text); outline: none; font-size: 14px;
=======
        width: 100%;
        background: var(--bg-input);
        border: 1px solid var(--border-color);
        padding: 10px 16px 10px 40px;
        border-radius: 10px;
        color: white;
        outline: none;
        font-size: 14px;
>>>>>>> e971cf101f8f39429c38cec43ddc607171c84c39
    }

    .top-header .search-box input::placeholder { color: var(--text-muted); }

    .header-actions { display: flex; align-items: center; gap: 16px; }

    .header-actions .icon-btn {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--bg-dark);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .btn-scan {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--bg-dark);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-add-primary {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--primary);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    /* - NOTE: Popup QR dung :target de mo/dong ma khong can JS */
    .qr-popup-overlay {
        position: fixed;
        inset: 0;
        background: rgba(6, 8, 15, 0.75);
        backdrop-filter: blur(3px);
        z-index: 4000;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .qr-popup-overlay:target {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .qr-popup-card {
        width: min(92vw, 380px);
        background: var(--bg-panel);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 18px;
        position: relative;
        text-align: center;
    }

    .qr-popup-close {
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
    }

    .qr-popup-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .qr-popup-subtitle {
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 14px;
    }

    .qr-popup-image {
        width: 500px;
        max-width: 100%;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        background: #fff;
        padding: 8px;
    }
</style>

<header class="top-header">
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Tìm kiếm hội viên hoặc bản ghi...">
    </div>
    <div class="header-actions">
        <button class="icon-btn"><i class="fa-regular fa-bell"></i></button>
        <button class="icon-btn"><i class="fa-solid fa-gear"></i></button>

        <a href="#qr-popup" class="btn-scan"><i class="fa-solid fa-qrcode" style="color:#3b82f6"></i> Check-in QR</a>
        <a href="../Admin/DiemDanh.php" class="btn-scan"><i class="fa-solid fa-expand" style="color:#22c55e"></i> Check-in khuôn mặt</a>

        <button class="btn-add-primary"><i class="fa-solid fa-user-plus"></i> Đăng ký mới</button>
    </div>
</header>

<!-- - NOTE: Popup hien thi ma QR tu image/QR.png -->
<div id="qr-popup" class="qr-popup-overlay">
    <div class="qr-popup-card">
        <a href="#" class="qr-popup-close" aria-label="Dong popup"><i class="fa-solid fa-xmark"></i></a>
        <div class="qr-popup-title">Mã QR Check-in</div>
        <div class="qr-popup-subtitle">Quét mã QR để check-in.</div>
        <img src="../image/QR.png" alt="QR Check-in" class="qr-popup-image">
    </div>
</div>
