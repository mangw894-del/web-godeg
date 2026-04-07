<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role']!='admin'){
  die("Akses ditolak!");
}

$data = mysqli_query($koneksi,"SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Anggota</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}

body{
  min-height:100vh;
  background:linear-gradient(135deg,#1e3c72,#2a5298);
}

.wrapper{display:flex;min-height:100vh}

/* SIDEBAR */
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

.container{
  background:white;
  padding:30px;
  border-radius:15px;
}

h2{
  margin-bottom:20px;
  color:#2a5298;
}

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
      <h2>Data Anggota</h2>

      <table>
        <tr>
          <th>No</th>
          <th>Username</th>
          <th>Role</th>
        </tr>

        <?php $no=1; while($d=mysqli_fetch_array($data)){ ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $d['username'] ?></td>
          <td><?= $d['role'] ?></td>
        </tr>
        <?php } ?>

      </table>
    </div>

  </div>

</div>

</body>
</html>