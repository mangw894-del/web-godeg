<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role']!='user'){
  die("Akses ditolak!");
}

$user = $_SESSION['user'];
$tanggal = date("d F Y");

/* ================= TOTAL BUKU ================= */
$qBuku = mysqli_query($koneksi,"SELECT COUNT(*) as total FROM buku");
$dBuku = mysqli_fetch_assoc($qBuku);
$jbuku = $dBuku['total'];

/* ================= BUKU AKTIF ================= */
$aktif = mysqli_query($koneksi,"
  SELECT buku.judul, peminjaman.tanggal_pinjam
  FROM peminjaman
  JOIN buku ON buku.id = peminjaman.id_buku
  WHERE peminjaman.nama_peminjam='$user'
  AND peminjaman.status='Dipinjam'
");
$jaktif = mysqli_num_rows($aktif);

/* ================= RIWAYAT ================= */
$qRiwayat = mysqli_query($koneksi,"
  SELECT id FROM peminjaman
  WHERE nama_peminjam='$user'
");
$jriwayat = mysqli_num_rows($qRiwayat);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Member</title>
<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Segoe UI',sans-serif;
}

body{
  display:flex;
  min-height:100vh;
  background:linear-gradient(135deg,#1e3c72,#2a5298);
}

/* ===== SIDEBAR ===== */
.sidebar{
  width:240px;
  background:#1f2f56;
  color:white;
  padding:30px 20px;
}

.sidebar h2{
  margin-bottom:40px;
  font-size:20px;
}

.sidebar a{
  display:block;
  color:white;
  text-decoration:none;
  padding:12px 15px;
  margin-bottom:10px;
  border-radius:8px;
  transition:.3s;
}

.sidebar a:hover{
  background:rgba(255,255,255,0.1);
}

.logout{
  background:#e74c3c;
}

.logout:hover{
  background:#c0392b;
}

/* ===== CONTENT ===== */
.content{
  flex:1;
  padding:40px;
}

/* ===== HEADER CARD ===== */
.header{
  background:white;
  padding:25px 30px;
  border-radius:20px;
  margin-bottom:30px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.header h1{
  color:#2a5298;
}

.header span{
  font-weight:bold;
}

/* ===== CARDS ===== */
.cards{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:25px;
}

.card{
  background:white;
  border-radius:20px;
  padding:40px;
  text-align:center;
  box-shadow:0 10px 25px rgba(0,0,0,.2);
}

.card h1{
  font-size:50px;
  color:#20c997;
}

.card p{
  margin-top:10px;
  color:#555;
  font-weight:600;
}

/* ===== TABLE ===== */
.table-box{
  background:white;
  padding:25px;
  border-radius:20px;
  margin-top:30px;
  box-shadow:0 10px 25px rgba(0,0,0,.2);
}

table{
  width:100%;
  border-collapse:collapse;
}

th,td{
  padding:12px;
  border-bottom:1px solid #eee;
}

th{
  background:#f4f6fb;
}
</style>
</head>
<body>

<div class="sidebar">
  <h2>MEMBER PANEL</h2>
  <a href="dashboard_member.php">Dashboard</a>
  <a href="peminjaman.php">Peminjaman</a>
  <a href="riwayat_member.php">Riwayat</a>
  <a href="../logout.php" class="logout">Logout</a>
</div>

<div class="content">

  <div class="header">
    <div>
      <h1>Dashboard Member</h1>
      <p>Selamat datang, <b><?= $user ?></b></p>
    </div>
    <div><?= $tanggal ?></div>
  </div>

  <div class="cards">
    <div class="card">
      <h1><?= $jbuku ?></h1>
      <p>Total Buku</p>
    </div>

    <div class="card">
      <h1><?= $jaktif ?></h1>
      <p>Sedang Dipinjam</p>
    </div>

    <div class="card">
      <h1><?= $jriwayat ?></h1>
      <p>Total Riwayat</p>
    </div>
  </div>

  <div class="table-box">
    <h3>Buku Sedang Dipinjam</h3>
    <table>
      <tr>
        <th>Judul</th>
        <th>Tanggal Pinjam</th>
      </tr>

      <?php if($jaktif > 0): ?>
        <?php while($row=mysqli_fetch_assoc($aktif)): ?>
          <tr>
            <td><?= $row['judul'] ?></td>
            <td><?= $row['tanggal_pinjam'] ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="2">Tidak ada buku dipinjam</td>
        </tr>
      <?php endif; ?>
    </table>
  </div>

</div>

</body>
</html>