<?php
include '../config.php';
include '../auth.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'user'){
  die("Akses ditolak!");
}

$user = $_SESSION['user'];

/* PROSES PINJAM */
if(isset($_GET['pinjam'])){

  $id = intval($_GET['pinjam']);

  $cek = mysqli_query($koneksi,"
    SELECT * FROM peminjaman 
    WHERE nama_peminjam='$user' 
    AND status='Dipinjam'
  ");

  if(mysqli_num_rows($cek) > 0){
    echo "<script>alert('Masih ada buku yang belum dikembalikan!');</script>";
  } else {

    $buku = mysqli_fetch_assoc(mysqli_query($koneksi,"
      SELECT * FROM buku WHERE id='$id'
    "));

    if($buku['stok'] <= 0){
      echo "<script>alert('Stok habis!');</script>";
    } else {

      $tgl = date('Y-m-d');
      $tgl_kembali = date('Y-m-d', strtotime($tgl . " +7 days"));

      mysqli_query($koneksi,"
        INSERT INTO peminjaman
        (id_buku,nama_peminjam,jumlah,tanggal_pinjam,tanggal_kembali,status)
        VALUES
        ('$id','$user',1,'$tgl','$tgl_kembali','Dipinjam')
      ");

      mysqli_query($koneksi,"
        UPDATE buku SET stok = stok - 1 WHERE id='$id'
      ");

      echo "<script>alert('Berhasil pinjam!');window.location='riwayat_member.php';</script>";
    }
  }
}

/* AMBIL DATA BUKU */
$query = mysqli_query($koneksi,"SELECT * FROM buku");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Peminjaman Buku</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Poppins',sans-serif;
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

/* CONTENT */
.content{
  flex:1;
  padding:30px;
}

/* BOX */
.box{
  background:#fff;
  padding:25px;
  border-radius:12px;
}

/* GRID */
.grid{
  display:grid;
  grid-template-columns:repeat(auto-fill, minmax(220px, 1fr));
  gap:20px;
}

/* CARD */
.card{
  background:#fff;
  border-radius:12px;
  overflow:hidden;
  box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.card img{
  width:100%;
  height:180px;
  object-fit:cover;
}

.card-body{
  padding:15px;
}

.card-body h3{
  font-size:16px;
  margin-bottom:8px;
}

.card-body p{
  font-size:13px;
  color:#555;
}

/* BUTTON PINJAM */
.btn{
  display:inline-block;
  margin-top:10px;
  padding:8px 12px;
  background:#2a5298;
  color:white;
  text-decoration:none;
  border-radius:6px;
  font-size:13px;
}

.btn:hover{
  background:#1e3c72;
}

.btn.disabled{
  background:#aaa;
  pointer-events:none;
}
</style>
</head>

<body>

<div class="wrapper">

  <!-- SIDEBAR -->
  <div class="sidebar">
    <h3>USER PANEL</h3>
    <a href="dashboard_member.php">Dashboard</a>
    <a href="peminjaman.php">Peminjaman</a>
    <a href="riwayat_member.php">Riwayat</a>
    <a href="../logout.php" class="logout">Logout</a>
  </div>

  <!-- CONTENT -->
  <div class="content">

    <div class="box">

      <h2>Pinjam Buku</h2>

      <div class="grid">

      <?php while ($row = mysqli_fetch_assoc($query)) { ?>

      <div class="card">
        <img src="../upload/<?= $row['foto']; ?>">

        <div class="card-body">
          <h3><?= $row['judul']; ?></h3>
          <p><b>Pengarang:</b> <?= $row['pengarang']; ?></p>
          <p><b>Penerbit:</b> <?= $row['penerbit']; ?></p>
          <p><b>Stok:</b> <?= $row['stok']; ?></p>

          <?php if($row['stok'] > 0): ?>
            <a class="btn" href="?pinjam=<?= $row['id'] ?>">Pinjam</a>
          <?php else: ?>
            <span class="btn disabled">Stok Habis</span>
          <?php endif; ?>

        </div>
      </div>

      <?php } ?>

      </div>

    </div>

  </div>

</div>

</body>
</html>