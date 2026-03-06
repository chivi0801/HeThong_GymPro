<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$headerGoiTapList = [];

function headerColumnExists(mysqli $conn, string $table, string $column): bool
{
    $sql = "SELECT 1
            FROM information_schema.columns
            WHERE table_schema = DATABASE()
              AND table_name = ?
              AND column_name = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param('ss', $table, $column);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result && $result->num_rows > 0;
    $stmt->close();

    return $exists;
}

$chuGymId = isset($_SESSION['chu_gym_id']) ? (int) $_SESSION['chu_gym_id'] : 0;
if ($chuGymId > 0) {
    $conn = @new mysqli('localhost', 'root', '', 'gym_pro');
    if (!$conn->connect_error) {
        $conn->set_charset('utf8mb4');

        $hasTrangThai = headerColumnExists($conn, 'goi_tap', 'trang_thai');
        $sql = "SELECT id, ten_goi FROM goi_tap WHERE chu_gym_id = ?";
        if ($hasTrangThai) {
            $sql .= " AND trang_thai = 'active'";
        }
        $sql .= " ORDER BY ten_goi ASC";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('i', $chuGymId);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result ? $result->fetch_assoc() : null) {
                if (!$row) {
                    break;
                }
                $headerGoiTapList[] = [
                    'id' => (int) $row['id'],
                    'ten_goi' => (string) $row['ten_goi'],
                ];
            }

            $stmt->close();
        }

        $conn->close();
    }
}
?>
<style>
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
        width: 100%;
        background: var(--bg-input);
        border: 1px solid var(--border-color);
        padding: 10px 16px 10px 40px;
        border-radius: 10px;
        color: var(--input-text);
        outline: none;
        font-size: 14px;
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
        text-decoration: none;
    }

    .qr-popup-overlay,
    .member-popup-overlay {
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

    .qr-popup-overlay:target,
    .member-popup-overlay:target {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .qr-popup-card,
    .member-popup-card {
        background: var(--bg-panel);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        position: relative;
    }

    .qr-popup-card {
        width: min(92vw, 380px);
        padding: 18px;
        text-align: center;
    }

    .member-popup-card {
        width: min(92vw, 560px);
        padding: 20px;
    }

    .qr-popup-close,
    .member-popup-close {
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

    .qr-popup-title,
    .member-popup-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .qr-popup-subtitle,
    .member-popup-subtitle {
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

    .member-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .member-form-group { display: flex; flex-direction: column; gap: 6px; }
    .member-form-group.full { grid-column: 1 / -1; }

    .member-form-group label {
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .member-form-group input,
    .member-form-group select {
        background: var(--bg-input);
        border: 1px solid var(--border-color);
        color: var(--input-text);
        padding: 10px 12px;
        border-radius: 10px;
        font-size: 14px;
        outline: none;
    }

    .member-form-group input:focus,
    .member-form-group select:focus {
        border-color: var(--primary);
    }

    .member-required {
        color: #f97316;
        margin-left: 4px;
    }

    .member-form-note {
        margin-top: 10px;
        color: var(--text-muted);
        font-size: 12px;
    }

    .member-form-actions {
        margin-top: 18px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-member-cancel,
    .btn-member-submit {
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 18px;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .btn-member-cancel {
        background: transparent;
        color: var(--text-muted);
        border-color: var(--border-color);
    }

    .btn-member-submit {
        background: var(--primary);
        color: white;
        border: none;
    }

    .btn-member-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .member-form-grid {
            grid-template-columns: 1fr;
        }
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

        <a href="#member-register-popup" class="btn-add-primary"><i class="fa-solid fa-user-plus"></i> Đăng ký mới</a>
    </div>
</header>

<div id="qr-popup" class="qr-popup-overlay">
    <div class="qr-popup-card">
        <a href="#" class="qr-popup-close" aria-label="Dong popup"><i class="fa-solid fa-xmark"></i></a>
        <div class="qr-popup-title">Mã QR Check-in</div>
        <div class="qr-popup-subtitle">Quét mã QR để check-in.</div>
        <img src="../image/QR.png" alt="QR Check-in" class="qr-popup-image">
    </div>
</div>

<div id="member-register-popup" class="member-popup-overlay">
    <div class="member-popup-card">
        <a href="#" class="member-popup-close" aria-label="Dong popup"><i class="fa-solid fa-xmark"></i></a>
        <div class="member-popup-title">Đăng ký hội viên mới</div>
        <div class="member-popup-subtitle">Nhập thông tin hội viên và chọn gói tập đang mở bán.</div>

        <form action="../actions/ThemHoiVien.php" method="post">
            <div class="member-form-grid">
                <div class="member-form-group">
                    <label for="hv_ho_ten">Họ tên<span class="member-required">*</span></label>
                    <input id="hv_ho_ten" name="ho_ten" type="text" required maxlength="100" placeholder="Ví dụ: Nguyễn Văn A">
                </div>

                <div class="member-form-group">
                    <label for="hv_sdt">Số điện thoại<span class="member-required">*</span></label>
                    <input id="hv_sdt" name="sdt" type="tel" required maxlength="15" placeholder="Ví dụ: 0912345678">
                </div>

                <div class="member-form-group">
                    <label for="hv_email">Email</label>
                    <input id="hv_email" name="email" type="email" maxlength="100" placeholder="không bắt buộc">
                </div>

                <div class="member-form-group">
                    <label for="hv_ngay_sinh">Ngày sinh</label>
                    <input id="hv_ngay_sinh" name="ngay_sinh" type="date">
                </div>

                <div class="member-form-group">
                    <label for="hv_gioi_tinh">Giới tính</label>
                    <select id="hv_gioi_tinh" name="gioi_tinh">
                        <option value="">Chọn giới tính (không bắt buộc)</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>

                <div class="member-form-group">
                    <label for="hv_goi_tap_id">Gói tập<span class="member-required">*</span></label>
                    <select id="hv_goi_tap_id" name="goi_tap_id" required>
                        <option value="">Chọn gói tập</option>
                        <?php foreach ($headerGoiTapList as $pkg): ?>
                            <option value="<?php echo (int) $pkg['id']; ?>"><?php echo htmlspecialchars($pkg['ten_goi'], ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="member-form-note">Các trường có dấu * là bắt buộc. Nếu chưa chọn gói hoặc thiếu tên/số điện thoại thì không thể xác nhận.</div>

            <div class="member-form-actions">
                <a href="#" class="btn-member-cancel">Hủy</a>
                <button type="submit" class="btn-member-submit" <?php echo empty($headerGoiTapList) ? 'disabled' : ''; ?>>Xác nhận</button>
            </div>
        </form>
    </div>
</div>
