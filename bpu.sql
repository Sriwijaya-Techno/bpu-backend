-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2023 at 12:39 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` longtext NOT NULL,
  `slug` varchar(150) NOT NULL,
  `cover` varchar(50) NOT NULL,
  `jenis` enum('pengumuman','berita') NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `user_id`, `judul`, `isi`, `slug`, `cover`, `jenis`, `tanggal`) VALUES
(1, 1, 'Golkar Jambi Targetkan 4 Kursi DPR RI', 'Ketua Bappilu DPD Partai Golkar Provinsi Jambi, Yun Ilman mengatakan, dengan komposisi yang dimiliki oleh partainya saat ini, sangat rasional jika mereka menargetkan 4 dari 8 kursi DPR RI untuk Provinsi Jambi.\n\n\"Kalau DPR RI targetnya 50 persen dari 8 kursi yang tersedia,\" ujar Yun Ilman, Senin (23/1/2023).\n\nMenurutnya, target tersebut sangat rasional. Ia juga menegaskan jika Golkar memiliki caleg-caleg potensial untuk meraih target tersebut.\n\nYun Ilman juga mengatakan, jika berkaca dari hasil Pemilu 2019 lalu, dimana Golkar Jambi berhasil meraih 2 kursi DPR dengan raihan 29 persen suara, maka ia yakin target 4 kursi bisa dicapai.\n\n\"(Pemilu 2019, red) dulu kita terbanyak kok, kursi. Bahkan hampir 3 kursi. Artinya, targetnya rasional 4 kursi,\" katanya.\n\nJika dibandingkan dengan kondisi yang berbeda saat ini, dimana Golkar dihuni oleh kader-kader potensial serta tokoh-tokoh di Jambi, dirinya optimis dapat meraih 50 persen kursi DPR RI.\n\n\"Karena dulu kan tidak kuat, calegnya cuma dua orang. Hari ini ada HBA (Hasan Basri Agus), ada CE (Cek Endra), ada Saniatul, ada AJB (Asafri Jaya Bakri), ada saya, ada Syahrasaddin, iya kan? tiap-tiap orang punya basis,\" pungkasnya.', 'Berita', 'SS4.PNG', 'berita', '2022-01-19 17:00:00'),
(2, 1, 'Golkar Jambi Targetkan 4 Kursi DPR RI 1', 'Ketua Bappilu DPD Partai Golkar Provinsi Jambi, Yun Ilman mengatakan, dengan komposisi yang dimiliki oleh partainya saat ini, sangat rasional jika mereka menargetkan 4 dari 8 kursi DPR RI untuk Provinsi Jambi.\n\n\"Kalau DPR RI targetnya 50 persen dari 8 kursi yang tersedia,\" ujar Yun Ilman, Senin (23/1/2023).\n\nMenurutnya, target tersebut sangat rasional. Ia juga menegaskan jika Golkar memiliki caleg-caleg potensial untuk meraih target tersebut.\n\nYun Ilman juga mengatakan, jika berkaca dari hasil Pemilu 2019 lalu, dimana Golkar Jambi berhasil meraih 2 kursi DPR dengan raihan 29 persen suara, maka ia yakin target 4 kursi bisa dicapai.\n\n\"(Pemilu 2019, red) dulu kita terbanyak kok, kursi. Bahkan hampir 3 kursi. Artinya, targetnya rasional 4 kursi,\" katanya.\n\nJika dibandingkan dengan kondisi yang berbeda saat ini, dimana Golkar dihuni oleh kader-kader potensial serta tokoh-tokoh di Jambi, dirinya optimis dapat meraih 50 persen kursi DPR RI.\n\n\"Karena dulu kan tidak kuat, calegnya cuma dua orang. Hari ini ada HBA (Hasan Basri Agus), ada CE (Cek Endra), ada Saniatul, ada AJB (Asafri Jaya Bakri), ada saya, ada Syahrasaddin, iya kan? tiap-tiap orang punya basis,\" pungkasnya.', 'Berita', 'SS41.PNG', 'pengumuman', '2022-01-19 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `base_setting`
--

CREATE TABLE `base_setting` (
  `bs_id` int(11) NOT NULL,
  `bs_nama` varchar(50) NOT NULL,
  `bs_rektor` varchar(50) NOT NULL,
  `bs_keterangan` text NOT NULL,
  `bs_logo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `base_setting`
--

