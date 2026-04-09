<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role'] != 'user'){
    die("Akses ditolak!");
}

$user = $_SESSION['user'];

// Query JOIN untuk ambil semua data pinjaman
$query = mysqli_query($koneksi, "
    SELECT peminjaman.*, buku.judul, buku.foto 
    FROM peminjaman 
    JOIN buku ON peminjaman.id_buku = buku.id 
    WHERE peminjaman.nama_peminjam = '$user' 
    ORDER BY peminjaman.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pinjaman - Member</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f0f2f5;
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #1a2a6c;
            color: white;
            padding: 30px 20px;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 18px;
            text-transform: uppercase;
        }

        .sidebar a {
            display: block;
            color: #bdc3c7;
            text-decoration: none;
            padding: 12px 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .logout {
            background: #e74c3c !important;
            color: white !important;
            margin-top: 50px;
            text-align: center;
        }

        /* CONTENT */
        .content {
            margin-left: 260px;
            flex: 1;
            padding: 40px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .header-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #1a2a6c;
            font-size: 24px;
        }

        /* TOMBOL CETAK */
        .btn-cetak {
            background: #27ae60;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-cetak:hover {
            background: #219150;
        }

        /* TABEL STYLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8f9fc;
            color: #1a2a6c;
            padding: 15px;
            font-size: 14px;
            border-bottom: 2px solid #eee;
            text-align: center;
        }

        td {
            padding: 20px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
            font-size: 14px;
            color: #444;
            text-align: center;
        }

        .img-buku {
            width: 65px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .badge {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .dipinjam { background: #fff4e5; color: #ff9800; }
        .kembali { background: #e8f5e9; color: #2e7d32; }

        /* ===== CSS KHUSUS CETAK ===== */
        @media print {
            .sidebar, .btn-cetak, .logout, .btn-aksi-kembali {
                display: none !important;
            }
            .content {
                margin-left: 0;
                padding: 0;
            }
            .container {
                box-shadow: none;
                border: none;
            }
            body { background: white; }
            h1 {
                text-align: center;
                margin-bottom: 20px;
            }
            table {
                border: 1px solid #ddd;
            }
            th, td {
                border-bottom: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar">
    <h2>Perpustakaan</h2>
    <a href="dashboard_member.php">Dashboard</a>
    <a href="riwayat_member.php" class="active">Riwayat</a> 
    <a href="../logout.php" class="logout">Logout</a>
</div>
    <div class="content">
        <div class="container">
            <div class="header-box">
                <h1>Riwayat Peminjaman</h1>
            </div>
            <table>
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th width="120">Buku</th>
                        <th>Judul Buku</th>
                        <th width="200">Tanggal Pinjam</th>
                        <th width="150">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($query) > 0) {
                        while($row = mysqli_fetch_assoc($query)) {
                            $status_class = ($row['status'] == 'Dipinjam') ? 'dipinjam' : 'kembali';
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <?php if(!empty($row['foto'])): ?>
                                <img src="../upload/<?= $row['foto'] ?>" class="img-buku">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/65x90?text=No+Img" class="img-buku">
                            <?php endif; ?>
                        </td>
                        
                        <td style="font-weight: 600; color: #333;">
                            <?= htmlspecialchars($row['judul']) ?>
                        </td>

                        <td>
                            <?= date('d F Y', strtotime($row['tanggal_pinjam'])) ?>
                        </td>
                        <td>
                            <span class="badge <?= $status_class ?>">
                                <?= $row['status'] ?>
                            </span>
    
                            <?php if($row['status'] == 'Dipinjam'): ?>
                            <div class="btn-aksi-kembali">
                                <br>
                                <a href="proses_kembali.php?id=<?= $row['id'] ?>&id_buku=<?= $row['id_buku'] ?>" 
                                style="display:inline-block; margin-top:8px; color:#e74c3c; font-size:11px; font-weight:bold; text-decoration:none; border:1px solid #e74c3c; padding:2px 8px; border-radius:5px;"
                                onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                                Kembalikan
                                </a>
                            </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='5' style='padding:50px; color:#999;'>Kamu belum meminjam buku apa pun.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>