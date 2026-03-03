<!DOCTYPE html>
<html lang="vi" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Nâng tầm quản lý</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Tùy chỉnh CSS để giữ "hồn" của Figma trên nền Bootstrap */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a; /* Nền xanh đen sâu */
            color: #f8fafc;
        }

        /* Tiện ích (Utilities) */
        .text-gradient {
            background: linear-gradient(to right, #60a5fa, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-gradient-custom {
            background: linear-gradient(to right, #4f46e5, #9333ea);
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

        /* Navbar mờ (Glassmorphism) */
        .navbar-glass {
            background: rgba(15, 23, 42, 0.8) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(168, 85, 247, 0.1);
        }

        /* Card tùy chỉnh */
        .custom-card {
            background-color: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.25rem;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            border-color: rgba(168, 85, 247, 0.3);
        }

        /* Gói giá nổi bật */
        .card-pricing-featured {
            border: 2px solid #a855f7;
            position: relative;
            box-shadow: 0 10px 30px rgba(168, 85, 247, 0.15);
        }

        .badge-popular {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(to right, #6366f1, #a855f7);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
            letter-spacing: 1px;
            color: white;
        }

        /* Icon tính năng */
        .feature-icon {
            width: 50px;
            height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(168, 85, 247, 0.1);
            color: #a855f7;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Tùy chỉnh Bootstrap Carousel để ảnh đẹp hơn */
        .carousel-item img {
            height: 450px;
            object-fit: cover;
            border-radius: 1.25rem;
        }
        .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #a855f7;
        }

        /* ===== CSS DÀNH RIÊNG CHO FORM ĐĂNG KÝ MỚI ===== */
        .register-card-custom {
            background-color: #232d42; /* Màu xanh navy nhạt giống thiết kế */
            border-radius: 1.25rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .register-input-custom {
            background-color: #2b3344; /* Màu nền ô input tối hơn card một chút */
            border: none;
            color: #ffffff;
            padding: 0.8rem 1.2rem;
            border-radius: 0.5rem;
            font-size: 0.95rem;
        }

        .register-input-custom::placeholder {
            color: #64748b; /* Màu chữ placeholder xám mờ */
        }

        .register-input-custom:focus {
            background-color: #323b4f;
            color: #ffffff;
            box-shadow: 0 0 0 2px rgba(107, 128, 250, 0.5); /* Viền sáng nhẹ khi click */
            outline: none;
        }

        .btn-register-custom {
            background: linear-gradient(90deg, #6084ff 0%, #aa6cff 100%); /* Gradient từ xanh dương sang tím sáng */
            color: white;
            border: none;
            border-radius: 0.5rem;
            transition: opacity 0.3s ease;
        }

        .btn-register-custom:hover {
            color: white;
            opacity: 0.9;
        }

        .login-link-custom {
            color: #6b80fa;
        }

        .login-link-custom:hover {
            color: #8fa0ff;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-glass fixed-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold fs-4" href="#">
    
             <img src="../image/logo.png" alt="Logo GymPro" class="img-fluid" style="width: 100px; height: 50px;">
                
            </a>
            
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto fw-medium">
                    <li class="nav-item"><a class="nav-link active" href="#hero">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Liên hệ hổ trợ</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                    <a href="../Auth/DangNhap.php" class="text-decoration-none text-secondary hover-white">Đăng nhập</a>
                    <a href="#register" class="btn btn-gradient px-4 py-2 rounded-3 fw-semibold">Đăng ký ngay</a>
                </div>
            </div>
        </div>
    </nav>

    <section id="hero" class="pt-5 mt-5">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 mb-4 d-inline-block">
                        <i class="bi bi-star-fill me-1"></i> GIẢI PHÁP SỐ 1 VIỆT NAM
                    </span>
                    <h1 class="display-4 fw-bold lh-sm mb-4">
                        Nâng tầm quản lý <br>
                        <span class="text-gradient">Bứt phá doanh thu</span>
                    </h1>
                    <p class="lead text-secondary mb-5 fs-6">
                        Giải pháp phần mềm quản lý phòng tập chuyên nghiệp nhất hiện nay. Tự động hóa quy trình, tối ưu chi phí và gia tăng trải nghiệm hội viên trên một nền tảng duy nhất.
                    </p>
                    <a href="#register" class="btn btn-gradient px-5 py-3 rounded-3 fw-bold fs-5">Dùng thử miễn phí ngay</a>
                </div>
                
                <div class="col-lg-6">
                    <div id="heroCarousel" class="carousel slide carousel-fade shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-bs-interval="3000">
                                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1000&auto=format&fit=crop" class="d-block w-100" alt="Gym img 1">
                            </div>
                            <div class="carousel-item" data-bs-interval="3000">
                                <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?q=80&w=1000&auto=format&fit=crop" class="d-block w-100" alt="Gym img 2">
                            </div>
                            <div class="carousel-item" data-bs-interval="3000">
                                <img src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=1000&auto=format&fit=crop" class="d-block w-100" alt="Gym img 3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-5">
        <div class="container py-5 text-center">
            <h2 class="fw-bold fs-1 mb-3">Tính năng đột phá</h2>
            <p class="text-secondary mb-5">Thiết kế tối ưu cho mọi mô hình fitness club từ cơ bản đến nâng cao</p>
            
            <div class="row g-4 text-start">
                <div class="col-md-4">
                    <div class="card custom-card h-100 p-4 border-0">
                        <div class="card-body p-0 d-flex flex-column">
                            <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                            <h4 class="fw-bold mb-3">Dashboard Thông Minh</h4>
                            <p class="text-secondary mb-4">Quản lý doanh thu, hội viên, lịch tập qua biểu đồ trực quan, cập nhật real-time mọi lúc mọi nơi.</p>
                            <div class="rounded-4 overflow-hidden mt-auto shadow-sm">
                              <img src="https://images.unsplash.com/photo-1666875753105-c63a6f3bdc86?q=80&w=3000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA==" alt="Smart Analytics Dashboard" class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 16/9;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card custom-card h-100 p-4 border-0">
                        <div class="card-body p-0 d-flex flex-column">
                            <div class="feature-icon"><i class="bi bi-person-bounding-box"></i></div>
                            <h4 class="fw-bold mb-3">Check-in Face ID</h4>
                            <p class="text-secondary mb-4">Nhận diện khuôn mặt siêu tốc độ chống gian lận thẻ tập, tích hợp tự động mở cửa/barrier.</p>
                            <div class="rounded-4 overflow-hidden mt-auto shadow-sm">
                                <img src="https://play-lh.googleusercontent.com/sJUNXAopxk3RHmAi62IfCtBtdJwVWPoECsOGLleMSlBt6FF6zoTEM0v2Xa0SOd895w" alt="Face ID Check-in" class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 16/9;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card custom-card h-100 p-4 border-0">
                        <div class="card-body p-0 d-flex flex-column">
                            <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                            <h4 class="fw-bold mb-3">Bảo Mật Chuyên Sâu</h4>
                            <p class="text-secondary mb-4">Hệ thống phân quyền chi tiết cho cấp quản lý, PT, sale, và lễ tân đảm bảo an toàn dữ liệu.</p>
                            <div class="rounded-4 overflow-hidden mt-auto shadow-sm">
                               <img src="https://plus.unsplash.com/premium_photo-1681487769650-a0c3fbaed85a?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDEwfHx8ZW58MHx8fHx8" alt="Advanced Security" class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 16/9;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" class="py-5">
        <div class="container py-5 text-center">
            <h2 class="fw-bold fs-1 mb-3">Gói dịch vụ linh hoạt</h2>
            <p class="text-secondary mb-5">Phù hợp cho mọi quy mô phòng tập từ nhỏ đến hệ thống chuỗi</p>

            <div class="row g-4 align-items-center justify-content-center">

                <!-- GÓI CƠ BẢN -->
                <div class="col-lg-4 col-md-6">
                    <div class="card custom-card p-5 border-0 text-start">
                        <p class="text-uppercase text-secondary fw-bold small mb-2">Cơ Bản</p>
                        <h3 class="display-5 fw-bold mb-0">300K</h3>
                        <p class="text-secondary mb-4">/ tháng</p>
                        <ul class="list-unstyled mb-5 text-secondary">
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Quản lý hội viên</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Quét mã QR</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Tài chính cơ bản</li>
                        </ul>
                        <a href="../Auth/DangKy.php?goi=basic" class="btn btn-outline-light w-100 py-2 fw-semibold">Đăng ký ngay</a>
                    </div>
                </div>

                <!-- GÓI NÂNG CAO (nổi bật) -->
                <div class="col-lg-4 col-md-6">
                    <div class="card custom-card card-pricing-featured p-5 text-start z-1">
                        <span class="badge-popular">NÊN MUA</span>
                        <p class="text-uppercase fw-bold small mb-2 text-primary">Nâng Cao</p>
                        <h3 class="display-5 fw-bold mb-0">500K</h3>
                        <p class="text-secondary mb-4">/ tháng</p>
                        <ul class="list-unstyled mb-5">
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Điểm danh khuôn mặt</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Quản lý nhân viên</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Báo cáo chuyên sâu</li>
                        </ul>
                        <a href="../Auth/DangKy.php?goi=advanced" class="btn btn-gradient w-100 py-3 fw-bold fs-6">Đăng ký ngay</a>
                    </div>
                </div>

                <!-- GÓI CHUYÊN NGHIỆP -->
                <div class="col-lg-4 col-md-6">
                    <div class="card custom-card p-5 border-0 text-start">
                        <p class="text-uppercase text-secondary fw-bold small mb-2">Chuyên Nghiệp</p>
                        <h3 class="display-5 fw-bold mb-0">1.000K</h3>
                        <p class="text-secondary mb-4">/ tháng</p>
                        <ul class="list-unstyled mb-5 text-secondary">
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Tích điểm hội viên</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Hỗ trợ ưu tiên 24/7</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Tùy chỉnh thương hiệu</li>
                        </ul>
                        <a href="../Auth/DangKy.php?goi=pro" class="btn btn-outline-light w-100 py-2 fw-semibold">Đăng ký ngay</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="register" class="py-5 mb-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10"> 
                    <div class="register-card-custom p-4 p-md-5 border-0">
                        
                        <div class="text-center mb-5">
                            <h2 class="fw-bold fs-2 text-white">ĐĂNG KÝ NGAY</h2>
                            <p class="text-secondary mt-2 small">Bắt đầu quản lý phòng tập chuyên nghiệp ngay hôm nay</p>
                        </div>
                        
                        <form>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label text-white small mb-2">Họ và tên</label>
                                    <input type="text" class="form-control register-input-custom" placeholder="Nguyễn Văn A" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-white small mb-2">Số điện thoại</label>
                                    <input type="tel" class="form-control register-input-custom" placeholder="0123 456 789" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label text-white small mb-2">Tên phòng tập</label>
                                    <input type="text" class="form-control register-input-custom" placeholder="GymPro Center" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-white small mb-2">Mật khẩu</label>
                                    <input type="password" class="form-control register-input-custom" placeholder="********" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-white small mb-2">Email</label>
                                    <input type="email" class="form-control register-input-custom" placeholder="admin@vidu.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-white small mb-2">Xác nhận mật khẩu</label>
                                    <input type="password" class="form-control register-input-custom" placeholder="********" required>
                                </div>
                                
                                <div class="col-12 mt-4 pt-2 text-center">
                                    <button type="submit" class="btn btn-register-custom py-3 fw-bold fs-6 w-100">Đăng ký ngay</button>
                                </div>

                                <div class="col-12 mt-4 text-center">
                                    <p class="small text-secondary mb-0">Đã có tài khoản? <a href="#" class="text-decoration-none login-link-custom">Đăng nhập tại đây</a></p>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark pt-5 pb-4 mt-5 border-top border-secondary border-opacity-25">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3 text-white d-flex align-items-center">
                        <i class="bi bi-activity text-primary me-2"></i> GymPro
                    </h5>
                    <p class="text-secondary small">Hệ thống quản lý phòng gym hàng đầu, giúp tự động hóa và chuyển đổi số cho doanh nghiệp fitness tại Việt Nam.</p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3 text-white">Sản phẩm</h6>
                    <ul class="list-unstyled text-secondary small">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary hover-white">Tính năng</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary hover-white">Bảng giá</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary hover-white">Cập nhật</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3 text-white">Liên hệ</h6>
                    <ul class="list-unstyled text-secondary small">
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> 1900 68xx</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="a1c2cecfd5c0c2d5e1c6d8ccd1d3ce8fd7cf">[email&#160;protected]</a></li>
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Tòa nhà ABC, Hà Nội</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3 text-white">Kết nối</h6>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-secondary rounded-circle btn-sm"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-secondary rounded-circle btn-sm"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="btn btn-outline-secondary rounded-circle btn-sm"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center pt-4 border-top border-secondary border-opacity-25 text-secondary small">
                <p class="mb-0">&copy; 2026 GYMPRO MANAGEMENT SYSTEM. Tích hợp bởi Bootstrap 5.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>