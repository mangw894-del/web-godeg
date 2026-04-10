-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2026 at 09:37 AM
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
(23, 'The Secret Of The Old Book', 'Godeg', 'PT.Makmur', '2000', 21, '1775786287_The secret of the old book.png'),
(24, 'The Shadow Hunter', 'Arthur', 'PT.Alim Rugi', '2001', 1, '1775786795_The shadow hunter team united.png'),
(25, 'Chrono Signal', 'Hj Dendi', 'PT.Ayam', '2002', 12, '1775786945_Chrono Signal_ Time-travel team in action.png'),
(26, 'The Crimson Engine', 'Hj Dendi', 'PT.Alim Rugi', '2020', 2, '1775787227_The crimson engine riders.png'),
(27, 'Strike to the top', 'hafiedz', 'PT.bobon', '2004', 21, '1775787582_Strike to the Top cover art.png'),
(28, 'After scholl melody', 'Zihan', 'PT.Jaya', '2025', 21, '1775787833_After school band jam session (1).png'),
(29, 'Chasing Your Smile', 'udin', 'PT.Jaya', '2025', 21, '1775790556_Chasing your smile at sunset.png');

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
(12, 'rafli', 'Menghapus anggota: acil', 'User', '2026-04-09 08:37:55'),
(13, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 00:45:23'),
(14, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 00:46:17'),
(15, 'godeg', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 00:46:43'),
(16, 'godeg', 'Meminjam buku: doraemon', 'Peminjaman', '2026-04-10 01:00:47'),
(17, 'godeg', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 01:00:53'),
(18, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 01:00:55'),
(19, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 01:04:00'),
(20, 'godeg', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 01:04:06'),
(21, 'godeg', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 01:04:58'),
(22, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 01:05:00'),
(23, 'rafli', 'Menghapus buku: qedsa', 'Buku', '2026-04-10 01:08:58'),
(24, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 01:44:07'),
(25, 'godeg', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 01:44:23'),
(26, 'godeg', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 01:44:31'),
(27, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 01:44:32'),
(28, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 01:44:59'),
(29, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 01:45:53'),
(30, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 01:46:00'),
(31, 'godeg', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 01:46:04'),
(32, 'godeg', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 01:49:44'),
(33, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 01:49:49'),
(34, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 01:50:18'),
(35, 'godeg', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 01:50:29'),
(36, 'godeg', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 01:56:50'),
(37, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 01:56:52'),
(38, 'rafli', 'Menambahkan buku baru: The Secret Of The Old Book', 'Buku', '2026-04-10 01:58:07'),
(39, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 02:00:35'),
(40, 'godeg', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 02:00:43'),
(41, 'godeg', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 02:01:21'),
(42, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 02:01:22'),
(43, 'rafli', 'Menghapus buku: doraemon', 'Buku', '2026-04-10 02:01:29'),
(44, 'rafli', 'Menambahkan buku baru: The Shadow Hunter', 'Buku', '2026-04-10 02:06:35'),
(45, 'rafli', 'Menambahkan buku baru: Chrono Signal', 'Buku', '2026-04-10 02:09:05'),
(46, 'rafli', 'Menambahkan buku baru: The Crimson Engine', 'Buku', '2026-04-10 02:13:47'),
(47, 'rafli', 'Menambahkan buku baru: Strike to the top', 'Buku', '2026-04-10 02:19:42'),
(48, 'rafli', 'Menambahkan buku baru: After scholl melody', 'Buku', '2026-04-10 02:23:53'),
(49, 'rafli', 'Menambahkan buku baru: Chasing Your Smile', 'Buku', '2026-04-10 03:09:16'),
(50, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 03:09:42'),
(51, 'godeg', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 03:09:46'),
(52, 'godeg', 'Meminjam buku: Chasing Your Smile', 'Peminjaman', '2026-04-10 03:09:58'),
(53, 'godeg', 'Meminjam buku: Strike to the top', 'Peminjaman', '2026-04-10 03:10:13'),
(54, 'godeg', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 03:10:21'),
(55, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 03:10:23'),
(56, 'rafli', 'Menghapus anggota: rafli', 'User', '2026-04-10 03:21:12'),
(57, 'rafli', 'Menghapus anggota: dendi', 'User', '2026-04-10 03:23:16'),
(58, 'rafli', 'Menambahkan anggota baru: dendi (Role: user)', NULL, '2026-04-10 03:23:29'),
(59, 'rafli', 'Mengubah data anggota: artur', 'User', '2026-04-10 03:23:58'),
(60, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 03:25:39'),
(61, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 03:27:44'),
(62, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 03:27:46'),
(63, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 03:49:04'),
(64, 'rafli', 'Mengubah data buku: After scholl melody', 'Buku', '2026-04-10 03:49:51'),
(65, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 03:52:58'),
(66, 'godeg', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 03:53:04'),
(67, 'godeg', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 03:53:16'),
(68, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 03:53:21'),
(69, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 04:01:02'),
(70, 'godeg', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 04:01:08'),
(71, 'godeg', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 04:01:17'),
(72, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 04:01:22'),
(73, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 04:07:09'),
(74, 'rafli', 'Berhasil Login ke Sistem', 'Auth', '2026-04-10 04:10:51'),
(75, 'rafli', 'Berhasil Logout dari Sistem', 'Auth', '2026-04-10 04:10:56');

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
(23, 20, '', 1, '2026-04-09', '0000-00-00', 'Dipinjam'),
(24, 20, 'godeg', 1, '2026-04-10', '0000-00-00', 'Dipinjam'),
(25, 29, 'godeg', 1, '2026-04-10', '0000-00-00', 'Dikembalikan'),
(26, 27, 'godeg', 1, '2026-04-10', '0000-00-00', 'Dikembalikan');

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
(41, 'rafli', '202cb962ac59075b964b07152d234b70', 'admin'),
(42, 'godeg', '202cb962ac59075b964b07152d234b70', 'user'),
(45, 'artur', '$2y$10$t5I7Ex781BfAZNMh5soE1umuXBhtKV683HZ3CFDgnocUs4thLfq06', 'user');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
