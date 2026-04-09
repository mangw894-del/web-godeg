<?php
include '../config.php';
include '../auth.php';

// 1. LOGIC PHP (Paling Atas)
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$query = mysqli_query($koneksi, "
    SELECT peminjaman.*, buku.judul 
    FROM peminjaman
    JOIN buku ON peminjaman.id_buku = buku.id
    ORDER BY peminjaman.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        /* 2. BLOK CSS (Rapi & Tidak Menumpuk) */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body { 
            min-height: 100vh; 
            background: linear-gradient(135deg, #1e3c72, #2a5298); 
        }

        .wrapper { display: flex; min-height: 100vh; }

        /* SIDEBAR */
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
        .sidebar a:hover, .sidebar a.active { background: rgba(255, 255, 255, 0.2); }
        .sidebar .logout { background: #e74a3b; margin-top: 20px; text-align: center; }

        /* CONTENT AREA */
        .content { flex: 1; padding: 30px; margin-left: 260px; }
        
        .container { 
            background: white; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
        }

        .header-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }
        h2 { color: #2a5298; }

        /* TABEL */
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
        table th { background: #2a5298; color: white; }
        tr:hover { background: #f9f9f9; }

        /* TOMBOL CETAK */
        .btn-cetak {
            background: #27ae60;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-cetak:hover { background: #219150; transform: scale(1.03); }

        /* BADGE STATUS */
        .badge { padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .dipinjam { color: #856404; background: #fff3cd; border: 1px solid #ffeeba; }
        .kembali { color: #155724; background: #d4edda; border: 1px solid #c3e6cb; }

        /* MEDIA PRINT (Agar rapi saat dicetak) */
        @media print {
            .sidebar, .btn-cetak { display: none !important; }
            .content { margin-left: 0 !important; padding: 0 !important; }
            body { background: white !important; }
            .container { box-shadow: none; border: 1px solid #000; }
            table th { background: #eee !important; color: black !important; }
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
        <a href="riwayat_peminjaman.php" class="active">Riwayat Peminjaman</a>
        <a href="data_anggota.php">Data Anggota</a>
        <a href="tambah_anggota.php">Tambah Anggota</a>
        <a href="laporan_aktivitas.php">Laporan Aktivitas</a>
        <a href="../logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <div class="container">
            <div class="header-box">
                <h2>Riwayat Peminjaman Buku</h2>
                <button onclick="window.print()" class="btn-cetak">Cetak Laporan</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Nama Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)) { 
                        $statusClass = ($row['status'] == 'Dipinjam') ? 'dipinjam' : 'kembali';
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><strong><?= htmlspecialchars($row['judul']); ?></strong></td>
                        <td><?= htmlspecialchars($row['nama_peminjam']); ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_pinjam'])); ?></td>
                        <td><?= ($row['tanggal_kembali']) ? date('d-m-Y', strtotime($row['tanggal_kembali'])) : '-'; ?></td>
                        <td>
                            <span class="badge <?= $statusClass ?>">
                                <?= $row['status']; ?>
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>