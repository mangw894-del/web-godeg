<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role']!='admin'){
  die("Akses ditolak!");
}

if(isset($_POST['simpan'])){
  $u = mysqli_real_escape_string($koneksi, $_POST['username']);
  $p = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $r = $_POST['role'];
  
  // Ambil nama admin yang sedang login untuk dicatat sebagai pelaku
  $pelaku = $_SESSION['username']; 

  // 1. Query Tambah Anggota
  $query = mysqli_query($koneksi,"INSERT INTO users (username, password, role) VALUES ('$u','$p','$r')");

  if($query){
    // 2. LOGIC TAMBAHAN: Catat ke tabel log_aktivitas
    $aktivitas = "Menambahkan anggota baru: $u (Role: $r)";
    mysqli_query($koneksi, "INSERT INTO log_aktivitas (nama_pelaku, aktivitas, waktu) 
                            VALUES ('$pelaku', '$aktivitas', NOW())");

    echo "<script>alert('Anggota berhasil ditambahkan!');window.location='data_anggota.php';</script>";
  } else {
    echo "<script>alert('Gagal menambahkan anggota!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Anggota - Admin Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* STYLE KONSISTEN */
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif }

body{
  min-height:100vh;
  background: #f4f7fe;
}

.wrapper{
  display:flex;
  min-height:100vh;
}

/* SIDEBAR */
.sidebar {
  width: 270px;
  background: #1a1c2e;
  color: #a0aec0;
  padding: 30px 20px;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
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

.sidebar a:hover, .sidebar a.active {
  background: rgba(255, 255, 255, 0.05);
  color: #fff;
}

.sidebar .logout {
  background: rgba(231, 74, 59, 0.15); 
  color: #ff7675; 
  margin-top: 30px;
  text-align: left;
  border: 1px solid rgba(231, 74, 59, 0.2);
}

.sidebar .logout:hover {
  background: rgba(231, 74, 59, 0.25);
  color: white;
}

/* CONTENT AREA */
.content {
  flex: 1;
  padding: 40px;
  margin-left: 270px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.container {
  background: white;
  padding: 35px;
  border-radius: 20px;
  max-width: 500px;
  width: 100%;
  box-shadow: 0 10px 30px rgba(0,0,0,0.03);
  border: 1px solid #edf2f7;
}

h2 {
  margin-bottom: 25px;
  color: #2d3748;
  font-weight: 700;
  text-align: center;
}

label {
  display: block;
  margin-top: 15px;
  font-size: 13px;
  font-weight: 600;
  color: #718096;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

input, select {
  width: 100%;
  padding: 12px 15px;
  margin-top: 8px;
  border-radius: 10px;
  border: 1px solid #e2e8f0;
  outline: none;
  transition: 0.3s;
  background: #f8fafc;
  font-size: 14px;
}

input:focus, select:focus {
  border-color: #4e73df;
  background: #fff;
  box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
}

button {
  margin-top: 30px;
  width: 100%;
  padding: 14px;
  border: none;
  border-radius: 12px;
  background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
  color: white;
  font-weight: 600;
  font-size: 16px;
  cursor: pointer;
  transition: 0.3s;
}

button:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(78, 115, 223, 0.3);
}

.back {
  margin-top: 20px;
  display: block;
  text-align: center;
  text-decoration: none;
  color: #718096;
  font-size: 14px;
}
</style>
</head>

<body>

<div class="wrapper">
  <div class="sidebar">
    <h3>ADMIN PANEL</h3>
    <a href="dashboard_admin.php">Dashboard</a>
    <a href="data_buku.php">Data Buku</a>
    <a href="tambah_buku.php">Tambah Buku</a>
    <a href="riwayat_peminjaman.php">Riwayat Peminjaman</a>
    <a href="data_anggota.php">Data Anggota</a>
    <a href="tambah_anggota.php" class="active">Tambah Anggota</a>
    <a href="laporan_aktivitas.php">Laporan Aktivitas</a>
    <a href="../logout.php" class="logout">Logout</a>
  </div>

  <div class="content">
    <div class="container">
      <h2>Tambah Anggota Baru</h2>
      <form method="POST">
        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan username..." required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan password..." required>

        <label>Hak Akses (Role)</label>
        <select name="role">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>

        <button type="submit" name="simpan">Daftarkan Anggota</button>
      </form>
      <a href="data_anggota.php" class="back">← Kembali ke Data Anggota</a>
    </div>
  </div>
</div>

</body>
</html>