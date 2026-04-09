<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role'] != 'admin'){
    die("Akses ditolak!");
}

$data = mysqli_query($koneksi, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Anggota - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* CSS GLOBAL */
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
        body{ min-height:100vh; background:linear-gradient(135deg,#1e3c72,#2a5298); }
        .wrapper{display:flex;min-height:100vh}

        /* SIDEBAR (DIPERBAIKI) */
        .sidebar{
            width:260px;
            background:rgba(0,0,0,.25);
            backdrop-filter:blur(10px);
            color:white;
            padding:30px 20px;
            position: fixed;
            height: 100vh;
        }
        .sidebar h3{text-align:center;margin-bottom:30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;}
        .sidebar a{display:block;padding:12px;color:white;text-decoration:none;border-radius:10px;margin-bottom:10px; transition: 0.3s;}
        .sidebar a:hover, .sidebar a.active{background:rgba(255,255,255,.2)}
        .sidebar .logout{background:#e74a3b; text-align: center; margin-top: 20px;}

        /* CONTENT AREA */
        .content{ flex:1; padding:30px; margin-left: 260px; }
        .container{ background:white; padding:30px; border-radius:15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        
        h2{margin-bottom:20px; color:#2a5298;}

        /* TABEL RAPI */
        table{ width:100%; border-collapse:collapse; overflow: hidden; border-radius: 10px; }
        table th, table td{ padding:15px; text-align:center; border-bottom:1px solid #eee; }
        table th{ background:#2a5298; color:white; font-weight: 600; }
        tr:hover{ background:#f9f9f9; }

        /* TOMBOL AKSI */
        .btn-edit { color: #2a5298; text-decoration: none; font-weight: 600; }
        .btn-hapus { color: #e74a3b; text-decoration: none; font-weight: 600; }
        .btn-edit:hover, .btn-hapus:hover { text-decoration: underline; }
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
            <h2>Data Anggota</h2>

            <table>
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    while($d = mysqli_fetch_array($data)){ 
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($d['username']) ?></strong></td>
                        <td>
                            <span style="padding: 4px 10px; background: #eee; border-radius: 20px; font-size: 12px;">
                                <?= $d['role'] ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit_anggota.php?id=<?= $d['id'] ?>" class="btn-edit">Edit</a> | 
                            <a href="hapus_anggota.php?id=<?= $d['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin mau hapus si <?= $d['username'] ?>?')">Hapus</a>
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