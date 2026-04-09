<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role']!='user'){
  die("Akses ditolak!");
}

$user = $_SESSION['user'];

/* ================= PINJAM ================= */
if(isset($_GET['pinjam'])){
  $id_buku = $_GET['pinjam'];
  $tanggal = date("Y-m-d");

  $cek = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT stok FROM buku WHERE id='$id_buku'"));

  if($cek['stok'] > 0){
    mysqli_query($koneksi,"INSERT INTO peminjaman 
    (id_buku, nama_peminjam, tanggal_pinjam, status)
    VALUES ('$id_buku','$user','$tanggal','Dipinjam')");

    mysqli_query($koneksi,"UPDATE buku SET stok=stok-1 WHERE id='$id_buku'");
  }

  header("Location: peminjaman.php");
}

/* ================= KEMBALIKAN ================= */
if(isset($_GET['kembali'])){
  $id = $_GET['kembali'];

  // ambil id buku
  $data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT id_buku FROM peminjaman WHERE id='$id'"));

  // update status
  mysqli_query($koneksi,"UPDATE peminjaman 
    SET status='Kembali', tanggal_kembali=NOW() 
    WHERE id='$id'
  ");

  // kembalikan stok
  mysqli_query($koneksi,"UPDATE buku SET stok=stok+1 WHERE id='".$data['id_buku']."'");

  header("Location: peminjaman.php");
}

/* ================= SEARCH ================= */
$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = mysqli_query($koneksi,"
  SELECT * FROM buku 
  WHERE judul LIKE '%$search%' 
  ORDER BY id DESC
");

/* ================= CEK PINJAMAN USER ================= */
$pinjam_user = [];
$q = mysqli_query($koneksi,"
  SELECT * FROM peminjaman 
  WHERE nama_peminjam='$user' AND status='Dipinjam'
");

while($p = mysqli_fetch_assoc($q)){
  $pinjam_user[$p['id_buku']] = $p['id']; // id buku => id peminjaman
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Peminjaman Buku</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}

body{
  min-height:100vh;
  background:linear-gradient(135deg,#1e3c72,#2a5298);
}

.wrapper{display:flex}

/* SIDEBAR */
.sidebar{
  width:240px;
  background:#1f2f56;
  color:white;
  padding:30px 20px;
}
.sidebar a{
  display:block;
  color:white;
  padding:12px;
  text-decoration:none;
  margin-bottom:10px;
}
.sidebar a:hover{background:rgba(255,255,255,0.1)}
.logout{background:#e74c3c}

/* CONTENT */
.content{
  flex:1;
  padding:30px;
}

.container{
  background:white;
  padding:25px;
  border-radius:15px;
}

/* SEARCH */
.search{
  margin-bottom:15px;
}

.search input{
  padding:10px;
  width:250px;
  border-radius:8px;
  border:1px solid #ccc;
}

/* TABLE */
table{
  width:100%;
  border-collapse:collapse;
}

th, td{
  padding:10px;
  border-bottom:1px solid #ddd;
  text-align:center;
}

th{
  background:#2a5298;
  color:white;
}

img{
  border-radius:8px;
}

/* BUTTON */
.btn{
  padding:6px 10px;
  border-radius:6px;
  color:white;
  text-decoration:none;
}

.pinjam{background:#20c997;}
.kembali{background:#e74c3c;}
.pinjam:hover{background:#17a589;}
.kembali:hover{background:#c0392b;}
</style>
</head>

<body>

<div class="wrapper">

<!-- SIDEBAR -->
<div class="sidebar">
  <h2>MEMBER</h2>
  <a href="dashboard_member.php">Dashboard</a>
  <a href="peminjaman.php">Peminjaman</a>
  <a href="riwayat_member.php">Riwayat</a>
  <a href="../logout.php" class="logout">Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
  <div class="container">

    <h2>Daftar Buku</h2>

    <!-- SEARCH -->
    <form method="GET" class="search">
      <input type="text" name="search" placeholder="Cari buku..." value="<?= $search ?>">
      <button type="submit">Cari</button>
    </form>

    <table>
      <tr>
        <th>No</th>
        <th>Foto</th>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Stok</th>
        <th>Aksi</th>
      </tr>

      <?php $no=1; while($b=mysqli_fetch_assoc($query)){ ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><img src="../upload/<?= $b['foto'] ?>" width="60"></td>
        <td><?= $b['judul'] ?></td>
        <td><?= $b['pengarang'] ?></td>
        <td><?= $b['stok'] ?></td>
        <td>

          <?php if(isset($pinjam_user[$b['id']])){ ?>
            <!-- SUDAH DIPINJAM -->
            <a href="?kembali=<?= $pinjam_user[$b['id']] ?>" class="btn kembali">Kembalikan</a>

          <?php } else { ?>
            <!-- BELUM PINJAM -->
            <?php if($b['stok'] > 0){ ?>
              <a href="?pinjam=<?= $b['id'] ?>" class="btn pinjam">Pinjam</a>
            <?php } else { ?>
              <span style="color:red;">Habis</span>
            <?php } ?>
          <?php } ?>

        </td>
      </tr>
      <?php } ?>

    </table>

  </div>
</div>

</div>

</body>
</html>