-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 27, 2022 at 02:42 PM
-- Server version: 10.5.13-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u671953003_db_oembah`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_laundry`
--

CREATE TABLE `tb_laundry` (
  `id_laundry` int(10) UNSIGNED NOT NULL,
  `nama_laundry` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `latitude` decimal(11,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `biaya` int(11) UNSIGNED NOT NULL,
  `kontak` varchar(50) NOT NULL,
  `tipe_laundry` enum('Kiloan','Sepatu','Helm') NOT NULL,
  `hari_mulai` varchar(20) NOT NULL,
  `hari_akhir` varchar(20) NOT NULL,
  `jam_buka` time NOT NULL,
  `jam_tutup` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_laundry`
--

INSERT INTO `tb_laundry` (`id_laundry`, `nama_laundry`, `email`, `password`, `alamat`, `latitude`, `longitude`, `biaya`, `kontak`, `tipe_laundry`, `hari_mulai`, `hari_akhir`, `jam_buka`, `jam_tutup`) VALUES
(8, 'Laundry Aneka', 'aneka@gmail.com', '$2y$10$qDQQt5AFw9mei3EzGp6FlO2DisnGGNNg0KS6ysGFbEEgaMMUwM14G', 'Jalan Dusun Berjo Wetan, Sumbersari, Sidoluhur, Godean, Sleman Regency, Special Region of Yogyakarta', '-7.77024800', '110.28292600', 2000, '6292222', 'Kiloan', 'Senin', 'Jumat', '13:38:00', '22:38:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `id_order` int(10) UNSIGNED NOT NULL,
  `qty` smallint(11) UNSIGNED NOT NULL,
  `status` enum('Waiting','Confirmed','On Process','On Delivery','Delivered','Rejected') NOT NULL,
  `tgl_order` datetime NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_laundry` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_transaksi` int(10) UNSIGNED NOT NULL,
  `total_biaya` int(10) UNSIGNED NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `status_transaksi` enum('Failed','Pending','On Process','Success') NOT NULL,
  `id_order` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `latitude` decimal(11,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `kontak` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_user`, `email`, `password`, `alamat`, `latitude`, `longitude`, `kontak`) VALUES
(12, 'Bababa', 'test@gmail.com', '$2y$10$nyTReYfzdvLTFy.pcX5RguSiaF/M3NTwRouJ32ouXCBshlJzPFJJ2', 'Sumberarum, Moyudan, Sleman Regency, Special Region of Yogyakarta, 55562, Indonesia', '-7.76004300', '110.22593400', '628222221111');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_laundry`
--
ALTER TABLE `tb_laundry`
  ADD PRIMARY KEY (`id_laundry`);

--
-- Indexes for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `fk_user` (`id_user`),
  ADD KEY `fk_laundry` (`id_laundry`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_order` (`id_order`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_laundry`
--
ALTER TABLE `tb_laundry`
  MODIFY `id_laundry` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `id_order` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id_transaksi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD CONSTRAINT `fk_laundry` FOREIGN KEY (`id_laundry`) REFERENCES `tb_laundry` (`id_laundry`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`id_order`) REFERENCES `tb_order` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
