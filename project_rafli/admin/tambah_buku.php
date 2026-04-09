<?php
include '../config.php';
include '../auth.php';

// Cek Role Admin
if($_SESSION['role'] != 'admin'){
    die("Akses ditolak!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $penerbit  = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $tahun     = $_POST['tahun_terbit'];
    $stok      = $_POST['stok'];

    // Proses Foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $nama_file = $_FILES['foto']['name'];
        $tmp       = $_FILES['foto']['tmp_name'];
        $nama_baru = time() . '_' . $nama_file;
        $path      = "../upload/" . $nama_baru;

        if (move_uploaded_file($tmp, $path)) {
            // Jalankan Query
            $query_simpan = mysqli_query($koneksi, "INSERT INTO buku 
                (judul, pengarang, penerbit, tahun_terbit, stok, foto)
                VALUES 
                ('$judul','$pengarang','$penerbit','$tahun','$stok','$nama_baru')");

            if($query_simpan){
                // CATAT LOG AKTIVITAS
                catat_log($koneksi, "Menambahkan buku baru: $judul", "Buku");
                
                echo "<script>alert('Buku Berhasil Ditambahkan!'); window.location='data_buku.php';</script>";
                exit;
            } else {
                echo "Gagal menyimpan ke database!";
            }
        } else {
            echo "Gagal upload file ke folder!";
        }
    } else {
        echo "Harap upload foto buku!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* CSS KONSISTEN (TIDAK TUMPUK) */
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
        body{ min-height:100vh; background:linear-gradient(135deg,#1e3c72,#2a5298); }
        .wrapper{display:flex;min-height:100vh}

        /* SIDEBAR STYLE KACA */
        .sidebar{
            width:260px;
            background:rgba(0,0,0,.25);
            backdrop-filter:blur(10px);
            color:white;
            padding:30px 20px;
            position: fixed;
            height: 100vh;
        }
        .sidebar h3{text-align:center;margin-bottom:30px}
        .sidebar a{display:block;padding:12px;color:white;text-decoration:none;border-radius:10px;margin-bottom:10px}
        .sidebar a:hover, .sidebar a.active{background:rgba(255,255,255,.2)}
        .sidebar .logout{background:#e74a3b; margin-top: 20px; text-align: center;}

        /* CONTENT */
        .content{ flex:1; padding:30px; margin-left: 260px; display: flex; justify-content: center; }
        .container{ background:white; padding:30px; border-radius:15px; width: 100%; max-width: 500px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        
        h2{margin-bottom:20px; color:#2a5298; text-align: center;}
        label{display:block; margin-top:10px; font-size:14px; font-weight: 600; color: #444;}
        input{ width:100%; padding:10px; margin-top:5px; border-radius:8px; border:1px solid #ddd; outline: none; }
        input:focus{ border-color: #2a5298; }

        button{
            margin-top:20px; width:100%; padding:12px; border:none; border-radius:8px;
            background:#2a5298; color:white; font-weight:600; cursor:pointer; transition: 0.3s;
        }
        button:hover{ background:#1e3c72; }
        .back{ margin-top:15px; display:block; text-align: center; text-decoration:none; color:#2a5298; font-size: 14px; }
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
    <a href="tambah_anggota.php">Tambah Anggota</a>
    <a href="laporan_aktivitas.php" class=>Laporan Aktivitas</a>
    <a href="../logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <div class="container">
            <h2>Tambah Buku Baru</h2>
            <form method="POST" enctype="multipart/form-data">
                <label>Judul Buku</label>
                <input type="text" name="judul" placeholder="Masukkan judul..." required>

                <label>Pengarang</label>
                <input type="text" name="pengarang" placeholder="Nama pengarang..." required>

                <label>Penerbit</label>
                <input type="text" name="penerbit" placeholder="Nama penerbit..." required>

                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit" placeholder="Contoh: 2023" required>

                <label>Stok</label>
                <input type="number" name="stok" placeholder="Jumlah stok..." required>

                <label>Foto Sampul Buku</label>
                <input type="file" name="foto" required>

                <button type="submit">Simpan Buku</button>
            </form>
            <a href="data_buku.php" class="back">← Kembali ke Data Buku</a>
        </div>
    </div>
</div>

</body>
</html>