-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2026 at 10:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpusdeg`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `stok` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `stok`, `foto`) VALUES
(20, 'doraemon', 'imas', 'rafli', '2000', 13, '1775615150_09f524835f2044b6f45d1b824c9c124c.jpg'),
(22, 'qedsa', 'safdvv', 'dcsvf', '2000', 0, '1775721235_poto1.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `nama_pelaku` varchar(100) DEFAULT NULL,
  `aktivitas` varchar(255) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `nama_pelaku`, `aktivitas`, `kategori`, `waktu`) VALUES
(1, 'Sistem/Guest', 'Menambahkan buku baru: qedsa', 'Buku', '2026-04-09 07:53:55'),
(2, 'Sistem/Guest', 'Menghapus buku: 123', 'Buku', '2026-04-09 08:07:01'),
(3, 'Sistem/Guest', 'Menghapus anggota: atur', 'User', '2026-04-09 08:07:19'),
(4, 'Sistem/Guest', 'Meminjam buku: doraemon', 'Peminjaman', '2026-04-09 08:10:02'),
(5, 'Sistem/Guest', 'Meminjam buku: qedsa', 'Peminjaman', '2026-04-09 08:19:21'),
(6, 'Sistem/Guest', 'Meminjam buku: qedsa', 'Peminjaman', '2026-04-09 08:20:00'),
(7, 'Sistem/Guest', 'Meminjam buku: doraemon', 'Peminjaman', '2026-04-09 08:20:23'),
(8, 'Sistem/Guest', 'Meminjam buku: doraemon', 'Peminjaman', '2026-04-09 08:20:33'),
(9, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-09 08:22:50'),
(10, 'rafli', 'Mengubah data anggota: acil', 'User', '2026-04-09 08:33:55'),
(11, 'rafli', 'Mengubah data anggota: acil', 'User', '2026-04-09 08:34:09'),
(12, 'rafli', 'Menghapus anggota: acil', 'User', '2026-04-09 08:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `nama_peminjam` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `status` varchar(20) DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_buku`, `nama_peminjam`, `jumlah`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(13, 20, 'acil', 1, '2026-04-08', '0000-00-00', 'Dipinjam'),
(14, 20, 'acil', 1, '2026-04-08', '0000-00-00', 'Dipinjam'),
(15, 20, 'acil', 1, '2026-04-08', '0000-00-00', 'Dikembalikan'),
(16, 20, 'acil', 1, '2026-04-08', '0000-00-00', 'Dikembalikan'),
(17, 20, 'acil', 1, '2026-04-09', '0000-00-00', 'Dipinjam'),
(18, 20, 'wantu', 1, '2026-04-09', '0000-00-00', 'Dipinjam'),
(19, 20, '', 1, '2026-04-09', '0000-00-00', 'Dipinjam'),
(20, 22, '', 1, '2026-04-09', '0000-00-00', 'Dipinjam'),
(21, 22, '', 1, '2026-04-09', '0000-00-00', 'Dipinjam'),
(22, 20, '', 1, '2026-04-09', '0000-00-00', 'Dipinjam'),
(23, 20, '', 1, '2026-04-09', '0000-00-00', 'Dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(41, 'rafli', '202cb962ac59075b964b07152d234b70', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
