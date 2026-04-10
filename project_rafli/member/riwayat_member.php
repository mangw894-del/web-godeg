<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role'] != 'user'){
    die("Akses ditolak!");
}

$user = $_SESSION['username'];

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            background: #f8fafc;
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR SINKRON DENGAN DASHBOARD */
        .sidebar {
            width: 270px;
            height: 100vh;
            background: #0f172a;
            color: white;
            padding: 30px 20px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: #94a3b8;
            text-decoration: none;
            padding: 14px 18px;
            margin-bottom: 8px;
            border-radius: 12px;
            transition: 0.3s;
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        /* PERBAIKAN LOGOUT: Rata Kiri & Warna Kalem */
        .sidebar .logout {
            background: rgba(231, 74, 59, 0.15) !important;
            color: #ff7675 !important;
            margin-top: 50px;
            text-align: left;
            border: 1px solid rgba(231, 74, 59, 0.2);
        }

        .sidebar .logout:hover {
            background: rgba(231, 74, 59, 0.25) !important;
            color: white !important;
        }

        /* CONTENT */
        .content {
            margin-left: 270px;
            flex: 1;
            padding: 40px;
        }

        .container {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid #edf2f7;
        }

        .header-box {
            margin-bottom: 30px;
        }

        h1 {
            color: #1e293b;
            font-size: 24px;
            font-weight: 700;
        }

        /* TABEL STYLE */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            background: #f8fafc;
            color: #4f46e5; /* Warna indigo */
            padding: 15px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f1f5f9;
            text-align: center;
        }

        td {
            padding: 20px 15px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 14px;
            color: #475569;
            text-align: center;
        }

        tr:hover td { background: #fafafa; }

        .img-buku {
            width: 60px;
            height: 85px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        /* BADGE STATUS */
        .badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            text-transform: uppercase;
        }

        .dipinjam { background: #fff7ed; color: #ea580c; }
        .kembali { background: #f0fdf4; color: #16a34a; }

        /* LINK KEMBALIKAN */
        .link-kembali {
            display: inline-block;
            margin-top: 8px;
            color: #ef4444;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            padding: 4px 10px;
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 6px;
            transition: 0.3s;
        }

        .link-kembali:hover {
            background: #ef4444;
            color: white;
        }

        /* ===== CETAK ===== */
        @media print {
            .sidebar, .link-kembali { display: none !important; }
            .content { margin-left: 0; padding: 0; }
            .container { box-shadow: none; border: none; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>LIB-MEMBER</h2>
    <a href="dashboard_member.php">Katalog Buku</a>
    <a href="riwayat_member.php" class="active">Buku Saya</a> 
    <a href="../logout.php" class="logout">Logout</a>
</div>

<div class="content">
    <div class="container">
        <div class="header-box">
            <h1>Riwayat Peminjaman Kamu</h1>
            <p style="color: #64748b; font-size: 14px;">Pantau daftar buku yang sedang kamu baca atau yang sudah dikembalikan.</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th width="100">Cover</th>
                    <th>Judul Buku</th>
                    <th width="180">Tanggal Pinjam</th>
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
                            <img src="https://via.placeholder.com/60x85?text=No+Cover" class="img-buku">
                        <?php endif; ?>
                    </td>
                    
                    <td style="font-weight: 600; color: #1e293b; text-align: left;">
                        <?= htmlspecialchars($row['judul']) ?>
                    </td>

                    <td style="color: #64748b;">
                        <?= date('d M Y', strtotime($row['tanggal_pinjam'])) ?>
                    </td>

                    <td>
                        <span class="badge <?= $status_class ?>">
                            <?= $row['status'] ?>
                        </span>

                        <?php if($row['status'] == 'Dipinjam'): ?>
                        <div>
                            <a href="proses_kembali.php?id=<?= $row['id'] ?>&id_buku=<?= $row['id_buku'] ?>" 
                               class="link-kembali"
                               onclick="return confirm('Apakah kamu ingin mengembalikan buku ini sekarang?')">
                                Kembalikan
                            </a>
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php 
                    } 
                } else {
                    echo "<tr><td colspan='5' style='padding:80px; color:#94a3b8;'>Kamu belum meminjam buku apapun. Yuk cari buku di katalog!</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>