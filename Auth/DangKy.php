<!DOCTYPE html>
<html lang="vi" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Đăng ký hệ thống</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(90deg, #2563eb, #7c3aed);
            --glass-bg: rgba(15, 23, 42, 0.8);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #0f172a url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070') no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 100vh;
            padding-top: 80px;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(10, 15, 30, 0.85);
            z-index: 0;
        }

        /* Navbar mờ (Glassmorphism) */
        .navbar-glass {
            background: rgba(15, 23, 42, 0.8) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(168, 85, 247, 0.1);
        }

        .nav-link {
            color: #f8fafc !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #a855f7 !important;
        }

        .nav-link.active {
            color: #a855f7 !important;
        }

        .text-secondary.hover-white:hover {
            color: white !important;
        }

        .btn-gradient {
            background: linear-gradient(to right, #4f46e5, #9333ea);
            color: white;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3);
        }

        .btn-gradient:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(168, 85, 247, 0.5);
        }

        /* ===== PRICING SECTION ===== */
        .pricing-section {
            position: relative;
            z-index: 1;
            padding: 60px 20px;
            text-align: center;
        }

        .pricing-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
        }

        .pricing-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 40px 25px;
            width: 280px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        .pricing-card.active {
            border: 2px solid #7c3aed;
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(124, 58, 237, 0.3);
            background: rgba(124, 58, 237, 0.05);
        }

        .price {
            font-size: 32px;
            font-weight: 700;
            margin: 15px 0 25px;
        }

        .price span {
            font-size: 14px;
            color: #94a3b8;
        }

        .pricing-card ul {
            list-style: none;
            text-align: left;
            margin-bottom: 30px;
            min-height: 150px;
        }

        .pricing-card li {
            margin-bottom: 12px;
            font-size: 14px;
            color: #cbd5e1;
        }

        .pricing-card li i {
            color: #22c55e;
            
        }

        /* Button styling */
        .btn-select {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: none;
            color: white;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .btn-default {
            background: #16a34a;
        }

        .btn-pro {
            background: var(--primary-gradient);
        }

        /* Style khi nút được chọn */
        .pricing-card.active .btn-select {
            background: #475569 !important;
            cursor: default;
        }

        /* ===== REGISTER FORM ===== */
        .form-section {
            position: relative;
            z-index: 1;
            padding: 40px 20px 100px;
            display: flex;
            justify-content: center;
        }

        .register-card {
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid var(--glass-border);
            width: 800px;
            padding: 50px;
            border-radius: 24px;
            backdrop-filter: blur(20px);
        }

        .plan-alert {
            grid-column: span 2;
            background: rgba(124, 58, 237, 0.15);
            border: 1px dashed #7c3aed;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 25px;
            color: #a78bfa;
            font-weight: 600;
            display: none;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .grid-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .input-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: white;
            outline: none;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.08);
        }

        .btn-submit {
            grid-column: span 2;
            background: var(--primary-gradient);
            padding: 18px;
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 700;
            cursor: pointer;
            margin-top: 15px;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            opacity: 0.8;
        }

        .login-link a {
            color: #8b5cf6;
            text-decoration: none;
        }

         .bottom-footer {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 20px;
            font-size: 11px;
            color: #64748b;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-glass fixed-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold fs-4" href="../index.php">
                <img src="../image/logo.png" alt="Logo GymPro" class="img-fluid" style="width: 100px; height: 50px;">
            </a>

            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto fw-medium">
                    <li class="nav-item"><a class="nav-link" href="../index.php#hero">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="../index.php#features">Liên hệ hổ trợ</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                    <a href="DangNhap.php" class="text-decoration-none text-secondary hover-white fw-medium">Đăng nhập</a>
                    <a href="DangKy.php" class="btn btn-gradient px-4 py-2 rounded-3 fw-semibold">Đăng ký ngay</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="pricing-section">
        <h2 style="font-size: 32px; margin-bottom: 50px;">Chọn gói phù hợp với phòng gym của bạn</h2>
        <div class="pricing-container">

            <!-- GÓI mien phi -->
            <div class="pricing-card" data-plan="Miễn phí 7 ngày">
                <h4>Gói miễn phí </h4>
                <div class="price">7 Ngày </div>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Full chức năng hệ thống </li>
                    <li><i ></i> </li>
                    <li><i ></i> </li>
                </ul>
                <button class="btn-select btn-default">Dùng thử ngay</button>
            </div>

            <!-- GÓI CƠ BẢN -->
            <div class="pricing-card" data-plan="basic">
                <h4>Gói Cơ Bản</h4>
                <div class="price">300K <span>/tháng</span></div>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Quản lý hội viên</li>
                    <li><i class="fa-solid fa-check"></i> Quản lý gói tập</li>
                    <li><i class="fa-solid fa-check"></i> Điểm danh QR</li>
                    <li><i class="fa-solid fa-check"></i> Tài chính cơ bản</li>
                    
                </ul>
                
                <button class="btn-select btn-default">Đăng ký ngay</button>
            </div>

            <!-- GÓI NÂNG CAO -->
            <div class="pricing-card" data-plan="advanced">
                <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #7c3aed; padding: 4px 15px; border-radius: 20px; font-size: 11px; font-weight: 700;">Khuyên Dùng</div>
                <h4>Gói Nâng Cao</h4>
                <div class="price">500K <span>/tháng</span></div>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Tất cả chức năng gói cơ bản</li>
                    <li><i class="fa-solid fa-check"></i> Điểm danh khuôn mặt</li>
                    <li><i class="fa-solid fa-check"></i> Quản lý nhân viên</li>
                    <li><i class="fa-solid fa-check"></i> Báo cáo chuyên sâu</li>
                </ul>
                <button class="btn-select btn-pro">Đăng ký ngay</button>
            </div>

            <!-- GÓI CHUYÊN NGHIỆP -->
            <div class="pricing-card" data-plan="pro">
                <h4>Gói Chuyên Nghiệp</h4>
                <div class="price">1.000K <span>/tháng</span></div>
                
                <ul>
                    <li><i class="fa-solid fa-check"></i> Tất cả chức năng gói nâng cao</li>
                    <li><i class="fa-solid fa-check"></i> Tích điểm hội viên</li>
                    <li><i class="fa-solid fa-check"></i> Hỗ trợ ưu tiên 24/7</li>
                    <li><i class="fa-solid fa-check"></i> Tùy chỉnh theo nhu cầu</li>
                </ul>

                <button class="btn-select btn-default">Đăng ký ngay</button>
            </div>

        </div>
    </section>

    <section class="form-section" id="register-form">
        <div class="register-card">

            <div class="icon-header" style="text-align: center; margin-bottom: 20px;">
                <i class="fa-solid fa-dumbbell" style="font-size: 24px; color: white;"></i>
            </div>

            <h2 style="text-align: center; margin-bottom: 10px;">ĐĂNG KÝ HỆ THỐNG</h2>
            <p style="text-align: center; color: #94a3b8; margin-bottom: 30px;">Bắt đầu quản lý chuyên nghiệp ngay hôm
                nay</p>

            <div class="plan-alert" id="planAlert">
                Bạn đã chọn gói: <span id="selectedName"></span>
            </div>

            <form class="grid-form">
                <div class="input-group"><i class="fa-regular fa-user"></i><input id="ho_ten" type="text" placeholder="Họ và tên">
                </div>

                <div class="input-group"><i class="fa-solid fa-phone"></i><input id="so_dien_thoai" type="text"
                        placeholder="Số điện thoại"></div>

                <div class="input-group"><i class="fa-solid fa-building"></i><input id="ten_phong_tap" type="text"
                        placeholder="Tên phòng tập"></div>

                <div class="input-group"><i class="fa-solid fa-lock"></i><input id="mat_khau" type="password" placeholder="Mật khẩu">
                </div>

                <div class="input-group"><i class="fa-regular fa-envelope"></i><input id="email" type="email" placeholder="Email">
                </div>

                <div class="input-group"><i class="fa-solid fa-key"></i><input id="xac_nhan_mat_khau" type="password"
                        placeholder="Xác nhận mật khẩu"></div>


                <button id = "dang_ky" type="submit" class="btn-submit"> Đăng ký ngay <i class="fa-solid fa-user-plus"
                        style="margin-left: 10px;"></i></button>

            </form>
            <div class="login-link">
                Đã có tài khoản? <a href="DangNhap.php">Đăng nhập tại đây</a>
            </div>
        </div>
    </section>

     <footer class="bottom-footer">
        © 2026 GYMPRO MANAGEMENT SYSTEM
    </footer>

    <script>
        const cards = document.querySelectorAll('.pricing-card');
        const planAlert = document.getElementById('planAlert');
        const selectedName = document.getElementById('selectedName');

        const planNames = {
            'basic':    'Cơ Bản (300K/tháng)',
            'advanced': 'Nâng Cao (500K/tháng)',
            'pro':      'Chuyên Nghiệp (1.000K/tháng)'
        };

        function selectCard(planKey) {
            cards.forEach(c => {
                c.classList.remove('active');
                c.querySelector('.btn-select').innerText = 'Đăng ký ngay';
            });

            const target = document.querySelector(`.pricing-card[data-plan="${planKey}"]`);
            if (target) {
                target.classList.add('active');
                target.querySelector('.btn-select').innerText = 'Đã chọn gói này';
                selectedName.innerText = planNames[planKey] || planKey;
                planAlert.style.display = 'block';
            }
        }

        // Click thủ công
        cards.forEach(card => {
            card.querySelector('.btn-select').addEventListener('click', () => {
                selectCard(card.getAttribute('data-plan'));
                document.getElementById('register-form').scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });

        // Auto-select từ URL: DangKy.php?goi=standard
        const params = new URLSearchParams(window.location.search);
        const goiParam = params.get('goi');
        if (goiParam && planNames[goiParam]) {
            selectCard(goiParam);
            // Scroll nhẹ xuống form sau 300ms để UX mượt
            setTimeout(() => {
                document.getElementById('register-form').scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>