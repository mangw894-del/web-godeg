<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role']!='admin'){
  die("Akses ditolak!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

    logAktivitas($koneksi, $_SESSION['user'], "Menambahkan buku: $judul");

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

        $nama_file = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];

        $nama_baru = time() . '_' . $nama_file;
        $path = "../upload/" . $nama_baru;

        if (move_uploaded_file($tmp, $path)) {

            mysqli_query($koneksi, "INSERT INTO buku 
            (judul, pengarang, penerbit, tahun_terbit, stok, foto)
            VALUES 
            ('$judul','$pengarang','$penerbit','$tahun','$stok','$nama_baru')");

        } else {
            echo "Upload gagal!";
            exit;
        }

    } else {
        echo "File tidak terbaca!";
        exit;
    }

    header("Location: data_buku.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tambah Buku</title>

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

/* CONTAINER (BIAR SAMA) */
.container{
  background:white;
  padding:30px;
  border-radius:15px;
  max-width:500px;
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

input{
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
    <a href="riwayat_buku.php">Riwayat Buku</a>
    <a href="data_anggota.php">Data Anggota</a>
    <a href="tambah_anggota.php">Tambah Anggota</a>
    <a href="../logout.php" class="logout">Logout</a>
  </div>

  <!-- CONTENT -->
  <div class="content">

    <div class="container">

      <h2>Tambah Buku</h2>

      <form method="POST" enctype="multipart/form-data">

        <label>Judul</label>
        <input type="text" name="judul" required>

        <label>Pengarang</label>
        <input type="text" name="pengarang" required>

        <label>Penerbit</label>
        <input type="text" name="penerbit" required>

        <label>Tahun Terbit</label>
        <input type="number" name="tahun_terbit" required>

        <label>Stok</label>
        <input type="number" name="stok" required>

        <label>Foto Buku</label>
        <input type="file" name="foto" required>

        <button type="submit">Simpan</button>

      </form>

      <a href="data_buku.php" class="back">← Kembali ke Data Buku</a>

    </div>

  </div>

</div>

</body>
</html>