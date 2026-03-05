<?php
session_start();

if (isset($_SESSION['chu_gym_id'])) {
    header('Location: ../Admin/TongQuan.php');
    exit;
}

$error = '';
$emailValue = $_COOKIE['remember_email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $matKhau = (string)($_POST['mat_khau'] ?? '');
    $remember = isset($_POST['remember']);
    $emailValue = $email;

    if ($email === '' || $matKhau === '') {
        $error = 'Vui long nhap day du email va mat khau.';
    } else {
        $conn = @new mysqli('localhost', 'root', '', 'gym_pro');

        if ($conn->connect_error) {
            $error = 'Khong the ket noi CSDL. Vui long kiem tra MySQL va cau hinh.';
        } else {
            $conn->set_charset('utf8mb4');

            $sql = "SELECT id, ten_phong, ho_ten_chu, email, mat_khau, trang_thai FROM chu_gym WHERE email = ? LIMIT 1";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                $error = 'Loi he thong khi xu ly dang nhap.';
            } else {
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result ? $result->fetch_assoc() : null;
                $stmt->close();

                if (!$user) {
                    $error = 'Email hoac mat khau khong dung.';
                } else {
                    if ($user['trang_thai'] !== 'active') {
                        if ($user['trang_thai'] === 'pending') {
                            $error = 'Tai khoan dang cho kich hoat. Vui long lien he ho tro.';
                        } elseif ($user['trang_thai'] === 'expired') {
                            $error = 'Tai khoan da het han. Vui long gia han de tiep tuc su dung.';
                        } else {
                            $error = 'Tai khoan khong hop le de dang nhap.';
                        }
                    } else {
                        $stored = (string)$user['mat_khau'];
                        $isValidPassword = password_verify($matKhau, $stored) || ($matKhau === $stored);

                        if (!$isValidPassword) {
                            $error = 'Email hoac mat khau khong dung.';
                        } else {
                            session_regenerate_id(true);
                            $_SESSION['chu_gym_id'] = (int)$user['id'];
                            $_SESSION['chu_gym_email'] = $user['email'];
                            $_SESSION['chu_gym_ten_phong'] = $user['ten_phong'];
                            $_SESSION['chu_gym_ho_ten'] = $user['ho_ten_chu'];

                            if ($remember) {
                                setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
                            } else {
                                setcookie('remember_email', '', time() - 3600, '/');
                            }

                            $conn->close();
                            header('Location: ../Admin/TongQuan.php');
                            exit;
                        }
                    }
                }
            }

            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Đăng nhập quản trị</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
            background: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
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

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 70px);
            padding: 40px 20px;
            margin-top: 70px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
        }

        .login-card {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(168, 85, 247, 0.2);
            border-radius: 1.25rem;
            backdrop-filter: blur(20px);
            padding: 45px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(168, 85, 247, 0.1);
            border: 1px solid rgba(168, 85, 247, 0.3);
            border-radius: 50%;
            color: #a855f7;
            font-size: 28px;
        }

        .login-header h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #f8fafc;
        }

        .login-header p {
            color: #94a3b8;
            font-size: 14px;
            margin: 0;
        }

        .error-box {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fecaca;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #cbd5e1;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .forgot-link {
            color: #3b82f6;
            text-decoration: none;
            font-size: 12px;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #60a5fa;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .input-wrapper i:first-child {
            left: 15px;
        }

        .toggle-password {
            right: 15px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #a855f7;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px 45px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: white;
            outline: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .form-control-custom::placeholder {
            color: #64748b;
        }

        .form-control-custom:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #a855f7;
            box-shadow: 0 0 0 2px rgba(168, 85, 247, 0.2);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            font-size: 13px;
            color: #94a3b8;
        }

        .checkbox-group input[type="checkbox"] {
            accent-color: #a855f7;
            cursor: pointer;
            width: 16px;
            height: 16px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, #2563eb, #7c3aed);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #94a3b8;
        }

        .login-footer a {
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #60a5fa;
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

    <!-- Login Section -->
    <div class="login-container">
        <div class="login-wrapper">
            <div class="login-card">

                <div class="login-header">

                     <div>
                        <img src="../image/logo.png" alt="Logo GymPro" class="img-fluid" style="width: 200px; height: 100px;">
                    </div>

                    <h2>CHÀO MỪNG TRỞ LẠI</h2>
                    <p>Đăng nhập để quản lý phòng Gym ngay</p>

                </div>

                <?php if ($error !== ''): ?>
                    <div class="error-box"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <form id="loginForm" method="post" action="">
                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-envelope"></i>
                            <input
                                type="email"
                                class="form-control-custom"
                                name="email"
                                value="<?php echo htmlspecialchars($emailValue, ENT_QUOTES, 'UTF-8'); ?>"
                                placeholder="Nhập email của bạn"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-row">
                            <label>Mật khẩu</label>
                            <a href="QuenMatKhau.php" class="forgot-link">Quên mật khẩu?</a>
                        </div>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input  id="password" class="form-control-custom" name="mat_khau" placeholder="Nhập mật khẩu" required >
                            <i class="fa-regular fa-eye toggle-password" id="togglePassword"></i>
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="remember" name="remember" <?php echo isset($_POST['remember']) || isset($_COOKIE['remember_email']) ? 'checked' : ''; ?>>
                        <label for="remember" style="margin: 0; cursor: pointer;">Ghi nhớ đăng nhập</label>
                    </div>

                    <button type="submit" class="btn-login">
                        Đăng nhập <i class="fa-solid fa-right-to-bracket"></i>
                    </button>
                </form>

                <div class="login-footer">
                    Bạn chưa có tài khoản?
                    <a href="DangKy.php">Đăng ký ngay</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="bottom-footer">
        © 2026 GYMPRO MANAGEMENT SYSTEM
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>

</html>
