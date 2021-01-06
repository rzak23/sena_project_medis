-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2021 at 04:55 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rekam_medis`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_dokter`
--

CREATE TABLE `tabel_dokter` (
  `id_dokter` varchar(20) NOT NULL,
  `nama_dokter` varchar(50) NOT NULL,
  `jns_kelamin_dokter` varchar(10) NOT NULL,
  `alamat_dokter` varchar(100) NOT NULL,
  `telepon_dokter` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_dokter`
--

INSERT INTO `tabel_dokter` (`id_dokter`, `nama_dokter`, `jns_kelamin_dokter`, `alamat_dokter`, `telepon_dokter`) VALUES
('201225020001', 'Dr.I Wayan Nengah Dipayana', 'Laki-Laki', 'Br.samuan Kawan', '0'),
('201225020002', 'Dr.Ni Putu Nila Utari', 'Perempuan', 'Br.Samuan Kawan', '0'),
('201225020003', 'Dr.Made Dwijaya', 'Laki-Laki', 'Mengwi', '0'),
('201229020004', 'Dr.Jaya Nuraga', 'Laki-Laki', 'Sibang Gede', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_medis`
--

CREATE TABLE `tabel_medis` (
  `id_medis` varchar(20) NOT NULL,
  `tanggal_medis` date NOT NULL,
  `id_dokter` varchar(20) NOT NULL,
  `id_param` varchar(20) NOT NULL,
  `shift_medis` varchar(5) NOT NULL,
  `id_pasien` varchar(20) NOT NULL,
  `tipe_pasien` varchar(5) NOT NULL,
  `diagnosa_medis` varchar(255) NOT NULL,
  `terapi_medis` varchar(255) NOT NULL,
  `biaya_medis` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_obat`
--

CREATE TABLE `tabel_obat` (
  `id_tagihan` varchar(20) NOT NULL,
  `nomor_nota` varchar(100) NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `nama_apotek` varchar(100) NOT NULL,
  `biaya_tagihan` bigint(20) NOT NULL,
  `bayar_tagihan` bigint(20) DEFAULT NULL,
  `status_tagihan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_paramedis`
--

CREATE TABLE `tabel_paramedis` (
  `id_param` varchar(20) NOT NULL,
  `nama_param` varchar(50) NOT NULL,
  `jns_kelamin_param` varchar(10) NOT NULL,
  `alamat_param` varchar(100) NOT NULL,
  `telepon_param` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_paramedis`
--

INSERT INTO `tabel_paramedis` (`id_param`, `nama_param`, `jns_kelamin_param`, `alamat_param`, `telepon_param`) VALUES
('201225030001', 'Helen', 'Perempuan', 'Br.Ubud', '0'),
('201225030002', 'Diana', 'Laki-Laki', 'Blahkiuh', '0'),
('201225030003', 'Ogik', 'Laki-Laki', 'Br.Samuan Kawan', '0'),
('201229030004', 'Adhi', 'Perempuan', 'Br.Pacung', '0'),
('201229030005', 'Buda', 'Laki-Laki', 'Br.Petang Suci', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pasien`
--

CREATE TABLE `tabel_pasien` (
  `id_pasien` varchar(20) NOT NULL,
  `nama_pasien` varchar(50) NOT NULL,
  `jns_kelamin_pasien` varchar(10) NOT NULL,
  `umur_pasien` varchar(5) NOT NULL,
  `alamat_pasien` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pemasukan`
--

CREATE TABLE `tabel_pemasukan` (
  `id_pemasukan` varchar(20) NOT NULL,
  `tanggal_pemasukan` date NOT NULL,
  `biaya_umum` bigint(20) NOT NULL,
  `biaya_bpjs` bigint(20) NOT NULL,
  `biaya_aqua` bigint(20) NOT NULL,
  `total_pemasukan` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pengeluaran`
--

CREATE TABLE `tabel_pengeluaran` (
  `id_pengeluaran` varchar(20) NOT NULL,
  `tanggal_pengeluaran` date NOT NULL,
  `biaya_obat` bigint(20) NOT NULL,
  `biaya_gaji` bigint(20) NOT NULL,
  `biaya_harian` bigint(20) NOT NULL,
  `total_pengeluaran` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pengguna`
--

CREATE TABLE `tabel_pengguna` (
  `id_pengguna` varchar(20) NOT NULL,
  `tanggal_pengguna` date NOT NULL,
  `nama_pengguna` varchar(30) NOT NULL,
  `tipe_pengguna` varchar(10) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `kode_keamanan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_pengguna`
--

INSERT INTO `tabel_pengguna` (`id_pengguna`, `tanggal_pengguna`, `nama_pengguna`, `tipe_pengguna`, `kata_sandi`, `kode_keamanan`) VALUES
('200728010001', '2020-07-28', 'admin', 'ADMIN', '$2y$10$t7vd7RVeKaQhfGX0JgH92O/OAjld05Q9wtq5m2fLW2VJyq8Jf/Auu', '12368');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_rekap`
--

CREATE TABLE `tabel_rekap` (
  `id_rekap` varchar(20) NOT NULL,
  `tanggal_rekap` date NOT NULL,
  `shift_rekap` varchar(5) NOT NULL,
  `id_dokter` varchar(20) NOT NULL,
  `pasien_umum` int(11) NOT NULL,
  `pasien_bpjs` int(11) NOT NULL,
  `pasien_aqua` int(11) NOT NULL,
  `kunjungan` int(11) NOT NULL,
  `total_biaya` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_uang`
--

CREATE TABLE `tabel_uang` (
  `id_uang` varchar(20) NOT NULL,
  `uang_hadir` bigint(20) NOT NULL,
  `uang_bpjs` bigint(20) NOT NULL,
  `uang_aqua` bigint(20) NOT NULL,
  `biaya_bank` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_uang`
--

INSERT INTO `tabel_uang` (`id_uang`, `uang_hadir`, `uang_bpjs`, `uang_aqua`, `biaya_bank`) VALUES
('200701050001', 75000, 38000, 80000, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `tbmedis`
--

CREATE TABLE `tbmedis` (
  `id_medis` varchar(20) NOT NULL,
  `tanggal_medis` date NOT NULL,
  `id_dokter` varchar(20) NOT NULL,
  `id_param` varchar(20) NOT NULL,
  `shift_medis` varchar(7) NOT NULL,
  `id_pasien` varchar(20) NOT NULL,
  `tipe_pasien` varchar(7) NOT NULL,
  `diagnosa_medis` varchar(255) NOT NULL,
  `terapi_medis` varchar(255) NOT NULL,
  `biaya_medis` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_dokter`
--
ALTER TABLE `tabel_dokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indexes for table `tabel_medis`
--
ALTER TABLE `tabel_medis`
  ADD PRIMARY KEY (`id_medis`),
  ADD KEY `fk_dokter` (`id_dokter`),
  ADD KEY `fk_paramedis` (`id_param`),
  ADD KEY `fk_pasien` (`id_pasien`);

--
-- Indexes for table `tabel_obat`
--
ALTER TABLE `tabel_obat`
  ADD PRIMARY KEY (`id_tagihan`);

--
-- Indexes for table `tabel_paramedis`
--
ALTER TABLE `tabel_paramedis`
  ADD PRIMARY KEY (`id_param`);

--
-- Indexes for table `tabel_pasien`
--
ALTER TABLE `tabel_pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `tabel_pemasukan`
--
ALTER TABLE `tabel_pemasukan`
  ADD PRIMARY KEY (`id_pemasukan`);

--
-- Indexes for table `tabel_pengeluaran`
--
ALTER TABLE `tabel_pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `tabel_pengguna`
--
ALTER TABLE `tabel_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `tabel_rekap`
--
ALTER TABLE `tabel_rekap`
  ADD PRIMARY KEY (`id_rekap`);

--
-- Indexes for table `tabel_uang`
--
ALTER TABLE `tabel_uang`
  ADD PRIMARY KEY (`id_uang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