INSERT INTO `base_setting` (`bs_id`, `bs_nama`, `bs_rektor`, `bs_keterangan`, `bs_logo`) VALUES
(1, 'UNIVERSITAS SRIWIJAYA', 'Prof. Dr. Ir. Anis Saggaff, MSCE', 'Rektor Universitas Sriwijaya, berdasarkan Surat Keputusan Menteri Riset dan Pendidikan Tinggi Republik Indonesia Nomor 334/M/KP/XI/2015 Tanggal 24 November 2015 Tentang Pengangkatan Rektor Universitas Sriwijaya, berkedudukan di Jalan Raya Palembang-Prabumulih Km 32 Indralaya Ogan Ilir 30662, bertindak untuk dan atas nama Universitas Sriwijaya', '4ac2d22825cea9c757384ad9a5af3d92.png');

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cps_id` int(11) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `nama_pimpinan` varchar(100) NOT NULL,
  `alamat_email` varchar(100) NOT NULL,
  `telepon` varchar(30) NOT NULL,
  `alamat_perusahaan` text NOT NULL,
  `logo` text NOT NULL DEFAULT '',
  `visi_misi` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`id`, `user_id`, `cps_id`, `nama_perusahaan`, `nama_pimpinan`, `alamat_email`, `telepon`, `alamat_perusahaan`, `logo`, `visi_misi`, `created_date`) VALUES
(1, 1, 4, 'Scafol', 'Shaffan Madanny S.Kom', 'shaffanmadanny@gmail.com', '081272487113', 'Alamat 1', '757b1168641ae0a503bd0f2fd287a66b.jpg', 'Visi Misi 1', '2023-02-01 01:28:37');

-- --------------------------------------------------------

--
-- Table structure for table `company_profile_status`
--

CREATE TABLE `company_profile_status` (
  `cps_id` int(11) NOT NULL,
  `cps_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_profile_status`
--

INSERT INTO `company_profile_status` (`cps_id`, `cps_nama`) VALUES
(1, 'Rektor'),
(3, 'Ketua Yayasan'),
(4, 'Direktur'),
(5, 'Direktur Utama'),
(6, 'Sekretaris '),
(7, 'Kepala'),
(8, 'Gubernur'),
(9, 'Walikota'),
(10, 'Manager '),
(11, 'Bupati'),
(12, 'Ketua '),
(13, 'Wakil Rektor'),
(14, 'Dekan');

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
(1, 1, 'judul penelitian 1', 'ruang lingkup 1', 'deskripsi 1', 30, '2023-02-01', '2023-03-03', 'termin', 3, 10000000, 'disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `draft_kerjasama`
--

CREATE TABLE `draft_kerjasama` (
  `id` int(11) NOT NULL,
  `id_kerjasama` int(11) NOT NULL,
  `id_cp` int(11) NOT NULL,
  `draft_nomorp1` varchar(50) NOT NULL,
  `draft_nomorp2` varchar(50) NOT NULL,
  `draft_tanggal_mulai` date NOT NULL,
  `draft_tanggal_akhir` date NOT NULL,
  `draft_info` text NOT NULL,
  `draft_lokasi` varchar(50) NOT NULL,
  `draft_keterangan` text NOT NULL,
  `draft_file` varchar(100) NOT NULL,
  `draft_status` enum('p1','p2') NOT NULL,
  `status` enum('usul','tidak disetujui','disetujui') NOT NULL DEFAULT 'usul'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `draft_kerjasama`
--

INSERT INTO `draft_kerjasama` (`id`, `id_kerjasama`, `id_cp`, `draft_nomorp1`, `draft_nomorp2`, `draft_tanggal_mulai`, `draft_tanggal_akhir`, `draft_info`, `draft_lokasi`, `draft_keterangan`, `draft_file`, `draft_status`, `status`) VALUES
(1, 1, 1, '1', '2', '2023-02-01', '2023-02-02', 'oke', 'oke', 'oke', 'Draft_kerjasama_Scafol_oke.pdf', 'p1', 'disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `header_home`
--

CREATE TABLE `header_home` (
  `id` int(11) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `title_logo` varchar(100) NOT NULL,
  `sub_title_logo` varchar(100) NOT NULL,
  `lokasi` text NOT NULL,
  `kontak` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `img_item_kategori`
--

CREATE TABLE `img_item_kategori` (
  `id` int(11) NOT NULL,
  `id_item_kategori` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `img_item_kategori`
--

INSERT INTO `img_item_kategori` (`id`, `id_item_kategori`, `gambar`) VALUES
(1, 1, 'unsri-tampak-depan.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `item_kategori`
--

CREATE TABLE `item_kategori` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` text NOT NULL,
  `deskripsi` text NOT NULL,
  `fasilitas` text NOT NULL DEFAULT '',
  `ketentuan` text NOT NULL DEFAULT '',
  `slug` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_kategori`
--

INSERT INTO `item_kategori` (`id`, `id_kategori`, `judul`, `deskripsi`, `fasilitas`, `ketentuan`, `slug`, `created_date`) VALUES
(1, 1, 'Kerjasama Penelitian', 'deskripsi 1', 'fasilitas 1', 'ketentuan 1', 'kerjasama-penelitian', '2023-02-01 00:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `icon` text NOT NULL DEFAULT '',
  `slug` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `id_layanan`, `nama`, `icon`, `slug`, `created_date`) VALUES
(1, 1, 'Penelitian', '', 'penelitian', '2023-02-01 00:59:05');

-- --------------------------------------------------------

--
-- Table structure for table `kerjasama`
--

CREATE TABLE `kerjasama` (
  `id` int(11) NOT NULL,
  `id_item_kategori` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nomor` int(11) NOT NULL,
  `status` enum('usul','draft','disetujui') NOT NULL DEFAULT 'usul',
  `komentar` text NOT NULL DEFAULT '',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kerjasama`
--

INSERT INTO `kerjasama` (`id`, `id_item_kategori`, `user_id`, `nomor`, `status`, `komentar`, `created_date`) VALUES
(1, 1, 1, 0, 'disetujui', '', '2023-02-01 01:00:29');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `icon` text NOT NULL,
  `slug` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id`, `nama`, `icon`, `slug`, `created_date`) VALUES
