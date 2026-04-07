<?php
include 'config.php';

if (isset($_POST['login'])) {
    $u = mysqli_real_escape_string($koneksi, $_POST['username']);
    $p = md5($_POST['password']);

    $q = mysqli_query(
        $koneksi,
        "SELECT * FROM users WHERE username='$u' AND password='$p'"
    );

    if (!$q) {
        die("Query error: " . mysqli_error($koneksi));
    }

    $d = mysqli_fetch_assoc($q);

    if ($d) {
        $_SESSION['login'] = true;
        $_SESSION['id']    = $d['id'];
        $_SESSION['user']  = $d['username'];
        $_SESSION['role']  = $d['role'];

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
<title>Login</title>
<style>
body{
  margin:0;
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  background:linear-gradient(120deg,#4e73df,#1cc88a);
  font-family:'Segoe UI',sans-serif;
}
.box{
  background:white;
  padding:35px;
  width:360px;
  border-radius:14px;
  box-shadow:0 20px 40px rgba(0,0,0,.25);
}
.box h2{
  text-align:center;
  color:#4e73df;
  margin-bottom:20px;
}
.box input{
  width:100%;
  padding:12px;
  margin:10px 0;
  border-radius:8px;
  border:1px solid #ccc;
}
.box button{
  width:100%;
  padding:12px;
  background:#1cc88a;
  border:none;
  color:white;
  border-radius:8px;
  font-weight:600;
  cursor:pointer;
}
.error{
  background:#fee2e2;
  color:#b91c1c;
  padding:10px;
  border-radius:8px;
  margin-bottom:12px;
  text-align:center;
}
</style>
</head>
<body>

<form method="post" class="box">
    <h2>Silahkan Login</h2>

    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

    <input name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="login">Login</button>
    <p align="center">Belum punya akun? <a href="register.php">Daftar</a></p>
</form>

</body>
</html>
