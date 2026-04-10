<?php
include '../config.php';
include '../auth.php';

// Pastikan hanya user/member yang bisa masuk
if($_SESSION['role'] != 'user'){
    die("Akses ditolak!");
}

$user = $_SESSION['username'];
$tanggal = date("d F Y");

// --- LOGIKA SEARCH ---
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $queryBuku = "SELECT * FROM buku WHERE judul LIKE '%$search%' AND stok > 0 ORDER BY id DESC";
} else {
    $queryBuku = "SELECT * FROM buku WHERE stok > 0 ORDER BY id DESC";
}
$daftarBuku = mysqli_query($koneksi, $queryBuku);

// --- DATA STATISTIK ---
$qPinjam = mysqli_query($koneksi, "SELECT id FROM peminjaman WHERE nama_peminjam='$user' AND status='Dipinjam'");
$jaktif = mysqli_num_rows($qPinjam);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - Member</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            background: #f8fafc;
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR MODERN (Dark Slate) */
        .sidebar {
            width: 270px;
            background: #0f172a; /* Warna lebih gelap & elegan */
            color: white;
            padding: 30px 20px;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
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

        /* LOGOUT: Rata Kiri & Merah Kalem */
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

        /* CONTENT AREA */
        .content {
            margin-left: 270px;
            flex: 1;
            padding: 40px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .welcome-text h1 {
            color: #1e293b;
            font-size: 28px;
            font-weight: 700;
        }

        .welcome-text p {
            color: #64748b;
            font-size: 14px;
        }

        /* SEARCH BOX ELEGAN */
        .search-container {
            display: flex;
            background: white;
            padding: 8px 10px 8px 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 400px;
            border: 1px solid #e2e8f0;
        }

        .search-container input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
            color: #1e293b;
        }

        .search-container button {
            background: #4f46e5;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: 0.3s;
        }

        .search-container button:hover {
            background: #4338ca;
        }

        /* GRID KATALOG */
        .katalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 25px;
        }

        .card-buku {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.03);
            transition: 0.3s;
            border: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
        }

        .card-buku:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0,0,0,0.08);
        }

        .card-buku img {
            width: 100%;
            height: 390px;
            object-fit: cover;
        }

        .card-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .stok-badge {
            display: inline-block;
            background: #f0fdf4;
            color: #16a34a;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .card-body h4 {
            color: #1e293b;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .card-body p {
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 20px;
        }

        .btn-pinjam {
            background: #4f46e5;
            color: white;
            text-decoration: none;
            text-align: center;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-top: auto;
            transition: 0.3s;
        }

        .btn-pinjam:hover {
            background: #1e293b;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 0;
        }

        .empty-state h3 { color: #64748b; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>LIB-MEMBER</h2>
        <a href="dashboard_member.php" class="active">Katalog Buku</a>
        <a href="riwayat_member.php">Buku Saya (<?= $jaktif ?>)</a> 
        <a href="../logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <div class="top-bar">
            <div class="welcome-text">
                <h1>Katalog Buku</h1>
                <p>Hari ini: <b><?= $tanggal ?></b> | Selamat datang, <?= htmlspecialchars($user) ?>!</p>
            </div>

            <form action="" method="GET" class="search-container">
                <input type="text" name="search" placeholder="Cari buku kesukaanmu..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Cari</button>
            </form>
        </div>

        <div class="katalog-grid">
            <?php if (mysqli_num_rows($daftarBuku) > 0): ?>
                <?php while($b = mysqli_fetch_assoc($daftarBuku)): ?>
                <div class="card-buku">
                    <?php if(!empty($b['foto'])): ?>
                        <img src="../upload/<?= $b['foto'] ?>" alt="Cover">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/240x320?text=No+Cover" alt="No Cover">
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <div>
                            <span class="stok-badge">Tersedia: <?= $b['stok'] ?> Pcs</span>
                        </div>
                        <h4><?= htmlspecialchars($b['judul']) ?></h4>
                        <p><?= htmlspecialchars($b['pengarang']) ?> (<?= $b['tahun_terbit'] ?>)</p>
                        
                        <a href="proses_pinjam.php?id=<?= $b['id'] ?>" 
                           class="btn-pinjam" 
                           onclick="return confirm('Apakah Anda yakin ingin meminjam buku ini?')">
                            Pinjam Sekarang
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h3>Yah, buku tidak ditemukan...</h3>
                    <p>Coba gunakan kata kunci judul yang lain ya.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>