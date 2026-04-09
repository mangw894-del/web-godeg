<?php
include '../config.php';
include '../auth.php';

if($_SESSION['role'] != 'user'){
    die("Akses ditolak!");
}

$user = $_SESSION['user'];
$tanggal = date("d F Y");

// --- LOGIKA SEARCH (PENCARIAN) ---
$search = "";
if (isset($_GET['search'])) {
    // Perbaikan: Fungsi yang benar adalah mysqli_real_escape_string
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
    <title>Katalog Buku - Member</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        /* CSS */
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

        /* SIDEBAR KIRI */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #1a2a6c;
            color: white;
            padding: 30px 20px;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
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
            font-weight: 600;
        }

        /* KONTEN UTAMA */
        .content {
            margin-left: 260px;
            flex: 1;
            padding: 40px;
        }

        /* HEADER & SEARCH */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
        }

        .welcome-text h1 {
            color: #1a2a6c;
            font-size: 28px;
        }

        .search-container {
            display: flex;
            background: white;
            padding: 8px 20px;
            border-radius: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 350px;
        }

        .search-container input {
            border: none;
            outline: none;
            width: 100%;
            padding: 5px;
            font-size: 14px;
        }

        .search-container button {
            background: #1a2a6c;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            transition: 0.3s;
        }

        .search-container button:hover {
            background: #b21f1f;
        }

        /* GRID KATALOG BUKU */
        .katalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 30px;
        }

        /* CARD BUKU */
        .card-buku {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            border: 1px solid #eee;
        }

        .card-buku:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.1);
        }

        .card-buku img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            background: #f8f8f8;
        }

        .card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .stok-badge {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 3px 10px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 10px;
            display: inline-block;
        }

        .card-body h4 {
            font-size: 15px;
            color: #333;
            margin-bottom: 5px;
            line-height: 1.4;
            height: 42px;
            overflow: hidden;
        }

        .card-body p {
            font-size: 12px;
            color: #888;
            margin-bottom: 15px;
        }

        .btn-pinjam {
            background: #1a2a6c;
            color: white;
            text-decoration: none;
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            margin-top: auto;
            transition: 0.3s;
        }

        .btn-pinjam:hover {
            background: #b21f1f;
        }

        /* NOTIFIKASI KOSONG */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 100px 0;
            color: #999;
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
        
        <div class="top-bar">
            <div class="welcome-text">
                <h1>Katalog Buku</h1>
                <p>Halo <b><?= $user ?></b>, selamat membaca!</p>
            </div>

            <form action="" method="GET" class="search-container">
                <input type="text" name="search" placeholder="Cari judul buku..." value="<?= htmlspecialchars($search) ?>">
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
                        <img src="https://via.placeholder.com/220x280?text=No+Image" alt="No Cover">
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <div>
                            <span class="stok-badge">Tersedia: <?= $b['stok'] ?></span>
                        </div>
                        <h4><?= $b['judul'] ?></h4>
                        <p><?= $b['pengarang'] ?> | <?= $b['tahun_terbit'] ?></p>
                        
                        <a href="proses_pinjam.php?id=<?= $b['id'] ?>" 
                           class="btn-pinjam" 
                           onclick="return confirm('Pinjam buku ini?')">
                           Pinjam Sekarang
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h3>Yah, buku "<?= htmlspecialchars($search) ?>" tidak ditemukan...</h3>
                    <p>Coba cari dengan kata kunci lain bos.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>