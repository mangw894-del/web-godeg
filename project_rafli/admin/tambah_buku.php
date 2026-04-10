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
        $path       = "../upload/" . $nama_baru;

        if (move_uploaded_file($tmp, $path)) {
            // Jalankan Query
            $query_simpan = mysqli_query($koneksi, "INSERT INTO buku 
                (judul, pengarang, penerbit, tahun_terbit, stok, foto)
                VALUES 
                ('$judul','$pengarang','$penerbit','$tahun','$stok','$nama_baru')");

            if($query_simpan){
                // CATAT LOG AKTIVITAS
                if (function_exists('catat_log')) {
                    catat_log($koneksi, "Menambahkan buku baru: $judul", "Buku");
                }
                
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
    <title>Tambah Buku - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        
        body { 
            min-height:100vh; 
            background: #f4f7fe; 
        }

        .wrapper { display:flex; min-height:100vh; }

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

        /* --- PERBAIKAN LOGOUT: TEKS RATA KIRI --- */
        .sidebar .logout {
            background: rgba(231, 74, 59, 0.15); 
            color: #ff7675; 
            text-align: left; /* Berubah jadi kiri */
            margin-top: 30px;
            border: 1px solid rgba(231, 74, 59, 0.2);
        }

        .sidebar .logout:hover {
            background: rgba(231, 74, 59, 0.25);
            color: #fff;
        }

        /* CONTENT */
        .content { 
            flex:1; 
            padding:40px; 
            margin-left: 270px; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
        }

        .container { 
            background:white; 
            padding:40px; 
            border-radius:20px; 
            width: 100%; 
            max-width: 650px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid #edf2f7;
        }
        
        h2 { margin-bottom:10px; color:#2d3748; text-align: center; font-weight: 700; }
        
        label { 
            display:block; 
            margin-top:15px; 
            font-size:13px; 
            font-weight: 600; 
            color: #718096; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input { 
            width:100%; 
            padding:12px 15px; 
            margin-top:8px; 
            border-radius:10px; 
            border:1px solid #e2e8f0; 
            outline: none; 
            transition: 0.3s;
            background: #f8fafc;
            font-size: 14px;
        }

        input:focus { 
            border-color: #4e73df; 
            background: #fff;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
        }

        input[type="file"] {
            background: white;
            border: 1px dashed #cbd5e0;
        }

        button {
            margin-top:35px; 
            width:100%; 
            padding:14px; 
            border:none; 
            border-radius:12px;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color:white; 
            font-weight:600; 
            font-size: 16px;
            cursor:pointer; 
            transition: 0.3s;
        }

        button:hover { 
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(78, 115, 223, 0.3);
        }

        .back { 
            margin-top:20px; 
            display:block; 
            text-align: center; 
            text-decoration:none; 
            color:#718096; 
            font-size: 14px; 
        }
        .back:hover { color: #4e73df; }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="sidebar">
        <h3>ADMIN PANEL</h3>
        <a href="dashboard_admin.php">Dashboard</a>
        <a href="data_buku.php">Data Buku</a>
        <a href="tambah_buku.php" class="active">Tambah Buku</a>
        <a href="riwayat_peminjaman.php">Riwayat Peminjaman</a>
        <a href="data_anggota.php">Data Anggota</a>
        <a href="tambah_anggota.php">Tambah Anggota</a>
        <a href="laporan_aktivitas.php">Laporan Aktivitas</a>
        <a href="../logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <div class="container">
            <h2>Tambah Buku Baru</h2>
            <p style="text-align: center; color: #a0aec0; margin-bottom: 25px; font-size: 14px;">Masukkan data katalog perpustakaan.</p>
            
            <form method="POST" enctype="multipart/form-data">
                <label>Judul Buku</label>
                <input type="text" name="judul" placeholder="Judul buku lengkap..." required>

                <label>Pengarang</label>
                <input type="text" name="pengarang" placeholder="Nama penulis..." required>

                <label>Penerbit</label>
                <input type="text" name="penerbit" placeholder="Nama penerbit..." required>

                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1;">
                        <label>Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" placeholder="Tahun" required>
                    </div>
                    <div style="flex: 1;">
                        <label>Stok</label>
                        <input type="number" name="stok" placeholder="Jumlah" required>
                    </div>
                </div>

                <label>Foto Sampul Buku</label>
                <input type="file" name="foto" required>

                <button type="submit">Simpan ke Katalog</button>
            </form>
            
            <a href="data_buku.php" class="back">← Kembali ke Data Buku</a>
        </div>
    </div>
</div>

</body>
</html>