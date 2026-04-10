<?php
include '../config.php';
// Pastikan auth check ada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("location:../login.php");
    exit;
}

// Ambil data dari URL
$id_pinjam = mysqli_real_escape_string($koneksi, $_GET['id']);
$id_buku   = mysqli_real_escape_string($koneksi, $_GET['id_buku']);

//  AMBIL JUDUL BUKU DULU 
$cekBuku = mysqli_query($koneksi, "SELECT judul FROM buku WHERE id = '$id_buku'");
$dataBuku = mysqli_fetch_assoc($cekBuku);
$judulBuku = $dataBuku['judul'];

//  UPDATE STATUS PINJAM
$updateStatus = mysqli_query($koneksi, "UPDATE peminjaman SET status = 'Dikembalikan' WHERE id = '$id_pinjam'");

if ($updateStatus) {
    // .TAMBAHKAN STOK BUKU 
    $tambahStok = mysqli_query($koneksi, "UPDATE buku SET stok = stok + 1 WHERE id = '$id_buku'");

     if ($insertkembali) {
            catat_log($koneksi, "Mengembalikan buku: $judulBuku", "kembali");

        echo "<script>
                alert('Buku $judulBuku berhasil dikembalikan! Stok bertambah.');
                window.location='riwayat_member.php';
              </script>";
    } else {
        echo "Gagal update stok: " . mysqli_error($koneksi);
    }
} else {
    echo "Gagal memproses pengembalian: " . mysqli_error($koneksi);
}
?>