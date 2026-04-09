<?php
include '../config.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$pengarang = $_POST['pengarang'];
$penerbit = $_POST['penerbit'];
$tahun = $_POST['tahun_terbit'];
$stok = $_POST['stok'];
$foto_lama = $_POST['foto_lama'];

if($_FILES['foto']['name'] != ''){
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    move_uploaded_file($tmp, "../upload/".$foto);
} else {
    $foto = $foto_lama;
}

mysqli_query($koneksi, "UPDATE buku SET
    judul='$judul',
    pengarang='$pengarang',
    penerbit='$penerbit',
    tahun_terbit='$tahun',
    stok='$stok',
    foto='$foto'
    WHERE id='$id'
");

header("Location: data_buku.php");