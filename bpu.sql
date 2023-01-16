-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 16, 2023 at 02:26 AM
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
(1, 1, 'scafol', 'shaffanmadanny@gmail.com', '081272487113', 'Jln Syakikirti', '757b1168641ae0a503bd0f2fd287a66b.jpg', 'sampai titik terawal');

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
  `id_lembaga` int(11) NOT NULL,
  `draft_nomorp1` varchar(50) NOT NULL,
  `draft_nomorp2` varchar(50) NOT NULL,
  `draft_tanggal_mulai` date NOT NULL,
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

INSERT INTO `draft_kerjasama` (`id`, `id_kerjasama`, `id_lembaga`, `draft_nomorp1`, `draft_nomorp2`, `draft_tanggal_mulai`, `draft_info`, `draft_lokasi`, `draft_keterangan`, `draft_file`, `draft_status`, `status`) VALUES
(1, 1, 1, '1', '2', '2022-01-16', 'info', 'lokasi', 'keterangan', 'Draft_ kerjasama_KIRKLARELI UNIVERSITY_lokasi.pdf', 'p1', 'usul');

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
-- Table structure for table `lembaga`
--

CREATE TABLE `lembaga` (
  `lembaga_id` int(11) NOT NULL,
  `lembaga_nama` varchar(255) NOT NULL,
  `lj_id` int(11) DEFAULT NULL,
  `lembaga_pimpinan_nama` varchar(50) NOT NULL,
  `ls_id` int(11) DEFAULT NULL,
  `lembaga_lat` float NOT NULL,
  `lembaga_lng` float NOT NULL,
  `lembaga_address` text NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `lembaga_country_id` varchar(10) NOT NULL,
  `lembaga_country` varchar(50) NOT NULL,
  `lembaga_provinsi_id` varchar(100) DEFAULT NULL,
  `lembaga_logo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lembaga`
--

INSERT INTO `lembaga` (`lembaga_id`, `lembaga_nama`, `lj_id`, `lembaga_pimpinan_nama`, `ls_id`, `lembaga_lat`, `lembaga_lng`, `lembaga_address`, `tanggal_mulai`, `tanggal_berakhir`, `lembaga_country_id`, `lembaga_country`, `lembaga_provinsi_id`, `lembaga_logo`) VALUES
(1, 'KIRKLARELI UNIVERSITY', 1, 'Prof. Dr. Buln t Seigo rur', 1, -2.98606, 104.732, 'Jl. Masjid Al Gazali, Bukit Lama, Kec. Ilir Bar. I, Kota Palembang, Sumatera Selatan 30128, Indonesia', '2020-07-27', '2025-07-27', 'ID', 'Indonesia', '1', '757b1168641ae0a503bd0f2fd287a66b.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lembaga_jenis`
--

CREATE TABLE `lembaga_jenis` (
  `lj_id` int(11) NOT NULL,
  `lj_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lembaga_jenis`
--

INSERT INTO `lembaga_jenis` (`lj_id`, `lj_nama`) VALUES
(1, 'Perguruan Tinggi'),
(2, 'Perguruan Tinggi Swasta'),
(4, 'Pesantren'),
(5, 'Lembaga Negara'),
(6, 'Perusahaan BUMN '),
(7, 'Perusahaan Swasta'),
(8, 'Perusahaan Nasional'),
(9, 'Badan Organisasi'),
(10, 'Rumah Sakit');

-- --------------------------------------------------------

--
-- Table structure for table `lembaga_status`
--

CREATE TABLE `lembaga_status` (
  `ls_id` int(11) NOT NULL,
  `ls_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lembaga_status`
--

INSERT INTO `lembaga_status` (`ls_id`, `ls_nama`) VALUES
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
-- Table structure for table `negara_dunia`
--

CREATE TABLE `negara_dunia` (
  `negara_id` int(11) NOT NULL,
  `negara_label` varchar(2) NOT NULL DEFAULT '',
  `negara_name` varchar(100) NOT NULL DEFAULT '',
  `negara_code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `negara_dunia`
--

INSERT INTO `negara_dunia` (`negara_id`, `negara_label`, `negara_name`, `negara_code`) VALUES
(5, 'AD', 'Andorra', '130'),
(230, 'AE', 'United Arab Emirates', '200'),
(1, 'AF', 'Afghanistan', '93'),
(9, 'AG', 'Antigua and Barbuda', '01'),
(7, 'AI', 'Anguilla', '207'),
(2, 'AL', 'Albania', '129'),
(11, 'AM', 'Armenia', '94'),
(157, 'AN', 'Netherlands Antilles', '207'),
(6, 'AO', 'Angola', '40'),
(8, 'AQ', 'Antarctica', '672'),
(10, 'AR', 'Argentina', '25'),
(14, 'AT', 'Austria', '131'),
(13, 'AU', 'Australia', '175'),
(12, 'AW', 'Aruba', '297'),
(15, 'AZ', 'Azerbaijan', '95'),
(27, 'BA', 'Bosnia and Herzegovina', '190'),
(19, 'BB', 'Barbados', '03'),
(18, 'BD', 'Bangladesh', '96'),
(21, 'BE', 'Belgium', '133'),
(34, 'BF', 'Burkina Faso', '43'),
(33, 'BG', 'Bulgaria', '135'),
(17, 'BH', 'Bahrain', '134'),
(35, 'BI', 'Burundi', '44'),
(23, 'BJ', 'Benin', '41'),
(24, 'BM', 'Bermuda', '209'),
(32, 'BN', 'Brunei Darussalam', '98'),
(26, 'BO', 'Bolivia', '26'),
(30, 'BR', 'Brazil', '27'),
(16, 'BS', 'Bahamas', '02'),
(25, 'BT', 'Bhutan', '97'),
(29, 'BV', 'Bouvet Island', ''),
(28, 'BW', 'Botswana', '42'),
(20, 'BY', 'Belarus', '132'),
(22, 'BZ', 'Belize', '04'),
(38, 'CA', 'Canada', '05'),
(46, 'CC', 'Cocos (Keeling) Islands', '211'),
(49, 'CD', 'Democratic Republic of the Congo', '51'),
(41, 'CF', 'Central African Republic', '236'),
(50, 'CG', 'Republic of Congo', '91'),
(213, 'CH', 'Switzerland', '168'),
(108, 'CI', 'Ivory Coast', '50'),
(51, 'CK', 'Cook Islands', '212'),
(43, 'CL', 'Chile', '28'),
(37, 'CM', 'Cameroon', '45'),
(44, 'CN', 'China', '101'),
(47, 'CO', 'Colombia', '29'),
(52, 'CR', 'Costa Rica', '06'),
(54, 'CU', 'Cuba', '07'),
(39, 'CV', 'Cape Verde', '46'),
(45, 'CX', 'Christmas Island', '213'),
(55, 'CY', 'Cyprus', '172'),
(56, 'CZ', 'Czech Republic', '137'),
(81, 'DE', 'Germany', '142'),
(58, 'DJ', 'Djibouti', '52'),
(57, 'DK', 'Denmark', '138'),
(59, 'DM', 'Dominica', '08'),
(60, 'DO', 'Dominican Republic', '09'),
(4, 'DS', 'American Samoa', '208'),
(3, 'DZ', 'Algeria', '39'),
(62, 'EC', 'Ecuador', '30'),
(67, 'EE', 'Estonia', '139'),
(63, 'EG', 'Egypt', '53'),
(243, 'EH', 'Western Sahara', '87'),
(66, 'ER', 'Eritrea', '55'),
(204, 'ES', 'Spain', '166'),
(68, 'ET', 'Ethiopia', '56'),
(72, 'FI', 'Finland', '140'),
(71, 'FJ', 'Fiji', '176'),
(69, 'FK', 'Falkland Islands (Malvinas)', '31'),
(144, 'FM', 'Micronesia, Federated States of', '179'),
(70, 'FO', 'Faroe Islands', ''),
(73, 'FR', 'France', '141'),
(74, 'FX', 'France, Metropolitan', ''),
(78, 'GA', 'Gabon', '57'),
(231, 'GB', 'United Kingdom', '170'),
(87, 'GD', 'Grenada', '11'),
(80, 'GE', 'Georgia', '103'),
(75, 'GF', 'French Guiana', '32'),
(82, 'GH', 'Ghana', '58'),
(83, 'GI', 'Gibraltar', '217'),
(84, 'GK', 'Guernsey', '221'),
(86, 'GL', 'Greenland', '24'),
(79, 'GM', 'Gambia', '90'),
(91, 'GN', 'Guinea', '59'),
(88, 'GP', 'Guadeloupe', '219'),
(65, 'GQ', 'Equatorial Guinea', '54'),
(85, 'GR', 'Greece', '143'),
(202, 'GS', 'South Georgia South Sandwich Islands', '220'),
(90, 'GT', 'Guatemala', '12'),
(89, 'GU', 'Guam', '221'),
(92, 'GW', 'Guinea-Bissau', '60'),
(93, 'GY', 'Guyana', '33'),
(97, 'HK', 'Hong Kong', '127'),
(95, 'HM', 'Heard and Mc Donald Islands', ''),
(96, 'HN', 'Honduras', '14'),
(53, 'HR', 'Croatia (Hrvatska)', '136'),
(94, 'HT', 'Haiti', '13'),
(98, 'HU', 'Hungary', '144'),
(102, 'ID', 'Indonesia', '105'),
(105, 'IE', 'Ireland', '192'),
(106, 'IL', 'Israel', '192'),
(101, 'IM', 'Isle of Man', '222'),
(100, 'IN', 'India', '104'),
(31, 'IO', 'British Indian Ocean Territory', '246'),
(104, 'IQ', 'Iraq', ''),
(103, 'IR', 'Iran (Islamic Republic of)', '146'),
(99, 'IS', 'Iceland', '145'),
(107, 'IT', 'Italy', '147'),
(109, 'JE', 'Jersey', '223'),
(110, 'JM', 'Jamaica', '15'),
(112, 'JO', 'Jordan', '193'),
(111, 'JP', 'Japan', '107'),
(114, 'KE', 'Kenya', '61'),
(120, 'KG', 'Kyrgyzstan', '111'),
(36, 'KH', 'Cambodia', '100'),
(115, 'KI', 'Kiribati', '177'),
(48, 'KM', 'Comoros', '49'),
(185, 'KN', 'Saint Kitts and Nevis', '19'),
(116, 'KP', 'Korea, Democratic People\'s Republic of', '109'),
(117, 'KR', 'Korea, Republic of', '110'),
(119, 'KW', 'Kuwait', '194'),
(40, 'KY', 'Cayman Islands', '203'),
(113, 'KZ', 'Kazakhstan', '108'),
(121, 'LA', 'Lao People\'s Democratic Republic', '112'),
(123, 'LB', 'Lebanon', '195'),
(186, 'LC', 'Saint Lucia', '20'),
(127, 'LI', 'Liechtenstein', '63'),
(205, 'LK', 'Sri Lanka', '120'),
(125, 'LR', 'Liberia', '64'),
(124, 'LS', 'Lesotho', '62'),
(128, 'LT', 'Lithuania', '150'),
(129, 'LU', 'Luxembourg', '151'),
(122, 'LV', 'Latvia', '148'),
(126, 'LY', 'Libyan Arab Jamahiriya', '64'),
(150, 'MA', 'Morocco', '69'),
(146, 'MC', 'Monaco', '155'),
(145, 'MD', 'Moldova, Republic of', '225'),
(148, 'ME', 'Montenegro', '226'),
(132, 'MG', 'Madagascar', '156'),
(138, 'MH', 'Marshall Islands', '178'),
(131, 'MK', 'North Macedonia', '152'),
(136, 'ML', 'Mali', '67'),
(152, 'MM', 'Myanmar', '99'),
(147, 'MN', 'Mongolia', '114'),
(130, 'MO', 'Macau', ''),
(165, 'MP', 'Northern Mariana Islands', '227'),
(139, 'MQ', 'Martinique', '228'),
(140, 'MR', 'Mauritania', '68'),
(149, 'MS', 'Montserrat', '65'),
(137, 'MT', 'Malta', '153'),
(141, 'MU', 'Mauritius', '92'),
(135, 'MV', 'Maldives', '154'),
(133, 'MW', 'Malawi', '66'),
(143, 'MX', 'Mexico', '16'),
(134, 'MY', 'Malaysia', '113'),
(151, 'MZ', 'Mozambique', '70'),
(153, 'NA', 'Namibia', '245'),
(158, 'NC', 'New Caledonia', '246'),
(161, 'NE', 'Niger', '72'),
(164, 'NF', 'Norfolk Island', '229'),
(162, 'NG', 'Nigeria', '73'),
(160, 'NI', 'Nicaragua', '17'),
(156, 'NL', 'Netherlands', '157'),
(166, 'NO', 'Norway', '158'),
(155, 'NP', 'Nepal', '115'),
(154, 'NR', 'Nauru', '180'),
(163, 'NU', 'Niue', '231'),
(159, 'NZ', 'New Zealand', '181'),
(167, 'OM', 'Oman', '196'),
(171, 'PA', 'Panama', '18'),
(174, 'PE', 'Peru', '35'),
(76, 'PF', 'French Polynesia', '216'),
(172, 'PG', 'Papua New Guinea', '183'),
(175, 'PH', 'Philippines', '117'),
(168, 'PK', 'Pakistan', '116'),
(177, 'PL', 'Poland', '159'),
(207, 'PM', 'St. Pierre and Miquelon', '236'),
(176, 'PN', 'Pitcairn', '232'),
(179, 'PR', 'Puerto Rico', '202'),
(170, 'PS', 'Palestine', '240'),
(178, 'PT', 'Portugal', '160'),
(169, 'PW', 'Palau', '182'),
(173, 'PY', 'Paraguay', '34'),
(180, 'QA', 'Qatar', '197'),
(181, 'RE', 'Reunion', '233'),
(182, 'RO', 'Romania', '161'),
(193, 'RS', 'Serbia', '163'),
(183, 'RU', 'Russian Federation', '118'),
(184, 'RW', 'Rwanda', '74'),
(191, 'SA', 'Saudi Arabia', '198'),
(199, 'SB', 'Solomon Islands', '185'),
(194, 'SC', 'Seychelles', '77'),
(208, 'SD', 'Sudan', '81'),
(212, 'SE', 'Sweden', '167'),
(196, 'SG', 'Singapore', '119'),
(206, 'SH', 'St. Helena', '235'),
(198, 'SI', 'Slovenia', '165'),
(210, 'SJ', 'Svalbard and Jan Mayen Islands', '247'),
(197, 'SK', 'Slovakia', '164'),
(195, 'SL', 'Sierra Leone', '78'),
(189, 'SM', 'San Marino', '162'),
(192, 'SN', 'Senegal', '76'),
(200, 'SO', 'Somalia', '79'),
(209, 'SR', 'Suriname', '36'),
(203, 'SS', 'South Sudan', '204'),
(190, 'ST', 'Sao Tome and Principe', '75'),
(64, 'SV', 'El Salvador', '247'),
(214, 'SY', 'Syrian Arab Republic', '199'),
(211, 'SZ', 'Swaziland', '82'),
(226, 'TC', 'Turks and Caicos Islands', '237'),
(42, 'TD', 'Chad', '48'),
(77, 'TF', 'French Southern Territories', ''),
(219, 'TG', 'Togo', '84'),
(218, 'TH', 'Thailand', '122'),
(216, 'TJ', 'Tajikistan', '121'),
(220, 'TK', 'Tokelau', '248'),
(225, 'TM', 'Turkmenistan', '123'),
(223, 'TN', 'Tunisia', '85'),
(221, 'TO', 'Tonga', '186'),
(61, 'TP', 'East Timor', '102'),
(224, 'TR', 'Turkey', '173'),
(222, 'TT', 'Trinidad and Tobago', '22'),
(227, 'TV', 'Tuvalu', '187'),
(215, 'TW', 'Taiwan', '126'),
(142, 'TY', 'Mayotte', '227'),
(217, 'TZ', 'Tanzania, United Republic of', '83'),
(229, 'UA', 'Ukraine', '169'),
(228, 'UG', 'Uganda', '86'),
(233, 'UM', 'United States minor outlying islands', ''),
(232, 'US', 'United States', '23'),
(234, 'UY', 'Uruguay', '37'),
(235, 'UZ', 'Uzbekistan', '124'),
(237, 'VA', 'Vatican City State', '171'),
(187, 'VC', 'Saint Vincent and the Grenadines', '21'),
(238, 'VE', 'Venezuela', '38'),
(240, 'VG', 'Virgin Islands (British)', '238'),
(241, 'VI', 'Virgin Islands (U.S.)', '239'),
(239, 'VN', 'Vietnam', '125'),
(236, 'VU', 'Vanuatu', '188'),
(242, 'WF', 'Wallis and Futuna Islands', '241'),
(188, 'WS', 'Samoa', '184'),
(118, 'XK', 'Kosovo', '205'),
(244, 'YE', 'Yemen', ''),
(201, 'ZA', 'South Africa', '80'),
(245, 'ZM', 'Zambia', '88'),
(246, 'ZW', 'Zimbabwe', '89');

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
(1, '1', 1, 'pasal 1'),
(2, '1', 2, 'Ford#@#BMW#@#Fiat'),
(3, '1', 3, 'pasal 3'),
(4, '1', 4, 'pasal 4'),
(5, '1', 5, 'pasal 5'),
(6, '1', 6, 'pasal 6'),
(7, '1', 7, 'pasal 7');

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
-- Table structure for table `provinsi_indonesia`
--

CREATE TABLE `provinsi_indonesia` (
  `provinsi_id` int(11) NOT NULL,
  `provinsi_code` varchar(3) NOT NULL,
  `provinsi_name` varchar(100) NOT NULL,
  `provinsi_spec` varchar(2) NOT NULL,
  `provinsi_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `provinsi_indonesia`
--

INSERT INTO `provinsi_indonesia` (`provinsi_id`, `provinsi_code`, `provinsi_name`, `provinsi_spec`, `provinsi_count`) VALUES
(2, 'AC', 'Aceh', '01', NULL),
(3, 'BA', 'Bali', '02', NULL),
(5, 'BT', 'Banten', '33', NULL),
(6, 'BE', 'Bengkulu', '03', NULL),
(32, 'YO', 'Daerah Istimewa Yogyakarta', '10', NULL),
(14, 'JK', 'Daerah Khusus Ibukota Jakarta', '04', NULL),
(13, 'GO', 'Gorontalo', '34', NULL),
(15, 'LA', 'Jambi', '05', NULL),
(28, 'JR', 'Jawa Barat', '30', NULL),
(7, 'JT', 'Jawa Tengah', '07', NULL),
(10, 'JI', 'Jawa Timur', '08', NULL),
(29, 'KB', 'Kalimantan Barat', '11', NULL),
(25, '12', 'Kalimantan Selatan', '12', NULL),
(8, 'KT', 'Kalimantan Tengah', '13', NULL),
(11, 'KI', 'Kalimantan Timur', '14', NULL),
(33, 'KU', 'Kalimantan Utara', '42', NULL),
(4, 'BB', 'Kepulauan Bangka Belitung', '35', NULL),
(23, 'KR', 'Kepulauan Riau', '40', NULL),
(16, 'LA', 'Lampung', '15', NULL),
(17, 'MA', 'Maluku', '28', NULL),
(18, 'MU', 'Maluku Utara', '29', NULL),
(12, 'NT', 'Nusa Tenggara Timur', '18', NULL),
(21, 'PA', 'Papua', '36', NULL),
(27, 'IB', 'Papua Barat', '39', NULL),
(22, 'RI', 'Riau', '37', NULL),
(30, 'SR', 'Sulawesi Barat', '41', NULL),
(26, 'SN', 'Sulawesi Selatan', '38', NULL),
(9, 'ST', 'Sulawesi Tengah', '21', NULL),
(24, 'SG', 'Sulawesi Tenggara', '22', NULL),
(19, 'SA', 'Sulawesi Utara', '31', NULL),
(31, 'SB', 'Sumatera Barat', '24', NULL),
(1, 'SL', 'Sumatera Selatan', '32', NULL),
(20, 'SU', 'Sumatera Utara', '26', NULL);

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
-- Indexes for table `lembaga`
--
ALTER TABLE `lembaga`
  ADD PRIMARY KEY (`lembaga_id`),
  ADD KEY `lj_id` (`lj_id`),
  ADD KEY `ls_id` (`ls_id`),
  ADD KEY `lembaga_provinsi_id` (`lembaga_provinsi_id`);

--
-- Indexes for table `lembaga_jenis`
--
ALTER TABLE `lembaga_jenis`
  ADD PRIMARY KEY (`lj_id`);

--
-- Indexes for table `lembaga_status`
--
ALTER TABLE `lembaga_status`
  ADD PRIMARY KEY (`ls_id`);

--
-- Indexes for table `negara_dunia`
--
ALTER TABLE `negara_dunia`
  ADD PRIMARY KEY (`negara_label`),
  ADD KEY `negara_name` (`negara_name`);

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
-- Indexes for table `provinsi_indonesia`
--
ALTER TABLE `provinsi_indonesia`
  ADD PRIMARY KEY (`provinsi_name`);

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
-- AUTO_INCREMENT for table `base_setting`
--
ALTER TABLE `base_setting`
  MODIFY `bs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `lembaga`
--
ALTER TABLE `lembaga`
  MODIFY `lembaga_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lembaga_jenis`
--
ALTER TABLE `lembaga_jenis`
  MODIFY `lj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lembaga_status`
--
ALTER TABLE `lembaga_status`
  MODIFY `ls_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pasal`
--
ALTER TABLE `pasal`
  MODIFY `pasal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
