<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$chuGymId = isset($_SESSION['chu_gym_id']) ? (int) $_SESSION['chu_gym_id'] : 0;
$tenPhong = isset($_SESSION['chu_gym_ten_phong']) ? (string) $_SESSION['chu_gym_ten_phong'] : 'GymPro';
$hoTenChu = isset($_SESSION['chu_gym_ho_ten']) ? (string) $_SESSION['chu_gym_ho_ten'] : 'Alex Johnson';
$emailChuGym = isset($_SESSION['chu_gym_email']) ? (string) $_SESSION['chu_gym_email'] : 'admin@gympro.local';
$avatarLabel = strtoupper(substr(trim($hoTenChu), 0, 1));
if ($avatarLabel === '') {
    $avatarLabel = 'A';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Quản lý gói dịch vụ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --bg-main: #13131a;
            --bg-card: #1c1c26;
            --text-main: #ffffff;
            --text-muted: #7c8196;
            --primary: #8b5cf6;
            --primary-hover: #7c3aed;
            --border-color: #2b2b36;
        }
        .text-muted {
            color: var(--text-muted) !important;
        }
        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        /* --- TÙY CHỈNH CHỮ GỢI Ý (PLACEHOLDER) --- */
        /* Giúp chữ mờ trong ô nhập liệu sáng hơn, không bị tệp vào nền đen */
        ::-webkit-input-placeholder { color: #8b8f9e !important; opacity: 1 !important; }
        :-ms-input-placeholder { color: #8b8f9e !important; opacity: 1 !important; }
        ::placeholder { color: #8b8f9e !important; opacity: 1 !important; }

        .search-bar::placeholder,
        .form-control-dark::placeholder,
        textarea::placeholder {
            color: #8b8f9e !important;
        }

        /* --- TÙY CHỈNH SIDEBAR --- */
        .sidebar {
            width: 250px;
            background-color: var(--bg-card);
            height: 100vh;
            position: fixed;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
        }

        .logo-area {
            padding: 20px;
            font-size: 1.25rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 5px 10px;
            border-radius: 8px;
        }

        .nav-link {
            color: var(--text-muted);
            padding: 12px 20px;
            margin: 4px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: var(--text-main);
            background-color: rgba(255, 255, 255, 0.05);
        }

        .nav-link.active {
            color: var(--text-main);
            background-color: rgba(139, 92, 246, 0.15);
            border-left: 4px solid var(--primary);
        }

        /* --- TÙY CHỈNH MAIN CONTENT --- */
        .main-content {
            margin-left: 250px;
            padding: 20px 30px;
            min-height: 100vh;
}

        /* Topbar & Inputs */
        .search-bar {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 20px;
            padding: 8px 15px;
            width: 300px;
        }

        .search-bar:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: none;
            background-color: var(--bg-card);
            color: white;
        }

        .btn-custom-outline {
            border: 1px solid var(--border-color);
            color: var(--text-main);
            background-color: var(--bg-card);
        }

        .btn-primary-gradient {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }

        .btn-primary-gradient:hover {
            opacity: 0.9;
            color: white;
        }

        /* Table */
        .table-custom {
            /* Ép Bootstrap dùng màu của Dark Mode */
            --bs-table-bg: transparent; 
            --bs-table-color: var(--text-main);
            --bs-table-border-color: var(--border-color); /* Khóa chính: Đổi đường kẻ trắng thành màu tối */
            
            margin-top: 15px;
        }
        
        .table-custom th {
            color: var(--text-muted);
            padding: 15px 10px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border-color);
        }
        
        .table-custom td {
            padding: 15px 10px;
            vertical-align: middle;
            background-color: transparent;
            /* Đã xóa dòng border-bottom ở đây vì Bootstrap sẽ tự lo nhờ biến --bs-table-border-color */
        }
        
        /* Thêm hiệu ứng hover (đổi màu nhẹ) khi di chuột qua từng hàng cho xịn xò */
        .table-custom tbody tr:hover td {
            background-color: rgba(255, 255, 255, 0.02);
        }

        .badge-status {
            background-color: rgba(139, 92, 246, 0.2);
            color: #bfa4ff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        /* --- TÙY CHỈNH MODAL (POPUP) --- */
        .modal-content {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 15px;
        }
        .modal-header {
            border-bottom: 1px solid var(--border-color);
        }
        .modal-title {
            font-weight: bold;
        }
        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        .form-control-dark, .form-select-dark {
            background-color: var(--bg-main);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }
        .form-control-dark:focus, .form-select-dark:focus {
background-color: var(--bg-main);
            color: var(--text-main);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(139, 92, 246, 0.25);
        }
        .form-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        .input-group-text-dark {
            background-color: var(--bg-main);
            border: 1px solid var(--border-color);
            border-right: none;
            color: var(--text-muted);
        }
        .form-control-dark-borderless {
            border-left: none;
        }

        /* Toggle Button trạng thái */
        .btn-group-status .btn {
            border: 1px solid var(--border-color);
            color: var(--text-muted);
        }
        .btn-group-status .btn-check:checked + .btn {
            background-color: rgba(139, 92, 246, 0.2);
            color: var(--primary);
            border-color: var(--primary);
        }

        /* --- TÙY CHỈNH NÚT THAO TÁC (ACTION ICONS) --- */
        .action-icon {
            color: #a1a5b7; 
            font-size: 1.15rem; 
            padding: 8px; 
            border-radius: 8px; 
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-icon.edit:hover {
            color: #8b5cf6; 
            background-color: rgba(139, 92, 246, 0.15); 
            transform: scale(1.1); 
            box-shadow: 0 4px 10px rgba(139, 92, 246, 0.2); 
        }

        .action-icon.delete:hover {
            color: #f1416c; 
            background-color: rgba(241, 65, 108, 0.15); 
            transform: scale(1.1); 
            box-shadow: 0 4px 10px rgba(241, 65, 108, 0.2); 
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
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo-area">
            <div class="logo-icon"><i class="bi bi-hexagon-fill"></i></div>
            <div>
                <div class="fw-bold">GymPro</div>
                <div style="font-size: 0.65rem; color: var(--text-muted);">HỆ THỐNG QUẢN LÝ</div>
            </div>
        </div>

        <div class="mt-3 flex-grow-1">
            <a href="#" class="nav-link text-decoration-none"><i class="bi bi-grid-1x2"></i> Tổng quan</a>
            <a href="#" class="nav-link text-decoration-none"><i class="bi bi-people"></i> Quản lý hội viên</a>
            <a href="#" class="nav-link active text-decoration-none"><i class="bi bi-box-seam"></i> Quản lý gói dịch vụ</a>
            <a href="#" class="nav-link text-decoration-none"><i class="bi bi-person-badge"></i> Quản lý nhân viên</a>
            <a href="#" class="nav-link text-decoration-none"><i class="bi bi-cart3"></i> Bán hàng</a>
            <a href="#" class="nav-link text-decoration-none"><i class="bi bi-graph-up"></i> Doanh thu</a>
<a href="#" class="nav-link text-decoration-none"><i class="bi bi-file-earmark-text"></i> Báo cáo</a>
        </div>

        <div class="p-3 border-top" style="border-color: var(--border-color) !important;">
            <div class="d-flex align-items-center gap-2">
                <img src="https://ui-avatars.com/api/?name=Alex+Johnson&background=random" class="rounded-circle" width="40" height="40" alt="User">
                <div>
                    <div class="fw-bold" style="font-size: 0.9rem;">Alex Johnson</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">Quản trị viên</div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="position-relative">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text" class="form-control search-bar ps-5" placeholder="Tìm kiếm hội viên hoặc tên gói...">
            </div>
            <div class="d-flex gap-3 align-items-center">
                <i class="bi bi-bell text-muted fs-5 cursor-pointer"></i>
                <i class="bi bi-gear text-muted fs-5 cursor-pointer"></i>
                <button class="btn btn-custom-outline rounded-pill px-3"><i class="bi bi-person-bounding-box me-1"></i> Quét khuôn mặt</button>
                <button class="btn btn-primary rounded-pill px-3" style="background-color: #2563eb; border:none;"><i class="bi bi-person-plus me-1"></i> Đăng ký mới</button>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-1">QUẢN LÝ GÓI DỊCH VỤ</h2>
                <span class="text-muted">Cấu hình các chương trình tập luyện và gia hạn viên</span>
            </div>
            <div class="d-flex gap-2">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" class="form-control form-control-dark rounded-pill ps-5" placeholder="Tìm tên gói tập..." style="background-color: var(--bg-card); width: 250px;">
                </div>
                <button class="btn btn-primary-gradient rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addPackageModal">
                    <i class="bi bi-plus-circle me-1"></i> Thêm gói tập
                </button>
            </div>
        </div>

        <div class="p-4 rounded-4" style="background-color: var(--bg-card);">
            <div class="d-flex justify-content-between border-bottom pb-2" style="border-color: var(--border-color) !important;">
                <ul class="nav custom-tabs">
<li class="nav-item"><a class="nav-link active" href="#">Tất cả</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Đang hoạt động</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tạm dừng</a></li>
                </ul>
                <div class="d-flex gap-3">
                    <span class="text-muted" style="cursor: pointer;"><i class="bi bi-funnel"></i> Lọc</span>
                    <span class="text-muted" style="cursor: pointer;"><i class="bi bi-sort-down"></i> Sắp xếp</span>
                </div>
            </div>

            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th>Tên gói</th>
                        <th>Thời hạn</th>
                        <th>Giá tiền</th>
                        <th>Quyền lợi</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="bi bi-circle-fill text-primary me-2" style="font-size: 8px;"></i> <strong>Gói 1 Tháng</strong></td>
                        <td>1 Tháng</td>
                        <td>300.000đ</td>
                        <td class="text-muted">Cá nhân</td>
                        <td><span class="badge badge-status">ĐANG BÁN</span></td>
                        <td>
                            <i class="bi bi-pencil-square action-icon edit me-2" title="Chỉnh sửa"></i>
                            <i class="bi bi-trash action-icon delete" title="Xóa"></i>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-circle-fill text-primary me-2" style="font-size: 8px;"></i> <strong>Gói nhóm 5 người</strong></td>
                        <td>1 Tháng</td>
                        <td>1.200.000đ</td>
                        <td class="text-muted">Nhóm 5 người</td>
                        <td><span class="badge badge-status">ĐANG BÁN</span></td>
                        <td>
                            <i class="bi bi-pencil-square action-icon edit me-2" title="Chỉnh sửa"></i>
                            <i class="bi bi-trash action-icon delete" title="Xóa"></i>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-circle-fill text-primary me-2" style="font-size: 8px;"></i> <strong>Gói XXXXX</strong></td>
                        <td>XX Tháng</td>
                        <td>XXX.XXXđ</td>
                        <td class="text-muted">XXXXXXXXXXXXXXXXX</td>
                        <td><span class="badge badge-status">ĐANG BÁN</span></td>
                        <td>
                            <i class="bi bi-pencil-square action-icon edit me-2" title="Chỉnh sửa"></i>
<i class="bi bi-trash action-icon delete" title="Xóa"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted text-sm d-flex align-items-center gap-2">
                    Hiển thị 
                    <select class="form-select form-select-sm form-select-dark rounded-pill" style="width: 60px;">
                        <option>5</option>
                        <option>10</option>
                    </select>
                </div>
                <div class="btn btn-primary rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">1</div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPackageModal" tabindex="-1" aria-labelledby="addPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-2">
                
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="addPackageModalLabel">
                        <i class="bi bi-stars text-primary"></i> Thêm gói dịch vụ mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="px-3 pb-3 pt-1 text-muted" style="font-size: 0.85rem;">Thiết lập thông tin gói tập</div>

                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Tên gói tập</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-tag"></i></span>
                                <input type="text" class="form-control form-control-dark form-control-dark-borderless rounded-end" placeholder="VD: Gói Platinum 3 Tháng">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label">Giá niêm yết</label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-dark"><i class="bi bi-cash"></i></span>
                                    <input type="text" class="form-control form-control-dark form-control-dark-borderless" placeholder="0">
                                    <span class="input-group-text" style="background-color: var(--bg-main); border: 1px solid var(--border-color); color: var(--text-muted);">VNĐ</span>
                                </div>
</div>
                            <div class="col-6">
                                <label class="form-label">Thời hạn gói</label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-dark"><i class="bi bi-calendar3"></i></span>
                                    <select class="form-select form-select-dark form-control-dark-borderless rounded-end">
                                        <option selected>30 ngày</option>
                                        <option>90 ngày</option>
                                        <option>365 ngày</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Số lượng hội viên</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-people"></i></span>
                                <select class="form-select form-select-dark form-control-dark-borderless rounded-end">
                                    <option selected>1</option>
                                    <option>2</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả ngắn</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark align-items-start pt-2"><i class="bi bi-text-left"></i></span>
                                <textarea class="form-control form-control-dark form-control-dark-borderless rounded-end" rows="3" placeholder="Nhập mô tả về đặc quyền của gói..."></textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">Trạng thái</label>
                            <div class="btn-group btn-group-status" role="group">
                                <input type="radio" class="btn-check" name="statusRadio" id="statusActive" autocomplete="off" checked>
                                <label class="btn rounded-start-pill px-4" for="statusActive">Đang bán</label>

                                <input type="radio" class="btn-check" name="statusRadio" id="statusPause" autocomplete="off">
                                <label class="btn rounded-end-pill px-4" for="statusPause">Tạm dừng</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
<button type="button" class="btn btn-primary-gradient py-2 rounded-3 fw-bold">
                                <i class="bi bi-check2-circle me-1"></i> Xác nhận tạo gói
                            </button>
                            <button type="button" class="btn text-muted mt-1" data-bs-dismiss="modal">Hủy bỏ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
