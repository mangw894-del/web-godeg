<?php
include '../config.php';
include '../auth.php';

// 1. Proteksi Admin
if($_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

// 2. Ambil ID dari URL
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("location:data_anggota.php");
    exit;
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// 3. Ambil data lama buat ditampilin di form
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
if(mysqli_num_rows($query) == 0){
    die("Data anggota tidak ditemukan!");
}
$d = mysqli_fetch_array($query);

// 4. Proses Update saat tombol Simpan ditekan
if(isset($_POST['update'])){
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $role     = $_POST['role'];
    
    // Cek apakah password diganti atau tidak
    if(!empty($_POST['password'])){
        $password = md5($_POST['password']); // Pakai md5 biar sinkron sama login.php abang
        $sql = "UPDATE users SET username='$username', password='$password', role='$role' WHERE id='$id'";
    } else {
        $sql = "UPDATE users SET username='$username', role='$role' WHERE id='$id'";
    }

    $eksekusi = mysqli_query($koneksi, $sql);

    if($eksekusi){
        // CATAT LOG (Pakai fungsi catat_log dari config.php)
        catat_log($koneksi, "Mengubah data anggota: $username", "User");
        
        echo "<script>
                alert('Data berhasil diupdate!'); 
                window.location='data_anggota.php';
              </script>";
        exit;
    } else {
        echo "Gagal update: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Anggota - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* CSS RAPI KE BAWAH */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR STYLE */
        .sidebar {
            width: 260px;
            background: rgba(0, 0, 0, .25);
            backdrop-filter: blur(10px);
            color: white;
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .sidebar a:hover, 
        .sidebar a.active {
            background: rgba(255, 255, 255, .2);
        }

        .sidebar .logout {
            background: #e74a3b;
            text-align: center;
            margin-top: 20px;
        }

        /* CONTENT STYLE */
        .content {
            flex: 1;
            padding: 30px;
            margin-left: 260px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
        }

        h2 {
            margin-bottom: 25px;
            color: #2a5298;
            text-align: center;
        }

        /* FORM STYLE */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #2a5298;
        }

        /* BUTTON STYLE */
        .btn-box {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .btn-simpan {
            flex: 2;
            padding: 12px;
            background: #2a5298;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-simpan:hover {
            background: #1e3c72;
        }

        .btn-batal {
            flex: 1;
            padding: 12px;
            background: #eee;
            color: #333;
            text-decoration: none;
            text-align: center;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
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
        <a href="data_anggota.php" class="active">Data Anggota</a>
        <a href="tambah_anggota.php">Tambah Anggota</a>
        <a href="laporan_aktivitas.php">Laporan Aktivitas</a>
        <a href="../logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <div class="container">
            <h2>Edit Data Anggota</h2>
            
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($d['username']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="admin" <?= ($d['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="member" <?= ($d['role'] == 'member') ? 'selected' : '' ?>>Member</option>
                        <option value="user" <?= ($d['role'] == 'user') ? 'selected' : '' ?>>User</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" placeholder="Isi hanya jika ingin ganti password">
                    <small style="color: #666; font-size: 11px;">*Kosongkan jika tidak ingin mengubah password</small>
                </div>

                <div class="btn-box">
                    <button type="submit" name="update" class="btn-simpan">Simpan Perubahan</button>
                    <a href="data_anggota.php" class="btn-batal">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>