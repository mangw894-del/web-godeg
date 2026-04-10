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
<title>Dashboard Admin - Eleghan Style</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
  min-height: 100vh;
  /* Background warna abu-abu gelap netral agar konten lebih 'pop' */
  background: #f4f7fe; 
}

/* WRAPPER */
.wrapper {
  display: flex;
  min-height: 100vh;
}

/* SIDEBAR - Warna Deep Navy/Charcoal */
.sidebar {
  width: 270px;
  background: #1a1c2e; /* Warna gelap eleghan */
  color: #a0aec0;
  padding: 30px 20px;
  min-height: 100vh;
  position: fixed; /* Biar sidebar gak ikut kegulung */
}

.sidebar h3 {
  text-align: center;
  color: #fff;
  font-size: 20px;
  letter-spacing: 2px;
  margin-bottom: 40px;
  text-transform: uppercase;
  border-bottom: 1px solid rgba(255,255,255,0.1);
  padding-bottom: 20px;
}

.sidebar a {
  display: block;
  padding: 14px 18px;
  color: #cbd5e0;
  text-decoration: none;
  border-radius: 12px;
  margin-bottom: 8px;
  transition: all 0.3s ease;
  font-size: 14px;
  font-weight: 500;
}

.sidebar a:hover {
  background: rgba(255,255,255,0.05);
  color: #fff;
  padding-left: 25px; /* Efek geser sedikit */
}

.sidebar a.active {
  background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
  color: #fff;
  box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
}

.sidebar .logout {
  background: rgba(231, 74, 59, 0.1);
  color: #e74a3b;
  margin-top: 30px;
}

.sidebar .logout:hover {
  background: #e74a3b;
  color: #fff;
}

/* CONTENT AREA */
.content {
  flex: 1;
  padding: 40px;
  margin-left: 270px; /* Jarak dari sidebar fixed */
}

/* HEADER BOX */
.header {
  background: #fff;
  padding: 25px 35px;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.03);
  margin-bottom: 35px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.header h2 {
  color: #2d3748;
  font-size: 24px;
}

.header p {
  color: #718096;
  font-size: 14px;
}

.header b {
  color: #4e73df;
}

.date-box {
  background: #f8f9fc;
  padding: 10px 20px;
  border-radius: 10px;
  color: #4e73df;
  font-size: 14px;
  font-weight: 600;
}

/* GRID DASHBOARD */
.dashboard {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 25px;
}

/* CARD MODERN */
.card {
  background: #fff;
  padding: 30px;
  border-radius: 20px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.02);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: 1px solid #edf2f7;
  position: relative;
  overflow: hidden;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0,0,0,0.06);
}

/* Garis aksen di atas card */
.card::before {
  content: "";
  position: absolute;
  top: 0; left: 0; width: 100%; height: 5px;
  background: #4e73df;
}

.card h3 {
  font-size: 42px;
  font-weight: 700;
  color: #2d3748;
  margin-bottom: 5px;
}

.card p {
  color: #a0aec0;
  font-size: 13px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* Warna berbeda untuk tiap angka (Opsional) */
.card:nth-child(1) h3 { color: #4e73df; } /* Biru */
.card:nth-child(2) h3 { color: #1cc88a; } /* Hijau */
.card:nth-child(3) h3 { color: #f6ad55; } /* Orange */
.card:nth-child(4) h3 { color: #9f7aea; } /* Ungu */

/* FOOTER */
.footer {
  margin-top: 50px;
  text-align: center;
  color: #a0aec0;
  font-size: 13px;
}
</style>

</head>

<body>

<div class="wrapper">

  <?php include 'sidebar.php'; ?>

  <div class="content">

    <div class="header">
      <div>
        <h2>Dashboard Utama</h2>
        <p>Selamat datang kembali, <b><?= $_SESSION['username']; ?></b></p>
      </div>
      <div class="date-box">
        <?= date('d F Y') ?>
      </div>
    </div>

    <div class="dashboard">

      <div class="card">
        <h3><?= $jbuku ?></h3>
        <p>Total Koleksi Buku</p>
      </div>

      <div class="card">
        <h3><?= $juser ?></h3>
        <p>Total Anggota Terdaftar</p>
      </div>

      <div class="card">
        <h3><?= $jadmin ?></h3>
        <p>Staf Admin</p>
      </div>

      <div class="card">
        <h3><?= $juser_biasa ?></h3>
        <p>Anggota Aktif</p>
      </div>

    </div>

    <div class="footer">
      Sistem Informasi Perpustakaan Digital &bull; &copy; <?= date('Y') ?>
    </div>

  </div>

</div>

</body>
</html>