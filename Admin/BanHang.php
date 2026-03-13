<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="vi" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quản lý bán hàng – GymPro</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
    --input-text: #ffffff;
    /* Alias untuk kompatibilitas */
    --border: rgba(255, 255, 255, 0.08);
    --text: #ffffff;
    --muted: #94a3b8;
    --bg-body: #121521;
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
    --warning: #ea580c;
    --danger: #dc2626;
    --success: #059669;
    --gradient-btn: linear-gradient(90deg, #2563eb, #7c3aed);
    --input-text: #0f172a;
    /* Alias untuk kompatibilitas */
    --border: rgba(15, 23, 42, 0.12);
    --text: #0f172a;
    --muted: #64748b;
    --bg-body: #f1f5f9;
}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',system-ui,sans-serif;background:var(--bg-body);color:var(--text);display:flex;height:100vh;overflow:hidden}

/* ── SIDEBAR ── */

 .sidebar {
            width: 260px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            flex-shrink: 0;
        }

/* ── LAYOUT ── */
.main-content{display:flex;flex:1;overflow:hidden;flex-direction:column}

/* ── HEADER ── */
.top-header{display:flex;justify-content:space-between;align-items:center;padding:0 32px;height:72px;flex-shrink:0;background:var(--bg-panel);border-bottom:1px solid var(--border)}
.search-box{position:relative;width:320px}
.search-box i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:13px}
.search-box input{width:100%;background:var(--bg-input);border:1px solid var(--border);padding:10px 14px 10px 38px;border-radius:10px;color:var(--input-text);outline:none;font-size:13px}
.search-box input::placeholder{color:var(--muted)}
.header-actions{display:flex;align-items:center;gap:12px}
.icon-btn{width:38px;height:38px;border-radius:10px;background:var(--bg-dark);border:1px solid var(--border);color:var(--muted);display:flex;align-items:center;justify-content:center;cursor:pointer}
.btn-scan{display:flex;align-items:center;gap:7px;background:var(--bg-dark);border:1px solid var(--border);color:var(--muted);padding:9px 14px;border-radius:10px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;white-space:nowrap}
.btn-add{display:flex;align-items:center;gap:7px;background:var(--primary);border:none;color:#fff;padding:9px 18px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;white-space:nowrap}

/* ── PAGE CONTENT ── */
.page-content{flex:1;overflow-y:auto;padding:24px 40px}
.page-title{font-size:22px;font-weight:700;margin-bottom:3px}
.page-subtitle{font-size:13px;color:var(--muted);margin-bottom:22px}

/* ── TOOLBAR ── */
.toolbar{display:flex;align-items:center;gap:10px;margin-bottom:20px;flex-wrap:wrap}
.tb-search{position:relative;flex:1;min-width:180px}
.tb-search i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:12px}
.tb-search input{width:100%;background:var(--bg-input);border:1px solid var(--border);color:var(--input-text);padding:10px 13px 10px 36px;border-radius:10px;font-size:13px;outline:none}
.tb-search input::placeholder{color:var(--muted)}
.tab-group{display:flex;gap:7px;flex-wrap:wrap}
.tab-btn{padding:9px 16px;border-radius:10px;border:1px solid var(--border);background:var(--bg-dark);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;white-space:nowrap;transition:.15s}
.tab-btn:hover{color:var(--text)}
.tab-btn.active{background:var(--primary);border-color:var(--primary);color:#fff}
.btn-export{display:flex;align-items:center;gap:7px;background:var(--bg-dark);border:1px solid var(--border);color:var(--muted);padding:9px 14px;border-radius:10px;font-size:13px;font-weight:500;cursor:pointer;white-space:nowrap}
.btn-import{display:flex;align-items:center;gap:7px;background:var(--bg-dark);border:1px solid var(--border);color:var(--muted);padding:9px 14px;border-radius:10px;font-size:13px;font-weight:500;cursor:pointer;white-space:nowrap}
.btn-sell-now{display:flex;align-items:center;gap:7px;background:var(--primary);border:none;color:#fff;padding:9px 18px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap}

/* ── TABLE ── */
.table-wrap{background:var(--bg-panel);border:1px solid var(--border);border-radius:16px;overflow:hidden}
table{width:100%;border-collapse:collapse}
thead tr{border-bottom:1px solid var(--border)}
thead th{padding:13px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.5px}
tbody tr{border-bottom:1px solid var(--border);transition:background .15s}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:rgba(255,255,255,.025)}
tbody td{padding:13px 16px;font-size:13.5px;vertical-align:middle}

.prod-thumb{width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#1a2236,#253047);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:15px;flex-shrink:0}
.prod-name{font-weight:600;font-size:13.5px}
.prod-cat{font-size:11.5px;color:var(--muted);margin-top:2px}
.ma-hang{font-family:monospace;font-size:11.5px;color:var(--blue);background:rgba(59,130,246,.12);padding:3px 8px;border-radius:6px;border:1px solid rgba(59,130,246,.2)}

.stock-wrap{display:flex;align-items:center;gap:10px}
.stock-bar-bg{flex:1;height:5px;border-radius:999px;background:rgba(255,255,255,.06);overflow:hidden;min-width:60px}
.stock-bar{height:100%;border-radius:999px}
.stock-num{font-size:13px;font-weight:700;min-width:28px;text-align:right}
.stock-empty{display:flex;align-items:center;gap:5px;color:var(--red);font-size:12.5px;font-weight:600}

.action-btns{display:flex;gap:7px}
.act-btn{width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:var(--bg-dark);color:var(--muted);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:.15s;font-size:12px}
.act-btn:hover{border-color:var(--primary);color:var(--text)}
.act-btn.del:hover{border-color:var(--red);color:var(--red)}
.act-btn.sell:hover{border-color:var(--green);color:var(--green)}

/* ── PAGINATION ── */
.pagination{display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-top:1px solid var(--border);font-size:13px;color:var(--muted)}
.page-btns{display:flex;gap:5px}
.pg-btn{width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:var(--bg-dark);color:var(--muted);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:13px;transition:.15s}
.pg-btn:hover,.pg-btn.active{background:var(--primary);border-color:var(--primary);color:#fff}

/* ── POPUP OVERLAY ── */
.popup-overlay{position:fixed;inset:0;background:rgba(6,8,15,.75);backdrop-filter:blur(4px);z-index:3000;display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;visibility:hidden;pointer-events:none;transition:.2s ease}
.popup-overlay.show{opacity:1;visibility:visible;pointer-events:auto}
.popup-card{background:var(--bg-panel);border:1px solid var(--border);border-radius:16px;padding:22px;position:relative;width:min(92vw,430px)}
.popup-close{position:absolute;top:12px;right:12px;width:30px;height:30px;border-radius:8px;border:1px solid var(--border);background:var(--bg-dark);color:var(--muted);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:13px}
.popup-close:hover{color:var(--text)}
.popup-title{font-size:16px;font-weight:700;margin-bottom:4px}
.popup-sub{font-size:13px;color:var(--muted);margin-bottom:18px}

/* ── FORM ── */
.form-group{margin-bottom:14px}
.form-group label{display:block;font-size:12.5px;color:var(--muted);font-weight:500;margin-bottom:6px}
.form-group input,.form-group select{width:100%;background:var(--bg-input);border:1px solid var(--border);color:var(--input-text);padding:10px 12px;border-radius:10px;font-size:13.5px;outline:none;transition:.15s}
.form-group input:focus,.form-group select:focus{border-color:var(--primary)}
.form-group select option{background:var(--bg-panel)}
.sel-ico{position:relative}.sel-ico i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:12px;pointer-events:none}
.sel-ico select{padding-left:34px}

/* ── PRODUCT PREVIEW ── */
.prod-preview{display:flex;gap:14px;align-items:center;background:var(--bg-input);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:14px}
.preview-img{width:60px;height:60px;border-radius:10px;background:linear-gradient(135deg,#1a2236,#253047);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:20px;flex-shrink:0}
.preview-name{font-weight:600;font-size:14.5px}
.preview-price{font-size:16px;font-weight:700;color:var(--primary);margin-top:4px}

/* ── QTY ── */
.qty-row{display:flex;align-items:center;gap:10px}
.qty-btn{width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:var(--bg-dark);color:var(--text);font-size:15px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:.15s}
.qty-btn:hover{background:var(--primary);border-color:var(--primary)}
.qty-inp{width:60px;text-align:center;background:var(--bg-input);border:1px solid var(--border);color:var(--input-text);padding:7px 6px;border-radius:8px;font-size:15px;font-weight:700;outline:none}

/* ── TOTAL ── */
.divider{height:1px;background:var(--border);margin:14px 0}
.total-row{display:flex;justify-content:space-between;align-items:center;font-size:13.5px;color:var(--muted);margin-bottom:14px}
.total-row strong{color:var(--text);font-size:19px;font-weight:700}

/* ── BUTTONS ── */
.btn-confirm{width:100%;background:var(--primary);border:none;color:#fff;padding:13px;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:9px;transition:.15s}
.btn-confirm:hover{filter:brightness(1.1)}
.btn-cancel-f{width:100%;background:transparent;border:1px solid var(--border);color:var(--muted);padding:10px;border-radius:10px;font-size:13.5px;cursor:pointer;transition:.15s}
.btn-cancel-f:hover{border-color:var(--muted);color:var(--text)}

/* ── TOAST ── */
.toast{position:fixed;bottom:28px;right:28px;background:var(--bg-panel);border:1px solid var(--border);border-left:3px solid var(--green);border-radius:10px;padding:13px 18px;font-size:13.5px;display:flex;align-items:center;gap:10px;z-index:9000;opacity:0;transform:translateY(8px);transition:.25s ease;pointer-events:none}
.toast.show{opacity:1;transform:translateY(0)}
.toast i{color:var(--green)}

/* scrollbar */
.page-content::-webkit-scrollbar{width:4px}
.page-content::-webkit-scrollbar-thumb{background:#334155;border-radius:10px}
</style>
</head>
<body>

    <div id="sidebar-placeholder"></div>

    <main class="main-content">
        
        <div id="header-placeholder"></div>
        <div class="page-content">
        <div class="page-title">QUẢN LÝ BÁN HÀNG</div>
        <div class="page-subtitle">Quản lý danh mục sản phẩm và theo dõi doanh số bán hàng</div>

        <!-- TOOLBAR -->
        <div class="toolbar">
            <div class="tb-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInp" placeholder="Tìm kiếm sản phẩm..." oninput="doFilter()">
            </div>
            <div class="tab-group">
                <button class="tab-btn active" onclick="setTab(this,'all')">Tất cả</button>
                <button class="tab-btn" onclick="setTab(this,'Thực phẩm bổ sung')">Thực phẩm bổ sung</button>
                <button class="tab-btn" onclick="setTab(this,'Nước giải khát')">Nước giải khát</button>
                <button class="tab-btn" onclick="setTab(this,'Phụ kiện')">Phụ kiện</button>
            </div>
            <button class="btn-export" onclick="toast('Đã xuất file Excel!')"><i class="fa-solid fa-file-arrow-up"></i> Xuất Dữ liệu</button>
            <button class="btn-import" onclick="openImport()"><i class="fa-solid fa-boxes-stacked"></i> Nhập hàng</button>
            <button class="btn-sell-now" onclick="openSell(null)"><i class="fa-solid fa-cash-register"></i> Bán ngay</button>
        </div>

        <!-- TABLE -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:56px">Ảnh</th>
                        <th>Tên hàng</th>
                        <th>Mã hàng</th>
                        <th>Giá bán</th>
                        <th>Tồn kho</th>
                        <th style="width:120px">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
            <div class="pagination">
                <span id="pgInfo"></span>
                <div class="page-btns" id="pgBtns"></div>
            </div>
        </div>
    </main>

<!-- ══════════ POPUP BÁN HÀNG ══════════ -->
<div class="popup-overlay" id="sellOverlay">
    <div class="popup-card">
        <button class="popup-close" onclick="closeSell()"><i class="fa-solid fa-xmark"></i></button>
        <div class="popup-title">Bán hàng nhanh</div>
        <div class="popup-sub">Tạo đơn hàng nhanh cho hội viên</div>

        <div class="form-group">
            <label>Tên khách hàng</label>
            <input id="sc_cust" type="text" placeholder="Nhập tên hoặc tìm hội viên...">
        </div>
        <div class="form-group">
            <label>Chọn sản phẩm / Dịch vụ</label>
            <div class="sel-ico">
                <i class="fa-solid fa-box"></i>
                <select id="sc_prod" onchange="onProdSel()">
                    <option value="">-- Chọn sản phẩm --</option>
                </select>
            </div>
        </div>

        <div class="prod-preview" id="sc_preview" style="display:none">
            <div class="preview-img"><i class="fa-solid fa-box"></i></div>
            <div>
                <div class="preview-name" id="sc_name">–</div>
                <div class="preview-price" id="sc_price">0đ</div>
            </div>
        </div>

        <div class="form-group" id="sc_qtyGroup" style="display:none">
            <label>Số lượng</label>
            <div class="qty-row">
                <button class="qty-btn" onclick="chgQty(-1)"><i class="fa-solid fa-minus"></i></button>
                <input class="qty-inp" id="sc_qty" type="number" value="1" min="1" oninput="updTotal()">
                <button class="qty-btn" onclick="chgQty(1)"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>

        <div class="divider"></div>
        <div class="total-row">
            <span>Thành tiền</span>
            <strong id="sc_total">0đ</strong>
        </div>

        <div class="form-group">
            <div class="sel-ico">
                <i class="fa-solid fa-circle-plus" style="color:var(--primary)"></i>
                <select id="sc_prod2" onchange="onProd2Sel()">
                    <option value="">+ Thêm sản phẩm khác</option>
                </select>
            </div>
        </div>

        <button class="btn-confirm" onclick="confirmSell()"><i class="fa-solid fa-print"></i> Xác nhận và in hóa đơn</button>
        <button class="btn-cancel-f" onclick="closeSell()">Hủy bỏ</button>
    </div>
</div>

<!-- ══════════ POPUP NHẬP HÀNG ══════════ -->
<div class="popup-overlay" id="importOverlay">
    <div class="popup-card">
        <button class="popup-close" onclick="closeImport()"><i class="fa-solid fa-xmark"></i></button>
        <div class="popup-title">Nhập hàng vào kho</div>
        <div class="popup-sub">Cập nhật số lượng tồn kho cho sản phẩm</div>
        <div class="form-group">
            <label>Chọn sản phẩm</label>
            <select id="imp_prod"><option value="">-- Chọn sản phẩm --</option></select>
        </div>
        <div class="form-group">
            <label>Số lượng nhập</label>
            <input id="imp_qty" type="number" value="10" min="1" placeholder="Nhập số lượng...">
        </div>
        <div class="form-group">
            <label>Ghi chú</label>
            <input id="imp_note" type="text" placeholder="Nhà cung cấp, số lô...">
        </div>
        <button class="btn-confirm" onclick="confirmImport()"><i class="fa-solid fa-boxes-stacked"></i> Xác nhận nhập kho</button>
        <button class="btn-cancel-f" onclick="closeImport()">Hủy bỏ</button>
    </div>
</div>

<!-- TOAST -->
<div class="toast" id="toastEl"><i class="fa-solid fa-circle-check"></i><span id="toastMsg"></span></div>

<script>
// ── DATA ──
const PRODUCTS = [
    {id:1, name:'Whey Gold Standard (5lbs)',     code:'WHY-001', price:1850000, stock:24,  cat:'Thực phẩm bổ sung'},
    {id:2, name:'Nước khoáng Lavie (500ml)',      code:'WAT-002', price:10000,   stock:0,   cat:'Nước giải khát'},
    {id:3, name:'Thanh năng lượng Mars Protein',  code:'BAR-003', price:65000,   stock:42,  cat:'Thực phẩm bổ sung'},
    {id:4, name:'C4 Pre-Workout Original',        code:'PRE-004', price:860000,  stock:72,  cat:'Thực phẩm bổ sung'},
    {id:5, name:'Nước suối Aqua',                 code:'WAT-005', price:5000,    stock:120, cat:'Nước giải khát'},
    {id:6, name:'BCAA 2:1:1 Optimum',             code:'BCA-006', price:650000,  stock:18,  cat:'Thực phẩm bổ sung'},
    {id:7, name:'Găng tay tập gym',               code:'ACC-007', price:120000,  stock:35,  cat:'Phụ kiện'},
    {id:8, name:'Dây kháng lực tập luyện',        code:'ACC-008', price:85000,   stock:50,  cat:'Phụ kiện'},
];

// ── PAGINATION ──
const PER_PAGE = 10;
let currentPage = 1;
let currentTab  = 'all';
let searchQ     = '';

function filteredData(){
    return PRODUCTS.filter(p=>{
        const matchTab = currentTab==='all' || p.cat===currentTab;
        const matchQ   = p.name.toLowerCase().includes(searchQ) || p.code.toLowerCase().includes(searchQ);
        return matchTab && matchQ;
    });
}

function renderTable(){
    const data = filteredData();
    const totalPages = Math.max(1, Math.ceil(data.length/PER_PAGE));
    if(currentPage > totalPages) currentPage = totalPages;
    const slice = data.slice((currentPage-1)*PER_PAGE, currentPage*PER_PAGE);

    const tbody = document.getElementById('tbody');
    tbody.innerHTML = slice.map(p=>{
        const maxS = 150;
        const pct  = Math.min(100,(p.stock/maxS)*100);
        const col  = p.stock===0?'var(--red)':p.stock<10?'var(--orange)':p.stock<30?'var(--yellow)':'var(--green)';
        const stockCell = p.stock===0
            ? `<span class="stock-empty"><i class="fa-solid fa-circle-exclamation"></i>0 (Hết hàng)</span>`
            : `<div class="stock-wrap">
                 <div class="stock-bar-bg"><div class="stock-bar" style="width:${pct}%;background:${col}"></div></div>
                 <span class="stock-num" style="color:${col}">${p.stock}</span>
               </div>`;
        return `<tr>
            <td><div class="prod-thumb"><i class="fa-solid fa-box"></i></div></td>
            <td><div class="prod-name">${p.name}</div><div class="prod-cat">${p.cat}</div></td>
            <td><span class="ma-hang">${p.code}</span></td>
            <td style="font-weight:600">${fmt(p.price)}</td>
            <td>${stockCell}</td>
            <td>
                <div class="action-btns">
                    <button class="act-btn sell" title="Bán ngay" onclick='openSell(${JSON.stringify(p)})'><i class="fa-solid fa-cart-plus"></i></button>
                    <button class="act-btn" title="Chỉnh sửa"><i class="fa-solid fa-pen"></i></button>
                    <button class="act-btn del" title="Xóa" onclick="delRow(${p.id})"><i class="fa-solid fa-trash"></i></button>
                </div>
            </td>
        </tr>`;
    }).join('');

    // pagination info
    const start = data.length===0?0:(currentPage-1)*PER_PAGE+1;
    const end   = Math.min(currentPage*PER_PAGE, data.length);
    document.getElementById('pgInfo').textContent = `Hiển thị ${start}–${end} trong số ${data.length} sản phẩm`;

    // page buttons
    const pgBtns = document.getElementById('pgBtns');
    let html = `<button class="pg-btn" onclick="goPage(${currentPage-1})"><i class="fa-solid fa-chevron-left"></i></button>`;
    for(let i=1;i<=totalPages;i++){
        html += `<button class="pg-btn${i===currentPage?' active':''}" onclick="goPage(${i})">${i}</button>`;
    }
    html += `<button class="pg-btn" onclick="goPage(${currentPage+1})"><i class="fa-solid fa-chevron-right"></i></button>`;
    pgBtns.innerHTML = html;
}

function goPage(p){
    const max = Math.max(1,Math.ceil(filteredData().length/PER_PAGE));
    if(p<1||p>max) return;
    currentPage=p; renderTable();
}

function setTab(btn, tab){
    document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    currentTab=tab; currentPage=1; renderTable();
}

function doFilter(){
    searchQ = document.getElementById('searchInp').value.toLowerCase();
    currentPage=1; renderTable();
}

function delRow(id){
    if(!confirm('Bạn có chắc muốn xóa sản phẩm này?')) return;
    const idx = PRODUCTS.findIndex(p=>p.id===id);
    if(idx>-1) PRODUCTS.splice(idx,1);
    renderTable();
    toast('Đã xóa sản phẩm!');
}

// ── SELL POPUP ──
let sellPrice  = 0;
let sellExtra  = 0;

function populateSellSelects(){
    const opts = PRODUCTS.map(p=>`<option value="${p.id}" data-price="${p.price}">${p.name} – ${fmt(p.price)}</option>`).join('');
    document.getElementById('sc_prod').innerHTML  = '<option value="">-- Chọn sản phẩm --</option>'+opts;
    document.getElementById('sc_prod2').innerHTML = '<option value="">+ Thêm sản phẩm khác</option>'+opts;
    document.getElementById('imp_prod').innerHTML = '<option value="">-- Chọn sản phẩm --</option>'+PRODUCTS.map(p=>`<option value="${p.id}">${p.name}</option>`).join('');
}

function openSell(prod){
    populateSellSelects();
    document.getElementById('sc_cust').value='';
    document.getElementById('sc_prod').value='';
    document.getElementById('sc_prod2').value='';
    document.getElementById('sc_preview').style.display='none';
    document.getElementById('sc_qtyGroup').style.display='none';
    document.getElementById('sc_qty').value=1;
    document.getElementById('sc_total').textContent='0đ';
    sellPrice=0; sellExtra=0;
    if(prod){
        document.getElementById('sc_prod').value=prod.id;
        onProdSel();
    }
    document.getElementById('sellOverlay').classList.add('show');
}
function closeSell(){ document.getElementById('sellOverlay').classList.remove('show'); }

function onProdSel(){
    const sel = document.getElementById('sc_prod');
    const opt = sel.options[sel.selectedIndex];
    if(!opt||!opt.value){ sellPrice=0; document.getElementById('sc_preview').style.display='none'; document.getElementById('sc_qtyGroup').style.display='none'; updTotal(); return; }
    const p = PRODUCTS.find(x=>x.id==opt.value);
    if(!p) return;
    sellPrice = p.price;
    document.getElementById('sc_name').textContent  = p.name;
    document.getElementById('sc_price').textContent = fmt(p.price);
    document.getElementById('sc_preview').style.display='flex';
    document.getElementById('sc_qtyGroup').style.display='block';
    updTotal();
}

function onProd2Sel(){
    const sel = document.getElementById('sc_prod2');
    const opt = sel.options[sel.selectedIndex];
    const p = opt&&opt.value ? PRODUCTS.find(x=>x.id==opt.value) : null;
    sellExtra = p ? p.price : 0;
    updTotal();
}

function chgQty(d){ const inp=document.getElementById('sc_qty'); inp.value=Math.max(1,(parseInt(inp.value)||1)+d); updTotal(); }
function updTotal(){ const q=parseInt(document.getElementById('sc_qty').value)||1; document.getElementById('sc_total').textContent=fmt(sellPrice*q+sellExtra); }
function confirmSell(){ closeSell(); toast('Đã xác nhận đơn hàng và in hóa đơn!'); }

// ── IMPORT POPUP ──
function openImport(){ populateSellSelects(); document.getElementById('importOverlay').classList.add('show'); }
function closeImport(){ document.getElementById('importOverlay').classList.remove('show'); }
function confirmImport(){ closeImport(); toast('Đã cập nhật tồn kho thành công!'); }

// ── TOAST ──
function toast(msg){
    const el=document.getElementById('toastEl');
    document.getElementById('toastMsg').textContent=msg;
    el.classList.add('show');
    setTimeout(()=>el.classList.remove('show'),3000);
}

// ── UTILS ──
function fmt(n){ return n.toLocaleString('vi-VN')+'đ'; }

// close overlays on outside click
['sellOverlay','importOverlay'].forEach(id=>{
    document.getElementById(id).addEventListener('click',function(e){ if(e.target===this) this.classList.remove('show'); });
});

// ── INIT ──
renderTable();

// ── LOAD HEADER & SIDEBAR ──
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

function initSidebarProfilePopup() {
    const _tr = document.getElementById('gymProfileTrigger');
    const _pp = document.getElementById('gymProfilePopup');
    const _ov = document.getElementById('gymProfileOverlay');
    const _cl = document.getElementById('gymProfileClose');
    if (_tr && _pp) {
        _tr.addEventListener('click', () => { _pp.classList.add('show'); _ov.classList.add('show'); });
        _cl.addEventListener('click', () => { _pp.classList.remove('show'); _ov.classList.remove('show'); });
        _ov.addEventListener('click', () => { _pp.classList.remove('show'); _ov.classList.remove('show'); });
    }
}

function bindAdminThemeToggle() {
    const _thm = document.getElementById('adminThemeToggle');
    if (_thm) {
        _thm.addEventListener('click', () => {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            document.documentElement.setAttribute('data-theme', isDark ? 'light' : 'dark');
            _thm.innerHTML = isDark ? '<i class="fa-solid fa-moon"></i> Chế độ tối' : '<i class="fa-solid fa-sun"></i> Chế độ sáng';
        });
    }
}
</script>
</body>
</html>
