-- phpMyAdmin SQL Dump
-- version 5.2.3-dev+20250219.c8559ff3dd
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 08:48 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uts`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_barang`
--

CREATE TABLE `tabel_barang` (
  `id` int(55) NOT NULL,
  `nama_barang` varchar(55) NOT NULL,
  `katagori` varchar(55) NOT NULL,
  `jumlah` int(55) NOT NULL,
  `harga` decimal(55,0) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_barang`
--

INSERT INTO `tabel_barang` (`id`, `nama_barang`, `katagori`, `jumlah`, `harga`, `tanggal`) VALUES
(5, 'cooler leptop', 'set up', 22, 500000, '2025-04-21'),
(7, 'windows 12 original', 'perangkat lunak', 22, 6000, '2025-04-21'),
(8, 'colingped tuf 2', 'set up', 12, 300000, '2025-04-21'),
(9, 'vga', 'perangkat keras', 2, 300000, '2025-04-21'),
(11, 'ghifari ', 'set up', 2, 300000, '2025-04-21');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_katagori`
--

CREATE TABLE `tabel_katagori` (
  `id` int(55) NOT NULL,
  `katagori` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_katagori`
--

INSERT INTO `tabel_katagori` (`id`, `katagori`) VALUES
(1, 'perangkat lunak'),
(2, 'perangkat keras'),
(7, 'set up'),
(8, 'Device');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_barang`
--
ALTER TABLE `tabel_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabel_katagori`
--
ALTER TABLE `tabel_katagori`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_barang`
--
ALTER TABLE `tabel_barang`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tabel_katagori`
--
ALTER TABLE `tabel_katagori`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
