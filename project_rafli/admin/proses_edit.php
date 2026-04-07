<?php
include '../config.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$pengarang = $_POST['pengarang'];
$penerbit = $_POST['penerbit'];
$tahun = $_POST['tahun_terbit'];
$stok = $_POST['stok'];

$foto_lama = $_POST['foto_lama'];

/* CEK APAKAH UPLOAD FOTO BARU */
if ($_FILES['foto']['name'] != "") {

    $nama_file = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    move_uploaded_file($tmp, "../upload/".$nama_file);

    $foto = $nama_file;

} else {
    /* kalau tidak upload, pakai foto lama */
    $foto = $foto_lama;
}

/* UPDATE DATABASE */
mysqli_query($koneksi, "UPDATE buku SET 
    judul='$judul',
    pengarang='$pengarang',
    penerbit='$penerbit',
    tahun_terbit='$tahun',
    stok='$stok',
    foto='$foto'
WHERE id='$id'");

header("Location: data_buku.php");
?>