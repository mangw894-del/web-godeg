<?php
session_start(); 
include 'config.php';

if (isset($_POST['login'])) {
    $u = mysqli_real_escape_string($koneksi, $_POST['username']);
    $p = md5($_POST['password']);

    $q = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$u' AND password='$p'");

    if (!$q) {
        die("Query error: " . mysqli_error($koneksi));
    }

    $d = mysqli_fetch_assoc($q);

    if ($d) {
        $_SESSION['login']    = true;
        $_SESSION['id']       = $d['id'];
        $_SESSION['username'] = $d['username'];
        $_SESSION['role']     = $d['role'];

        if (function_exists('catat_log')) {
            catat_log($koneksi, "Berhasil Login ke Sistem", "Auth");
        }

        if ($d['role'] === 'admin') {
            header("Location: admin/dashboard_admin.php");
        } else {
            header("Location: member/dashboard_member.php");
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perpustakaan - Dark Theme</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;

            background: #f4f7fe;
        }
/
        .login-card {
            background: #1a1c2e;
            max-width: 420px;
            padding: 50px 40px;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(26, 28, 46, 0.3);
            position: relative;
            overflow: hidden;
        }

        /* Dekorasi biar gak kaku */
        .login-card::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
        }

        .login-card h2 {
            color: #ffffff;
            font-weight: 700;
            font-size: 26px;
            text-align: center;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .login-card p {
            color: #a0aec0;
            text-align: center;
            font-size: 14px;
            margin-bottom: 35px;
        }

        .form-label {
            display: block;
            color: #cbd5e0;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            margin-left: 5px;
        }

        .input-group {
            margin-bottom: 25px;
        }

        .login-card input {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.05); 
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .login-card input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #4e73df;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.2);
        }

        .login-card input::placeholder {
            color: #718096;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: #4e73df; 
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(78, 115, 223, 0.3);
        }

        .error-box {
            background: rgba(231, 74, 59, 0.1);
            color: #ff7675;
            padding: 12px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid rgba(231, 74, 59, 0.2);
        }

        .footer-text {
            text-align: center;
            margin-top: 30px;
            font-size: 13px;
            color: #a0aec0;
        }

        .footer-text a {
            color: #4e73df;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-card">
    <form method="post">
        <h2>PERPUSTAKAAN</h2>
        <p>Login to Access Your Panel</p>

        <?php if (isset($error)): ?>
            <div class="error-box">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <div class="input-group">
            <label class="form-label">Username</label>
            <input type="text" name="username" placeholder="Enter username" required autocomplete="off">
        </div>

        <div class="input-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" placeholder="Enter password" required>
        </div>
        
        <button type="submit" name="login" class="btn-login">SIGN IN</button>
        
        <div class="footer-text">
            Don't have an account? <a href="register.php">Register Now</a>
        </div>
    </form>
</div>

</body>
</html>