<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Quáº£n lÃ½ há»™i viÃªn</title>
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
            --warning: #f97316;
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

        /* Active Nav Item - Quáº£n lÃ½ há»™i viÃªn */
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
        /* ÄÃ£ Ä‘Æ°á»£c sá»­a láº¡i giá»‘ng há»‡t file DoanhThu.php */
        .main-content { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            overflow: hidden; /* KhÃ³a cuá»™n á»Ÿ Ä‘Ã¢y Ä‘á»ƒ Header Ä‘á»©ng im */
        }

        .page-content {
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            overflow-y: auto; /* Chá»‰ pháº§n nÃ y Ä‘Æ°á»£c phÃ©p cuá»™n */
            padding: 24px 40px;
        }

        /* ================= PAGE TITLE & EXPORT (Kiá»ƒu giá»‘ng Doanh Thu) ================= */
        .page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; }
        .page-title h1 { font-size: 28px; font-weight: 700; margin-bottom: 5px; }
        .page-title p { color: var(--text-muted); font-size: 14px; }
        
        .page-actions { display: flex; gap: 12px; align-items: center; }
        .btn-date-filter {
            display: flex; align-items: center; gap: 8px; 
            background: var(--bg-panel); border: 1px solid var(--border-color);
            color: var(--text-muted); padding: 10px 16px; border-radius: 10px; 
            font-size: 13px; font-weight: 500; cursor: pointer; transition: 0.3s;
        }
        .btn-date-filter:hover { background: var(--bg-input); color: white; }
        
        .btn-primary {
            display: flex; align-items: center; gap: 8px; 
            background: var(--gradient-btn); border: none;
            color: white; padding: 10px 20px; border-radius: 10px; 
            font-size: 14px; font-weight: 600; cursor: pointer; 
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.25); transition: 0.3s;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }

        /* ================= MEMBER STATS GRID ================= */
        .member-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px; flex-shrink: 0; }
        .stat-card-m {
            background: var(--bg-panel); border: 1px solid var(--border-color); border-radius: 16px;
            padding: 24px; display: flex; flex-direction: column; justify-content: space-between; position: relative;
        }
        .stat-card-m .top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .stat-card-m .title { font-size: 13px; color: var(--text-muted); font-weight: 500; }
        .stat-card-m .icon-s { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; }
        
        .stat-card-m.blue .icon-s { background: rgba(59, 130, 246, 0.1); color: var(--primary); }
        .stat-card-m.purple .icon-s { background: rgba(139, 92, 246, 0.1); color: var(--purple); }
        .stat-card-m.warning .icon-s { background: rgba(249, 115, 22, 0.1); color: var(--warning); }
        
        .stat-card-m .value { font-size: 28px; font-weight: 700; margin-bottom: 4px; }
        .stat-card-m .desc { font-size: 12px; color: var(--text-muted); }
        .stat-card-m .desc.blue-text { color: var(--primary); }
        .stat-card-m .desc.warning-text { color: var(--warning); font-weight: 500;}

        /* ================= DATA TABLE AREA ================= */
        .table-panel {
            background: var(--bg-panel); border: 1px solid var(--border-color); border-radius: 16px; padding: 20px; flex: 1; display: flex; flex-direction: column; min-height: 0;
        }

        /* Tabs & Controls */
        .table-header-controls {
            display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 15px;
        }
        .tabs { display: flex; gap: 24px; }
        .tab { color: var(--text-muted); font-size: 14px; font-weight: 500; cursor: pointer; padding-bottom: 15px; margin-bottom: -16px; position: relative; }
        .tab.active { color: white; border-bottom: 2px solid var(--purple); }

        .filters { display: flex; gap: 10px; }
        .btn-filter {
            background: transparent; border: 1px solid var(--border-color); color: var(--text-muted);
            padding: 8px 12px; border-radius: 6px; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px;
        }

        /* Table Styles */
        .table-wrapper { flex: 1; overflow-y: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th { text-align: left; padding: 12px 16px; color: var(--text-muted); font-size: 11px; text-transform: uppercase; font-weight: 600; border-bottom: 1px solid var(--border-color); position: sticky; top: 0; background: var(--bg-panel); z-index: 1;}
        td { padding: 16px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; }
        
        tr:hover td { background: rgba(255,255,255,0.02); }

        /* User Info Column */
        .user-col { display: flex; align-items: center; gap: 12px; }
        .user-col .avatar { width: 32px; height: 32px; border-radius: 50%; background: #334155; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; }
        .user-col .avatar.purple { background: rgba(139, 92, 246, 0.2); color: #c4b5fd; }
        
        .code-col { color: var(--text-muted); font-family: monospace; font-size: 13px; }
        
        /* Badges */
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; display: inline-block; }
        .badge.active { background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }
        .badge.warning { background: rgba(249, 115, 22, 0.1); color: #fb923c; border: 1px solid rgba(249, 115, 22, 0.2); }

        /* Actions */
        .action-btns { display: flex; gap: 12px; color: var(--text-muted); }
        .action-btns i { cursor: pointer; transition: 0.2s; }
        .action-btns i:hover { color: white; }

        /* Warning Row Highlight */
        tr.row-warning td { background: rgba(249, 115, 22, 0.02); }
        tr.row-warning td.date-col { color: var(--warning); font-weight: 500; }

        /* Pagination */
        .pagination-area { display: flex; justify-content: space-between; align-items: center; padding-top: 20px; border-top: 1px solid var(--border-color); margin-top: auto; }
        .page-info { font-size: 13px; color: var(--text-muted); display: flex; align-items: center; gap: 8px; }
        .page-info select { background: var(--bg-input); border: 1px solid var(--border-color); color: white; padding: 4px 8px; border-radius: 4px; outline: none; }
        
        .pagination { display: flex; gap: 6px; align-items: center; }
        .page-btn {
            width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
            border-radius: 6px; border: 1px solid transparent; color: var(--text-muted); font-size: 13px; cursor: pointer;
        }
        .page-btn:hover { background: var(--bg-input); }
        .page-btn.active { background: var(--purple); color: white; font-weight: 600; }
        .page-text { font-size: 13px; color: var(--text-muted); margin: 0 8px; cursor: pointer; }

    </style>
</head>
<body>

    <div id="sidebar-placeholder"></div>

    <main class="main-content">
        
        <div id="header-placeholder"></div>

        <div class="page-content">
            
            <div class="page-header">
                <div class="page-title">
                    <h1>Quáº£n lÃ½ há»™i viÃªn</h1>
                    <p>Quáº£n lÃ½ thÃ´ng tin chi tiáº¿t vÃ  tráº¡ng thÃ¡i Ä‘Äƒng kÃ½ cá»§a há»™i viÃªn.</p>
                </div>
                <div class="page-actions">
                    <button class="btn-date-filter">
                        <i class="fa-regular fa-calendar"></i> ThÃ¡ng nÃ y 
                        <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 4px;"></i>
                    </button>
                    <button class="btn-primary">
                        <i class="fa-solid fa-download"></i> Táº£i BÃ¡o CÃ¡o
                    </button>
                </div>
            </div>

            <div class="member-stats">
                <div class="stat-card-m blue">
                    <div class="top">
                        <span class="title">Tá»•ng Há»™i ViÃªn</span>
                        <div class="icon-s"><i class="fa-solid fa-users"></i></div>
                    </div>
                    <div class="value">1,284</div>
                    <div class="desc blue-text"><i class="fa-solid fa-arrow-trend-up"></i> +12% thÃ¡ng nÃ y</div>
                </div>
                
                <div class="stat-card-m purple">
                    <div class="top">
                        <span class="title">GÃ³i Táº­p Hoáº¡t Äá»™ng</span>
                        <div class="icon-s"><i class="fa-solid fa-shield-halved"></i></div>
                    </div>
                    <div class="value">1,102</div>
                    <div class="desc blue-text"><i class="fa-solid fa-arrow-trend-up"></i> +5% so vá»›i tuáº§n trÆ°á»›c</div>
                </div>

                <div class="stat-card-m warning">
                    <div class="top">
                        <span class="title">Sáº¯p Háº¿t Háº¡n</span>
                        <div class="icon-s"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    </div>
                    <div class="value">45</div>
                    <div class="desc warning-text">Cáº§n gia háº¡n ngay</div>
                </div>
            </div>

            <div class="table-panel">
                
                <div class="table-header-controls">
                    <div class="tabs">
                        <div class="tab active">Táº¥t cáº£</div>
                        <div class="tab">Äang hoáº¡t Ä‘á»™ng</div>
                        <div class="tab">Sáº¯p háº¿t háº¡n</div>
                        <div class="tab">ÄÃ£ háº¿t háº¡n</div>
                        <div class="tab">Báº£o lÆ°u</div>
                        <div class="tab">Táº¡m dá»«ng</div>
                    </div>
                    <div class="filters">
                        <button class="btn-filter"><i class="fa-solid fa-filter"></i> Lá»c</button>
                        <button class="btn-filter"><i class="fa-solid fa-sort"></i> Sáº¯p xáº¿p</button>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>TÃªn há»™i viÃªn</th>
                                <th>MÃ£ ID</th>
                                <th>GÃ³i táº­p</th>
                                <th>NgÃ y háº¿t háº¡n</th>
                                <th>Tráº¡ng thÃ¡i</th>
                                <th>Thao tÃ¡c</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="user-col">
                                        <div class="avatar purple">C</div>
                                        <span>Customer</span>
                                    </div>
                                </td>
                                <td class="code-col">#FF-2023-001</td>
                                <td>Premium Annual</td>
                                <td>12/12/2024</td>
                                <td><span class="badge active">Hoáº¡t Ä‘á»™ng</span></td>
                                <td>
                                    <div class="action-btns"><i class="fa-regular fa-eye"></i> <i class="fa-solid fa-pen"></i></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="user-col">
                                        <div class="avatar purple">C</div>
                                        <span>Customer</span>
                                    </div>
                                </td>
                                <td class="code-col">#FF-2023-001</td>
                                <td>Premium Annual</td>
                                <td>12/12/2024</td>
                                <td><span class="badge active">Hoáº¡t Ä‘á»™ng</span></td>
                                <td>
                                    <div class="action-btns"><i class="fa-regular fa-eye"></i> <i class="fa-solid fa-pen"></i></div>
                                </td>
                            </tr>
                            
                            <tr class="row-warning">
                                <td>
                                    <div class="user-col">
                                        <div class="avatar" style="background: rgba(249, 115, 22, 0.2); color: #fb923c;">C</div>
                                        <span>Customer</span>
                                    </div>
                                </td>
                                <td class="code-col">#FF-2023-142</td>
                                <td>Monthly Standard</td>
                                <td class="date-col">28/10/2023</td>
                                <td><span class="badge warning">Sáº¯p háº¿t háº¡n</span></td>
                                <td>
                                    <div class="action-btns"><i class="fa-regular fa-eye"></i> <i class="fa-solid fa-pen"></i></div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="user-col">
                                        <div class="avatar purple">C</div>
                                        <span>Customer</span>
                                    </div>
                                </td>
                                <td class="code-col">#FF-2023-001</td>
                                <td>Premium Annual</td>
                                <td>12/12/2024</td>
                                <td><span class="badge active">Hoáº¡t Ä‘á»™ng</span></td>
                                <td>
                                    <div class="action-btns"><i class="fa-regular fa-eye"></i> <i class="fa-solid fa-pen"></i></div>
                                </td>
                            </tr>

                            <tr class="row-warning">
                                <td>
                                    <div class="user-col">
                                        <div class="avatar" style="background: rgba(249, 115, 22, 0.2); color: #fb923c;">C</div>
                                        <span>Customer</span>
                                    </div>
                                </td>
                                <td class="code-col">#FF-2023-142</td>
                                <td>Monthly Standard</td>
                                <td class="date-col">28/10/2023</td>
                                <td><span class="badge warning">Sáº¯p háº¿t háº¡n</span></td>
                                <td>
                                    <div class="action-btns"><i class="fa-regular fa-eye"></i> <i class="fa-solid fa-pen"></i></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pagination-area">
                    <div class="page-info">
                        Hiá»ƒn thá»‹ 
                        <select><option>5</option><option>10</option><option>20</option></select>
                    </div>
                    <div class="pagination">
                        <span class="page-text">TrÆ°á»›c</span>
                        <div class="page-btn active">1</div>
                        <div class="page-btn">2</div>
                        <div class="page-btn">3</div>
                        <span class="page-text">Sau</span>
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
