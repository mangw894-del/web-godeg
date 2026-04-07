<?php
include '../config.php';
include '../auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    echo "Akses ditolak";
    exit;
}

if (isset($_POST['simpan'])) {

    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

    /* UPLOAD FOTO */
    if ($_FILES['foto']['name'] != "") {

        $nama_file = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];

        // biar gak ketimpa
        $nama_baru = time() . '_' . $nama_file;

        move_uploaded_file($tmp, "../upload/" . $nama_baru);

        $foto = $nama_baru;

    } else {
        $foto = NULL;
    }

    /* INSERT + FOTO */
    $query = "INSERT INTO buku 
    (judul, pengarang, penerbit, tahun_terbit, stok, foto)
    VALUES 
    ('$judul', '$pengarang', '$penerbit', '$tahun', '$stok', '$foto')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: data_buku.php");
        exit;
    } else {
        echo "Gagal menambahkan data!";
    }
}
?>