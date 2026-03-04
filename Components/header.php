<style>
    /* ================= HEADER STYLE ================= */
    .top-header { 
        display: flex; justify-content: space-between; align-items: center; 
        padding: 0 40px; height: 80px; flex-shrink: 0;
        background-color: var(--bg-panel); border-bottom: 1px solid var(--border-color); 
    }

    .top-header .search-box { position: relative; width: 350px; }
    .top-header .search-box i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
    .top-header .search-box input {
        width: 100%; background: var(--bg-input); border: 1px solid var(--border-color);
        padding: 10px 16px 10px 40px; border-radius: 10px; color: white; outline: none; font-size: 14px;
    }

    .header-actions { display: flex; align-items: center; gap: 16px; }

    .header-actions .icon-btn {
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
</style>

<header class="top-header">
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Tìm kiếm hội viên hoặc bản ghi...">
    </div>
    <div class="header-actions">
        <button class="icon-btn"><i class="fa-regular fa-bell"></i></button>
        <button class="icon-btn"><i class="fa-solid fa-gear"></i></button>
        
        <a href="../Admin/DiemDanh.php" class="btn-scan"><i class="fa-solid fa-expand"></i> Quét khuôn mặt</a>

        <button class="btn-add-primary"><i class="fa-solid fa-user-plus"></i> Đăng ký mới</button>
    </div>
</header>