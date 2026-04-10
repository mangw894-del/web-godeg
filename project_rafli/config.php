<?php
$koneksi = mysqli_connect("localhost","root","","perpusdeg");

if(!$koneksi){
    die("Koneksi gagal: ".mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function catat_log($koneksi, $aksi, $kategori) {
    $nama = isset($_SESSION['username']) ? $_SESSION['username'] : 'Member';
    
    $aksi_safe = mysqli_real_escape_string($koneksi, $aksi);
    
    mysqli_query($koneksi, "INSERT INTO log_aktivitas (nama_pelaku, aktivitas, kategori) 
    VALUES ('$nama', '$aksi_safe', '$kategori')");
}
?>