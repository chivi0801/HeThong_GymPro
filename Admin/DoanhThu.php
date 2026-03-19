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
            --input-text: #ffffff;
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
            overflow: hidden; /* Giá»¯ layout cá»©ng, khÃ´ng cuá»™n á»Ÿ Ä‘Ã¢y */
        }

        /* HEADER TOP (Cá» Äá»ŠNH, CÃ“ MÃ€U Ná»€N & VIá»€N) */
        .top-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 0 40px;
            height: 80px; 
            flex-shrink: 0;
            background-color: var(--bg-panel); /* MÃ u ná»n riÃªng biá»‡t */
            border-bottom: 1px solid var(--border-color); /* ÄÆ°á»ng viá»n tÃ¡ch biá»‡t */
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

        /* ================= POPUP & TOAST ================= */
        .popup-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 9999; display: flex; align-items: center; justify-content: center; opacity: 0; pointer-events: none; transition: 0.3s; backdrop-filter: blur(2px); }
        .popup-overlay.show { opacity: 1; pointer-events: auto; }
        .popup-card { background: var(--bg-panel); width: 420px; padding: 24px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); border: 1px solid var(--border-color); position: relative; transform: translateY(-20px); transition: 0.3s; }
        .popup-overlay.show .popup-card { transform: translateY(0); }
        .popup-close { position: absolute; top: 16px; right: 16px; background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 20px; transition: 0.2s; }
        .popup-close:hover { color: var(--danger); }
        .popup-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; color: var(--text-main); }
        
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 13px; color: var(--text-muted); font-weight: 500; }
        .form-group input, .form-group select { width: 100%; background: var(--bg-input); border: 1px solid var(--border-color); color: var(--input-text); padding: 12px 16px; border-radius: 10px; outline: none; font-size: 14px; }
        .form-group input:focus, .form-group select:focus { border-color: var(--primary); }
        .btn-confirm { width: 100%; background: var(--gradient-btn); border: none; padding: 14px; color: white; border-radius: 10px; font-weight: 600; font-size: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 24px; transition: opacity 0.2s; }
        .btn-confirm:hover { opacity: 0.9; }

        .toast { position: fixed; bottom: 24px; right: 24px; background: var(--bg-panel); padding: 16px 24px; border-radius: 12px; border-left: 4px solid var(--success); box-shadow: 0 4px 20px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 12px; color: var(--text-main); transform: translateX(120%); transition: transform 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55); z-index: 10000; }
        .toast.show { transform: translateX(0); }
        .toast i { font-size: 20px; }
    </style>
