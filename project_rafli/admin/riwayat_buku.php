<?php
include '../config.php';
include '../auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    echo "Akses ditolak";
    exit;
}

$query = mysqli_query($koneksi, "
    SELECT peminjaman.*, buku.judul 
    FROM peminjaman
    JOIN buku ON peminjaman.id_buku = buku.id
    ORDER BY peminjaman.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Riwayat Buku</title>

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

/* SIDEBAR (SAMA) */
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
}

/* CONTAINER (SAMA) */
.container{
  background:white;
  padding:30px;
  border-radius:15px;
}

h2{
  margin-bottom:20px;
  color:#2a5298;
}

/* TABLE */
table{
  width:100%;
  border-collapse:collapse;
}

table th, table td{
  padding:12px;
  text-align:center;
  border-bottom:1px solid #ddd;
}

table th{
  background:#2a5298;
  color:white;
}

tr:hover{
  background:#f5f5f5;
}

/* BADGE */
.badge{
  padding:5px 10px;
  border-radius:6px;
  font-size:12px;
  border:1px solid #ccc;
}

.dipinjam{
  color:#856404;
}

.kembali{
  color:#155724;
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
    <a href="riwayat_buku.php">Riwayat Buku</a>
    <a href="data_anggota.php">Data Anggota</a>
    <a href="tambah_anggota.php">Tambah Anggota</a>
    <a href="../logout.php" class="logout">Logout</a>
  </div>

  <!-- CONTENT -->
  <div class="content">

    <div class="container">

      <h2>Riwayat Peminjaman Buku</h2>

      <table>
      <tr>
          <th>No</th>
          <th>Judul Buku</th>
          <th>Nama</th>
          <th>Tgl Pinjam</th>
          <th>Tgl Kembali</th>
          <th>Status</th>
      </tr>

      <?php 
      $no = 1;
      while ($row = mysqli_fetch_assoc($query)) {
      ?>
      <tr>
          <td><?= $no++; ?></td>
          <td><?= $row['judul']; ?></td>
          <td><?= $row['nama_peminjam']; ?></td>
          <td><?= $row['tanggal_pinjam']; ?></td>
          <td><?= $row['tanggal_kembali']; ?></td>
          <td>
              <?php if($row['status'] == 'Dipinjam'): ?>
                  <span class="badge dipinjam">Dipinjam</span>
              <?php else: ?>
                  <span class="badge kembali">Kembali</span>
              <?php endif; ?>
          </td>
      </tr>
      <?php } ?>

      </table>

    </div>

  </div>

</div>

</body>
</html>