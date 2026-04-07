<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role']!='admin'){
  die("Akses ditolak!");
}

// DATA
$jbuku = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS total FROM buku"))['total'];
$juser = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS total FROM users"))['total'];

// DETAIL ROLE
$jadmin = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS total FROM users WHERE role='admin'"))['total'];
$juser_biasa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS total FROM users WHERE role='user'"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Poppins',sans-serif
}

body{
  min-height:100vh;
  background:linear-gradient(135deg,#1e3c72,#2a5298);
}

/* WRAPPER */
.wrapper{
  display:flex;
  min-height:100vh;
}

/* SIDEBAR */
.sidebar{
  width:260px;
  background:#1e3c72;
  color:white;
  padding:30px 20px;
  min-height:100vh;
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

.sidebar a:hover{
  background:rgba(255,255,255,.2);
}

.sidebar .logout{
  background:#e74a3b;
}

.sidebar a.active{
  background:rgba(255,255,255,.3);
}

/* CONTENT */
.content{
  flex:1;
  padding:35px;
}

/* HEADER */
.header{
  background:white;
  padding:30px;
  border-radius:20px;
  box-shadow:0 20px 40px rgba(0,0,0,.2);
  margin-bottom:30px;
  display:flex;
  justify-content:space-between;
}

/* DASHBOARD */
.dashboard{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
  gap:25px;
}

/* CARD */
.card{
  background:white;
  padding:35px 25px;
  border-radius:22px;
  box-shadow:0 20px 40px rgba(0,0,0,.2);
  text-align:center;
}

.card h3{
  font-size:48px;
  color:#1cc88a;
}

.card p{
  margin-top:8px;
  color:#666;
}

/* FOOTER */
.footer{
  margin-top:40px;
  text-align:center;
  color:white;
  opacity:.7;
}
</style>

</head>

<body>

<div class="wrapper">

  <!-- SIDEBAR -->
  <?php include 'sidebar.php'; ?>

  <!-- CONTENT -->
  <div class="content">

    <div class="header">
      <div>
        <h2>Dashboard Admin</h2>
        <p>Selamat datang, <b><?= $_SESSION['user']; ?></b></p>
      </div>
      <div>
        <strong><?= date('d F Y') ?></strong>
      </div>
    </div>

    <div class="dashboard">

      <div class="card">
        <h3><?= $jbuku ?></h3>
        <p>Total Buku</p>
      </div>

      <div class="card">
        <h3><?= $juser ?></h3>
        <p>Total Anggota</p>
      </div>

      <div class="card">
        <h3><?= $jadmin ?></h3>
        <p>Admin</p>
      </div>

      <div class="card">
        <h3><?= $juser_biasa ?></h3>
        <p>User</p>
      </div>

    </div>

    <div class="footer">
      Sistem Informasi Perpustakaan © <?= date('Y') ?>
    </div>

  </div>

</div>

</body>
</html>