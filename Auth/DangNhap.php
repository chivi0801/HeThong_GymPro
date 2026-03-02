<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Đăng nhập quản trị</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
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
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(10, 15, 30, 0.85);
            z-index: 0;
        }

        /* Header & Footer */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 80px;
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--glass-border);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 20px;
        }

        .logo i {
            background: var(--primary-gradient);
            padding: 8px;
            border-radius: 8px;
            transform: rotate(45deg);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        nav a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-signup-nav {
            background: var(--primary-gradient);
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        /* Main Login Card */
        .auth-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            padding: 100px 20px;
        }

        .login-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 24px;
            backdrop-filter: blur(20px);
            text-align: center;
        }

        .icon-header {
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(37, 99, 235, 0.1);
            border: 1px solid rgba(37, 99, 235, 0.3);
            border-radius: 50%;
            color: #3b82f6;
            font-size: 24px;
        }

        .icon-header i {
            transform: rotate(45deg);
        }

        h2 {
            font-size: 22px;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 30px;
        }

        /* Form Elements */
        .input-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            color: #cbd5e1;
            margin-bottom: 8px;
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .forgot-link {
            color: #3b82f6;
            text-decoration: none;
            font-size: 12px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i:first-child {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            cursor: pointer;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 45px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            color: white;
            outline: none;
            transition: 0.3s;
        }

        .input-wrapper input:focus {
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.08);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            text-align: left;
            font-size: 13px;
            color: #94a3b8;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: none;
            background: var(--primary-gradient);
            color: white;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .login-footer {
            margin-top: 25px;
            font-size: 13px;
            color: #94a3b8;
        }

        .login-footer a {
            color: #3b82f6;
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

    <header>
        <div class="logo"><i class="fa-solid fa-dumbbell"></i> GymPro</div>
        <nav>
            <ul>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Liên hệ hỗ trợ</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <a href="DangNhap.php"
                style="color: white; text-decoration: none; font-size: 14px; margin-right: 20px;">Đăng nhập</a>
            <a href="DangKy.php" class="btn-signup-nav">Đăng ký ngay</a>
        </div>
    </header>

    <main class="auth-container">
        <div class="login-card">
            <div class="icon-header">
                <i class="fa-solid fa-dumbbell"></i>
            </div>
            <h2>CHÀO MỪNG BẠN TRỞ LẠI</h2>
            <p class="subtitle">Đăng Nhập Quản Trị</p>

            <form id="loginForm">
                <div class="input-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" placeholder="Nhập email của bạn" required>
                    </div>
                </div>

                <div class="input-group">
                    <div class="label-row">
                        <label>Mật khẩu</label>
                        <a href="#" class="forgot-link">Quên mật khẩu?</a>
                    </div>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" placeholder="Nhập mật khẩu" required>
                        <i class="fa-regular fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember">
                    <label for="remember">Ghi nhớ đăng nhập</label>
                </div>

                <button type="submit" class="btn-submit">
                    Đăng nhập <i class="fa-solid fa-right-to-bracket"></i>
                </button>
            </form>

            <div class="login-footer">
                Bạn chưa có hệ thống? <a href="DangKy.php">Đăng ký phòng tập mới</a>
            </div>
        </div>
    </main>

    <footer class="bottom-footer">
        © 2026 GYMPRO MANAGEMENT SYSTEM • PREMIUM EDITION
    </footer>

    <script src="script.js"></script>
</body>

</html>