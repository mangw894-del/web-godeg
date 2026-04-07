<?php
include 'config.php';

if(isset($_POST['register'])){
  $username = mysqli_real_escape_string($koneksi, $_POST['username']);
  $password = $_POST['password'];
  $confirm  = $_POST['confirm'];

  // cek username
  $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
  if(mysqli_num_rows($cek) > 0){
    $error = "Username sudah digunakan!";
  } elseif($password != $confirm){
    $error = "Password tidak sama!";
  } else {
    $pass = md5($password);
    mysqli_query($koneksi,
      "INSERT INTO users (username,password,role)
       VALUES ('$username','$pass','user')"
    );
    header("Location: login.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register</title>
<style>
*{
  box-sizing:border-box;
  font-family:'Segoe UI',Tahoma,sans-serif;
}
body{
  margin:0;
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  background:linear-gradient(120deg,#4e73df,#1cc88a);
}
.box{
  background:#fff;
  width:360px;
  padding:35px;
  border-radius:14px;
  box-shadow:0 20px 40px rgba(0,0,0,.25);
  animation:fade .5s ease;
}
@keyframes fade{
  from{opacity:0;transform:translateY(15px);}
  to{opacity:1;transform:translateY(0);}
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
.box input:focus{
  outline:none;
  border-color:#4e73df;
}
.box button{
  width:100%;
  padding:12px;
  background:#1cc88a;
  border:none;
  color:#fff;
  font-weight:600;
  border-radius:8px;
  cursor:pointer;
}
.box button:hover{
  background:#17a673;
}
.error{
  background:#fee2e2;
  color:#b91c1c;
  padding:10px;
  border-radius:8px;
  text-align:center;
  margin-bottom:10px;
}
.box p{
  text-align:center;
  margin-top:15px;
}
.box a{
  color:#4e73df;
  text-decoration:none;
  font-weight:600;
}
</style>
</head>
<body>

<form method="post" class="box">
  <h2>Register Member</h2>

  <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <input type="password" name="confirm" placeholder="Ulangi Password" required>

  <button name="register">Daftar</button>

  <p>Sudah punya akun? <a href="login.php">Login</a></p>
</form>

</body>
</html>
