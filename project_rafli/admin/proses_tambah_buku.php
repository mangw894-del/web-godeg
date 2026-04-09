<?php
include '../config.php';
include '../auth.php';

// Pastikan hanya admin yang bisa akses
if($_SESSION['role'] != 'admin'){
    die("Akses dilarang!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Ambil data dari form dan amankan dari karakter aneh
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $penerbit  = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $tahun     = $_POST['tahun_terbit'];
    $stok      = $_POST['stok'];

    // 2. Cek apakah ada file foto yang diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $nama_file = $_FILES['foto']['name'];
        $tmp       = $_FILES['foto']['tmp_name'];
        
        // Buat nama unik supaya file tidak tertumpuk jika namanya sama
        $nama_baru = time() . '_' . $nama_file;
        $path      = "../upload/" . $nama_baru;

        // Pindahkan file ke folder upload
        if (move_uploaded_file($tmp, $path)) {
            
            // 3. Masukkan data ke tabel buku
            $sql = "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, stok, foto) 
                    VALUES ('$judul', '$pengarang', '$penerbit', '$tahun', '$stok', '$nama_baru')";
            
            if (mysqli_query($koneksi, $sql)) {
                
                // 4. CATAT LOG AKTIVITAS (Biar muncul di Laporan)
                // Kita pakai fungsi catat_log yang tadi sudah dibuat di config.php
                catat_log($koneksi, "Menambah buku baru: $judul", "Buku");

                // Lempar balik ke halaman data buku dengan status sukses
                header("Location: data_buku.php?status=sukses");
                exit;
            } else {
                echo "Gagal menyimpan data ke database: " . mysqli_error($koneksi);
            }
        } else {
            echo "Gagal mengunggah foto ke folder tujuan.";
        }
    } else {
        echo "Harap pilih foto buku terlebih dahulu.";
    }
} else {
    // Jika diakses tanpa submit form, kembalikan ke form tambah
    header("Location: tambah_buku.php");
    exit;
}
?>