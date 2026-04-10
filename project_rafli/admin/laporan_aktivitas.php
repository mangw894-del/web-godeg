<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role'] != 'admin'){
    die("Akses ditolak!");
}

$result = mysqli_query($koneksi, "SELECT * FROM log_aktivitas ORDER BY waktu DESC LIMIT 50");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aktivitas - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>

        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }

        body {
            min-height: 100vh;
            background: #f4f7fe;
        }

        .wrapper { display: flex; min-height: 100vh; }

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
        
        .content {
            flex: 1;
            padding: 40px;
            margin-left: 270px;
        }

        .container {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid #edf2f7;
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h2 { color: #2d3748; font-weight: 700; font-size: 24px; }

        .btn-cetak {
            background: #4e73df;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .btn-cetak:hover { background: #2e59d9; transform: translateY(-2px); }

        table { width: 100%; border-collapse: separate; border-spacing: 0; }
        table th {
            background: #f8f9fc;
            color: #4e73df;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 15px;
            border-bottom: 2px solid #edf2f7;
            text-align: left;
        }
        table td { 
            padding: 18px 15px; 
            border-bottom: 1px solid #edf2f7;
            color: #4a5568;
            font-size: 14px;
        }

    
        @media print {
            .sidebar, .btn-cetak { display: none !important; }
            .content { margin-left: 0 !important; padding: 0 !important; }
            .container { box-shadow: none !important; border: none !important; padding: 0 !important; }
            body { background: white !important; }
            h2 { font-size: 20px; margin-bottom: 20px; }
            table { font-size: 12px; }
            table td, table th { padding: 10px 5px !important; }
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
        <a href="tambah_anggota.php">Tambah Anggota</a>
        <a href="laporan_aktivitas.php" class="active">Laporan Aktivitas</a>
        <a href="../logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <div class="container">
            <div class="header-flex">
                <h2>Riwayat Aktivitas Sistem</h2>
                <button onclick="window.print()" class="btn-cetak">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Laporan
                </button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="180">Waktu</th>
                        <th width="180">Pelaku</th>
                        <th>Aktivitas / Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td style="font-weight:600; color:#718096; font-size:13px;">
                                <?= date('d M Y', strtotime($row['waktu'])) ?> 
                                <span style="font-weight:400; color:#cbd5e0; margin:0 5px;">|</span>
                                <?= date('H:i', strtotime($row['waktu'])) ?>
                            </td>
                            <td style="color: #2d3748; font-weight: 600;">
                                <?= htmlspecialchars($row['nama_pelaku']) ?>
                            </td>
                            <td style="line-height: 1.6;">
                                <?= htmlspecialchars($row['aktivitas']) ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align:center; padding:50px; color:#a0aec0;">
                                Belum ada riwayat aktivitas yang tercatat.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>