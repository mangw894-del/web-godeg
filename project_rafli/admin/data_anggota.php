<?php
include '../config.php';
include '../auth.php';

// Pastikan hanya admin yang bisa masuk
if($_SESSION['role'] != 'admin'){
    die("Akses ditolak!");
}

// Ambil data users
$data = mysqli_query($koneksi, "SELECT * FROM users ORDER BY role ASC, username ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Anggota - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* GLOBAL STYLE */
        *{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif }
        
        body{ 
            min-height:100vh; 
            background: #f4f7fe; 
        }

        .wrapper{ display:flex; min-height:100vh; }

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

        /* Menu Aktif & Hover: Dibuat gelap transparan (Bukan biru menyala) */
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        /* LOGOUT: Rata kiri dan warna merah kalem */
        .sidebar .logout {
            background: rgba(231, 74, 59, 0.1);
            color: #ff7675;
            margin-top: 30px;
            text-align: left; /* Perbaikan rata kiri */
            border: 1px solid rgba(231, 74, 59, 0.1);
        }

        .sidebar .logout:hover {
            background: rgba(231, 74, 59, 0.2);
            color: #fff;
        }

        /* CONTENT AREA */
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
        
        .header-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-box h2 {
            color: #2d3748;
            font-weight: 700;
            font-size: 24px;
        }

        /* TABEL MODERN */
        table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0; 
        }

        table th { 
            background: #f8f9fc; 
            color: #4e73df; 
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
            padding: 15px;
            border-bottom: 2px solid #edf2f7;
        }

        table td { 
            padding: 18px 15px; 
            text-align: center; 
            border-bottom: 1px solid #edf2f7;
            color: #4a5568;
            font-size: 14px;
        }

        tr:hover td { background: #fdfdfd; }

        /* BADGE ROLE */
        .badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .role-admin { background: rgba(78, 115, 223, 0.1); color: #4e73df; }
        .role-user { background: rgba(28, 200, 138, 0.1); color: #1cc88a; }

        /* AKSI BUTTONS */
        .btn-aksi {
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            transition: 0.3s;
            padding: 5px 10px;
        }

        .btn-edit { color: #4e73df; }
        .btn-edit:hover { color: #224abe; }
        
        .btn-hapus { color: #e74a3b; }
        .btn-hapus:hover { color: #be2617; }
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
            <div class="header-box">
                <h2>Data Anggota Sistem</h2>
                <a href="tambah_anggota.php" style="text-decoration:none; background:#4e73df; color:white; padding:10px 20px; border-radius:10px; font-size:14px; font-weight:600;">+ Tambah Anggota</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="70">No</th>
                        <th style="text-align:left;">Username / Nama</th>
                        <th>Hak Akses (Role)</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    while($d = mysqli_fetch_array($data)){ 
                        $roleClass = ($d['role'] == 'admin') ? 'role-admin' : 'role-user';
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td style="text-align:left;">
                            <strong style="color: #2d3748;"><?= htmlspecialchars($d['username']) ?></strong>
                        </td>
                        <td>
                            <span class="badge <?= $roleClass ?>">
                                <?= $d['role'] ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit_anggota.php?id=<?= $d['id'] ?>" class="btn-aksi btn-edit">Edit</a>
                            <span style="color: #edf2f7;">|</span>
                            <a href="hapus_anggota.php?id=<?= $d['id'] ?>" class="btn-aksi btn-hapus" onclick="return confirm('Yakin ingin menghapus akun <?= $d['username'] ?>?')">Hapus</a>
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