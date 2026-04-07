-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2026 at 03:34 AM
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
(15, 'dari miskin jadi kaya', 'iman', 'rafli', '2000', 122, '1774923805_09f524835f2044b6f45d1b824c9c124c.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `user` varchar(100) DEFAULT NULL,
  `aktivitas` text DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `user`, `aktivitas`, `waktu`) VALUES
(1, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:19:31'),
(2, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:19:31'),
(3, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:19:40'),
(4, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:00'),
(5, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:30'),
(6, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:30'),
(7, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:30'),
(8, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:31'),
(9, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:31'),
(10, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:31'),
(11, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:31'),
(12, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:55'),
(13, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:56'),
(14, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:56'),
(15, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:56'),
(16, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:56'),
(17, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:20:57'),
(18, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:21:09'),
(19, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:21:42'),
(20, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:21:44'),
(21, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:21:44'),
(22, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:21:45'),
(23, 'atur', 'Menambahkan anggota: ', '2026-04-02 01:21:45'),
(24, 'atur', 'Menambahkan anggota: ', '2026-04-06 01:13:59'),
(25, 'atur', 'Menambahkan anggota: ', '2026-04-06 01:13:59'),
(26, 'atur', 'Menambahkan anggota: dendi', '2026-04-06 01:17:58');

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
(1, 1, 'acil', 1, '2026-02-11', '2026-02-18', 'Dikembalikan'),
(2, 1, 'acil', 1, '2026-02-21', '2026-02-28', 'Dikembalikan'),
(3, 1, 'acil', 1, '2026-03-03', '2026-03-10', 'Dikembalikan'),
(4, 1, 'acil', 1, '2026-03-30', '2026-04-06', 'Dikembalikan'),
(5, 15, 'acil', 1, '2026-03-31', '2026-04-07', 'Dikembalikan'),
(6, 15, 'acil', 1, '2026-04-01', '2026-04-08', 'Dikembalikan'),
(7, 15, 'acil', 1, '2026-04-06', '2026-04-13', 'Dikembalikan');

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
(7, 'atur', '202cb962ac59075b964b07152d234b70', 'admin'),
(8, 'acil', '202cb962ac59075b964b07152d234b70', 'user'),
(34, 'dendi', '$2y$10$3XsRvohZiw7SzPVbnDfz6OWRpQtaLK.WgXookoHxz3erJXbeIW/k2', 'user');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
