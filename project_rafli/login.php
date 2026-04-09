<?php
session_start(); // WAJIB ADA BIAR SESSION JALAN
include 'config.php';

if (isset($_POST['login'])) {
    $u = mysqli_real_escape_string($koneksi, $_POST['username']);
    
    // Perhatikan: Pastikan di database abang pakai md5 atau password_hash. 
    // Saya ikuti kode abang yang pakai md5:
    $p = md5($_POST['password']);

    $q = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$u' AND password='$p'");

    if (!$q) {
        die("Query error: " . mysqli_error($koneksi));
    }

    $d = mysqli_fetch_assoc($q);

    if ($d) {
        // Set Session
        $_SESSION['login']    = true;
        $_SESSION['id']       = $d['id'];
        $_SESSION['username'] = $d['username']; // Pakai 'username' biar sinkron sama fungsi log
        $_SESSION['role']     = $d['role'];

        // --- CATAT LOG LOGIN ---
        // Karena session baru dibuat, fungsi catat_log bakal ambil nama dari $_SESSION['username']
        catat_log($koneksi, "Berhasil Login ke Sistem", "Auth");

        // Redirect berdasarkan role
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
    <title>Login Perpustakaan</title>
    <style>
        /* CSS TETAP DI SINI BIAR GAK REPOT */
        body {
            margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(120deg, #4e73df, #1cc88a);
            font-family: 'Segoe UI', sans-serif;
        }
        .box {
            background: white; padding: 35px; width: 360px; border-radius: 14px;
            box-shadow: 0 20px 40px rgba(0,0,0,.25);
        }
        .box h2 { text-align: center; color: #4e73df; margin-bottom: 20px; }
        .box input {
            width: 100%; padding: 12px; margin: 10px 0; border-radius: 8px;
            border: 1px solid #ccc; outline: none;
        }
        .box input:focus { border-color: #4e73df; }
        .box button {
            width: 100%; padding: 12px; background: #1cc88a; border: none;
            color: white; border-radius: 8px; font-weight: 600; cursor: pointer;
            margin-top: 10px; transition: 0.3s;
        }
        .box button:hover { background: #17a673; }
        .error {
            background: #fee2e2; color: #b91c1c; padding: 10px;
            border-radius: 8px; margin-bottom: 12px; text-align: center; font-size: 14px;
        }
        .reg-link { text-align: center; margin-top: 15px; font-size: 14px; }
        .reg-link a { color: #4e73df; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="box">
    <form method="post">
        <h2>Silahkan Login</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Username" required autocomplete="off">
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit" name="login">Masuk Sekarang</button>
        
        <div class="reg-link">
            Belum punya akun? <a href="register.php">Daftar</a>
        </div>
    </form>
</div>

</body>
</html>