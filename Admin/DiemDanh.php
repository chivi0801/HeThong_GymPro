<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['chu_gym_id'])) {
    header('Location: ../Auth/DangNhap.php');
    exit;
}

function ddColumnExists(mysqli $conn, string $table, string $column): bool
{
    $sql = "SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = ? AND column_name = ? LIMIT 1";
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

$chuGymId = (int) $_SESSION['chu_gym_id'];
$ddMode = isset($_GET['mode']) ? trim((string) $_GET['mode']) : '';
$ddEnrollMemberId = (int) ($_GET['member_id'] ?? 0);
$ddEnrollTarget = null;

if ($ddMode === 'enroll' && $ddEnrollMemberId > 0) {
    $conn = @new mysqli('localhost', 'root', '', 'gym_pro');
    if (!$conn->connect_error) {
        $conn->set_charset('utf8mb4');

        $hasMaId = ddColumnExists($conn, 'hoi_vien', 'ma_id');
        $memberCodeExpr = $hasMaId
            ? "COALESCE(NULLIF(TRIM(hv.ma_id), ''), CONCAT('#HV-', DATE_FORMAT(hv.ngay_dang_ky, '%Y'), '-', LPAD(hv.id, 3, '0')))"
            : "CONCAT('#HV-', DATE_FORMAT(hv.ngay_dang_ky, '%Y'), '-', LPAD(hv.id, 3, '0'))";

        $sql = "
            SELECT
                hv.id,
                hv.ho_ten,
                hv.sdt,
                {$memberCodeExpr} AS ma_id,
                COALESCE(gt.ten_goi, 'Chua co goi') AS ten_goi,
                dkg.ngay_ket_thuc,
                CASE WHEN km.hoi_vien_id IS NULL THEN 0 ELSE 1 END AS da_dang_ky_khuon_mat
            FROM hoi_vien hv
            LEFT JOIN (
                SELECT d1.hoi_vien_id, d1.goi_tap_id, d1.ngay_ket_thuc
                FROM dang_ky_goi d1
                INNER JOIN (
                    SELECT hoi_vien_id, MAX(id) AS max_id
                    FROM dang_ky_goi
                    GROUP BY hoi_vien_id
                ) d2 ON d2.max_id = d1.id
            ) dkg ON dkg.hoi_vien_id = hv.id
            LEFT JOIN goi_tap gt ON gt.id = dkg.goi_tap_id
            LEFT JOIN (
                SELECT DISTINCT hoi_vien_id
                FROM khuon_mat_hoi_vien
                WHERE trang_thai = 1
            ) km ON km.hoi_vien_id = hv.id
            WHERE hv.id = ? AND hv.chu_gym_id = ?
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('ii', $ddEnrollMemberId, $chuGymId);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            if ($row) {
                $ddEnrollTarget = [
                    'id' => (int) $row['id'],
                    'ho_ten' => (string) $row['ho_ten'],
                    'sdt' => (string) ($row['sdt'] ?? ''),
                    'ma_id' => (string) ($row['ma_id'] ?? ''),
                    'ten_goi' => (string) ($row['ten_goi'] ?? 'Chua co goi'),
                    'ngay_ket_thuc' => !empty($row['ngay_ket_thuc']) ? (string) $row['ngay_ket_thuc'] : null,
                    'da_dang_ky_khuon_mat' => (int) ($row['da_dang_ky_khuon_mat'] ?? 0),
                ];
            }
            $stmt->close();
        }

        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Điểm danh khuôn mặt</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

    <style>
        :root { --bg-dark:#121521; --bg-panel:#1a1e2d; --bg-sidebar:#151825; --bg-input:#23283c; --text-main:#fff; --text-muted:#94a3b8; --border-color:rgba(255,255,255,.08); --primary:#3b82f6; --purple:#8b5cf6; --danger:#ef4444; --success:#10b981; --gradient-btn:linear-gradient(90deg,#3b82f6,#8b5cf6);} 
        :root[data-theme="light"] { --bg-dark:#f1f5f9; --bg-panel:#fff; --bg-sidebar:#e2e8f0; --bg-input:#f8fafc; --text-main:#0f172a; --text-muted:#64748b; --border-color:rgba(15,23,42,.12); --primary:#2563eb; --purple:#7c3aed; --danger:#dc2626; --success:#059669; --gradient-btn:linear-gradient(90deg,#2563eb,#7c3aed);} 
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif} body{background:var(--bg-dark);color:var(--text-main);display:flex;height:100vh;overflow:hidden}
        .main-content{flex:1;display:flex;flex-direction:column;overflow:hidden}.page-content{flex:1;overflow-y:auto;padding:24px 40px}
        .page-title h1{font-size:28px;font-weight:700;margin-bottom:6px}.page-title p{color:var(--text-muted);font-size:14px;margin-bottom:18px}
        .dd-grid{display:grid;grid-template-columns:2fr 1fr;gap:20px}.panel{background:var(--bg-panel);border:1px solid var(--border-color);border-radius:16px;padding:20px}
        .camera-box{position:relative;border-radius:16px;overflow:hidden;border:1px solid var(--border-color);height:360px;background:#0b1120;margin-bottom:16px}
        .camera-video,.camera-canvas{position:absolute;inset:0;width:100%;height:100%}.camera-video{object-fit:cover;opacity:.9}.camera-canvas{pointer-events:none}
        .camera-pill{position:absolute;left:16px;top:16px;font-size:11px;background:rgba(0,0,0,.6);border:1px solid var(--border-color);border-radius:999px;padding:6px 12px;display:flex;align-items:center;gap:8px;font-weight:600;color:#f8fafc}
        .dot{width:8px;height:8px;border-radius:50%;display:inline-block}.dot.red{background:#ef4444}
        .camera-footer{position:absolute;left:0;right:0;bottom:0;padding:12px 16px;background:linear-gradient(180deg,rgba(11,17,32,0) 0%,rgba(11,17,32,.9) 60%,rgba(11,17,32,1) 100%);font-size:13px;display:flex;justify-content:space-between;color:#cbd5e1}
        .enroll-bar{display:flex;gap:10px;align-items:center;margin:10px 0 14px}.enroll-pill{font-size:12px;border:1px solid var(--border-color);border-radius:999px;padding:6px 10px;color:var(--text-muted)}
        .btn{border:none;border-radius:12px;padding:10px 14px;cursor:pointer;font-weight:600}.btn-primary{color:#fff;background:var(--gradient-btn)}.btn-ghost{color:var(--text-muted);background:transparent;border:1px solid var(--border-color)}
        .member-card{display:flex;flex-direction:column}.member-top{text-align:center;margin-bottom:18px}.member-top img{width:96px;height:96px;border-radius:50%;object-fit:cover;border:3px solid var(--primary);margin-bottom:10px}
        .member-top h3{font-size:22px;margin-bottom:6px}.member-id{font-size:12px;color:var(--text-muted);letter-spacing:.4px}
        .info-item{display:flex;justify-content:space-between;align-items:center;padding:12px;border:1px solid var(--border-color);border-radius:12px;margin-bottom:10px;background:rgba(0,0,0,.15);font-size:14px}
        .info-item .label{color:var(--text-muted)}.info-item .value{font-weight:600}.value.warn{color:#fb923c}
        .recent-list{display:flex;flex-direction:column;gap:10px}.recent-item{display:flex;justify-content:space-between;align-items:center;padding:12px;border:1px solid var(--border-color);border-radius:12px;background:rgba(255,255,255,.02)}
        .user-box{display:flex;align-items:center;gap:10px}.avatar{width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;background:rgba(249,115,22,.2);color:#fb923c}
        .user-name{font-weight:600;font-size:14px}.user-sub{font-size:12px;color:var(--text-muted);margin-top:3px}.right-col{text-align:right}.time{font-size:12px;color:var(--text-muted);margin-bottom:6px}
        .status{font-size:10px;font-weight:700;color:var(--primary);background:rgba(59,130,246,.12);padding:4px 8px;border-radius:8px}
        @media (max-width:1200px){.dd-grid{grid-template-columns:1fr}.camera-box{height:300px}}
    </style>
</head>
<body>
    <div id="sidebar-placeholder"></div>

    <main class="main-content">
        <div id="header-placeholder"></div>

        <div class="page-content">
            <div class="page-title">
                <h1>Check-in khuôn mặt</h1>
                <p id="ddModeHint">Nhìn vào camera để nhận diện và điểm danh tự động.</p>
            </div>

            <div class="dd-grid">
                <section class="panel">
                    <div class="camera-box">
                        <video id="ddCameraVideo" class="camera-video" autoplay muted playsinline></video>
                        <canvas id="ddCameraCanvas" class="camera-canvas"></canvas>
                        <div class="camera-pill"><span class="dot red"></span>CAM 01 - ĐANG HOẠT ĐỘNG</div>
                        <div class="camera-footer">
                            <span><i class="fa-solid fa-user"></i> Nhận diện: <strong id="ddDetectStatus">Đang khởi tạo...</strong></span>
                            <span><i class="fa-solid fa-bolt"></i> Độ trễ: <span id="ddDetectLatency">-- ms</span></span>
                        </div>
                    </div>

                    <div class="enroll-bar" id="ddEnrollBar" style="display:none;">
                        <span class="enroll-pill" id="ddEnrollTargetText">Đang đăng ký khuôn mặt</span>
                        <button type="button" class="btn btn-primary" id="ddEnrollBtn">Lưu khuôn mặt</button>
                        <a href="../Admin/HoiVien.php" class="btn btn-ghost" style="text-decoration:none;">Quay lại</a>
                    </div>

                    <div class="panel" style="padding: 16px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                            <h3 style="font-size:16px;">Check-in gần đây</h3>
                        </div>
                        <div class="recent-list" id="ddRecentList"></div>
                    </div>
                </section>

                <aside class="panel member-card">
                    <div class="member-top">
                        <img id="ddMemberAvatar" src="../image/Logo.png" alt="Member Avatar" onerror="this.onerror=null;this.src='../image/Logo.png';">
                        <h3 id="ddMemberName">Chưa nhận diện</h3>
                        <div class="member-id" id="ddMemberCode">MÃ THÀNH VIÊN: --</div>
                    </div>

                    <div class="info-item"><span class="label">Số điện thoại</span><span class="value" id="ddMemberPhone">--</span></div>
                    <div class="info-item"><span class="label">Gói tập</span><span class="value" id="ddMemberPackage">--</span></div>
                    <div class="info-item"><span class="label">Trạng thái gói</span><span class="value" id="ddMemberPackageStatus">--</span></div>
                    <div class="info-item"><span class="label">Ngày còn lại</span><span class="value warn" id="ddMemberRemainDays">--</span></div>
                    <div class="info-item"><span class="label">Lần cuối</span><span class="value" id="ddMemberLastCheckin">--</span></div>

                    <button class="btn btn-primary" id="ddConfirmBtn" type="button">XÁC NHẬN VÀO CỔNG</button>
                    <button class="btn btn-ghost" id="ddResetBtn" type="button">Không phải bạn? Quét lại</button>
                </aside>
            </div>
        </div>
    </main>

    <script>
        const DD_CONFIG = {
            mode: <?php echo json_encode($ddMode, JSON_UNESCAPED_UNICODE); ?>,
            enrollTarget: <?php echo json_encode($ddEnrollTarget, JSON_UNESCAPED_UNICODE); ?>
        };

        const ADMIN_THEME_KEY = 'gympro-admin-theme';
        const FACE_MODEL_URL = '../models';
        let detectTimer = null;
        let knownMembers = [];
        let memberByLabel = new Map();
        let faceMatcher = null;
        let currentRecognizedMember = null;
        const localCheckinCooldown = new Map();

        function syncThemeToggleButton(theme) {
            const themeBtn = document.getElementById('adminThemeToggle');
            if (!themeBtn) return;
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
            if (!themeBtn || themeBtn.dataset.bound === '1') return;
            themeBtn.dataset.bound = '1';
            themeBtn.addEventListener('click', function () {
                const currentTheme = document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
                applyAdminTheme(currentTheme === 'light' ? 'dark' : 'light');
            });
            syncThemeToggleButton(document.documentElement.getAttribute('data-theme'));
        }

        function formatDateTime(input) {
            if (!input) return '--';
            const date = new Date(input.replace(' ', 'T'));
            if (Number.isNaN(date.getTime())) return '--';
            return date.toLocaleString('vi-VN');
        }

        function calcRemainDays(ngayKetThuc) {
            if (!ngayKetThuc) return '--';
            const end = new Date(ngayKetThuc + 'T00:00:00');
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            return Math.ceil((end - today) / 86400000);
        }

        function renderMemberInfo(member) {
            const nameEl = document.getElementById('ddMemberName');
            const codeEl = document.getElementById('ddMemberCode');
            const phoneEl = document.getElementById('ddMemberPhone');
            const packageEl = document.getElementById('ddMemberPackage');
            const statusEl = document.getElementById('ddMemberPackageStatus');
            const remainEl = document.getElementById('ddMemberRemainDays');
            const lastEl = document.getElementById('ddMemberLastCheckin');
            if (!nameEl) return;

            if (!member) {
                nameEl.textContent = 'Chưa nhận diện';
                codeEl.textContent = 'MÃ THÀNH VIÊN: --';
                phoneEl.textContent = '--';
                packageEl.textContent = '--';
                statusEl.textContent = '--';
                remainEl.textContent = '--';
                lastEl.textContent = '--';
                return;
            }

            nameEl.textContent = member.ho_ten || '--';
            codeEl.textContent = `MÃ THÀNH VIÊN: ${member.ma_id || '--'}`;
            phoneEl.textContent = member.sdt || '--';
            packageEl.textContent = member.ten_goi || '--';
            statusEl.textContent = member.trang_thai_goi || '--';
            const remain = calcRemainDays(member.ngay_ket_thuc);
            remainEl.textContent = remain === '--' ? '--' : `${remain} ngày`;
            lastEl.textContent = formatDateTime(member.last_checkin);
        }

        function renderUnknownMemberInfo() {
            renderMemberInfo({
                ho_ten: 'Người lạ / chưa đăng ký',
                ma_id: '--',
                sdt: '--',
                ten_goi: '--',
                trang_thai_goi: 'Chưa đăng ký khuôn mặt',
                ngay_ket_thuc: null,
                last_checkin: null
            });
        }

        function addRecentItem(member) {
            const list = document.getElementById('ddRecentList');
            if (!list || !member) return;
            const initials = (member.ho_ten || '?').trim().charAt(0).toUpperCase();
            const item = document.createElement('div');
            item.className = 'recent-item';
            item.innerHTML = `
                <div class="user-box">
                    <div class="avatar">${initials}</div>
                    <div>
                        <div class="user-name">${member.ho_ten || '--'}</div>
                        <div class="user-sub">${member.ten_goi || 'Chua co goi'} • Check-in khuôn mặt</div>
                    </div>
                </div>
                <div class="right-col">
                    <div class="time">Vừa xong</div>
                    <span class="status">THÀNH CÔNG</span>
                </div>
            `;
            list.prepend(item);
            while (list.children.length > 5) {
                list.removeChild(list.lastChild);
            }
        }

        async function waitForFaceApi(maxWaitMs = 7000) {
            const startedAt = Date.now();
            while (typeof faceapi === 'undefined') {
                if (Date.now() - startedAt > maxWaitMs) {
                    throw new Error('Không tải được thư viện face-api.js');
                }
                await new Promise((resolve) => setTimeout(resolve, 80));
            }
        }

        async function fetchKnownMembers() {
            const response = await fetch('../actions/api_face_members.php', { credentials: 'same-origin' });
            const data = await response.json();
            if (!data.success || !Array.isArray(data.members)) {
                knownMembers = [];
                memberByLabel = new Map();
                faceMatcher = null;
                return;
            }

            knownMembers = data.members;
            memberByLabel = new Map();
            const labeled = [];

            data.members.forEach((member) => {
                if (!Array.isArray(member.embedding) || member.embedding.length === 0) {
                    return;
                }
                const descriptor = new Float32Array(member.embedding);
                labeled.push(new faceapi.LabeledFaceDescriptors(member.label, [descriptor]));
                memberByLabel.set(member.label, member);
            });

            faceMatcher = labeled.length > 0 ? new faceapi.FaceMatcher(labeled, 0.55) : null;
        }

        async function tryCheckin(member) {
            if (!member || !member.id) return;
            const now = Date.now();
            const last = localCheckinCooldown.get(member.id) || 0;
            if (now - last < 30000) return;
            localCheckinCooldown.set(member.id, now);

            try {
                const response = await fetch('../actions/api_face_checkin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    credentials: 'same-origin',
                    body: JSON.stringify({ member_id: member.id })
                });
                const payload = await response.json();
                if (payload.success && payload.inserted) {
                    addRecentItem(member);
                    member.last_checkin = new Date().toISOString().slice(0, 19).replace('T', ' ');
                    renderMemberInfo(member);
                }
            } catch (error) {
                console.error(error);
            }
        }

        async function enrollCurrentFace() {
            if (DD_CONFIG.mode !== 'enroll' || !DD_CONFIG.enrollTarget || !DD_CONFIG.enrollTarget.id) return;
            const video = document.getElementById('ddCameraVideo');
            const statusEl = document.getElementById('ddDetectStatus');

            const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (!detection || !detection.descriptor) {
                alert('Không thấy khuôn mặt rõ ràng để lưu.');
                return;
            }

            statusEl.textContent = 'Đang lưu khuôn mặt...';
            const response = await fetch('../actions/api_face_enroll.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({
                    member_id: DD_CONFIG.enrollTarget.id,
                    embedding: Array.from(detection.descriptor)
                })
            });
            const payload = await response.json();

            if (!payload.success) {
                statusEl.textContent = 'Lưu khuôn mặt thất bại';
                alert(payload.message || 'Không thể lưu khuôn mặt');
                return;
            }

            statusEl.textContent = 'Đã lưu khuôn mặt';
            alert('Đăng ký khuôn mặt thành công');
            DD_CONFIG.enrollTarget.da_dang_ky_khuon_mat = 1;
            await fetchKnownMembers();
        }

        async function initDiemDanhCamera() {
            const video = document.getElementById('ddCameraVideo');
            const canvas = document.getElementById('ddCameraCanvas');
            const statusEl = document.getElementById('ddDetectStatus');
            const latencyEl = document.getElementById('ddDetectLatency');
            const modeHintEl = document.getElementById('ddModeHint');
            const enrollBar = document.getElementById('ddEnrollBar');
            const enrollBtn = document.getElementById('ddEnrollBtn');
            const enrollTargetText = document.getElementById('ddEnrollTargetText');
            const resetBtn = document.getElementById('ddResetBtn');
            const confirmBtn = document.getElementById('ddConfirmBtn');

            if (!video || !canvas || !statusEl || !latencyEl) return;

            if (DD_CONFIG.mode === 'enroll' && DD_CONFIG.enrollTarget) {
                if (enrollBar) enrollBar.style.display = 'flex';
                if (modeHintEl) modeHintEl.textContent = `Chế độ đăng ký khuôn mặt cho ${DD_CONFIG.enrollTarget.ho_ten}.`;
                if (enrollTargetText) {
                    enrollTargetText.textContent = `${DD_CONFIG.enrollTarget.ho_ten} (${DD_CONFIG.enrollTarget.ma_id || '--'})`;
                }
                renderMemberInfo({
                    ...DD_CONFIG.enrollTarget,
                    trang_thai_goi: DD_CONFIG.enrollTarget.da_dang_ky_khuon_mat ? 'Da dang ky khuon mat' : 'Chua dang ky khuon mat',
                    last_checkin: null
                });
            }

            if (enrollBtn) {
                enrollBtn.addEventListener('click', async () => {
                    try {
                        await enrollCurrentFace();
                    } catch (error) {
                        console.error(error);
                        alert('Không thể đăng ký khuôn mặt');
                    }
                });
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    currentRecognizedMember = null;
                    if (DD_CONFIG.mode !== 'enroll') {
                        renderMemberInfo(null);
                    }
                });
            }

            if (confirmBtn) {
                confirmBtn.addEventListener('click', async () => {
                    if (!currentRecognizedMember) {
                        alert('Chưa có hội viên được nhận diện.');
                        return;
                    }
                    await tryCheckin(currentRecognizedMember);
                });
            }

            const setDetectStatus = (text) => { statusEl.textContent = text; };
            const setLatency = (ms) => { latencyEl.textContent = `${ms} ms`; };

            const startDetectLoop = (displaySize) => {
                canvas.width = displaySize.width;
                canvas.height = displaySize.height;
                faceapi.matchDimensions(canvas, displaySize);

                if (detectTimer) clearInterval(detectTimer);

                detectTimer = setInterval(async () => {
                    try {
                        const startedAt = performance.now();
                        const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                            .withFaceLandmarks()
                            .withFaceDescriptor();

                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);

                        if (!detection) {
                            setDetectStatus('Chưa phát hiện');
                            setLatency(Math.round(performance.now() - startedAt));
                            if (DD_CONFIG.mode !== 'enroll') {
                                currentRecognizedMember = null;
                            }
                            return;
                        }

                        const resized = faceapi.resizeResults(detection, displaySize);
                        faceapi.draw.drawDetections(canvas, [resized.detection]);

                        if (!faceMatcher) {
                            setDetectStatus('Người lạ / chưa đăng ký khuôn mặt');
                            if (DD_CONFIG.mode !== 'enroll') {
                                currentRecognizedMember = null;
                                renderUnknownMemberInfo();
                            }
                            setLatency(Math.round(performance.now() - startedAt));
                            return;
                        }

                        const best = faceMatcher.findBestMatch(detection.descriptor);
                        if (best.label && best.label !== 'unknown') {
                            const matchedMember = memberByLabel.get(best.label);
                            if (matchedMember) {
                                currentRecognizedMember = matchedMember;
                                renderMemberInfo(matchedMember);
                                setDetectStatus(`Đã nhận diện: ${matchedMember.ho_ten}`);
                                await tryCheckin(matchedMember);
                            } else {
                                setDetectStatus('Không xác định danh tính');
                                if (DD_CONFIG.mode !== 'enroll') {
                                    currentRecognizedMember = null;
                                    renderUnknownMemberInfo();
                                }
                            }
                        } else {
                            setDetectStatus('Người lạ / chưa đăng ký khuôn mặt');
                            if (DD_CONFIG.mode !== 'enroll') {
                                currentRecognizedMember = null;
                                renderUnknownMemberInfo();
                            }
                        }

                        setLatency(Math.round(performance.now() - startedAt));
                    } catch (error) {
                        console.error(error);
                        setDetectStatus('Lỗi khi nhận diện');
                    }
                }, 250);
            };

            try {
                await waitForFaceApi();
                setDetectStatus('Đang tải AI');
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(FACE_MODEL_URL),
                    faceapi.nets.faceLandmark68Net.loadFromUri(FACE_MODEL_URL),
                    faceapi.nets.faceRecognitionNet.loadFromUri(FACE_MODEL_URL)
                ]);

                await fetchKnownMembers();

                setDetectStatus('Đang mở camera');
                const stream = await navigator.mediaDevices.getUserMedia({ video: { width: 1280, height: 720, facingMode: 'user' } });
                video.srcObject = stream;
                await video.play();

                const start = () => {
                    const displaySize = {
                        width: video.clientWidth || video.videoWidth || 640,
                        height: video.clientHeight || video.videoHeight || 360
                    };
                    startDetectLoop(displaySize);
                };

                if (video.readyState >= 1) {
                    start();
                } else {
                    video.addEventListener('loadedmetadata', start, { once: true });
                }
            } catch (error) {
                console.error(error);
                setDetectStatus('Lỗi camera/AI');
            }
        }

        function initSidebarProfilePopup() {
            const trigger = document.getElementById('gymProfileTrigger');
            const overlay = document.getElementById('gymProfileOverlay');
            const popup = document.getElementById('gymProfilePopup');
            const closeBtn = document.getElementById('gymProfileClose');
            if (!trigger || !overlay || !popup || !closeBtn) return;
            const openPopup = () => { overlay.classList.add('show'); popup.classList.add('show'); };
            const closePopup = () => { overlay.classList.remove('show'); popup.classList.remove('show'); };
            trigger.addEventListener('click', openPopup);
            closeBtn.addEventListener('click', closePopup);
            overlay.addEventListener('click', closePopup);
            document.addEventListener('keydown', function (event) { if (event.key === 'Escape') closePopup(); });
        }

        let ddCameraInitStarted = false;
        function bootDiemDanhOnce() {
            if (ddCameraInitStarted) {
                return;
            }
            ddCameraInitStarted = true;
            initDiemDanhCamera();
        }

        initAdminTheme();
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bootDiemDanhOnce);
        } else {
            bootDiemDanhOnce();
        }

        fetch('../Components/header.php')
            .then(response => response.text())
            .then(data => { document.getElementById('header-placeholder').innerHTML = data; });

        fetch('../Components/sidebar.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('sidebar-placeholder').innerHTML = data;
                let currentPage = window.location.pathname.split('/').pop();
                if (currentPage === '') currentPage = 'TongQuan.php';
                const navLinks = document.querySelectorAll('.nav-menu a');
                navLinks.forEach(link => {
                    const linkHref = link.getAttribute('href');
                    if (linkHref === currentPage) link.parentElement.classList.add('active');
                });
                initSidebarProfilePopup();
                bindAdminThemeToggle();
            });
    </script>
</body>
</html>
