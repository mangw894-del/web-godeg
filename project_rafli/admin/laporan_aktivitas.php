<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role'] != 'admin'){
    die("Akses ditolak!");
}

// Ambil data dari tabel log_aktivitas yang baru kita buat
$result = mysqli_query($koneksi, "SELECT * FROM log_aktivitas ORDER BY waktu DESC LIMIT 50");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aktivitas - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        /* CSS KONSISTEN SEPERTI SEBELUMNYA */
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
        }

        .wrapper { display: flex; min-height: 100vh; }

        /* SIDEBAR (STYLE KACA / BLUR) */
        .sidebar {
            width: 260px;
            background: rgba(0, 0, 0, .25);
            backdrop-filter: blur(10px);
            color: white;
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
        }

        .sidebar h3 { text-align: center; margin-bottom: 30px; font-size: 20px; }

        .sidebar a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar .logout {
            background: #e74a3b;
            margin-top: 20px;
            text-align: center;
        }

        /* CONTENT AREA */
        .content {
            flex: 1;
            padding: 30px;
            margin-left: 260px; /* Jarak agar tidak tertutup sidebar */
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 { color: #2a5298; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }

        /* TABEL */
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        
        table th {
            background: #2a5298;
            color: white;
            font-size: 14px;
            text-transform: uppercase;
        }

        tr:hover { background: #f9f9f9; }

        /* BADGE KATEGORI */
        .badge {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }
        
        /* Warna Badge Berdasarkan Kategori */
        .kat-user { background: #e3f2fd; color: #1e3c72; border: 1px solid #bbdefb; }
        .kat-buku { background: #f3e5f5; color: #7b1fa2; border: 1px solid #e1bee7; }
        .kat-pinjam { background: #fff3e0; color: #e67e22; border: 1px solid #ffe0b2; }

        .waktu-log { font-size: 12px; color: #888; }
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
    <a href="riwayat_peminjaman.php">Riwayat Peminjaman</a>
    <a href="data_anggota.php">Data Anggota</a>
    <a href="tambah_anggota.php">Tambah Anggota</a>
    <a href="laporan_aktivitas.php" class="active">Laporan Aktivitas</a>
    <a href="../logout.php" class="logout">Logout</a>
  </div>

    <div class="content">
        <div class="container">
            <h2>Riwayat Aktivitas Sistem</h2>

            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Pelaku</th>
                        <th>Aktivitas</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): 
                        // Logika warna badge
                        $kat = strtolower($row['kategori']);
                        $badge_class = "kat-user"; // Default
                        if($kat == 'buku') $badge_class = "kat-buku";
                        if($kat == 'pinjam') $badge_class = "kat-pinjam";
                    ?>
                    <tr>
                        <td class="waktu-log"><?= date('d/m/Y | H:i', strtotime($row['waktu'])) ?></td>
                        <td><strong><?= htmlspecialchars($row['nama_pelaku']) ?></strong></td>
                        <td><?= htmlspecialchars($row['aktivitas']) ?></td>
                        <td>
                            <span class="badge <?= $badge_class ?>">
                                <?= strtoupper($row['kategori']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>