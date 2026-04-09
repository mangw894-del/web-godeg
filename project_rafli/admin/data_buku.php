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

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = mysqli_query($koneksi, "SELECT * FROM buku 
        WHERE judul LIKE '%$search%' 
        OR pengarang LIKE '%$search%' 
        OR penerbit LIKE '%$search%'");
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM buku");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Data Buku</title>

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
  padding:30px;
}

/* BOX */
.box{
  background:#fff;
  padding:25px;
  border-radius:12px;
}

/* TOP */
.top{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px;
}

/* BUTTON */
.top-btn{
  text-decoration:none;
  background:#f8f9fa;
  color:#333;
  padding:10px 15px;
  border-radius:8px;
  border:1px solid #ccc;
}

.top-btn:hover{
  background:#e2e6ea;
}

/* SEARCH */
.search-box input{
  padding:10px;
  border-radius:8px;
  border:1px solid #ccc;
}

.search-box button{
  padding:10px;
  border:none;
  background:#4e73df;
  color:#fff;
  border-radius:8px;
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

/* AKSI */
.aksi{
  margin-top:10px;
}

.aksi a{
  text-decoration:none;
  padding:6px 10px;
  border-radius:6px;
  font-size:12px;
  border:1px solid #ccc;
  margin-right:5px;
}

.edit:hover{background:#e2e6ea}
.hapus:hover{color:#c0392b}
</style>
</head>

<body>

<div class="wrapper">

  <!-- SIDEBAR -->
  <?php include 'sidebar.php'; ?>

  <!-- CONTENT -->
  <div class="content">

    <div class="box">

      <div class="top">
        <a href="tambah_buku.php" class="top-btn">+ Tambah Buku</a>

        <form method="GET" class="search-box">
          <input type="text" name="search" placeholder="Cari buku..." value="<?= $search; ?>">
          <button type="submit">Cari</button>
        </form>
      </div>

      <!-- GRID -->
      <div class="grid">

      <?php while ($row = mysqli_fetch_assoc($query)) { ?>

      <div class="card">
        <img src="../upload/<?= $row['foto']; ?>">

        <div class="card-body">
          <h3><?= $row['judul']; ?></h3>
          <p><b>Pengarang:</b> <?= $row['pengarang']; ?></p>
          <p><b>Penerbit:</b> <?= $row['penerbit']; ?></p>
          <p><b>Tahun:</b> <?= $row['tahun_terbit']; ?></p>
          <p><b>Stok:</b> <?= $row['stok']; ?></p>
  
          <div class="aksi">
            <a href="edit_buku.php?id=<?= $row['id']; ?>">Edit</a>
            <a href="hapus_buku.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
          </div>
        </div>
      </div>

      <?php } ?>

      </div>

    </div>

  </div>

</div>

</body>
</html>