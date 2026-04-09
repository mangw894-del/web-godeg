<?php 
include '../config.php';
include '../auth.php';

// Pastikan hanya admin yang bisa hapus
if($_SESSION['role'] != 'admin'){
    die("Akses dilarang!");
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // 1. Ambil dulu nama usernya buat keperluan log sebelum dihapus
    $ambil_user = mysqli_query($koneksi, "SELECT username FROM users WHERE id='$id'");
    $data_user = mysqli_fetch_assoc($ambil_user);
    $nama_dihapus = $data_user['username'];

    // 2. Jalankan perintah hapus
    $query_hapus = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

    if ($query_hapus) {
        // 3. CATAT LOG AKTIVITAS (Hanya jika berhasil hapus)
        // Kita catat nama usernya biar jelas siapa yang dihapus
        catat_log($koneksi, "Menghapus anggota: $nama_dihapus", "User");

        header("location:data_anggota.php?pesan=hapus_berhasil");
        exit;
    } else {
        // Jika gagal hapus
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    // Jika tidak ada ID di URL
    header("location:data_anggota.php");
    exit;
}
?>