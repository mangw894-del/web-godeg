<?php
include '../config.php';
include '../auth.php';

if (!isset($_SESSION['login'])) {
    die("Akses ditolak");
}
logAktivitas($koneksi, $_SESSION['user'], "Menghapus buku ID: $id");

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = intval($_GET['id']);

/* Cek apakah buku masih dipinjam */
$cek = mysqli_query($koneksi, "
    SELECT * FROM peminjaman 
    WHERE id_buku = $id 
    AND status = 'dipinjam'
");

if (mysqli_num_rows($cek) > 0) {
    die("Buku tidak bisa dihapus karena sedang dipinjam!");
}

/* Hapus buku */
mysqli_query($koneksi, "DELETE FROM buku WHERE id=$id");

header("Location: data_buku.php");
exit;
?>