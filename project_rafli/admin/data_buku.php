<?php
include '../config.php';
include '../auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $query = mysqli_query($koneksi, "SELECT * FROM buku 
        WHERE judul LIKE '%$search%' 
        OR pengarang LIKE '%$search%' 
        OR penerbit LIKE '%$search%'
        ORDER BY id DESC");
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Buku - Admin Panel</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    min-height: 100vh;
    background: #f4f7fe; /* Warna background sama dengan dashboard */
}

/* WRAPPER */
.wrapper {
    display: flex;
    min-height: 100vh;
}

/* SIDEBAR - DISAMAKAN PERSIS DENGAN DASHBOARD */
.sidebar {
    width: 270px;
    background: #1a1c2e;
    color: #a0aec0;
    padding: 30px 20px;
    height: 100vh;
    position: fixed; /* Fixed agar tidak goyang */
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

.sidebar a:hover {
    background: rgba(255,255,255,0.05);
    color: #fff;
    padding-left: 25px;
}

.sidebar a.active {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    color: #fff;
    box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
}

.sidebar .logout {
    background: rgba(231, 74, 59, 0.1);
    color: #e74a3b;
    margin-top: 30px;
}

/* CONTENT AREA */
.content {
    flex: 1;
    padding: 40px;
    margin-left: 270px; /* Jarak pas sesuai lebar sidebar */
}

/* HEADER BOX (BOX PUTIH) */
.box {
    background: #fff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
}

/* TOP SECTION */
.top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #f0f0f0;
}

/* BUTTON TAMBAH */
.top-btn {
    text-decoration: none;
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    color: #fff;
    padding: 12px 25px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    transition: 0.3s;
    box-shadow: 0 4px 10px rgba(78, 115, 223, 0.2);
}

.top-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(78, 115, 223, 0.3);
}

/* SEARCH BOX */
.search-box {
    display: flex;
    gap: 10px;
}

.search-box input {
    padding: 12px 20px;
    border-radius: 12px;
    border: 1px solid #e0e0e0;
    outline: none;
    width: 250px;
    transition: 0.3s;
}

.search-box input:focus {
    border-color: #4e73df;
}

.search-box button {
    padding: 0 20px;
    border: none;
    background: #1a1c2e;
    color: #fff;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
}

/* GRID LAYOUT */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 25px;
}

/* CARD BUKU ELEGHAN */
.card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #edf2f7;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}

.card img {
    width: 100%;
    height: 370px; /* Lebih tinggi agar lebih eleghan */
    object-fit: cover;
    border-bottom: 1px solid #f0f0f0;
}

.card-body {
    padding: 20px;
}

.card-body h3 {
    font-size: 16px;
    color: #2d3748;
    margin-bottom: 10px;
    height: 45px; /* Biar judul yang panjang gak ngerusak layout */
    overflow: hidden;
}

.card-body p {
    font-size: 13px;
    color: #718096;
    margin-bottom: 5px;
}

.card-body p b {
    color: #4e73df;
}

/* AKSI BUTTONS */
.aksi {
    margin-top: 20px;
    display: flex;
    gap: 10px;
}

.aksi a {
    flex: 1;
    text-align: center;
    text-decoration: none;
    padding: 8px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    transition: 0.3s;
}

.edit {
    background: rgba(78, 115, 223, 0.1);
    color: #4e73df;
}

.edit:hover {
    background: #4e73df;
    color: #fff;
}

.hapus {
    background: rgba(231, 74, 59, 0.1);
    color: #e74a3b;
}

.hapus:hover {
    background: #e74a3b;
    color: #fff;
}
</style>
</head>

<body>

<div class="wrapper">

    <?php include 'sidebar.php'; ?>

    <div class="content">

        <div class="box">
            <div class="top">
                <a href="tambah_buku.php" class="top-btn">+ Tambah Buku</a>

                <form method="GET" class="search-box">
                    <input type="text" name="search" placeholder="Cari judul, pengarang..." value="<?= htmlspecialchars($search); ?>">
                    <button type="submit">Cari</button>
                </form>
            </div>

            <div class="grid">
                <?php if (mysqli_num_rows($query) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                        <div class="card">
                            <?php if(!empty($row['foto'])): ?>
                                <img src="../upload/<?= $row['foto']; ?>" alt="Cover">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/240x350?text=No+Cover" alt="No Cover">
                            <?php endif; ?>

                            <div class="card-body">
                                <h3><?= $row['judul']; ?></h3>
                                <p><b>Pengarang:</b> <?= $row['pengarang']; ?></p>
                                <p><b>Penerbit:</b> <?= $row['penerbit']; ?></p>
                                <p><b>Tahun:</b> <?= $row['tahun_terbit']; ?></p>
                                <p><b>Stok:</b> <?= $row['stok']; ?> Buku</p>
                        
                                <div class="aksi">
                                    <a href="edit_buku.php?id=<?= $row['id']; ?>" class="edit">Edit</a>
                                    <a href="hapus_buku.php?id=<?= $row['id']; ?>" class="hapus" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 50px; color: #a0aec0;">
                        Data buku tidak ditemukan.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>