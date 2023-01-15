-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 15, 2023 at 03:20 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bpu`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `alamat_email` varchar(100) NOT NULL,
  `telepon` varchar(30) NOT NULL,
  `alamat_perusahaan` text NOT NULL,
  `logo` text NOT NULL DEFAULT '',
  `visi_misi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`id`, `user_id`, `nama_perusahaan`, `alamat_email`, `telepon`, `alamat_perusahaan`, `logo`, `visi_misi`) VALUES
(1, 1, 'scafol', 'shaffanmadanny@gmail.com', '081272487113', 'Jln Syakikirti', 'cngo.jpeg', 'sampai titik terkahir');

-- --------------------------------------------------------

--
-- Table structure for table `detail_kerjasama`
--

CREATE TABLE `detail_kerjasama` (
  `id` int(11) NOT NULL,
  `id_kerjasama` int(11) NOT NULL,
  `judul_kegiatan` text NOT NULL DEFAULT '',
  `ruang_lingkup` text NOT NULL DEFAULT '',
  `deskripsi` text NOT NULL DEFAULT '',
  `lama_pekerjaan` int(11) NOT NULL DEFAULT 0,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `metode_pembayaran` enum('none','sekaligus','termin') NOT NULL DEFAULT 'none',
  `jumlah_termin` int(11) NOT NULL DEFAULT 0,
  `nilai_kontrak` double NOT NULL DEFAULT 0,
  `status` enum('usul','tidak disetujui','disetujui') NOT NULL DEFAULT 'usul'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_kerjasama`
--

INSERT INTO `detail_kerjasama` (`id`, `id_kerjasama`, `judul_kegiatan`, `ruang_lingkup`, `deskripsi`, `lama_pekerjaan`, `tanggal_mulai`, `tanggal_akhir`, `metode_pembayaran`, `jumlah_termin`, `nilai_kontrak`, `status`) VALUES
(1, 1, 'jk1', 'rl1', 'desc1', 30, NULL, NULL, 'termin', 3, 100000000, 'usul');

-- --------------------------------------------------------

--
-- Table structure for table `draft_kerjasama`
--

CREATE TABLE `draft_kerjasama` (
  `id` int(11) NOT NULL,
  `id_kerjasama` int(11) NOT NULL,
  `nama_draft` varchar(100) NOT NULL,
  `status` enum('usul','tidak disetujui','disetujui') NOT NULL DEFAULT 'usul'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `draft_kerjasama`
--

INSERT INTO `draft_kerjasama` (`id`, `id_kerjasama`, `nama_draft`, `status`) VALUES
(1, 1, 'BukuMetodologiPenelitian-ISBN978-623-255-107-7.pdf', 'disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `img_item_kategori`
--

CREATE TABLE `img_item_kategori` (
  `id` int(11) NOT NULL,
  `id_item_kategori` int(11) NOT NULL,
  `gambar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `item_kategori`
--

CREATE TABLE `item_kategori` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` text NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `id_layanan`, `nama`) VALUES
(1, 1, 'penelitian');

-- --------------------------------------------------------

--
-- Table structure for table `kerjasama`
--

CREATE TABLE `kerjasama` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nomor` int(11) NOT NULL,
  `status` enum('usul','draft','pembayaran','disetujui') NOT NULL DEFAULT 'usul'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kerjasama`
--

INSERT INTO `kerjasama` (`id`, `id_kategori`, `user_id`, `nomor`, `status`) VALUES
(1, 1, 1, 1, 'disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id`, `nama`) VALUES
(1, 'Kerjasama');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `id_kerjasama` int(11) NOT NULL,
  `nominal` double NOT NULL DEFAULT 0,
  `tujuan_rekening` varchar(100) NOT NULL DEFAULT '',
  `tanggal` date DEFAULT NULL,
  `bukti_pembayaran` text NOT NULL DEFAULT '',
  `status` enum('belum dibayar','menunggu konfirmasi','ditolak','lunas') NOT NULL DEFAULT 'belum dibayar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `id_kerjasama`, `nominal`, `tujuan_rekening`, `tanggal`, `bukti_pembayaran`, `status`) VALUES
(1, 1, 30000000, '123456', '2023-01-15', 'SS2.PNG', 'lunas'),
(2, 1, 30000000, '123456', '2023-01-15', 'SS23.PNG', 'lunas'),
(3, 1, 40000000, '123456', '2023-01-15', 'SS22.PNG', 'lunas');

-- --------------------------------------------------------

--
-- Table structure for table `rab`
--

CREATE TABLE `rab` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `volume` double NOT NULL,
  `harga` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rab`
--

INSERT INTO `rab` (`id`, `nama`, `satuan`, `volume`, `harga`, `total`) VALUES
(1, 'semen', 'sak', 5, 10000, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `rab_kerjasama`
--

CREATE TABLE `rab_kerjasama` (
  `id` int(11) NOT NULL,
  `id_kerjasama` int(11) NOT NULL,
  `id_rab` int(11) NOT NULL,
  `status` enum('usul','tidak disetujui','disetujui') NOT NULL DEFAULT 'usul'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rab_kerjasama`
--

INSERT INTO `rab_kerjasama` (`id`, `id_kerjasama`, `id_rab`, `status`) VALUES
(1, 1, 1, 'disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tipe_akun` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `tipe_akun`) VALUES
(1, 'shaffanmadanny@gmail.com', '123456', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_kerjasama`
--
ALTER TABLE `detail_kerjasama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `draft_kerjasama`
--
ALTER TABLE `draft_kerjasama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `img_item_kategori`
--
ALTER TABLE `img_item_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_kategori`
--
ALTER TABLE `item_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kerjasama`
--
ALTER TABLE `kerjasama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rab`
--
ALTER TABLE `rab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rab_kerjasama`
--
ALTER TABLE `rab_kerjasama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_kerjasama`
--
ALTER TABLE `detail_kerjasama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `draft_kerjasama`
--
ALTER TABLE `draft_kerjasama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `img_item_kategori`
--
ALTER TABLE `img_item_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_kategori`
--
ALTER TABLE `item_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kerjasama`
--
ALTER TABLE `kerjasama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rab`
--
ALTER TABLE `rab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rab_kerjasama`
--
ALTER TABLE `rab_kerjasama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