(1, 'Kerjasama', 'fab fa-acquisitions-incorporated', 'kerjasama', '2023-02-01 00:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `menu_access`
--

CREATE TABLE `menu_access` (
  `id` int(11) NOT NULL,
  `menu` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('ditampilkan','dihapus') NOT NULL DEFAULT 'ditampilkan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pasal`
--

CREATE TABLE `pasal` (
  `pasal_id` int(11) NOT NULL,
  `draft_id` varchar(35) NOT NULL,
  `pasal_kode` int(11) NOT NULL,
  `pasal_isi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasal`
--

INSERT INTO `pasal` (`pasal_id`, `draft_id`, `pasal_kode`, `pasal_isi`) VALUES
(1, '1', 1, '<h3>\r\n                                <div style=\"text-align: center;\">\r\n                                    <span style=\"font-family: Arial; color: inherit;\">\r\n                                        PASAL 1\r\n                                    </span>\r\n                                </div>\r\n                                <span style=\"font-family: Arial; color: inherit;\">\r\n                                    <div style=\"text-align: center;\">\r\n                                        <span style=\"color: inherit;\">\r\n                                            MAKSUD DAN TUJUAN\r\n                                        </span>\r\n                                    </div>\r\n                                    <br>\r\n                                </span>\r\n                            </h3>\r\n                            <h3>\r\n                                <ol style=\"font-size: 13px;\">\r\n                                    <li style=\"text-align: left; margin-bottom: 0.0001pt; line-height: normal;\">\r\n                                        <span lang=\"IN\" style=\"text-align: justify; text-indent: -21.3pt; color: inherit; font-family: Arial;\"><span style=\"font-weight: normal;\">\r\n                                        Nota Kesepahaman Bersama ini disusun dengan maksud untuk memberikan dasar hukum bagi </span>PARA PIHAK<span style=\"font-weight: normal;\"> dalam melaksanakan kerjasama guna meningkatkan kemampuan segenap potensi dan sumber daya yang dimiliki </span>PARA PIHAK\r\n                                    </span>\r\n                                </li>\r\n                                <li style=\"text-align: left; margin-bottom: 0.0001pt; line-height: normal;\">\r\n                                    <span lang=\"IN\" style=\"text-align: justify; text-indent: -21.3pt; color: inherit; font-family: Arial; font-weight: normal;\">\r\n                                    Nota Kesepahaman Bersama ini bertujuan untuk meningkatkan kualitas pelaksanaan tugas dan fungsi </span><span lang=\"IN\" style=\"text-align: justify; text-indent: -21.3pt; color: inherit; font-family: Arial;\">PARA PIHAK</span><span lang=\"IN\" style=\"text-align: justify; text-indent: -21.3pt; color: inherit; font-family: Arial; font-weight: normal;\"> sesuai kewenangan yang dimiliki\r\n                                    </span>\r\n                                </li>\r\n                            </ol>\r\n                        </h3>'),
(2, '1', 2, '<h3>\r\n                            <div style=\"text-align: center;\">\r\n                                <span style=\"font-family: Arial; color: inherit;\">\r\n                                    PASAL 2\r\n                                </span>\r\n                            </div>\r\n                            <span style=\"font-family: Arial; color: inherit;\">\r\n                                <div style=\"text-align: center;\">\r\n                                    <span style=\"color: inherit;\">\r\n                                        RUANG\r\n                                        LINGKUP KERJASAMA\r\n                                    </span>\r\n                                </div>\r\n                                <br>\r\n                            </span>\r\n                        </h3>'),
(3, '1', 3, '<h3>\r\n                            <div style=\"text-align: center;\">\r\n                                <span style=\"font-family: Arial; color: inherit;\">\r\n                                    PASAL 3\r\n                                </span>\r\n                            </div>\r\n                            <span style=\"font-family: Arial; color: inherit;\">\r\n                                <div style=\"text-align: center;\">\r\n                                    <span style=\"color: inherit;\">\r\n                                        TUGAS PARA PIHAK\r\n                                    </span>\r\n                                </div>\r\n                                <br>\r\n                            </span>\r\n                        </h3>\r\n                    \r\n                        <div style=\"text-align: left;\">\r\n                            <span lang=\"IN\" style=\"font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;\"> \r\n                                <b>PARA PIHAK</b> dalam batas-batas kewenangan yang ada dan sumber daya yang tersedia akan saling menyediakan fasilitas yang diperlukan untuk pelaksanaan kerjasama sesuai dengan ruang lingkup kerjasama yang tersebut pada Pasal 2.\r\n                            </span>\r\n                            <br>\r\n                        </div>'),
(4, '1', 4, '<h3>\r\n                            <div style=\"text-align: center;\">\r\n                                <span style=\"font-family: Arial; color: inherit;\">\r\n                                    PASAL 4\r\n                                </span>\r\n                            </div>\r\n                            <span style=\"font-family: Arial; color: inherit;\">\r\n                                <div style=\"text-align: center;\">\r\n                                    <span style=\"color: inherit;\">\r\n                                        TUGAS PELAKSANAAN KEGIATAN KERJASAMA\r\n                                    </span>\r\n                                </div>\r\n                                <br>\r\n                            </span>\r\n                        </h3>\r\n                    \r\n                        <div style=\"text-align: left;\">\r\n                            <span lang=\"IN\" style=\"font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;\"> \r\n                                Nota Kesepahaman ini merupakan Payung dari Perjanjian Kerjasama yang disusun secara tersendiri untuk setiap bidang kerjasama yang akan dilaksanakan dan atau ditindaklanjuti oleh berbagai fakultas, lembaga atau unit di lingkungan Universitas Sriwijaya dan Universitas Bina Darma.\r\n                            </span>\r\n                            <br>\r\n                        </div>'),
(5, '1', 5, '<h3>\r\n                            <div style=\"text-align: center;\">\r\n                                <span style=\"font-family: Arial; color: inherit;\">\r\n                                    PASAL 5\r\n                                </span>\r\n                            </div>\r\n                            <span style=\"font-family: Arial; color: inherit;\">\r\n                                <div style=\"text-align: center;\">\r\n                                    <span style=\"color: inherit;\">\r\n                                        TUGAS PELAKSANAAN KEGIATAN KERJASAMA\r\n                                    </span>\r\n                                </div>\r\n                                <br>\r\n                            </span>\r\n                        </h3>\r\n                    \r\n                        <div style=\"text-align: left;\">\r\n                            <span lang=\"IN\" style=\"font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;\"> \r\n                                Nota Kesepahaman ini merupakan Payung dari Perjanjian Kerjasama yang disusun secara tersendiri untuk setiap bidang kerjasama yang akan dilaksanakan dan atau ditindaklanjuti oleh berbagai fakultas, lembaga atau unit di lingkungan Universitas Sriwijaya dan Universitas Bina Darma.\r\n                            </span>\r\n                            <br>\r\n                        </div>'),
(6, '1', 6, '<h3>\r\n                            <div style=\"text-align: center;\">\r\n                                <span style=\"font-family: Arial; color: inherit;\">\r\n                                    PASAL 6\r\n                                </span>\r\n                            </div>\r\n                            <span style=\"font-family: Arial; color: inherit;\">\r\n                                <div style=\"text-align: center;\">\r\n                                    <span style=\"color: inherit;\">\r\n                                        TUGAS PELAKSANAAN KEGIATAN KERJASAMA\r\n                                    </span>\r\n                                </div>\r\n                                <br>\r\n                            </span>\r\n                        </h3>\r\n                    \r\n                        <div style=\"text-align: left;\">\r\n                            <span lang=\"IN\" style=\"font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;\"> \r\n                                Nota Kesepahaman ini merupakan Payung dari Perjanjian Kerjasama yang disusun secara tersendiri untuk setiap bidang kerjasama yang akan dilaksanakan dan atau ditindaklanjuti oleh berbagai fakultas, lembaga atau unit di lingkungan Universitas Sriwijaya dan Universitas Bina Darma.\r\n                            </span>\r\n                            <br>\r\n                        </div>'),
(7, '1', 7, '<h3>\r\n                            <div style=\"text-align: center;\">\r\n                                <span style=\"font-family: Arial; color: inherit;\">\r\n                                    PASAL 7\r\n                                </span>\r\n                            </div>\r\n                            <span style=\"font-family: Arial; color: inherit;\">\r\n                                <div style=\"text-align: center;\">\r\n                                    <span style=\"color: inherit;\">\r\n                                        TUGAS PELAKSANAAN KEGIATAN KERJASAMA\r\n                                    </span>\r\n                                </div>\r\n                                <br>\r\n                            </span>\r\n                        </h3>\r\n                    \r\n                        <div style=\"text-align: left;\">\r\n                            <span lang=\"IN\" style=\"font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;\"> \r\n                                Nota Kesepahaman ini merupakan Payung dari Perjanjian Kerjasama yang disusun secara tersendiri untuk setiap bidang kerjasama yang akan dilaksanakan dan atau ditindaklanjuti oleh berbagai fakultas, lembaga atau unit di lingkungan Universitas Sriwijaya dan Universitas Bina Darma.\r\n                            </span>\r\n                            <br>\r\n                        </div>'),
(8, '1', 8, '<h3>\r\n                            <div style=\"text-align: center;\">\r\n                                <span style=\"font-family: Arial; color: inherit;\">\r\n                                    PASAL 8\r\n                                </span>\r\n                            </div>\r\n                            <span style=\"font-family: Arial; color: inherit;\">\r\n                                <div style=\"text-align: center;\">\r\n                                    <span style=\"color: inherit;\">\r\n                                        TUGAS PELAKSANAAN KEGIATAN KERJASAMA\r\n                                    </span>\r\n                                </div>\r\n                                <br>\r\n                            </span>\r\n                        </h3>\r\n                    \r\n                        <div style=\"text-align: left;\">\r\n                            <span lang=\"IN\" style=\"font-weight: 400; font-size: 13px; color: inherit; text-align: justify; font-family: Arial, sans-serif;\"> \r\n                                Nota Kesepahaman ini merupakan Payung dari Perjanjian Kerjasama yang disusun secara tersendiri untuk setiap bidang kerjasama yang akan dilaksanakan dan atau ditindaklanjuti oleh berbagai fakultas, lembaga atau unit di lingkungan Universitas Sriwijaya dan Universitas Bina Darma.\r\n                            </span>\r\n                            <br>\r\n                        </div>');

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
(1, 1, 4000000, '1', '2023-02-01', 'SS5.PNG', 'lunas'),
(2, 1, 0, '', NULL, '', 'belum dibayar'),
(3, 1, 0, '', NULL, '', 'belum dibayar');

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
(1, 'contoh 1', 'satuan 1', 10, 5000, 50000);

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
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tentang_home`
--

CREATE TABLE `tentang_home` (
  `id` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `tujuan` text NOT NULL,
  `quotes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tentang_home`
--

INSERT INTO `tentang_home` (`id`, `gambar`, `isi`, `visi`, `misi`, `tujuan`, `quotes`) VALUES
(1, 'unsri-tampak-depan.jpeg', 'Badan Pengelola Usaha (BPU) Universitas Sriwijaya dibentuk melalui Peraturan Rektor Universitas Sriwijaya No. 05 Tahun 2016, tanggal 18 Oktober 2016, direvisi Peraturan Rektor Universitas Sriwijaya No. 10 Tahun 2018, tanggal 26 Desember 2018, tentang Penyelenggaraan Badan Pengelola Usaha Universitas Sriwijaya.\n\nPengangkatan Personalia Badan Pengelola Usaha Universitas Sriwijaya melalui Keputusan Rektor Universitas Sriwijaya Nomor: 0702/UN9/SK.BUK.KP/2018, tanggal 31 Desember 2018.', 'Menjadi Induk Unit Usaha Inovatif, yang Profesional dan Berintegritas.', 'Misi BPU Unsri dibuat untuk menunjang misi ke 5 dan ke 6 Universitas Sriwijaya. Adapun misi BPU Unsri adalah sebagai berikut:\n\nMewujudkan tata kelola yang kredibel, transparan, akuntabel, bertanggung jawab dan adil di seluruh unit usaha.\nMengembangkan unit usaha berbasis teknologi, inovasi baik akademik dan Non akademik.\nMemberikan pelayanan yang prima bagi civitas akademika dan tenaga kependidikan Unsri, Masyarakat dan Industri.\nMengembangkan dan memfasilitasi Kegiatan Kerjasama dengan pihak ketiga.', 'Adapun tujuan BPU Unsri adalah sebagai berikut:\n\nUntuk Mengkoordinir Sumber-sumber Pendapatan Unsri sesuai peraturan yang berlaku\nUntuk Menciptakan Peluang Sumber Pendapatan Baru Bagi Unsri.', 'quotes 1');

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
--

CREATE TABLE `testimoni` (
  `id` int(11) NOT NULL,
  `isi` text NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_pembayaran`
--

CREATE TABLE `transaksi_pembayaran` (
  `id_transaksi` int(11) NOT NULL,
  `id_item_kategori` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `awal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `akhir` timestamp NOT NULL DEFAULT current_timestamp(),
  `satuan` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `harga` double NOT NULL,
  `kontrak` double NOT NULL,
  `kode_bayar` varchar(20) NOT NULL,
  `status_bayar` enum('pending','lunas') NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tipe_akun` enum('Mahasiswa','Dosen/Pegawai','Institusi/Pemerintahan','Masyarakat Umum','Admin') NOT NULL,
  `status` enum('unverified','verified') NOT NULL DEFAULT 'unverified',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `tipe_akun`, `status`, `created_date`) VALUES
(1, 'shaffan', 'shaffanmadanny@gmail.com', '6209f26e17cc96d256fd40ed2b85416d', 'Institusi/Pemerintahan', 'unverified', '2023-01-19 01:02:20'),
(2, 'shaffan94', 'shaffanmadanny05@gmail.com', '6209f26e17cc96d256fd40ed2b85416d', 'Admin', 'unverified', '2023-01-31 23:16:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE `user_access` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `status` enum('ditampilkan','dihapus') NOT NULL DEFAULT 'ditampilkan',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `base_setting`
--
ALTER TABLE `base_setting`
  ADD PRIMARY KEY (`bs_id`);

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_profile_status`
--
ALTER TABLE `company_profile_status`
  ADD PRIMARY KEY (`cps_id`);

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
-- Indexes for table `header_home`
--
ALTER TABLE `header_home`
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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`) USING HASH;

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`) USING HASH;

--
-- Indexes for table `kerjasama`
--
ALTER TABLE `kerjasama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`) USING HASH,
  ADD UNIQUE KEY `slug_2` (`slug`) USING HASH;

--
-- Indexes for table `menu_access`
--
ALTER TABLE `menu_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasal`
--
ALTER TABLE `pasal`
  ADD PRIMARY KEY (`pasal_id`);

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
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tentang_home`
--
ALTER TABLE `tentang_home`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_pembayaran`
--
ALTER TABLE `transaksi_pembayaran`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access`
--
ALTER TABLE `user_access`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `base_setting`
--
ALTER TABLE `base_setting`
  MODIFY `bs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_profile_status`
--
ALTER TABLE `company_profile_status`
  MODIFY `cps_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `detail_kerjasama`
--
ALTER TABLE `detail_kerjasama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `draft_kerjasama`
--
ALTER TABLE `draft_kerjasama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `header_home`
--
ALTER TABLE `header_home`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `img_item_kategori`
--
ALTER TABLE `img_item_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `item_kategori`
--
ALTER TABLE `item_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kerjasama`
--
ALTER TABLE `kerjasama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu_access`
--
ALTER TABLE `menu_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasal`
--
ALTER TABLE `pasal`
  MODIFY `pasal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tentang_home`
--
ALTER TABLE `tentang_home`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_pembayaran`
--
ALTER TABLE `transaksi_pembayaran`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_access`
--
ALTER TABLE `user_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
