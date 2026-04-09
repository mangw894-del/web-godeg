<?php
session_start();
include '../config.php';

if (!isset($_SESSION['login'])) {
    header("location:../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_pinjam = $_GET['id'];
    $user = $_SESSION['user'];

    $query_cek = mysqli_query($koneksi, "SELECT id_buku FROM peminjaman WHERE id = '$id_pinjam'");
    $data = mysqli_fetch_assoc($query_cek);
    
    if ($data) {
        $id_buku = $data['id_buku'];

        $update_pinjam = mysqli_query($koneksi, "UPDATE peminjaman SET status = 'Dikembalikan' WHERE id = '$id_pinjam'");

        if ($update_pinjam) {
         
            mysqli_query($koneksi, "UPDATE buku SET stok = stok + 1 WHERE id = '$id_buku'");

    
            mysqli_query($koneksi, "INSERT INTO log_aktivitas (user, aktivitas, waktu) VALUES ('$user', 'Berhasil mengembalikan buku', NOW())");

            echo "<script>
                    alert('Buku Berhasil Dikembalikan! Stok buku otomatis bertambah.');
                    window.location = 'riwayat_member.php';
                  </script>";
        } else {
            echo "Gagal update status: " . mysqli_error($koneksi);
        }
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='riwayat_member.php';</script>";
    }
} else {
    header("location:riwayat_member.php");
}
?>