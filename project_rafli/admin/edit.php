<?php
include '../config.php';

logAktivitas($koneksi, $_SESSION['user'], "Mengedit buku: $judul");

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM buku WHERE id='$id'");
$row = mysqli_fetch_assoc($data);
?>

<form action="proses_edit.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $row['id']; ?>">
<input type="hidden" name="foto_lama" value="<?= $row['foto']; ?>">

<label>Judul</label>
<input type="text" name="judul" value="<?= $row['judul']; ?>">

<label>Pengarang</label>
<input type="text" name="pengarang" value="<?= $row['pengarang']; ?>">

<label>Penerbit</label>
<input type="text" name="penerbit" value="<?= $row['penerbit']; ?>">

<label>Tahun</label>
<input type="number" name="tahun_terbit" value="<?= $row['tahun_terbit']; ?>">

<label>Stok</label>
<input type="number" name="stok" value="<?= $row['stok']; ?>">

<!-- FOTO LAMA -->
<label>Foto Lama</label><br>
<img src="../upload/<?= $row['foto']; ?>" width="80"><br><br>

<!-- FOTO BARU -->
<label>Ganti Foto</label>
<input type="file" name="foto">

<button type="submit">Update</button>

</form>