-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2023 at 07:17 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `username` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `tgl_keluar` date NOT NULL,
  `jam_keluar` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id_activity` int(11) NOT NULL,
  `kode` varchar(200) NOT NULL,
  `isi` text NOT NULL,
  `tgl_masuk` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `tgl_keluar` date NOT NULL,
  `jam_keluar` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id_activity`, `kode`, `isi`, `tgl_masuk`, `jam_masuk`, `tgl_keluar`, `jam_keluar`) VALUES
(1, 'ahmadhusain11', 'Login / Logout', '2023-12-23', '00:25:53', '2023-12-21', '00:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `activity_user`
--

CREATE TABLE `activity_user` (
  `id_activity` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `kegiatan` text NOT NULL,
  `menu` varchar(200) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_user`
--

INSERT INTO `activity_user` (`id_activity`, `username`, `kegiatan`, `menu`, `waktu`) VALUES
(1, 'ahmadhusain11', 'Melakukan Login di Cabang DIY', 'Login', '2023-12-18 00:05:12'),
(2, 'ahmadhusain11', 'Melakukan Logout di Cabang DIY', 'Logout', '2023-12-18 00:09:22'),
(3, 'ahmadhusain11', 'Melakukan Login di Cabang MGL', 'Login', '2023-12-18 00:09:36'),
(4, 'ahmadhusain11', 'Menambahkan Data PO, Dengan Invoice MGL-PRE2312180001', 'Pembelian Barang PO', '2023-12-18 00:15:10'),
(5, 'ahmadhusain11', 'Menambahkan Data Terima, Dengan Invoice MGL-TER2312180001', 'Pembelian Barang Terima', '2023-12-18 00:15:56'),
(6, 'ahmadhusain11', 'Menambahkan Data PO, Dengan Invoice MGL-PRE2312180002', 'Pembelian Barang PO', '2023-12-18 00:16:35'),
(7, 'ahmadhusain11', 'Menambahkan Data Terima, Dengan Invoice MGL-TER2312180002', 'Pembelian Barang Terima', '2023-12-18 00:19:12'),
(8, 'ahmadhusain11', 'Menghapus Data Terima, Dengan Invoice MGL-TER2312180002', 'Pembelian Barang Terima', '2023-12-18 00:19:41'),
(9, 'ahmadhusain11', 'Mengubah Data PO pada Invoice MGL-PRE2312180002, Dengan alasan : salah barang', 'Pembelian Barang PO', '2023-12-18 00:20:04'),
(10, 'ahmadhusain11', 'Menambahkan Data Terima, Dengan Invoice MGL-TER2312180002', 'Pembelian Barang Terima', '2023-12-18 00:20:18'),
(11, 'ahmadhusain11', 'Melakukan Logout di Cabang MGL', 'Logout', '2023-12-18 01:11:17'),
(12, 'ahmadhusain11', 'Melakukan Login di Cabang DIY', 'Login', '2023-12-18 12:45:33'),
(13, 'ahmadhusain11', 'Melakukan Logout di Cabang DIY', 'Logout', '2023-12-18 12:55:20'),
(14, 'ahmadhusain11', 'Melakukan Login di Cabang MGL', 'Login', '2023-12-18 12:55:25'),
(15, 'ahmadhusain11', 'Melakukan Logout di Cabang MGL', 'Logout', '2023-12-18 12:58:04'),
(16, 'ahmadhusain11', 'Melakukan Login di Cabang DIY', 'Login', '2023-12-18 12:58:09'),
(17, 'ahmadhusain11', 'Melakukan Login di Cabang MGL', 'Login', '2023-12-18 20:16:42'),
(18, 'ahmadhusain11', 'Melakukan Logout di Cabang MGL', 'Logout', '2023-12-18 20:19:04'),
(19, 'ahmadhusain11', 'Melakukan Login di Cabang MGL', 'Login', '2023-12-18 22:21:37'),
(20, 'ahmadhusain11', 'Menambahkan Data Retur Penerimaan, Dengan Invoice MGL-RET2312180001', 'Retur Pembelian', '2023-12-18 22:49:50'),
(21, 'ahmadhusain11', 'Menambahkan Sub Menu Garansi, Dengan ID Sub Menu 24', 'Core Sub Menu', '2023-12-18 22:54:59'),
(22, 'ahmadhusain11', 'Melakukan Logout di Cabang MGL', 'Logout', '2023-12-19 01:27:31'),
(23, 'ahmadhusain11', 'Melakukan Login di Cabang MGL', 'Login', '2023-12-19 11:23:19'),
(24, 'ahmadhusain11', 'Melakukan Login di Cabang MGL', 'Login', '2023-12-19 11:23:28'),
(25, 'ahmadhusain11', 'Melakukan Login di Cabang MGL', 'Login', '2023-12-20 13:01:12'),
(26, 'ahmadhusain11', 'Melakukan Login di Cabang MGL', 'Login', '2023-12-20 21:11:21'),
(27, 'ahmadhusain11', 'Menambahkan Menu Penjualan Barang, Dengan ID Menu 12', 'Core Menu', '2023-12-20 21:28:46'),
(28, 'ahmadhusain11', 'Menambahkan Sub Menu Jual, Dengan ID Sub Menu 25', 'Core Sub Menu', '2023-12-20 21:29:53'),
(29, 'ahmadhusain11', 'Menghapus Memberikan Akses Penjualan Barang, Pada Tingkatan 1', 'Core Akses Menu', '2023-12-20 21:30:18'),
(30, 'ahmadhusain11', 'Menghapus Menghapus Akses Transaksi, Pada Tingkatan 1', 'Core Akses Menu', '2023-12-20 21:30:28'),
(31, 'ahmadhusain11', 'Mengubah Menu Penjualan Barang, Dengan ID Menu 12', 'Core Menu', '2023-12-20 21:32:22'),
(32, 'ahmadhusain11', 'Mengubah Sub Menu Jual Barang, Dengan ID Sub Menu 25', 'Core Sub Menu', '2023-12-20 21:33:04'),
(33, 'ahmadhusain11', 'Menambahkan Data Jual, Dengan Invoice MGL-SELL2312210001', 'Pembelian Barang Jual', '2023-12-21 00:13:25'),
(34, 'ahmadhusain11', 'Menambahkan Data Jual, Dengan Invoice MGL-SELL2312210001', 'Pembelian Barang Jual', '2023-12-21 00:17:38'),
(35, 'ahmadhusain11', 'Menambahkan Data Jual, Dengan Invoice MGL-SELL2312210002', 'Pembelian Barang Jual', '2023-12-21 00:27:24'),
(36, 'ahmadhusain11', 'Menghapus Menghapus Akses Transaksi, Pada Tingkatan 3', 'Core Akses Menu', '2023-12-21 00:32:29'),
(37, 'ahmadhusain11', 'Mengubah Anggota Baru M. Riski Febriana, Dengan Username riski', 'Master Anggota', '2023-12-21 00:34:27'),
(38, 'ahmadhusain11', 'Mengubah Anggota Baru Shalijchah Rusmayanti, Dengan Username shalirus', 'Master Anggota', '2023-12-21 00:34:53'),
(39, 'ahmadhusain11', 'Merubah Tingkatan User riski dari Kasir menjadi Member', 'Akses Cabang', '2023-12-21 00:35:16'),
(40, 'ahmadhusain11', 'Melakukan Logout di Cabang MGL', 'Logout', '2023-12-21 00:37:30'),
(41, 'ahmadhusain11', 'Melakukan Login di Cabang MGL', 'Login', '2023-12-23 00:25:54');

-- --------------------------------------------------------

--
-- Table structure for table `akses_cabang`
--

CREATE TABLE `akses_cabang` (
  `id_akses` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akses_cabang`
--

INSERT INTO `akses_cabang` (`id_akses`, `id_cabang`, `id_user`) VALUES
(14, 1, 1),
(15, 2, 1),
(19, 5, 2),
(23, 1, 11),
(24, 1, 12),
(25, 3, 1),
(28, 7, 1),
(32, 6, 1),
(33, 5, 1),
(34, 2, 15),
(35, 1, 16),
(36, 2, 16),
(37, 5, 16),
(38, 3, 16),
(39, 6, 16),
(40, 7, 15);

-- --------------------------------------------------------

--
-- Table structure for table `akses_menu`
--

CREATE TABLE `akses_menu` (
  `id` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akses_menu`
--

INSERT INTO `akses_menu` (`id`, `id_menu`, `id_role`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 1),
(6, 4, 1),
(7, 5, 1),
(9, 7, 1),
(11, 3, 1),
(14, 7, 2),
(19, 5, 2),
(27, 12, 1),
(28, 12, 2);

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_barang` varchar(11) NOT NULL,
  `gambar` text NOT NULL DEFAULT 'default.jpg',
  `kode_kategori` varchar(11) NOT NULL,
  `nama_barang` varchar(200) NOT NULL,
  `harga_beli` varchar(20) NOT NULL,
  `harga_jual` varchar(20) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `pilihan_profit` varchar(20) NOT NULL,
  `profit` varchar(20) NOT NULL,
  `pilihan_disc` varchar(200) NOT NULL,
  `disc` varchar(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_cabang`, `kode_barang`, `gambar`, `kode_kategori`, `nama_barang`, `harga_beli`, `harga_jual`, `satuan`, `pilihan_profit`, `profit`, `pilihan_disc`, `disc`) VALUES
(15, 'MGL', 'MGL-BRG0001', 'default.jpg', 'MGL-KAT0004', 'Rinso', '5000', '5937', 'MGL-SAT0001', 'persentase', '1250', 'persentase', '313'),
(16, 'MGL', 'MGL-BRG0002', 'default.jpg', 'MGL-KAT0002', 'Aqua', '3000', '4000', 'MGL-SAT0005', 'manual', '1000', '', '0'),
(17, 'MGL', 'MGL-BRG0003', 'default.jpg', 'MGL-KAT0001', 'Mie Goreng isi 2 Ayam Kecap', '3500', '4000', 'MGL-SAT0002', 'manual', '500', '', '0'),
(18, 'MGL', 'MGL-BRG0004', 'default.jpg', 'MGL-KAT0001', 'Nabati', '10000', '11000', 'MGL-SAT0001', 'persentase', '1000', '', '0'),
(19, 'MGL', 'MGL-BRG0005', 'default.jpg', 'MGL-KAT0001', 'Roti Tawar', '15000', '16200', 'MGL-SAT0003', 'persentase', '16200', 'manual', '1800'),
(20, 'MGL', 'MGL-BRG0006', 'default.jpg', 'MGL-KAT0002', 'Coca - cola', '5000', '6000', 'MGL-SAT0002', 'manual', '1000', '', '0'),
(21, 'MGL', 'MGL-BRG0007', 'default.jpg', 'MGL-KAT0002', 'Sprit', '2500', '3750', 'MGL-SAT0001', 'persentase', '1250', '', '0'),
(22, 'MGL', 'MGL-BRG0008', 'default.jpg', 'MGL-KAT0004', 'Downy', '500', '550', 'MGL-SAT0001', 'manual', '50', '', '0'),
(28, 'MGL', 'MGL-BRG0009', 'default.jpg', 'MGL-KAT0003', 'Ayam Bakar Kecap Manis', '15000', '18000', 'MGL-SAT0002', 'manual', '5000', 'persentase', '2000'),
(29, 'SLO', 'SLO-BRG0001', 'default.jpg', 'SLO-KAT0001', 'Sari Roti', '4500', '9500', 'SLO-SAT0001', 'manual', '5000', '', '0'),
(30, 'DIY', 'DIY-BRG0001', 'default.jpg', 'DIY-KAT0002', 'Lifeboy (Botol)', '15000', '16500', 'DIY-SAT0002', 'persentase', '1500', '', '0'),
(31, 'DIY', 'DIY-BRG0002', 'default.jpg', 'DIY-KAT0001', 'Taro (Saset)', '5000', '5500', 'DIY-SAT0003', 'persentase', '500', '', '0'),
(32, 'DIY', 'DIY-BRG0003', 'default.jpg', 'DIY-KAT0003', 'Le Mineral (Botol)', '3000', '4000', 'DIY-SAT0002', 'manual', '1000', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

CREATE TABLE `cabang` (
  `id_cabang` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `nama_cabang` varchar(200) NOT NULL,
  `alamat_cabang` text NOT NULL,
  `kontak_cabang` varchar(20) NOT NULL,
  `penanggungjawab` varchar(200) NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_berakhir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`id_cabang`, `kode_cabang`, `nama_cabang`, `alamat_cabang`, `kontak_cabang`, `penanggungjawab`, `tgl_mulai`, `tgl_berakhir`) VALUES
(1, 'MGL', 'Magelang', 'Mungkid, Magelang', 'magelang@gmail.com', 'Kpl. Cabang Mgl', '2023-12-01', '2025-12-01'),
(2, 'DIY', 'Yogyakarta', 'Sleman, Yogyakarta', 'yogyakarta@gmail.com', 'Kpl. Cabang Diy', '2023-12-01', '2024-12-01'),
(3, 'SMG', 'Semarang', 'Ambarawa, Semarang', 'semarang@gmail.com', 'Kpl. Cabang Smg', '2023-12-01', '2025-12-01'),
(5, 'TMG', 'Temanggung', 'Maroon, Temanggung', 'temanggung@gmail.com', 'Kpl. Cabang Tmg', '2023-12-01', '2025-12-01'),
(6, 'SLO', 'Solo', 'Solo', 'solo@gmail.com', 'Kpl. Cabang Slo', '2023-12-01', '2025-12-01'),
(7, 'JKT', 'Jakarta', 'Kebon Jeruk, Jakarta', 'jakarta@gmail.com', 'Kpl. Cabang Jkt', '2023-12-01', '2025-12-01');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id_chat` int(11) NOT NULL,
  `tgl` datetime NOT NULL DEFAULT current_timestamp(),
  `dari` varchar(200) NOT NULL,
  `ke` varchar(200) NOT NULL,
  `pesan` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `id_follow` int(11) NOT NULL,
  `id_user_dari` int(11) NOT NULL,
  `id_user_ke` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`id_follow`, `id_user_dari`, `id_user_ke`) VALUES
(12, 11, 1),
(27, 15, 1),
(31, 1, 16),
(32, 16, 1),
(34, 12, 16),
(35, 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `garansi`
--

CREATE TABLE `garansi` (
  `id` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_barang` varchar(11) NOT NULL,
  `masa_garansi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `garansi`
--

INSERT INTO `garansi` (`id`, `kode_cabang`, `kode_barang`, `masa_garansi`) VALUES
(2, 'MGL', 'MGL-BRG0001', '2023-12-25'),
(3, 'MGL', 'MGL-BRG0002', '2024-12-20');

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_gudang` varchar(11) NOT NULL,
  `nama_gudang` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`id_gudang`, `kode_cabang`, `kode_gudang`, `nama_gudang`) VALUES
(1, 'DIY', 'DIY-GUD0001', 'Red'),
(2, 'DIY', 'DIY-GUD0002', 'Blue'),
(3, 'DIY', 'DIY-GUD0003', 'Yellow'),
(4, 'DIY', 'DIY-GUD0004', 'Green'),
(5, 'MGL', 'MGL-GUD0001', 'A'),
(6, 'MGL', 'MGL-GUD0002', 'B'),
(7, 'MGL', 'MGL-GUD0003', 'C'),
(8, 'MGL', 'MGL-GUD0004', 'D'),
(9, 'MGL', 'MGL-GUD0005', 'E');

-- --------------------------------------------------------

--
-- Table structure for table `jual_barang_d`
--

CREATE TABLE `jual_barang_d` (
  `id` int(11) NOT NULL,
  `invoice` varchar(25) NOT NULL,
  `kode_barang` varchar(11) NOT NULL,
  `tgl_expire` date NOT NULL,
  `nama` varchar(200) NOT NULL,
  `satuan` varchar(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `disc_pr` int(11) NOT NULL,
  `disc_rp` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jual_barang_d`
--

INSERT INTO `jual_barang_d` (`id`, `invoice`, `kode_barang`, `tgl_expire`, `nama`, `satuan`, `qty`, `harga`, `disc_pr`, `disc_rp`, `total`) VALUES
(1, 'MGL-SELL2312210001', 'MGL-BRG0001', '2025-12-18', 'Rinso', 'MGL-SAT0001', 10, 5937, 0, 370, 59000),
(3, 'MGL-SELL2312210002', 'MGL-BRG0001', '2025-12-18', 'Rinso', 'MGL-SAT0001', 5, 5937, 0, 185, 29500);

-- --------------------------------------------------------

--
-- Table structure for table `jual_barang_h`
--

CREATE TABLE `jual_barang_h` (
  `id` int(11) NOT NULL,
  `invoice` varchar(25) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_gudang` varchar(11) NOT NULL,
  `tgl_jual` date NOT NULL,
  `jam_jual` time NOT NULL,
  `penjual` varchar(200) NOT NULL,
  `pajak` int(11) NOT NULL,
  `ppn` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `sub_diskon` int(11) NOT NULL,
  `ppn_rp` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `alasan` text NOT NULL,
  `pembeli` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jual_barang_h`
--

INSERT INTO `jual_barang_h` (`id`, `invoice`, `kode_cabang`, `kode_gudang`, `tgl_jual`, `jam_jual`, `penjual`, `pajak`, `ppn`, `sub_total`, `sub_diskon`, `ppn_rp`, `total`, `alasan`, `pembeli`) VALUES
(1, 'MGL-SELL2312210001', 'MGL', 'MGL-GUD0001', '2023-12-21', '00:12:57', 'ahmadhusain11', 1, 2, 59370, 370, 5900, 64900, '', 'UMUM0001'),
(3, 'MGL-SELL2312210002', 'MGL', 'MGL-GUD0001', '2023-12-21', '00:26:58', 'ahmadhusain11', 0, 0, 29685, 185, 0, 29500, '', '11');

-- --------------------------------------------------------

--
-- Table structure for table `kasir`
--

CREATE TABLE `kasir` (
  `id` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kwitansi` varchar(25) NOT NULL,
  `invoice_jual` varchar(25) NOT NULL,
  `sub_total_jual` int(11) NOT NULL,
  `diskon_jual` int(11) NOT NULL,
  `ppn_rp_jual` int(11) NOT NULL,
  `total_jual` int(11) NOT NULL,
  `jenis_bayar` int(11) NOT NULL,
  `bayar_cash` int(11) NOT NULL,
  `bayar_card` int(11) NOT NULL,
  `penerima` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_kategori` varchar(11) NOT NULL,
  `nama_kategori` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kode_cabang`, `kode_kategori`, `nama_kategori`) VALUES
(2, 'MGL', 'MGL-KAT0001', 'Makanan ringan'),
(3, 'MGL', 'MGL-KAT0002', 'Minuman'),
(4, 'MGL', 'MGL-KAT0003', 'Makanan berat'),
(5, 'MGL', 'MGL-KAT0004', 'Sabun'),
(6, 'SLO', 'SLO-KAT0001', 'Snack'),
(7, 'DIY', 'DIY-KAT0001', 'Snack'),
(8, 'DIY', 'DIY-KAT0002', 'Sabun'),
(9, 'DIY', 'DIY-KAT0003', 'Minuman Botol'),
(10, 'DIY', 'DIY-KAT0004', 'Minuman Gelas'),
(11, 'DIY', 'DIY-KAT0005', 'Kebutuhan Pokok');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama_menu` text NOT NULL,
  `icon` text NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama_menu`, `icon`, `url`) VALUES
(1, 'Dashboard', '<i class=\"nav-icon fas fa-tachometer-alt\"></i>', 'Home'),
(2, 'Private', '<i class=\"nav-icon fa-solid fa-lock\"></i>', 'Privatex'),
(3, 'Master Menu', '<i class=\"fa-solid fa-bars nav-icon\"></i>', 'Menu'),
(4, 'Core', '<i class=\"fa-solid fa-code-commit nav-icon\"></i>', 'Inti'),
(5, 'Master', '<i class=\"nav-icon fas fa-copy\"></i>', 'Master'),
(6, 'Orang - orang', '<i class=\"fa-solid fa-people-group nav-icon\"></i>', 'Peoples'),
(7, 'Pembelian Barang', '<i class=\"fa-solid fa-truck-ramp-box nav-icon\"></i>', 'Pembelian'),
(8, 'Transaksi', '<i class=\"fa-solid fa-bag-shopping nav-icon\"></i>', 'Penjualan'),
(12, 'Penjualan Barang', '<i class=\"fa-solid fa-money-bill-transfer nav-icon\"></i>', 'Penjualan_barang');

-- --------------------------------------------------------

--
-- Table structure for table `order_pesanan`
--

CREATE TABLE `order_pesanan` (
  `id` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_order` varchar(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `status_order` int(1) NOT NULL DEFAULT 0,
  `tgl_order` date NOT NULL DEFAULT current_timestamp(),
  `jam_order` time NOT NULL DEFAULT current_timestamp(),
  `status_antar` int(1) NOT NULL DEFAULT 0,
  `biaya_tambahan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_pembayaran` varchar(11) NOT NULL,
  `kode_order` varchar(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `cara_bayar` varchar(200) NOT NULL,
  `kode_bank` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_d`
--

CREATE TABLE `pembelian_d` (
  `id` int(11) NOT NULL,
  `invoice` varchar(25) NOT NULL,
  `kode_barang` varchar(11) NOT NULL,
  `tgl_expire` date DEFAULT NULL,
  `nama` varchar(200) NOT NULL,
  `satuan` varchar(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `disc_pr` int(11) NOT NULL,
  `disc_rp` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_d`
--

INSERT INTO `pembelian_d` (`id`, `invoice`, `kode_barang`, `tgl_expire`, `nama`, `satuan`, `qty`, `harga`, `disc_pr`, `disc_rp`, `total`) VALUES
(1, 'MGL-TER2312180001', 'MGL-BRG0001', '2025-12-18', 'Rinso', 'MGL-SAT0001', 1000, 5000, 10, 500000, 4500000),
(2, 'MGL-TER2312180001', 'MGL-BRG0003', '2025-12-18', 'Mie Goreng isi 2 Ayam Kecap', 'MGL-SAT0002', 1000, 3500, 0, 500000, 3000000),
(3, 'MGL-TER2312180001', 'MGL-BRG0002', '2025-12-18', 'Aqua', 'MGL-SAT0005', 1000, 3000, 0, 0, 3000000),
(7, 'MGL-TER2312180002', 'MGL-BRG0001', '2025-12-18', 'Rinso', 'MGL-SAT0001', 100, 5000, 0, 0, 500000),
(8, 'MGL-TER2312180002', 'MGL-BRG0003', '2025-12-18', 'Mie Goreng isi 2 Ayam Kecap', 'MGL-SAT0002', 100, 3500, 0, 0, 350000),
(9, 'MGL-TER2312180002', 'MGL-BRG0002', '2025-12-18', 'Aqua', 'MGL-SAT0005', 100, 3000, 0, 0, 300000);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_h`
--

CREATE TABLE `pembelian_h` (
  `id` int(11) NOT NULL,
  `invoice` varchar(25) NOT NULL,
  `invoice_po` varchar(25) DEFAULT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_gudang` varchar(11) NOT NULL,
  `kode_supplier` varchar(11) NOT NULL,
  `tgl_terima` date NOT NULL DEFAULT current_timestamp(),
  `jam_terima` time NOT NULL DEFAULT current_timestamp(),
  `penerima` varchar(200) NOT NULL,
  `pajak` int(1) NOT NULL,
  `ppn` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `sub_diskon` int(11) NOT NULL,
  `ppn_rp` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `alasan` text DEFAULT NULL,
  `accer` varchar(200) NOT NULL,
  `acc` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_h`
--

INSERT INTO `pembelian_h` (`id`, `invoice`, `invoice_po`, `kode_cabang`, `kode_gudang`, `kode_supplier`, `tgl_terima`, `jam_terima`, `penerima`, `pajak`, `ppn`, `sub_total`, `sub_diskon`, `ppn_rp`, `total`, `alasan`, `accer`, `acc`) VALUES
(1, 'MGL-TER2312180001', 'MGL-PRE2312180001', 'MGL', 'MGL-GUD0002', 'MGL-SUP0001', '2023-12-18', '00:15:47', 'ahmadhusain11', 1, 2, 11500000, 1000000, 1050000, 11550000, NULL, 'ahmadhusain11', 1),
(3, 'MGL-TER2312180002', 'MGL-PRE2312180002', 'MGL', 'MGL-GUD0001', 'MGL-SUP0001', '2023-12-18', '00:20:13', 'ahmadhusain11', 1, 2, 1150000, 0, 115000, 1265000, NULL, 'ahmadhusain11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `id_pesan` int(11) NOT NULL,
  `kode` varchar(200) NOT NULL,
  `isi` text NOT NULL,
  `tgl` date NOT NULL DEFAULT current_timestamp(),
  `jam` time NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `po_d`
--

CREATE TABLE `po_d` (
  `id` int(11) NOT NULL,
  `invoice` varchar(25) NOT NULL,
  `kode_barang` varchar(11) NOT NULL,
  `tgl_expire` date DEFAULT NULL,
  `nama` varchar(200) NOT NULL,
  `satuan` varchar(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `disc_pr` int(11) NOT NULL,
  `disc_rp` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `po_d`
--

INSERT INTO `po_d` (`id`, `invoice`, `kode_barang`, `tgl_expire`, `nama`, `satuan`, `qty`, `harga`, `disc_pr`, `disc_rp`, `total`) VALUES
(1, 'MGL-PRE2312180001', 'MGL-BRG0001', '2025-12-18', 'Rinso', 'MGL-SAT0001', 1000, 5000, 10, 500000, 4500000),
(2, 'MGL-PRE2312180001', 'MGL-BRG0002', '2025-12-18', 'Aqua', 'MGL-SAT0005', 1000, 3000, 0, 0, 3000000),
(3, 'MGL-PRE2312180001', 'MGL-BRG0003', '2025-12-18', 'Mie Goreng isi 2 Ayam Kecap', 'MGL-SAT0002', 1000, 3500, 0, 500000, 3000000),
(7, 'MGL-PRE2312180002', 'MGL-BRG0001', '2025-12-18', 'Rinso', 'MGL-SAT0001', 100, 5000, 0, 0, 500000),
(8, 'MGL-PRE2312180002', 'MGL-BRG0002', '2025-12-18', 'Aqua', 'MGL-SAT0005', 100, 3000, 0, 0, 300000),
(9, 'MGL-PRE2312180002', 'MGL-BRG0003', '2025-12-18', 'Mie Goreng isi 2 Ayam Kecap', 'MGL-SAT0002', 100, 3500, 0, 0, 350000);

-- --------------------------------------------------------

--
-- Table structure for table `po_h`
--

CREATE TABLE `po_h` (
  `id` int(11) NOT NULL,
  `invoice` varchar(25) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_gudang` varchar(11) NOT NULL,
  `kode_supplier` varchar(11) NOT NULL,
  `tgl_pembelian` date NOT NULL DEFAULT current_timestamp(),
  `jam_pembelian` time NOT NULL DEFAULT current_timestamp(),
  `pengaju` varchar(200) NOT NULL,
  `pajak` int(1) NOT NULL,
  `ppn` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `sub_diskon` int(11) NOT NULL,
  `ppn_rp` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `alasan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `po_h`
--

INSERT INTO `po_h` (`id`, `invoice`, `kode_cabang`, `kode_gudang`, `kode_supplier`, `tgl_pembelian`, `jam_pembelian`, `pengaju`, `pajak`, `ppn`, `sub_total`, `sub_diskon`, `ppn_rp`, `total`, `alasan`) VALUES
(1, 'MGL-PRE2312180001', 'MGL', 'MGL-GUD0002', 'MGL-SUP0001', '2023-12-18', '00:14:27', 'ahmadhusain11', 1, 2, 11500000, 1000000, 1050000, 11550000, NULL),
(3, 'MGL-PRE2312180002', 'MGL', 'MGL-GUD0001', 'MGL-SUP0001', '2023-12-18', '00:16:13', 'ahmadhusain11', 1, 2, 1150000, 0, 115000, 1265000, 'salah barang');

-- --------------------------------------------------------

--
-- Table structure for table `ppn`
--

CREATE TABLE `ppn` (
  `id_ppn` int(11) NOT NULL,
  `nama_ppn` varchar(20) NOT NULL,
  `value_ppn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ppn`
--

INSERT INTO `ppn` (`id_ppn`, `nama_ppn`, `value_ppn`) VALUES
(2, '2020 (10%)', 10),
(3, '2023 (11%)', 11),
(4, '2024 (12%)', 12);

-- --------------------------------------------------------

--
-- Table structure for table `retur_beli_d`
--

CREATE TABLE `retur_beli_d` (
  `id` int(11) NOT NULL,
  `invoice` varchar(25) NOT NULL,
  `kode_barang` varchar(11) NOT NULL,
  `tgl_expire` date NOT NULL,
  `nama` varchar(200) NOT NULL,
  `satuan` varchar(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `disc_pr` int(11) NOT NULL,
  `disc_rp` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `retur_beli_d`
--

INSERT INTO `retur_beli_d` (`id`, `invoice`, `kode_barang`, `tgl_expire`, `nama`, `satuan`, `qty`, `harga`, `disc_pr`, `disc_rp`, `total`) VALUES
(11, 'DIY-RET2312170001', 'DIY-BRG0001', '2025-12-14', 'Lifeboy (Botol)', 'DIY-SAT0002', 10, 15000, 10, 15000, 135000),
(12, 'DIY-RET2312170001', 'DIY-BRG0003', '2025-12-14', 'Le Mineral (Botol)', 'DIY-SAT0002', 10, 3000, 0, 0, 30000),
(13, 'DIY-RET2312170002', 'DIY-BRG0001', '2024-12-17', 'Lifeboy (Botol)', 'DIY-SAT0002', 100, 15000, 0, 0, 1500000),
(14, 'MGL-RET2312180001', 'MGL-BRG0001', '2025-12-18', 'Rinso', 'MGL-SAT0001', 10, 5000, 0, 0, 50000),
(15, 'MGL-RET2312180001', 'MGL-BRG0003', '2025-12-18', 'Mie Goreng isi 2 Ayam Kecap', 'MGL-SAT0002', 10, 3500, 0, 0, 35000),
(16, 'MGL-RET2312180001', 'MGL-BRG0002', '2025-12-18', 'Aqua', 'MGL-SAT0005', 10, 3000, 0, 0, 30000);

-- --------------------------------------------------------

--
-- Table structure for table `retur_beli_h`
--

CREATE TABLE `retur_beli_h` (
  `id` int(11) NOT NULL,
  `invoice` varchar(25) NOT NULL,
  `invoice_terima` varchar(25) DEFAULT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_gudang` varchar(11) NOT NULL,
  `kode_supplier` varchar(11) NOT NULL,
  `tgl_retur` date NOT NULL,
  `jam_retur` time NOT NULL,
  `peretur` varchar(200) NOT NULL,
  `pajak` int(1) NOT NULL,
  `ppn` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `sub_diskon` int(11) NOT NULL,
  `ppn_rp` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `alasan` text NOT NULL,
  `accer` varchar(200) NOT NULL,
  `acc` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `retur_beli_h`
--

INSERT INTO `retur_beli_h` (`id`, `invoice`, `invoice_terima`, `kode_cabang`, `kode_gudang`, `kode_supplier`, `tgl_retur`, `jam_retur`, `peretur`, `pajak`, `ppn`, `sub_total`, `sub_diskon`, `ppn_rp`, `total`, `alasan`, `accer`, `acc`) VALUES
(1, 'MGL-RET2312180001', 'MGL-TER2312180002', 'MGL', 'MGL-GUD0001', 'MGL-SUP0001', '2023-12-18', '22:49:38', 'ahmadhusain11', 1, 2, 115000, 0, 11500, 126500, '', 'ahmadhusain11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `tingkatan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `tingkatan`) VALUES
(1, 'Admin'),
(2, 'Kasir'),
(3, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_satuan` varchar(11) NOT NULL,
  `nama_satuan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `kode_cabang`, `kode_satuan`, `nama_satuan`) VALUES
(16, 'MGL', 'MGL-SAT0001', 'Saset'),
(17, 'MGL', 'MGL-SAT0002', 'Box'),
(18, 'MGL', 'MGL-SAT0003', 'Pcs'),
(19, 'JKT', 'JKT-SAT0001', 'Box'),
(20, 'JKT', 'JKT-SAT0002', 'Saset'),
(21, 'JKT', 'JKT-SAT0003', 'Dus'),
(22, 'JKT', 'JKT-SAT0004', 'Botol'),
(24, 'MGL', 'MGL-SAT0005', 'Dus'),
(25, 'MGL', 'MGL-SAT0006', 'Botol'),
(26, 'SLO', 'SLO-SAT0001', 'Pcs'),
(27, 'DIY', 'DIY-SAT0001', 'Dus'),
(28, 'DIY', 'DIY-SAT0002', 'Botol'),
(29, 'DIY', 'DIY-SAT0003', 'Saset');

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `id_stok` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_gudang` varchar(11) NOT NULL,
  `kode_barang` varchar(11) NOT NULL,
  `tgl_expire` date DEFAULT NULL,
  `terima` int(11) NOT NULL DEFAULT 0,
  `keluar` int(11) NOT NULL DEFAULT 0,
  `saldo_akhir` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`id_stok`, `kode_cabang`, `kode_gudang`, `kode_barang`, `tgl_expire`, `terima`, `keluar`, `saldo_akhir`) VALUES
(1, 'MGL', 'MGL-GUD0002', 'MGL-BRG0001', '2025-12-18', 1000, 0, 1000),
(2, 'MGL', 'MGL-GUD0002', 'MGL-BRG0003', '2025-12-18', 1000, 0, 1000),
(3, 'MGL', 'MGL-GUD0002', 'MGL-BRG0002', '2025-12-18', 1000, 0, 1000),
(4, 'MGL', 'MGL-GUD0001', 'MGL-BRG0004', '2025-12-18', 0, 0, 0),
(5, 'MGL', 'MGL-GUD0001', 'MGL-BRG0006', '2025-12-18', 0, 0, 0),
(6, 'MGL', 'MGL-GUD0001', 'MGL-BRG0005', '2025-12-18', 0, 0, 0),
(7, 'MGL', 'MGL-GUD0001', 'MGL-BRG0001', '2025-12-18', 100, 10, 90),
(8, 'MGL', 'MGL-GUD0001', 'MGL-BRG0003', '2025-12-18', 100, 10, 90),
(9, 'MGL', 'MGL-GUD0001', 'MGL-BRG0002', '2025-12-18', 100, 10, 90);

-- --------------------------------------------------------

--
-- Table structure for table `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id` int(11) NOT NULL,
  `nama_menu` varchar(200) NOT NULL,
  `icon` text NOT NULL,
  `url` varchar(200) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_menu`
--

INSERT INTO `sub_menu` (`id`, `nama_menu`, `icon`, `url`, `id_menu`) VALUES
(1, 'Master Tingkatan', '<i class=\"fa-solid fa-person-circle-question nav-icon\"></i>', 'Privatex/master_role', 2),
(2, 'Aktifasi Akun', '<i class=\"fa-solid fa-users-gear nav-icon\"></i>', 'Privatex/akun', 2),
(3, 'Aktifasi Cabang', '<i class=\"fa-solid fa-network-wired nav-icon\"></i>', 'Privatex/cabang', 2),
(4, 'Tingkatan User', '<i class=\"fa-solid fa-elevator nav-icon\"></i>', 'Privatex/role', 2),
(5, 'Satuan', '<i class=\"fa-solid fa-table-cells-large nav-icon\"></i>', 'Inti/Satuan', 4),
(6, 'Kategori', '<i class=\"fa-solid fa-object-ungroup nav-icon\"></i>', 'Inti/Kategori', 4),
(7, 'Supplier', '<i class=\"fa-solid fa-code-branch nav-icon\"></i>', 'Inti/Supplier', 4),
(8, 'PPN', '<i class=\"fa-solid fa-percent nav-icon\"></i>', 'Inti/ppn', 4),
(9, 'Keanggotaan', '<i class=\"fa fa-users nav-icon\"></i>', 'Master/anggota', 5),
(10, 'Cabang', '<i class=\"fa-solid fa-code-branch nav-icon\"></i>', 'Master/cabang', 5),
(11, 'Barang', '<i class=\"fa fa-boxes nav-icon\"></i>', 'Master/barang', 5),
(12, 'Dapatkan Teman', '<i class=\"fa-solid fa-people-robbery nav-icon\"></i>', 'Peoples', 6),
(13, 'Daftar Teman', '<i class=\"fa-solid fa-people-pulling nav-icon\"></i>', 'Peoples/teman', 6),
(14, 'PO (Pre Order)', '<i class=\"fa-solid fa-boxes-packing nav-icon\"></i>', 'Pembelian/po', 7),
(15, 'Penerimaan', '<i class=\"fa-solid fa-dolly nav-icon\"></i>', 'Pembelian/terima', 7),
(16, 'Retur Penerimaan', '<i class=\"fa-solid fa-rotate-left nav-icon\"></i>', 'Pembelian/retur', 7),
(17, 'Laporan', '<i class=\"fa-solid fa-chart-simple nav-icon\"></i>', 'Pembelian/laporan', 7),
(18, 'Menu Utama', '<i class=\"fa-solid fa-angle-down nav-icon\"></i>', 'Menu', 3),
(19, 'Sub Menu', '<i class=\"fa-solid fa-angles-down nav-icon\"></i>', 'Menu/sub_menu', 3),
(20, 'Pengatuan Akses Menu', '<i class=\"fa-solid fa-users-gear nav-icon\"></i>', 'Menu/akses_menu', 3),
(22, 'Pesan', '<i class=\"fa-solid fa-message nav-icon\"></i>', 'Peoples/pesan', 6),
(23, 'Gudang', '<i class=\"fa-solid fa-warehouse nav-icon\"></i>', 'Inti/gudang', 4),
(24, 'Garansi', '<i class=\"fa-regular fa-calendar-check nav-icon\"></i>', 'Privatex/garansi', 2),
(25, 'Jual Barang', '<i class=\"fa-solid fa-cart-flatbed nav-icon\"></i>', 'Penjualan_barang/jual', 12);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `kode_cabang` varchar(3) NOT NULL,
  `kode_supplier` varchar(11) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `nohp_supplier` varchar(15) NOT NULL,
  `email_supplier` varchar(200) NOT NULL,
  `alamat` text NOT NULL,
  `wali` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `kode_cabang`, `kode_supplier`, `nama_supplier`, `nohp_supplier`, `email_supplier`, `alamat`, `wali`) VALUES
(3, 'MGL', 'MGL-SUP0001', 'Pt. Pratama Garuda', '0895363260970', 'pratama@garuda.com', 'Jl. Borobudur, Mungkid, Magelang 56512', 'Ahmad Husain'),
(4, 'MGL', 'MGL-SUP0002', 'Pt. Sukamulya', '089511111111', 'sukamulya@gmail.com', 'Jl. Mertoyudan, Magelang', 'Sandiaga'),
(5, 'DIY', 'DIY-SUP0001', 'Pt Nusantara', '089090902090', 'nusantara@pt.com', 'Jl Magelang Utara', 'Iwan Aji');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `jk` char(1) NOT NULL,
  `nohp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `gambar` text NOT NULL DEFAULT 'default.png',
  `is_active` int(11) NOT NULL DEFAULT 0,
  `on_off` int(1) DEFAULT 0,
  `is_create` datetime NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `jk`, `nohp`, `alamat`, `gambar`, `is_active`, `on_off`, `is_create`, `id_role`) VALUES
(1, 'ahmadhusain11', '21232f297a57a5a743894a0e4a801fc3', 'litch_98', 'P', '0895363260970', 'Mungkid, Magelang', '6b05d976ece72e5d920d8514e583e9c5.jpg', 1, 1, '2023-01-19 09:49:32', 1),
(11, 'indra', 'e24f6e3ce19ee0728ff1c443e4ff488d', 'Indra suryo', 'P', '0909', 'Mertoyudan, Magelang', 'default.png', 1, 0, '2023-01-23 13:50:21', 3),
(12, 'zaki', '9784ea3da268563469df99b2e6593564', 'Zakky Eko', 'P', '0808', 'Kajoran, Magelang', 'default.png', 1, 0, '2023-01-23 17:16:47', 3),
(15, 'riski', '6e24184c9f8092a67bcd413cbcf598da', 'M. Riski Febriana', 'P', '1231', 'Jakarta', 'pria.png', 1, 0, '2023-05-17 14:33:44', 3),
(16, 'shalirus', '9d5581fc0d8a4dc1512f09d5e6a8e3d9', 'Shalijchah Rusmayanti', 'W', '123321', 'Temanggung', 'wanita.png', 1, 0, '2023-05-17 17:15:55', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id_activity`);

--
-- Indexes for table `activity_user`
--
ALTER TABLE `activity_user`
  ADD PRIMARY KEY (`id_activity`);

--
-- Indexes for table `akses_cabang`
--
ALTER TABLE `akses_cabang`
  ADD PRIMARY KEY (`id_akses`);

--
-- Indexes for table `akses_menu`
--
ALTER TABLE `akses_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`id_cabang`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id_follow`);

--
-- Indexes for table `garansi`
--
ALTER TABLE `garansi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`);

--
-- Indexes for table `jual_barang_d`
--
ALTER TABLE `jual_barang_d`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jual_barang_h`
--
ALTER TABLE `jual_barang_h`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_pesanan`
--
ALTER TABLE `order_pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian_d`
--
ALTER TABLE `pembelian_d`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian_h`
--
ALTER TABLE `pembelian_h`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indexes for table `po_d`
--
ALTER TABLE `po_d`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `po_h`
--
ALTER TABLE `po_h`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppn`
--
ALTER TABLE `ppn`
  ADD PRIMARY KEY (`id_ppn`);

--
-- Indexes for table `retur_beli_d`
--
ALTER TABLE `retur_beli_d`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retur_beli_h`
--
ALTER TABLE `retur_beli_h`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id_stok`);

--
-- Indexes for table `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id_activity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity_user`
--
ALTER TABLE `activity_user`
  MODIFY `id_activity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `akses_cabang`
--
ALTER TABLE `akses_cabang`
  MODIFY `id_akses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `akses_menu`
--
ALTER TABLE `akses_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `cabang`
--
ALTER TABLE `cabang`
  MODIFY `id_cabang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `id_follow` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `garansi`
--
ALTER TABLE `garansi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id_gudang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jual_barang_d`
--
ALTER TABLE `jual_barang_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jual_barang_h`
--
ALTER TABLE `jual_barang_h`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kasir`
--
ALTER TABLE `kasir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_pesanan`
--
ALTER TABLE `order_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembelian_d`
--
ALTER TABLE `pembelian_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pembelian_h`
--
ALTER TABLE `pembelian_h`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `po_d`
--
ALTER TABLE `po_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `po_h`
--
ALTER TABLE `po_h`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ppn`
--
ALTER TABLE `ppn`
  MODIFY `id_ppn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `retur_beli_d`
--
ALTER TABLE `retur_beli_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `retur_beli_h`
--
ALTER TABLE `retur_beli_h`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
