<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role'] != 'admin'){
    die("Akses ditolak!");
}

// --- 1. LOGIKA PROSES UPDATE (Ditaruh paling atas) ---
if (isset($_POST['update'])) {
    $id        = $_POST['id'];
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $penerbit  = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $tahun     = $_POST['tahun_terbit'];
    $stok      = $_POST['stok'];
    $foto_lama = $_POST['foto_lama'];

    // Cek Ganti Foto
    if ($_FILES['foto']['name'] != "") {
        $nama_file = $_FILES['foto']['name'];
        $tmp       = $_FILES['foto']['tmp_name'];
        $nama_baru = time() . '_' . $nama_file;
        
        if (move_uploaded_file($tmp, "../upload/" . $nama_baru)) {
            if (file_exists("../upload/" . $foto_lama)) {
                unlink("../upload/" . $foto_lama);
            }
            $foto_final = $nama_baru;
        }
    } else {
        $foto_final = $foto_lama;
    }

    $sql = "UPDATE buku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun_terbit='$tahun', stok='$stok', foto='$foto_final' WHERE id='$id'";

    if (mysqli_query($koneksi, $sql)) {
        // CATAT LOG AKTIVITAS
        catat_log($koneksi, "Mengubah data buku: $judul", "Buku");
        
        echo "<script>alert('Data Berhasil Diupdate!'); window.location='data_buku.php';</script>";
    }
}

// --- 2. AMBIL DATA UNTUK FORM ---
$id_ambil = mysqli_real_escape_string($koneksi, $_GET['id']);
$data = mysqli_query($koneksi, "SELECT * FROM buku WHERE id='$id_ambil'");
$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        /* CSS NYA DI SINI BOS, GAK DIPISAH */
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { min-height:100vh; background:linear-gradient(135deg,#1e3c72,#2a5298); }
        .wrapper { display:flex; min-height:100vh; }

        .sidebar { width:260px; background:rgba(0,0,0,.25); backdrop-filter:blur(10px); color:white; padding:30px 20px; position:fixed; height:100vh; }
        .sidebar h3 { text-align:center; margin-bottom:30px; }
        .sidebar a { display:block; padding:12px; color:white; text-decoration:none; border-radius:10px; margin-bottom:10px; }
        .sidebar a:hover, .sidebar a.active { background:rgba(255,255,255,.2); }
        .sidebar .logout { background:#e74a3b; margin-top:20px; text-align:center; }

        .content { flex:1; padding:30px; margin-left:260px; display:flex; justify-content:center; }
        .container { background:white; padding:30px; border-radius:15px; width:100%; max-width:550px; box-shadow:0 10px 25px rgba(0,0,0,0.2); }
        
        h2 { color:#2a5298; margin-bottom:20px; text-align:center; border-bottom:2px solid #eee; padding-bottom:10px; }
        label { display:block; margin-top:12px; font-weight:600; color:#444; font-size:14px; }
        input { width:100%; padding:10px; margin-top:5px; border-radius:8px; border:1px solid #ddd; outline:none; }
        
        button { width:100%; padding:12px; margin-top:25px; background:#2a5298; color:white; border:none; border-radius:10px; font-weight:600; cursor:pointer; }
        button:hover { background:#1e3c72; }
        .back { display:block; text-align:center; margin-top:15px; text-decoration:none; color:#888; font-size:14px; }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="sidebar">
        <h3>ADMIN PANEL</h3>
        <a href="dashboard_admin.php">Dashboard</a>
        <a href="data_buku.php" class="active">Data Buku</a>
        <a href="tambah_buku.php">Tambah Buku</a>
        <a href="riwayat_peminjaman.php">Riwayat Peminjaman</a>
        <a href="data_anggota.php">Data Anggota</a>
        <a href="laporan_aktivitas.php">Laporan Aktivitas</a>
        <a href="../logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <div class="container">
            <h2>Edit Buku</h2>
            
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                <input type="hidden" name="foto_lama" value="<?= $row['foto']; ?>">

                <label>Judul Buku</label>
                <input type="text" name="judul" value="<?= $row['judul']; ?>" required>

                <label>Pengarang</label>
                <input type="text" name="pengarang" value="<?= $row['pengarang']; ?>" required>

                <label>Penerbit</label>
                <input type="text" name="penerbit" value="<?= $row['penerbit']; ?>" required>

                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="<?= $row['tahun_terbit']; ?>" required>

                <label>Stok</label>
                <input type="number" name="stok" value="<?= $row['stok']; ?>" required>

                <label>Foto Saat Ini</label><br>
                <img src="../upload/<?= $row['foto']; ?>" width="100" style="border-radius:8px; margin-top:5px; border: 1px solid #ddd;">

                <label>Ganti Foto (Kosongkan jika tidak diubah)</label>
                <input type="file" name="foto">

                <button type="submit" name="update">Simpan Perubahan</button>
            </form>
            <a href="data_buku.php" class="back">← Batal</a>
        </div>
    </div>
</div>

</body>
</html>