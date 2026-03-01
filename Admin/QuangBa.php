<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Nâng tầm quản lý</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        
        /* === GLOBAL VARIABLES === */
        :root {
            --bg-dark: #121521;
            --bg-card: #1a1e2d;
            --bg-input: #23283c;
            --primary-gradient: linear-gradient(90deg, #4f46e5, #8b5cf6, #ec4899);
            --blue-purple-gradient: linear-gradient(90deg, #3b82f6, #8b5cf6);
            --text-main: #ffffff;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.08);
            --glow-color: rgba(139, 92, 246, 0.3);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px; margin: 0 auto; padding: 0 24px;
        }

        a { text-decoration: none; color: inherit; transition: 0.3s; }
        ul { list-style: none; }

        /* === HEADER === */
        header {
            position: fixed; top: 0; width: 100%; z-index: 1000;
            background: rgba(18, 21, 33, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
        }
        .header-content {
            display: flex; justify-content: space-between; align-items: center;
            height: 70px;
        }
        .logo { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 20px; }
        .logo .icon-box {
            background: var(--blue-purple-gradient); padding: 6px; border-radius: 6px;
            display: flex; align-items: center; justify-content: center; transform: rotate(45deg);
        }
        .logo i { transform: rotate(-45deg); font-size: 14px; }
        
        nav ul { display: flex; gap: 40px; }
        nav a { font-size: 14px; font-weight: 500; color: var(--text-muted); }
        nav a:hover { color: var(--text-main); }

        .auth-actions { display: flex; align-items: center; gap: 20px; }
        .btn-login { font-size: 14px; font-weight: 500; }
        .btn-register {
            background: var(--blue-purple-gradient); color: white;
            padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600;
            border: none; cursor: pointer; transition: 0.3s opacity;
        }
        .btn-register:hover { opacity: 0.9; }

        /* === HERO SECTION === */
        .hero { padding: 160px 0 80px; }
        .hero-content {
            display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;
        }
        .badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.2);
            padding: 6px 16px; border-radius: 30px; font-size: 12px; font-weight: 600;
            color: #a78bfa; margin-bottom: 24px;
        }
        .hero h1 { font-size: 48px; line-height: 1.2; font-weight: 700; margin-bottom: 20px; }
        .gradient-text {
            background: var(--blue-purple-gradient);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero p { color: var(--text-muted); font-size: 16px; margin-bottom: 32px; max-width: 90%; }
        .btn-hero {
            background: var(--blue-purple-gradient); color: white;
            padding: 14px 32px; border-radius: 10px; font-size: 16px; font-weight: 600;
            border: none; cursor: pointer;
        }
        .hero-img {
            width: 100%; border-radius: 20px; box-shadow: 0 0 40px var(--glow-color);
        }

        /* === FEATURES === */
        .features { padding: 80px 0; text-align: center; }
        .section-title { font-size: 32px; font-weight: 700; margin-bottom: 10px; }
        .section-subtitle { color: var(--text-muted); margin-bottom: 50px; font-size: 15px; }

        .feature-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }
        .feature-card {
            background: var(--bg-card); border: 1px solid var(--border-color);
            border-radius: 20px; padding: 32px 24px; text-align: left;
        }
        .feature-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 20px; margin-bottom: 20px;
        }
        .feature-card h3 { font-size: 18px; margin-bottom: 12px; font-weight: 600; }
        .feature-card p { color: var(--text-muted); font-size: 14px; margin-bottom: 20px; }
        .feature-card img { width: 100%; border-radius: 12px; border: 1px solid var(--border-color); }

        /* === PRICING === */
        .pricing { padding: 80px 0; text-align: center; }
        .pricing-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 50px; }
        
        .price-card {
            background: var(--bg-card); border: 1px solid var(--border-color);
            border-radius: 24px; padding: 40px 32px; text-align: left; position: relative;
        }
        .price-card.popular {
            border: 1px solid transparent;
            background: linear-gradient(var(--bg-card), var(--bg-card)) padding-box,
                        var(--blue-purple-gradient) border-box;
            box-shadow: 0 0 30px var(--glow-color);
            transform: translateY(-10px);
        }
        .badge-popular {
            position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
            background: var(--blue-purple-gradient); padding: 6px 16px; border-radius: 20px;
            font-size: 12px; font-weight: 700;
        }
        
        .plan-name { font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }
        .price { font-size: 40px; font-weight: 700; margin: 15px 0 25px; }
        .price span { font-size: 16px; color: var(--text-muted); font-weight: 400; }
        
        .price-card ul { margin-bottom: 30px; }
        .price-card li { display: flex; gap: 12px; margin-bottom: 16px; font-size: 14px; color: #cbd5e1; align-items: center; }
        .price-card li i { color: #3b82f6; font-size: 14px; }
        
        .btn-price {
            width: 100%; padding: 14px; border-radius: 12px; font-weight: 600; text-align: center; cursor: pointer; transition: 0.3s;
        }
        .btn-outline { background: rgba(255,255,255,0.05); color: white; border: 1px solid var(--border-color); }
        .btn-outline:hover { background: rgba(255,255,255,0.1); }
        .btn-fill { background: var(--blue-purple-gradient); color: white; border: none; }

        /* === REGISTRATION FORM === */
        .registration { padding: 80px 0; }
        .reg-box {
            background: linear-gradient(180deg, #1e253c 0%, #151929 100%);
            border: 1px solid var(--border-color); border-radius: 24px;
            padding: 60px; max-width: 900px; margin: 0 auto;
        }
        .reg-header { text-align: center; margin-bottom: 40px; }
        .reg-header h2 { font-size: 28px; font-weight: 700; margin-bottom: 10px; }
        .reg-header p { color: var(--text-muted); font-size: 14px; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .input-group { display: flex; flex-direction: column; gap: 8px; }
        .input-group label { font-size: 13px; font-weight: 500; color: #cbd5e1; }
        .input-wrapper { position: relative; }
        .input-wrapper input {
            width: 100%; background: var(--bg-input); border: 1px solid var(--border-color);
            padding: 14px 16px; border-radius: 10px; color: white; outline: none; font-size: 14px;
        }
        .input-wrapper input:focus { border-color: #8b5cf6; }
        
        .btn-submit {
            grid-column: 1 / -1; background: var(--blue-purple-gradient); border: none;
            color: white; padding: 16px; border-radius: 10px; font-weight: 600; font-size: 16px;
            cursor: pointer; margin-top: 10px; transition: 0.3s;
        }
        .btn-submit:hover { opacity: 0.9; box-shadow: 0 0 20px var(--glow-color); }
        .login-link { text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-muted); }
        .login-link a { color: #3b82f6; }

        /* === FOOTER === */
        footer { padding: 60px 0 30px; border-top: 1px solid var(--border-color); margin-top: 80px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .footer-brand p { color: var(--text-muted); font-size: 13px; margin-top: 16px; max-width: 80%; }
        .footer-col h4 { font-size: 15px; font-weight: 600; margin-bottom: 20px; }
        .footer-col ul li { margin-bottom: 12px; }
        .footer-col ul li a, .footer-col p { color: var(--text-muted); font-size: 14px; }
        .social-icons { display: flex; gap: 15px; }
        .social-icons a { 
            width: 36px; height: 36px; border-radius: 50%; background: var(--bg-card);
            display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color);
        }
        .copyright { text-align: center; padding-top: 30px; border-top: 1px solid var(--border-color); color: var(--text-muted); font-size: 12px; letter-spacing: 1px; }

    </style>
</head>
<body>

    <header>
        <div class="container header-content">
            <div class="logo">
                <div class="icon-box"><i class="fa-solid fa-dumbbell"></i></div>
                GymPro
            </div>
            <nav>
                <ul>
                    <li><a href="#">Giới thiệu</a></li>
                    <li><a href="#">Liên hệ hỗ trợ</a></li>
                </ul>
            </nav>
            <div class="auth-actions">
                <a href="#" class="btn-login">Đăng nhập</a>
                <button class="btn-register">Đăng ký ngay</button>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container hero-content">
            <div class="hero-text">
                <div class="badge"><i class="fa-solid fa-check-circle"></i> GIẢI PHÁP SỐ 1 VIỆT NAM</div>
                <h1>Nâng tầm quản lý<br><span class="gradient-text">Bứt phá doanh thu</span></h1>
                <p>Hệ thống quản lý phòng gym chuyên nghiệp nhất hiện nay. Tự động hóa quy trình, tối ưu chi phí và tăng trải nghiệm khách hàng chỉ trên một nền tảng duy nhất.</p>
                <button class="btn-hero">Dùng thử miễn phí ngay</button>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2070&auto=format&fit=crop" alt="Dashboard" class="hero-img">
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2 class="section-title">Tính năng đột phá</h2>
            <p class="section-subtitle">Thiết kế để tối ưu hóa hiệu suất vận hành</p>
            
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-chart-pie"></i></div>
                    <h3>Dashboard Thông Minh</h3>
                    <p>Giao diện trực quan, hiển thị đầy đủ các chỉ số quan trọng ngay khi bạn đăng nhập.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;"><i class="fa-solid fa-expand"></i></div>
                    <h3>Check-In Siêu Tốc</h3>
                    <p>Nhận diện khuôn mặt, AI hỗ trợ vào phòng tập trong chưa đầy 1.0 giây.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(236, 72, 153, 0.1); color: #ec4899;"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                    <h3>Báo Cáo Chuyên Sâu</h3>
                    <p>Tự động xuất báo cáo doanh thu, công nợ và tỷ lệ giữ chân khách hàng định kỳ.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="pricing">
        <div class="container">
            <h2 class="section-title">Gói dịch vụ</h2>
            <p class="section-subtitle">Phù hợp cho mọi quy mô từ phòng đơn đến chuỗi hệ thống</p>

            <div class="pricing-grid">
                <div class="price-card">
                    <div class="plan-name">DÙNG THỬ</div>
                    <div class="price">Miễn phí <span>/7 ngày</span></div>
                    <ul>
                        <li><i class="fa-regular fa-circle-check"></i> Dùng thử toàn bộ chức năng</li>
                        <li><i class="fa-regular fa-circle-check"></i> Quản lý 50 hội viên cơ bản</li>
                        <li><i class="fa-regular fa-circle-check"></i> Báo cáo doanh thu ngày</li>
                    </ul>
                    <button class="btn-price btn-outline">Bắt đầu ngay</button>
                </div>

                <div class="price-card popular">
                    <div class="badge-popular">PHỔ BIẾN NHẤT</div>
                    <div class="plan-name" style="color: #a78bfa;">TIÊU CHUẨN</div>
                    <div class="price">499k <span>/tháng</span></div>
                    <ul>
                        <li><i class="fa-regular fa-circle-check"></i> Tất cả tính năng gói cơ bản</li>
                        <li><i class="fa-regular fa-circle-check"></i> Điểm danh khuôn mặt</li>
                        <li><i class="fa-regular fa-circle-check"></i> Quản lý quầy hàng & phụ kiện</li>
                        <li><i class="fa-regular fa-circle-check"></i> Quản lý tài chính, nhân viên</li>
                    </ul>
                    <button class="btn-price btn-fill">Đăng ký ngay</button>
                </div>

                <div class="price-card">
                    <div class="plan-name">CHUYÊN NGHIỆP</div>
                    <div class="price">999k <span>/tháng</span></div>
                    <ul>
                        <li><i class="fa-regular fa-circle-check"></i> Mở khóa tính năng giữ liệu chuẩn</li>
                        <li><i class="fa-regular fa-circle-check"></i> Quản lý PT không giới hạn</li>
                        <li><i class="fa-regular fa-circle-check"></i> Tích điểm hội viên</li>
                        <li><i class="fa-regular fa-circle-check"></i> Hỗ trợ ưu tiên</li>
                    </ul>
                    <button class="btn-price btn-outline">Liên hệ</button>
                </div>
            </div>
        </div>
    </section>

    <section class="registration">
        <div class="container">
            <div class="reg-box">
                <div class="reg-header">
                    <h2>ĐĂNG KÝ NGAY</h2>
                    <p>Bắt đầu quản lý phòng tập chuyên nghiệp ngay hôm nay</p>
                </div>
                
                <form class="form-grid">
                    <div class="input-group">
                        <label>Họ và tên</label>
                        <div class="input-wrapper"><input type="text" placeholder="Nguyễn Văn A"></div>
                    </div>
                    <div class="input-group">
                        <label>Số điện thoại</label>
                        <div class="input-wrapper"><input type="text" placeholder="0123 456 789"></div>
                    </div>
                    <div class="input-group">
                        <label>Tên phòng tập</label>
                        <div class="input-wrapper"><input type="text" placeholder="GymPro Center"></div>
                    </div>
                    <div class="input-group">
                        <label>Mật khẩu</label>
                        <div class="input-wrapper"><input type="password" placeholder="••••••••"></div>
                    </div>
                    <div class="input-group">
                        <label>Email</label>
                        <div class="input-wrapper"><input type="email" placeholder="admin@vidu.com"></div>
                    </div>
                    <div class="input-group">
                        <label>Xác nhận mật khẩu</label>
                        <div class="input-wrapper"><input type="password" placeholder="••••••••"></div>
                    </div>
                    <button type="submit" class="btn-submit">Đăng ký ngay</button>
                </form>
                <div class="login-link">
                    Đã có tài khoản? <a href="#">Đăng nhập tại đây</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="logo">
                        <div class="icon-box" style="padding: 4px; border-radius: 4px;"><i class="fa-solid fa-dumbbell" style="font-size: 12px;"></i></div>
                        GymPro
                    </div>
                    <p>Hệ thống quản lý phòng gym hàng đầu, giúp chuyển đổi số doanh nghiệp thể thao tại Việt Nam.</p>
                </div>
                <div class="footer-col">
                    <h4>Liên hệ</h4>
                    <p><i class="fa-solid fa-phone" style="margin-right: 8px;"></i> 1900 6789</p>
                    <p><i class="fa-solid fa-envelope" style="margin-right: 8px; margin-top: 10px;"></i> contact@gympro.vn</p>
                </div>
                <div class="footer-col">
                    <h4>Đối tác chiến lược</h4>
                    <div style="display: flex; gap: 10px;">
                        <div style="width: 40px; height: 25px; background: #23283c; border-radius: 4px;"></div>
                        <div style="width: 40px; height: 25px; background: #23283c; border-radius: 4px;"></div>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Theo dõi chúng tôi</h4>
                    <div class="social-icons">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                © 2026 GYMPRO MANAGEMENT SYSTEM • PREMIUM EDITION
            </div>
        </div>
    </footer>

</body>
</html>