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
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Dang nhap quan tri</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(90deg, #2563eb, #7c3aed);
            --glass-bg: rgba(15, 23, 42, 0.8);
            --glass-border: rgba(255, 255, 255, 0.1);
            --error-bg: rgba(239, 68, 68, 0.15);
            --error-border: rgba(239, 68, 68, 0.4);
            --error-text: #fecaca;
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
            margin-bottom: 20px;
        }

        .error-box {
            margin-bottom: 18px;
            padding: 10px 12px;
            border-radius: 10px;
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            color: var(--error-text);
            font-size: 13px;
            text-align: left;
        }

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
        <div>
            <a href="DangKy.php" style="color: white; text-decoration: none; font-size: 14px;">Dang ky ngay</a>
        </div>
    </header>

    <main class="auth-container">
        <div class="login-card">
            <div class="icon-header">
                <i class="fa-solid fa-dumbbell"></i>
            </div>
            <h2>CHAO MUNG BAN TRO LAI</h2>
            <p class="subtitle">Dang nhap quan tri phong gym</p>

            <?php if ($error !== ''): ?>
                <div class="error-box"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form id="loginForm" method="post" action="">
                <div class="input-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-envelope"></i>
                        <input
                            type="email"
                            name="email"
                            value="<?php echo htmlspecialchars($emailValue, ENT_QUOTES, 'UTF-8'); ?>"
                            placeholder="Nhap email cua ban"
                            required>
                    </div>
                </div>

                <div class="input-group">
                    <div class="label-row">
                        <label>Mat khau</label>
                        <a href="QuenMatKhau.php" class="forgot-link">Quen mat khau?</a>
                    </div>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="mat_khau" placeholder="Nhap mat khau" required>
                        <i class="fa-regular fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember" <?php echo isset($_POST['remember']) || isset($_COOKIE['remember_email']) ? 'checked' : ''; ?>>
                    <label for="remember">Ghi nho email dang nhap</label>
                </div>

                <button type="submit" class="btn-submit">
                    Dang nhap <i class="fa-solid fa-right-to-bracket"></i>
                </button>
            </form>

            <div class="login-footer">
                Ban chua co he thong? <a href="DangKy.php">Dang ky phong tap moi</a>
            </div>
        </div>
    </main>

    <footer class="bottom-footer">
        © 2026 GYMPRO MANAGEMENT SYSTEM
    </footer>

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
