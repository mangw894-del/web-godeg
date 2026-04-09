<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role']!='admin'){
  die("Akses ditolak!");
}

if(isset($_POST['simpan'])){
  $u = $_POST['username'];
  $p = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $r = $_POST['role'];

  mysqli_query($koneksi,"INSERT INTO users VALUES('','$u','$p','$r')");

  echo "<script>alert('Berhasil ditambahkan!');window.location='data_anggota.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tambah Anggota</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}

body{
  min-height:100vh;
  background:linear-gradient(135deg,#1e3c72,#2a5298);
}

.wrapper{
  display:flex;
  min-height:100vh;
}

/* SIDEBAR (SAMA PERSIS) */
.sidebar{
  width:260px;
  background:rgba(0,0,0,.25);
  backdrop-filter:blur(10px);
  color:white;
  padding:30px 20px;
}
.sidebar h3{
  text-align:center;
  margin-bottom:30px;
}
.sidebar a{
  display:block;
  padding:12px;
  color:white;
  text-decoration:none;
  border-radius:10px;
  margin-bottom:10px;
}
.sidebar a:hover{background:rgba(255,255,255,.2)}
.sidebar .logout{background:#e74a3b}

/* CONTENT */
.content{
  flex:1;
  padding:30px;
  display:flex;
  justify-content:center;
}

/* CONTAINER (SAMA) */
.container{
  background:white;
  padding:30px;
  border-radius:15px;
  max-width:500px;
  width:100%;
}

/* FORM */
h2{
  margin-bottom:20px;
  color:#2a5298;
}

label{
  display:block;
  margin-top:10px;
  font-size:14px;
}

input, select{
  width:100%;
  padding:10px;
  margin-top:5px;
  border-radius:8px;
  border:1px solid #ccc;
}

button{
  margin-top:15px;
  width:100%;
  padding:12px;
  border:none;
  border-radius:8px;
  background:#2a5298;
  color:white;
  font-weight:600;
  cursor:pointer;
}

button:hover{
  background:#1e3c72;
}

.back{
  margin-top:15px;
  display:block;
  text-decoration:none;
  color:#2a5298;
}
</style>
</head>

<body>

<div class="wrapper">

  <!-- SIDEBAR -->
  <div class="sidebar">
    <h3>ADMIN PANEL</h3>
    <a href="dashboard_admin.php">Dashboard</a>
    <a href="data_buku.php">Data Buku</a>
    <a href="tambah_buku.php">Tambah Buku</a>
    <a href="riwayat_peminjaman.php">Riwayat Peminjaman</a>
    <a href="data_anggota.php">Data Anggota</a>
    <a href="tambah_anggota.php">Tambah Anggota</a>
    <a href="laporan_aktivitas.php" class="active">Laporan Aktivitas</a>
    <a href="../logout.php" class="logout">Logout</a>
  </div>

  <!-- CONTENT -->
  <div class="content">

    <div class="container">

      <h2>Tambah Anggota</h2>

      <form method="POST">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Role</label>
        <select name="role">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>

        <button type="submit" name="simpan">Simpan</button>

      </form>

      <a href="data_anggota.php" class="back">← Kembali ke Data Anggota</a>

    </div>

  </div>

</div>

</body>
</html>