<?php
include 'config.php';

if(isset($_POST['register'])){
  $username = mysqli_real_escape_string($koneksi, $_POST['username']);
  $password = $_POST['password'];
  $confirm  = $_POST['confirm'];

  $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
  if(mysqli_num_rows($cek) > 0){
    $error = "Username sudah digunakan!";
  } elseif($password != $confirm){
    $error = "Password tidak sama!";
  } else {
    $pass = md5($password);
    $query = mysqli_query($koneksi,
      "INSERT INTO users (username,password,role)
       VALUES ('$username','$pass','user')"
    );

    if($query){
        echo "<script>alert('Pendaftaran Berhasil!'); window.location='login.php';</script>";
        exit;
    } else {
        $error = "Gagal mendaftar!";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Member - Dark Theme</title>
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

        /* Container Register warna Biru Navy Sidebar */
        .register-card {
            background: #1a1c2e;
            width: 100%;
            max-width: 420px;
            padding: 45px 40px;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(26, 28, 46, 0.3);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .register-card h2 {
            color: #ffffff;
            font-weight: 700;
            font-size: 26px;
            text-align: center;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .register-card p.subtitle {
            color: #a0aec0;
            text-align: center;
            font-size: 14px;
            margin-bottom: 30px;
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
            margin-bottom: 20px;
        }

        .register-card input {
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

        .register-card input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #4e73df;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.2);
        }

        /* TOMBOL SEKARANG WARNA BIRU SESUAI DASHBOARD */
        .btn-register {
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
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-register:hover {
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
            margin-top: 25px;
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

<div class="register-card">
    <form method="post">
        <h2>JOIN US</h2>
        <p class="subtitle">Buat akun member perpustakaan</p>

        <?php if(isset($error)): ?>
            <div class="error-box">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <div class="input-group">
            <label class="form-label">Username</label>
            <input type="text" name="username" placeholder="Pilih username" required autocomplete="off">
        </div>

        <div class="input-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" placeholder="Buat password" required>
        </div>

        <div class="input-group">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="confirm" placeholder="Ulangi password" required>
        </div>
        
        <button type="submit" name="register" class="btn-register">DAFTAR SEKARANG</button>
        
        <div class="footer-text">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </div>
    </form>
</div>

</body>
</html>