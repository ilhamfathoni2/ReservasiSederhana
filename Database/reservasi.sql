-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2021 at 10:52 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservasi-ujk`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_menu`
--

CREATE TABLE `data_menu` (
  `id_menu` int(10) UNSIGNED NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` int(50) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_menu`
--

INSERT INTO `data_menu` (`id_menu`, `nama_menu`, `harga`) VALUES
(1, 'Mie Ayam', 10000),
(2, 'Bakso', 5000),
(4, 'Nasi Goreng', 10000),
(5, 'Indomie Special', 6000),
(6, 'Seprit', 5000),
(7, 'Es Teh', 1000),
(8, 'Bakso Spesial', 1002),
(9, 'Es Jeruk', 1001),
(10, 'Boba', 1000),
(11, 'Milo', 1004);

-- --------------------------------------------------------

--
-- Table structure for table `data_reservasi`
--

CREATE TABLE `data_reservasi` (
  `kode_reservasi` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal_daftar` date DEFAULT current_timestamp(),
  `total_harga` int(50) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_reservasi`
--

INSERT INTO `data_reservasi` (`kode_reservasi`, `nama`, `tanggal_daftar`, `total_harga`) VALUES
('202106250001', 'Ilham', '2021-06-25', 50000),
('202106250002', 'Soraya Ga', '2021-06-25', 0),
('202106250003', 'Pak Ongky A', '2021-06-25', 18000),
('202106300001', 'Ilhhhhha', '2021-06-30', 60000),
('202108250001', 'tesss', '2021-08-25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(10) UNSIGNED NOT NULL,
  `kode_reservasi` varchar(50) NOT NULL,
  `id_menu` int(10) UNSIGNED NOT NULL,
  `nama_menu_saat_ini` varchar(100) NOT NULL,
  `jumlah_pesanan` int(10) UNSIGNED NOT NULL,
  `harga_saat_ini` int(50) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `kode_reservasi`, `id_menu`, `nama_menu_saat_ini`, `jumlah_pesanan`, `harga_saat_ini`) VALUES
(62, '202106250001', 4, 'Nasi Goreng', 3, 10000),
(63, '202106250001', 4, 'Nasi Goreng', 1, 10000),
(64, '202106250001', 4, 'Nasi Goreng', 1, 10000),
(65, '202106250003', 7, 'Es Teh', 3, 1000),
(66, '202106250003', 2, 'Bakso', 3, 5000),
(77, '202106300001', 4, 'Nasi Goreng', 6, 10000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_menu`
--
ALTER TABLE `data_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `data_reservasi`
--
ALTER TABLE `data_reservasi`
  ADD PRIMARY KEY (`kode_reservasi`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `kode_reservasi` (`kode_reservasi`),
  ADD KEY `id_menu` (`id_menu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_menu`
--
ALTER TABLE `data_menu`
  MODIFY `id_menu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `data_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`kode_reservasi`) REFERENCES `data_reservasi` (`kode_reservasi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