</head>
<body>

    <div id="sidebar-placeholder"></div>

    <main class="main-content">
        
        <!-- <header class="top-header">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="TÃ¬m kiáº¿m há»™i viÃªn hoáº·c báº£n ghi...">
            </div>
            <div class="header-actions">
                <button class="icon-btn"><i class="fa-regular fa-bell"></i></button>
                <button class="icon-btn"><i class="fa-solid fa-gear"></i></button>
                <button class="btn-scan"><i class="fa-solid fa-expand"></i> QuÃ©t khuÃ´n máº·t</button>
                <button class="btn-add-primary"><i class="fa-solid fa-user-plus"></i> ÄÄƒng kÃ½ má»›i</button>
            </div>
        </header> -->
        <div id="header-placeholder"></div>

        <div class="page-content">
            <div class="revenue-top">
                <div class="finance-stats">
                    <div class="f-card thu">
                        <div class="f-title"><i class="fa-solid fa-wallet"></i> Tổng thu</div>
                        <div class="f-value" id="card_thu">0đ</div>
                    </div>
                    <div class="f-card chi">
                        <div class="f-title"><i class="fa-solid fa-money-bill-transfer"></i> Tổng chi</div>
                        <div class="f-value" id="card_chi">0đ</div>
                    </div>
                    <div class="f-card phatsinh">
                        <div class="f-title"><i class="fa-solid fa-arrow-trend-up"></i>Lợi nhuận</div>
                        <div class="f-value" id="card_loinhuan">0đ</div>
                    </div>
                </div>
                
                <div class="finance-actions">
                    <button class="btn-action-purple" onclick="openModal('THU')"><i class="fa-solid fa-plus"></i> Thêm phiếu thu</button>
                    <button class="btn-action-purple" onclick="openModal('CHI')"><i class="fa-solid fa-plus"></i> Thêm phiếu chi</button>
                </div>
            </div>

            <div class="content-split">
                
                <div class="data-panel">
                    <div class="table-toolbar">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="searchInput" oninput="debounceSearch()" placeholder="Tìm kiếm mã phiếu, người nộp...">
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã phiếu</th>
                                    <th>Thời gian</th>
                                    <th>Danh mục</th>
                                    <th>Người nộp/Nhận</th>
                                    <th>Giá trị</th>
                                    <th>Loại</th>
                                    <th>Phân quyền</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Dữ liệu API đổ vào đây -->
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-footer">
                        <div class="total-records">Tổng số bản ghi: <span id="totalRecords">0</span></div>
                        <div class="page-controls" id="paginationControls"></div>
                    </div>
                </div>

                <div class="filter-panel">
                    <div class="filter-group">
                        <div class="filter-label">Bộ Lọc Loại Phiếu</div>
                        <div class="filter-btns-column">
                            <button class="filter-btn active" onclick="setFilter('ALL', this)">Tất cả chứng từ</button>
                            <button class="filter-btn" onclick="setFilter('THU', this)">Chỉ hiện Phiếu Thu</button>
                            <button class="filter-btn" onclick="setFilter('CHI', this)">Chỉ hiện Phiếu Chi</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- POPUP THÊM PHIẾU THU / CHI -->
    <div class="popup-overlay" id="transModal">
        <div class="popup-card">
            <button class="popup-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
            <div class="popup-title" id="modalTitle">Tạo phiếu</div>
            
            <input type="hidden" id="transType" value="">
            
            <div class="form-group">
                <label>Danh mục (Lý do)</label>
                <input type="text" id="transCat" placeholder="VD: Thu tiền tài trợ, Chi tiền điện..." required>
            </div>
            <div class="form-group">
                <label>Số tiền (VNĐ)</label>
                <input type="number" id="transAmt" min="0" placeholder="Nhập số tiền..." required>
            </div>
            <div class="form-group">
                <label>Người giao dịch (Nộp/Nhận)</label>
                <input type="text" id="transPerson" placeholder="VD: Công ty Điện lực, Anh A...">
            </div>
            <div class="form-group">
                <label>Ghi chú thêm</label>
                <input type="text" id="transNote" placeholder="Ghi chú chi tiết (Không bắt buộc)">
            </div>
            
            <button class="btn-confirm" onclick="submitTransaction()" id="btnSubmitForm">
                <i class="fa-solid fa-check"></i> Xác nhận lưu
            </button>
        </div>
    </div>

    <!-- TOAST -->
    <div class="toast" id="toastEl">
        <i class="fa-solid fa-circle-check" id="toastIcon"></i>
        <span id="toastMsg">Thao tác thành công</span>
    </div>

    <script>
        const ADMIN_THEME_KEY = 'gympro-admin-theme';

        function syncThemeToggleButton(theme) {
            const themeBtn = document.getElementById('adminThemeToggle');
            if (!themeBtn) {
                return;
            }

            if (theme === 'light') {
                themeBtn.innerHTML = '<i class="fa-solid fa-moon"></i> Chế độ tối';
                themeBtn.setAttribute('aria-label', 'Chuyển sang chế độ tối');
            } else {
                themeBtn.innerHTML = '<i class="fa-solid fa-sun"></i> Chế độ sáng';
                themeBtn.setAttribute('aria-label', 'Chuyển sang chế độ sáng');
            }
        }

        function applyAdminTheme(theme) {
            const nextTheme = theme === 'light' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', nextTheme);
            localStorage.setItem(ADMIN_THEME_KEY, nextTheme);
            syncThemeToggleButton(nextTheme);
        }

        function initAdminTheme() {
            const savedTheme = localStorage.getItem(ADMIN_THEME_KEY) || 'dark';
            applyAdminTheme(savedTheme);
        }

        function bindAdminThemeToggle() {
            const themeBtn = document.getElementById('adminThemeToggle');
            if (!themeBtn || themeBtn.dataset.bound === '1') {
                return;
            }

            themeBtn.dataset.bound = '1';
            themeBtn.addEventListener('click', function () {
                const currentTheme = document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
                applyAdminTheme(currentTheme === 'light' ? 'dark' : 'light');
            });

            syncThemeToggleButton(document.documentElement.getAttribute('data-theme'));
        }

        initAdminTheme();
        
        // ================= DỮ LIỆU & TRẠNG THÁI =================
        let allData = [];
        let filteredData = [];
        let currentPage = 1;
        const PER_PAGE = 10;
        let currentFilter = 'ALL';
        let searchTimer;

        // Tiện ích Format
        const fmtMoney = (n) => parseInt(n).toLocaleString('vi-VN') + 'đ';
        const fmtDate = (d) => { if(!d) return '--'; const dt = new Date(d); return `${dt.getDate().toString().padStart(2,'0')}/${(dt.getMonth()+1).toString().padStart(2,'0')}/${dt.getFullYear()} ${dt.getHours().toString().padStart(2,'0')}:${dt.getMinutes().toString().padStart(2,'0')}`;};

        // UI Toast
        function showToast(msg, isError = false) {
            const toast = document.getElementById('toastEl');
            document.getElementById('toastMsg').textContent = msg;
            toast.style.borderLeftColor = isError ? 'var(--danger)' : 'var(--success)';
            document.getElementById('toastIcon').className = isError ? 'fa-solid fa-circle-xmark' : 'fa-solid fa-circle-check';
            document.getElementById('toastIcon').style.color = isError ? 'var(--danger)' : 'var(--success)';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // ================= TẢI DỮ LIỆU TỪ API =================
        async function loadData() {
            try {
                const res = await fetch('../actions/api_doanh_thu.php?action=fetch');
                const json = await res.json();
                if(json.success) {
                    allData = json.data;
                    
                    // Cập nhật Top Cards
                    document.getElementById('card_thu').textContent = fmtMoney(json.summary.thu);
                    document.getElementById('card_chi').textContent = fmtMoney(json.summary.chi);
                    document.getElementById('card_loinhuan').textContent = fmtMoney(json.summary.loi_nhuan);
                    document.getElementById('card_loinhuan').style.color = json.summary.loi_nhuan < 0 ? 'var(--danger)' : 'var(--purple)';

                    applyFilters();
                }
            } catch (err) {
                console.error(err); showToast('Lỗi tải dữ liệu', true);
            }
        }

        // ================= BỘ LỌC VÀ TÌM KIẾM =================
        function setFilter(type, btn) {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentFilter = type;
            applyFilters();
        }

        function debounceSearch() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => { applyFilters(); }, 300);
        }

        function applyFilters() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            filteredData = allData.filter(item => {
                const matchType = currentFilter === 'ALL' || item.type === currentFilter;
                const matchSearch = item.code.toLowerCase().includes(query) || item.person.toLowerCase().includes(query) || item.category.toLowerCase().includes(query);
                return matchType && matchSearch;
            });
            currentPage = 1;
            renderTable();
        }

        // ================= RENDER BẢNG & PHÂN TRANG =================
        function renderTable() {
            const total = filteredData.length;
            document.getElementById('totalRecords').textContent = total;
            const maxPage = Math.max(1, Math.ceil(total / PER_PAGE));
            
            const start = (currentPage - 1) * PER_PAGE;
            const pageData = filteredData.slice(start, start + PER_PAGE);

            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = pageData.map(r => {
                const valColor = r.type === 'THU' ? 'color: var(--primary)' : 'color: var(--danger)';
                const badgeStyle = r.type === 'THU' ? 'background:rgba(16, 185, 129, 0.1); color:var(--success); border:1px solid rgba(16, 185, 129, 0.2)' : 'background:rgba(239, 68, 68, 0.1); color:var(--danger); border:1px solid rgba(239, 68, 68, 0.2)';
                const typeText = r.type === 'THU' ? 'Phiếu Thu' : 'Phiếu Chi';
                
                // Hiện Icon Ổ khóa nếu là dòng Hệ thống tự sinh
                const authIcon = r.is_sys ? `<span title="Hệ thống tự động" style="color:var(--text-muted)"><i class="fa-solid fa-lock"></i> Auto</span>` : `<span title="Chỉnh sửa thủ công" style="color:#60a5fa"><i class="fa-solid fa-user-pen"></i> User</span>`;

                return `<tr>
                    <td class="col-id">${r.code}</td>
                    <td style="color:var(--text-muted); font-size:13px">${fmtDate(r.date)}</td>
                    <td style="font-weight:500">${r.category}</td>
                    <td>${r.person || 'Khách vãng lai'}</td>
                    <td style="font-weight:700; ${valColor}">${r.type === 'THU'?'+':'-'}${fmtMoney(r.amount)}</td>
                    <td><span class="status-badge" style="${badgeStyle}">${typeText}</span></td>
                    <td>${authIcon}</td>
                </tr>`;
            }).join('');

            if(total === 0) tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; padding: 40px; color:var(--text-muted)">Không tìm thấy giao dịch nào</td></tr>`;

            // Vẽ nút phân trang
            let pgHtml = `<button class="p-btn" onclick="changePage(${currentPage-1})"><i class="fa-solid fa-angle-left"></i></button>`;
            for(let i=1; i<=maxPage; i++) {
                pgHtml += `<button class="p-btn ${i===currentPage ? 'active':''}" onclick="changePage(${i})">${i}</button>`;
            }
            pgHtml += `<button class="p-btn" onclick="changePage(${currentPage+1})"><i class="fa-solid fa-angle-right"></i></button>`;
            document.getElementById('paginationControls').innerHTML = pgHtml;
        }

        function changePage(p) {
            const maxPage = Math.max(1, Math.ceil(filteredData.length / PER_PAGE));
            if(p >= 1 && p <= maxPage) { currentPage = p; renderTable(); }
        }

        // ================= XỬ LÝ FORM POPUP =================
        function openModal(type) {
            document.getElementById('transType').value = type;
            document.getElementById('modalTitle').innerHTML = type === 'THU' 
                ? '<i class="fa-solid fa-arrow-down" style="color:var(--primary)"></i> Tạo phiếu thu mới' 
                : '<i class="fa-solid fa-arrow-up" style="color:var(--danger)"></i> Tạo phiếu chi mới';
            
            // Reset input
            ['transCat', 'transAmt', 'transPerson', 'transNote'].forEach(id => document.getElementById(id).value = '');
            document.getElementById('transModal').classList.add('show');
        }

        function closeModal() { document.getElementById('transModal').classList.remove('show'); }

        async function submitTransaction() {
            const type = document.getElementById('transType').value;
            const category = document.getElementById('transCat').value;
            const amount = document.getElementById('transAmt').value;
            const person = document.getElementById('transPerson').value;
            const note = document.getElementById('transNote').value;

            if(!category || !amount || amount <= 0) return showToast('Vui lòng nhập đủ danh mục và số tiền hợp lệ', true);

            const btn = document.getElementById('btnSubmitForm');
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang xử lý...';
            btn.disabled = true;

            const fd = new FormData();
            fd.append('action', 'add_manual');
            fd.append('type', type);
            fd.append('category', category);
            fd.append('amount', amount);
            fd.append('person', person);
            fd.append('note', note);

            try {
                const res = await fetch('../actions/api_doanh_thu.php', { method: 'POST', body: fd});
                const json = await res.json();
                if(json.success) {
                    showToast(json.message);
                    closeModal();
                    loadData(); // Tải lại toàn bộ bảng và top cards
                } else {
                    showToast(json.message, true);
                }
            } catch (err) {
                showToast('Lỗi mạng', true);
            }
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Xác nhận lưu';
            btn.disabled = false;
        }

        // Khởi chạy dữ liệu
        loadData();

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

        fetch('../Components/header.php')
            .then(response => response.text())
            .then(data => document.getElementById('header-placeholder').innerHTML = data);

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
                bindAdminThemeToggle();
            });
    </script>
</body>
</html>
