-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2026 at 11:53 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik_hewan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_admin` int NOT NULL,
  `nama_admin` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id_admin`, `nama_admin`, `username`, `password`, `created_at`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', '2026-06-02 10:22:40');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id_appointment` int NOT NULL,
  `id_pemilik` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `keluhan` text,
  `status` enum('Pending','Datang','Selesai','Batal','Pemeriksaan') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id_appointment`, `id_pemilik`, `tanggal`, `jam`, `keluhan`, `status`, `created_at`) VALUES
(2, 2, '2026-06-16', '16:13:58', 'diare', 'Selesai', '2026-06-16 09:13:58'),
(3, 3, '2026-06-28', '09:51:29', 'vaksin', 'Pending', '2026-06-28 02:51:29'),
(4, 5, '2026-06-28', '09:51:54', 'lemas', 'Pending', '2026-06-28 02:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_hewan`
--

CREATE TABLE `appointment_hewan` (
  `id` int NOT NULL,
  `id_appointment` int NOT NULL,
  `id_hewan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `appointment_hewan`
--

INSERT INTO `appointment_hewan` (`id`, `id_appointment`, `id_hewan`) VALUES
(2, 2, 3),
(3, 3, 4),
(4, 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `detail_obat_kunjungan`
--

CREATE TABLE `detail_obat_kunjungan` (
  `id_detail` int NOT NULL,
  `id_kunjungan` int DEFAULT NULL,
  `id_obat` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_obat_kunjungan`
--

INSERT INTO `detail_obat_kunjungan` (`id_detail`, `id_kunjungan`, `id_obat`, `jumlah`, `subtotal`) VALUES
(1, 3, 4, 1, '65000.00'),
(2, 5, 7, 1, '350000.00');

-- --------------------------------------------------------

--
-- Table structure for table `detail_vaksin_kunjungan`
--

CREATE TABLE `detail_vaksin_kunjungan` (
  `id_detail` int NOT NULL,
  `id_kunjungan` int DEFAULT NULL,
  `id_vaksin` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_vaksin_kunjungan`
--

INSERT INTO `detail_vaksin_kunjungan` (`id_detail`, `id_kunjungan`, `id_vaksin`, `jumlah`, `subtotal`) VALUES
(1, 3, 1, 1, '150000.00'),
(2, 4, 3, 1, '200000.00'),
(3, 5, 1, 1, '150000.00');

-- --------------------------------------------------------

--
-- Table structure for table `hewan`
--

CREATE TABLE `hewan` (
  `id_hewan` int NOT NULL,
  `id_pemilik` int DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama_hewan` varchar(100) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `ras` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `berat` decimal(5,2) DEFAULT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `jenis_kelamin` enum('Jantan','Betina') DEFAULT NULL,
  `alergi` text,
  `status_vaksin` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hewan`
--

INSERT INTO `hewan` (`id_hewan`, `id_pemilik`, `foto`, `nama_hewan`, `jenis`, `ras`, `tanggal_lahir`, `berat`, `warna`, `jenis_kelamin`, `alergi`, `status_vaksin`, `created_at`) VALUES
(3, 2, 'IMG_20221228_182220.jpg', 'Jelly', 'kucing', 'Himalaya', '2025-10-10', '3.00', 'putih coklat', 'Betina', 'alergi susu', 'Belum Pernah', '2026-06-16 09:13:12'),
(4, 3, 'kucin6.jpg', 'Celin', 'kucing', 'persia', '2025-03-05', '4.00', 'coklat putih', 'Betina', 'tidak ada', 'Lengkap', '2026-06-28 02:48:24'),
(5, 5, 'anj german.jpg', 'kevin', 'anjing', 'german', '2024-08-28', '5.00', 'coklat moca', 'Jantan', 'susu', 'Belum Lengkap', '2026-06-28 02:50:17');

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan`
--

CREATE TABLE `kunjungan` (
  `id_kunjungan` int NOT NULL,
  `id_hewan` int DEFAULT NULL,
  `tanggal_kunjungan` date DEFAULT NULL,
  `keluhan` text,
  `diagnosa` text,
  `tindakan` text,
  `biaya_tindakan` decimal(12,2) DEFAULT '0.00',
  `catatan` text,
  `hasil_lab` varchar(255) DEFAULT NULL,
  `foto_medis` varchar(255) DEFAULT NULL,
  `total_biaya` decimal(12,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kunjungan`
--

INSERT INTO `kunjungan` (`id_kunjungan`, `id_hewan`, `tanggal_kunjungan`, `keluhan`, `diagnosa`, `tindakan`, `biaya_tindakan`, `catatan`, `hasil_lab`, `foto_medis`, `total_biaya`, `created_at`) VALUES
(3, 3, '2026-06-16', 'diare', 'diare', 'vaksin ', '300000.00', 'jangan makan sembarangan dan harus higienis', '', '', '515000.00', '2026-06-16 09:33:23'),
(4, 4, '2026-06-28', 'tidak ada', 'sehat', 'vaksin', '160000.00', 'sehat', '', '', '360000.00', '2026-06-28 02:53:07'),
(5, 5, '2026-06-28', 'lemas', 'sistem imun', 'vaksin', '100000.00', 'banyak istirahat', '', '', '600000.00', '2026-06-28 02:54:40');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int NOT NULL,
  `nama_obat` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `stok` int DEFAULT '0',
  `harga` decimal(12,2) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `status_stok` enum('Aman','Menipis','Kritis','Habis') DEFAULT 'Aman',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`, `kategori`, `stok`, `harga`, `supplier`, `status_stok`, `created_at`) VALUES
(1, 'Cat Dewormer', 'Obat cacing', 50, '50000.00', 'catmart', 'Aman', '2026-06-16 09:16:27'),
(2, 'frontline plus cat', 'obat kutu & caplak', 9, '35000.00', 'catmart', 'Menipis', '2026-06-16 09:17:52'),
(3, 'Scabies', 'Obat jamur', 30, '40000.00', 'catmart', 'Aman', '2026-06-16 09:18:52'),
(4, 'Norit', 'Obat Diare', 5, '65000.00', 'catmart', 'Kritis', '2026-06-16 09:20:06'),
(5, 'Amoxicilin', 'Antibiotik', 0, '50000.00', 'catmart', 'Habis', '2026-06-16 09:21:08'),
(6, 'Neo eye drop', 'Obat tetes mata', 100, '50000.00', 'catmart', 'Aman', '2026-06-16 09:22:39'),
(7, 'Nutri Plus Gel', 'Vitamin', 54, '350000.00', 'catmart', 'Aman', '2026-06-16 10:43:18'),
(9, 'GIO', 'RADANG', 10, '10000.00', 'catmart', 'Menipis', '2026-06-28 03:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `invoice` varchar(50) DEFAULT NULL,
  `id_kunjungan` int DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `metode` enum('Cash','Transfer','QRIS') DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `invoice`, `id_kunjungan`, `total`, `metode`, `tanggal_bayar`, `created_at`) VALUES
(4, 'INV-20260616093350', 3, '515000.00', 'QRIS', '2026-06-16', '2026-06-16 09:33:50'),
(5, 'INV-20260628030151', 4, '360000.00', 'Cash', '2026-06-28', '2026-06-28 03:01:51'),
(6, 'INV-20260628030201', 5, '600000.00', 'Transfer', '2026-06-28', '2026-06-28 03:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `pemilik`
--

CREATE TABLE `pemilik` (
  `id_pemilik` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text,
  `tanggal_registrasi` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pemilik`
--

INSERT INTO `pemilik` (`id_pemilik`, `nama`, `no_hp`, `email`, `alamat`, `tanggal_registrasi`, `created_at`) VALUES
(2, 'andi', '0857687689', 'andi@gmail.com', 'cikajang', '2026-06-16', '2026-06-16 09:09:28'),
(3, 'Agus', '0895678751', 'agus@gmail.com', 'Cihuni', '2026-06-16', '2026-06-16 10:02:48'),
(5, 'erika', '089567765687', 'erika@gmail.com', 'talaga bodas', '2026-06-28', '2026-06-28 02:43:13');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int NOT NULL,
  `nama_supplier` varchar(100) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaksin`
--

CREATE TABLE `vaksin` (
  `id_vaksin` int NOT NULL,
  `nama_vaksin` varchar(100) DEFAULT NULL,
  `jenis_vaksin` varchar(100) NOT NULL,
  `stok` int DEFAULT '0',
  `harga` decimal(12,2) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `status_stok` enum('Aman','Menipis','Kritis','Habis') DEFAULT 'Aman',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vaksin`
--

INSERT INTO `vaksin` (`id_vaksin`, `nama_vaksin`, `jenis_vaksin`, `stok`, `harga`, `supplier`, `status_stok`, `created_at`) VALUES
(1, 'Tricat f3', 'virus', 18, '150000.00', 'catmart', 'Aman', '2026-06-16 09:26:23'),
(2, 'Tetracat f4', 'Rabies', 10, '250000.00', 'catmart', 'Menipis', '2026-06-16 09:29:11'),
(3, 'FeLV', 'Sistem kekebalan tubuh', 49, '200000.00', 'catmart', 'Aman', '2026-06-16 09:31:08'),
(4, 'vaksin f3', 'Sistem kekebalan tubuh', 10, '10000.00', 'catmart', 'Menipis', '2026-06-28 03:46:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id_appointment`),
  ADD KEY `fk_appointment_pemilik` (`id_pemilik`);

--
-- Indexes for table `appointment_hewan`
--
ALTER TABLE `appointment_hewan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app` (`id_appointment`),
  ADD KEY `fk_hewan` (`id_hewan`);

--
-- Indexes for table `detail_obat_kunjungan`
--
ALTER TABLE `detail_obat_kunjungan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_kunjungan` (`id_kunjungan`),
  ADD KEY `id_obat` (`id_obat`);

--
-- Indexes for table `detail_vaksin_kunjungan`
--
ALTER TABLE `detail_vaksin_kunjungan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_kunjungan` (`id_kunjungan`),
  ADD KEY `id_vaksin` (`id_vaksin`);

--
-- Indexes for table `hewan`
--
ALTER TABLE `hewan`
  ADD PRIMARY KEY (`id_hewan`),
  ADD KEY `fk_hewan_pemilik` (`id_pemilik`);

--
-- Indexes for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`id_kunjungan`),
  ADD KEY `id_hewan` (`id_hewan`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_kunjungan` (`id_kunjungan`);

--
-- Indexes for table `pemilik`
--
ALTER TABLE `pemilik`
  ADD PRIMARY KEY (`id_pemilik`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `vaksin`
--
ALTER TABLE `vaksin`
  ADD PRIMARY KEY (`id_vaksin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id_appointment` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appointment_hewan`
--
ALTER TABLE `appointment_hewan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detail_obat_kunjungan`
--
ALTER TABLE `detail_obat_kunjungan`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_vaksin_kunjungan`
--
ALTER TABLE `detail_vaksin_kunjungan`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hewan`
--
ALTER TABLE `hewan`
  MODIFY `id_hewan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `id_kunjungan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pemilik`
--
ALTER TABLE `pemilik`
  MODIFY `id_pemilik` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vaksin`
--
ALTER TABLE `vaksin`
  MODIFY `id_vaksin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_appointment_pemilik` FOREIGN KEY (`id_pemilik`) REFERENCES `pemilik` (`id_pemilik`) ON DELETE CASCADE;

--
-- Constraints for table `appointment_hewan`
--
ALTER TABLE `appointment_hewan`
  ADD CONSTRAINT `fk_app` FOREIGN KEY (`id_appointment`) REFERENCES `appointment` (`id_appointment`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_hewan` FOREIGN KEY (`id_hewan`) REFERENCES `hewan` (`id_hewan`) ON DELETE CASCADE;

--
-- Constraints for table `detail_obat_kunjungan`
--
ALTER TABLE `detail_obat_kunjungan`
  ADD CONSTRAINT `detail_obat_kunjungan_ibfk_1` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_obat_kunjungan_ibfk_2` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`) ON DELETE CASCADE;

--
-- Constraints for table `detail_vaksin_kunjungan`
--
ALTER TABLE `detail_vaksin_kunjungan`
  ADD CONSTRAINT `detail_vaksin_kunjungan_ibfk_1` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_vaksin_kunjungan_ibfk_2` FOREIGN KEY (`id_vaksin`) REFERENCES `vaksin` (`id_vaksin`) ON DELETE CASCADE;

--
-- Constraints for table `hewan`
--
ALTER TABLE `hewan`
  ADD CONSTRAINT `fk_hewan_pemilik` FOREIGN KEY (`id_pemilik`) REFERENCES `pemilik` (`id_pemilik`) ON DELETE CASCADE;

--
-- Constraints for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD CONSTRAINT `kunjungan_ibfk_1` FOREIGN KEY (`id_hewan`) REFERENCES `hewan` (`id_hewan`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
