<?php
include '../config.php';
include '../auth.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'user'){
  die("Akses ditolak!");
}

$user = $_SESSION['user'];

/* ========= PROSES KEMBALIKAN ========= */
if(isset($_GET['kembali'])){

  $id = intval($_GET['kembali']);

  $cek = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT * FROM peminjaman
    WHERE id='$id'
    AND nama_peminjam='$user'
    AND status='Dipinjam'
  "));

  if($cek){

    mysqli_query($koneksi,"
      UPDATE peminjaman 
      SET status='Dikembalikan'
      WHERE id='$id'
    ");

    mysqli_query($koneksi,"
      UPDATE buku 
      SET stok = stok + ".$cek['jumlah']."
      WHERE id='".$cek['id_buku']."'
    ");
  }

  header("Location: riwayat_member.php");
  exit;
}

/* ========= AMBIL DATA ========= */
$riwayat = mysqli_query($koneksi,"
  SELECT p.*, b.judul
  FROM peminjaman p
  JOIN buku b ON b.id = p.id_buku
  WHERE p.nama_peminjam='$user'
  ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Riwayat Peminjaman</title>

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

.content{
  flex:1;
  padding:20px;
  display:flex;
  justify-content:center;
  align-items:center;
  padding-top:0; /* reset */
  margin-top:-50px; /* geser ke atas */
}

/* CONTAINER */
.container{
  background:white;
  padding:30px;
  border-radius:15px;
  width:100%;
  max-width:900px;
}

/* TITLE */
h2{
  margin-bottom:20px;
  color:#2a5298;
  text-align:center;
}

/* TABLE */
table{
  width:100%;
  border-collapse:collapse;
}

th,td{
  border:1px solid #ddd;
  padding:10px;
  text-align:center;
}

th{
  background:#2a5298;
  color:white;
}

tr:nth-child(even){
  background:#f9f9f9;
}

/* BUTTON */
.btn{
  padding:6px 12px;
  background:#2a5298;
  color:#fff;
  text-decoration:none;
  border-radius:6px;
  font-size:13px;
}

.btn:hover{
  background:#1e3c72;
}

/* STATUS */
.status{
  padding:5px 10px;
  border-radius:6px;
  font-size:12px;
  background:#eee;
}

/* BACK */
.back{
  display:block;
  margin-top:15px;
  text-align:center;
  text-decoration:none;
  color:#2a5298;
}
</style>
</head>

<body>

<div class="wrapper">

  <!-- SIDEBAR -->
  <div class="sidebar">
    <h3>USER PANEL</h3>
    <a href="dashboard_member.php">Dashboard</a>
    <a href="peminjaman.php">Pinjam Buku</a>
    <a href="riwayat_member.php">Riwayat</a>
    <a href="../logout.php" class="logout">Logout</a>
  </div>

  <!-- CONTENT -->
  <div class="content">

    <div class="container">

      <h2>Riwayat Peminjaman</h2>

      <table>
      <tr>
      <th>No</th>
      <th>Judul</th>
      <th>Jumlah</th>
      <th>Tgl Pinjam</th>
      <th>Tgl Kembali</th>
      <th>Status</th>
      <th>Aksi</th>
      </tr>

      <?php 
      $no=1; 
      while($r=mysqli_fetch_assoc($riwayat)): 
      ?>
      <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($r['judul']) ?></td>
      <td><?= $r['jumlah'] ?></td>
      <td><?= $r['tanggal_pinjam'] ?></td>
      <td><?= $r['tanggal_kembali'] ?></td>
      <td><span class="status"><?= $r['status'] ?></span></td>
      <td>
      <?php if($r['status'] == 'Dipinjam'): ?>
        <a class="btn" 
           href="?kembali=<?= $r['id'] ?>" 
           onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
           Kembalikan
        </a>
      <?php else: ?>
        -
      <?php endif; ?>
      </td>
      </tr>
      <?php endwhile; ?>

      </table>

      <a class="back" href="dashboard_member.php">← Kembali</a>

    </div>

  </div>

</div>

</body>
</html>