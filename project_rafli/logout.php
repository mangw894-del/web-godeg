<?php
include 'config.php';
session_start();

// 1. Cek apakah masih ada session (biar gak error kalau diakses langsung)
if (isset($_SESSION['username'])) {
    
    // 2. CATAT LOG LOGOUT
    // Kita catat aktivitasnya sebelum session dibuang
    catat_log($koneksi, "Berhasil Logout dari Sistem", "Auth");

    // 3. HAPUS SEMUA DATA SESSION
    $_SESSION = []; // Kosongkan array session
    session_unset();
    session_destroy();
}

// 4. LEMPAR BALIK KE LOGIN
header("Location: login.php?pesan=logout_berhasil");
exit;
?>