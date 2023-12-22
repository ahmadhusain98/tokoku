-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2023 at 07:51 PM
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
(1, 'ahmadhusain11', 'Login / Logout', '2023-12-16', '22:10:22', '2023-12-17', '01:51:03'),
(2, 'shali', 'Login / Logout', '2023-07-21', '16:11:16', '2023-07-21', '16:16:38'),
(3, 'indra', 'Login / Logout', '2023-05-17', '14:29:07', '2023-05-17', '14:32:35'),
(4, 'zaki', 'Login / Logout', '2023-08-02', '23:58:09', '2023-08-02', '23:59:10'),
(6, 'riski', 'Login / Logout', '2023-07-21', '16:16:44', '2023-07-21', '16:40:29'),
(7, 'shalirus', 'Login / Logout', '2023-07-30', '16:52:54', '2023-07-30', '18:20:58');

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
(2, 'ahmadhusain11', 'Mengaktifkan user shali', 'Aktifasi Akun', '2023-01-23 00:50:34'),
(4, 'ahmadhusain11', 'Memberikan akses cabang DIY ke user shali', 'Akses Cabang', '2023-01-23 00:55:05'),
(5, 'ahmadhusain11', 'Menghapus akses cabang SMG ke user shali', 'Akses Cabang', '2023-01-23 00:59:04'),
(6, 'ahmadhusain11', 'Menghapus akses cabang DIY ke user : shali', 'Akses Cabang', '2023-01-23 00:59:42'),
(7, 'ahmadhusain11', 'Meningkatkan user shali menjadi Administrator', 'Akses Cabang', '2023-01-23 01:02:40'),
(8, 'ahmadhusain11', 'Menurunkan user shali menjadi Anggota', 'Akses Cabang', '2023-01-23 01:02:54'),
(9, 'ahmadhusain11', 'Meningkatkan user shali menjadi Administrator', 'Akses Cabang', '2023-01-23 11:54:58'),
(10, 'ahmadhusain11', 'Menurunkan user shali menjadi Anggota', 'Akses Cabang', '2023-01-23 11:58:26'),
(11, 'ahmadhusain11', 'Mengaktifkan user indra', 'Aktifasi Akun', '2023-01-23 13:50:35'),
(12, 'ahmadhusain11', 'Memberikan akses cabang MGL ke user indra', 'Akses Cabang', '2023-01-23 13:50:50'),
(13, 'ahmadhusain11', 'Mengaktifkan user zaki', 'Aktifasi Akun', '2023-01-23 17:16:58'),
(14, 'ahmadhusain11', 'Memberikan akses cabang MGL ke user zaki', 'Akses Cabang', '2023-01-23 17:17:29'),
(15, 'ahmadhusain11', 'Memberikan akses cabang SMG ke user ahmadhusain11', 'Akses Cabang', '2023-01-23 17:40:58'),
(16, 'ahmadhusain11', 'Memberikan akses cabang TMG ke user ahmadhusain11', 'Akses Cabang', '2023-01-23 17:41:00'),
(17, 'ahmadhusain11', 'Memberikan akses cabang SLO ke user ahmadhusain11', 'Akses Cabang', '2023-01-23 17:41:03'),
(18, 'ahmadhusain11', 'Memberikan akses cabang JKT ke user ahmadhusain11', 'Akses Cabang', '2023-01-23 17:41:06'),
(19, 'ahmadhusain11', 'Menonaktikan user zaki', 'Aktifasi Akun', '2023-01-24 17:01:21'),
(20, 'ahmadhusain11', 'Mengaktifkan user zaki', 'Aktifasi Akun', '2023-01-24 17:07:52'),
(21, 'ahmadhusain11', 'Menonaktikan user shali', 'Aktifasi Akun', '2023-01-28 21:16:46'),
(22, 'ahmadhusain11', 'Memberikan akses cabang DIY ke user indra', 'Akses Cabang', '2023-02-06 00:26:41'),
(23, 'ahmadhusain11', 'Menghapus akses cabang DIY ke user indra', 'Akses Cabang', '2023-02-06 00:26:44'),
(24, 'ahmadhusain11', 'Menonaktikan user indra', 'Aktifasi Akun', '2023-02-06 00:27:10'),
(25, 'ahmadhusain11', 'Menonaktikan user zaki', 'Aktifasi Akun', '2023-02-06 00:27:13'),
(26, 'ahmadhusain11', 'Mengaktifkan user zaki', 'Aktifasi Akun', '2023-02-06 00:59:41'),
(27, 'ahmadhusain11', 'Menghapus Barang Aqua 30ml', 'Master Barang', '2023-02-06 22:58:49'),
(28, 'ahmadhusain11', 'Menambahkan Barang Baru aqua, Dengan Kode JKT-BRG0001', 'Master Barang', '2023-02-06 23:00:34'),
(29, 'ahmadhusain11', 'Memberikan akses cabang SLO ke user zaki', 'Akses Cabang', '2023-02-07 07:33:19'),
(30, 'ahmadhusain11', 'Menghapus akses cabang SLO ke user zaki', 'Akses Cabang', '2023-02-07 07:33:34'),
(31, 'ahmadhusain11', 'Menghapus Barang Aqua, Dengan Kode JKT-BRG0001', 'Master Barang', '2023-02-07 07:37:50'),
(32, 'ahmadhusain11', 'Menambahkan Barang Baru indomie goreng isi 2 ayam kecap, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-07 21:06:28'),
(33, 'ahmadhusain11', 'Mengubah Barang , Dengan Kode ', 'Master Barang', '2023-02-07 21:22:48'),
(34, 'ahmadhusain11', 'Mengubah Barang , Dengan Kode ', 'Master Barang', '2023-02-07 21:23:03'),
(35, 'ahmadhusain11', 'Mengubah Barang , Dengan Kode ', 'Master Barang', '2023-02-07 21:23:56'),
(36, 'ahmadhusain11', 'Mengubah Barang , Dengan Kode ', 'Master Barang', '2023-02-07 21:25:03'),
(37, 'ahmadhusain11', 'Mengubah Barang Indomie goreng isi 2 ayam kecap, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-07 21:25:56'),
(38, 'ahmadhusain11', 'Mengubah Barang Indomie goreng isi 2 ayam kecap, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-07 21:27:34'),
(39, 'ahmadhusain11', 'Mengubah Barang Indomie goreng isi 2 ayam kecap, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-07 21:29:05'),
(40, 'ahmadhusain11', 'Mengubah Barang Indomie goreng isi 2 ayam kecap, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-07 21:30:22'),
(41, 'ahmadhusain11', 'Mengubah Barang Indomie goreng isi 2 ayam kecap, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-07 21:31:25'),
(42, 'ahmadhusain11', 'Menambahkan Barang Baru ultra milk, Dengan Kode MGL-BRG0002', 'Master Barang', '2023-02-07 21:37:38'),
(43, 'ahmadhusain11', 'Mengubah Barang Ultra milk 20ml, Dengan Kode MGL-BRG0002', 'Master Barang', '2023-02-07 21:39:39'),
(44, 'ahmadhusain11', 'Menghapus Barang Ultra milk 20ml, Dengan Kode MGL-BRG0002', 'Master Barang', '2023-02-07 21:43:45'),
(45, 'ahmadhusain11', 'Meningkatkan user zaki menjadi Administrator', 'Akses Cabang', '2023-02-07 21:53:37'),
(46, 'zaki', 'Menambahkan Anggota Baru zamzanah, Dengan Username zamzanah', 'Master Anggota', '2023-02-07 21:54:57'),
(47, 'zaki', 'Mengaktifkan user zamzanah', 'Aktifasi Akun', '2023-02-07 21:55:23'),
(48, 'zaki', 'Mengubah Anggota Baru zamzanah reinal, Dengan Username zamzanah', 'Master Anggota', '2023-02-07 21:55:54'),
(49, 'zaki', 'Menonaktikan user zamzanah', 'Aktifasi Akun', '2023-02-07 21:56:25'),
(50, 'zaki', 'Mengaktifkan user zamzanah', 'Aktifasi Akun', '2023-02-07 21:56:55'),
(51, 'zaki', 'Memberikan akses cabang SLO ke user zamzanah', 'Akses Cabang', '2023-02-07 21:57:12'),
(52, 'zaki', 'Menghapus akses cabang SLO ke user zamzanah', 'Akses Cabang', '2023-02-07 21:57:27'),
(53, 'zaki', 'Meningkatkan user zamzanah menjadi Administrator', 'Akses Cabang', '2023-02-07 21:57:44'),
(54, 'zaki', 'Menurunkan user zamzanah menjadi Anggota', 'Akses Cabang', '2023-02-07 21:57:53'),
(55, 'zaki', 'Menonaktikan user zamzanah', 'Aktifasi Akun', '2023-02-07 21:58:17'),
(56, 'zaki', 'Menghapus Anggota Baru zamzanah reinal, Dengan Username zamzanah', 'Master Anggota', '2023-02-07 21:58:34'),
(57, 'zaki', 'Menonaktikan user ahmadhusain11', 'Aktifasi Akun', '2023-02-07 22:03:09'),
(58, 'zaki', 'Mengaktifkan user ahmadhusain11', 'Aktifasi Akun', '2023-02-07 22:07:11'),
(59, 'zaki', 'Menghapus akses cabang SLO ke user ahmadhusain11', 'Akses Cabang', '2023-02-07 22:10:32'),
(60, 'zaki', 'Memberikan akses cabang SLO ke user ahmadhusain11', 'Akses Cabang', '2023-02-07 22:13:39'),
(61, 'zaki', 'Menghapus akses cabang TMG ke user ahmadhusain11', 'Akses Cabang', '2023-02-07 22:13:48'),
(62, 'zaki', 'Memberikan akses cabang TMG ke user ahmadhusain11', 'Akses Cabang', '2023-02-07 22:13:53'),
(63, 'zaki', 'Menurunkan user ahmadhusain11 menjadi Anggota', 'Akses Cabang', '2023-02-07 22:18:16'),
(64, 'zaki', 'Meningkatkan user ahmadhusain11 menjadi Administrator', 'Akses Cabang', '2023-02-07 22:18:21'),
(65, 'zaki', 'Menurunkan user ahmadhusain11 menjadi Anggota', 'Akses Cabang', '2023-02-07 22:19:57'),
(66, 'zaki', 'Meningkatkan user ahmadhusain11 menjadi Administrator', 'Akses Cabang', '2023-02-07 22:20:37'),
(67, 'zaki', 'Meningkatkan user ahmadhusain11 menjadi Administrator', 'Akses Cabang', '2023-02-07 22:21:10'),
(68, 'zaki', 'Menambahkan satuan Toples, Dengan Kode MGL-SAT0005', 'Core Satuan', '2023-02-07 22:36:29'),
(69, 'zaki', 'Mengubah satuan Dus, Dengan Kode MGL-SAT0005', 'Core Satuan', '2023-02-07 22:36:55'),
(70, 'zaki', 'Menghapus satuan Btl, Dengan Kode MGL-SAT0004', 'Core Satuan', '2023-02-07 22:37:15'),
(71, 'zaki', 'Menambahkan kategori sabun, Dengan Kode MGL-KAT0004', 'Core Kategori', '2023-02-07 22:38:02'),
(72, 'zaki', 'Mengubah kategori Minuman, Dengan Kode MGL-KAT0004', 'Core Kategori', '2023-02-07 22:47:50'),
(73, 'zaki', 'Mengubah kategori Sabun, Dengan Kode MGL-KAT0004', 'Core Kategori', '2023-02-07 22:48:00'),
(74, 'zaki', 'Mengubah kategori Minuman, Dengan Kode MGL-KAT0004', 'Core Kategori', '2023-02-07 22:50:59'),
(75, 'zaki', 'Mengubah kategori Sabun, Dengan Kode MGL-KAT0004', 'Core Kategori', '2023-02-07 22:51:27'),
(76, 'zaki', 'Mengubah kategori Sbn, Dengan Kode MGL-KAT0004', 'Core Kategori', '2023-02-07 23:05:24'),
(77, 'zaki', 'Mengubah kategori Sabun, Dengan Kode MGL-KAT0004', 'Core Kategori', '2023-02-07 23:05:58'),
(78, 'zaki', 'Mengubah Anggota Baru Indra suryo, Dengan Username indra', 'Master Anggota', '2023-02-07 23:17:31'),
(79, 'zaki', 'Menambahkan Anggota Baru zamzanah, Dengan Username zamzanah', 'Master Anggota', '2023-02-07 23:19:04'),
(80, 'zaki', 'Mengubah Anggota Baru zamzanah rey, Dengan Username zamzanah', 'Master Anggota', '2023-02-07 23:19:20'),
(81, 'zaki', 'Menghapus Anggota Baru zamzanah rey, Dengan Username zamzanah', 'Master Anggota', '2023-02-07 23:19:30'),
(82, 'zaki', 'Menambahkan Cabang Baru bandung, Dengan Kode bdg', 'Master Cabang', '2023-02-07 23:31:16'),
(83, 'zaki', 'Mengubah Cabang Baru Bandung, Dengan Kode BDG', 'Master Cabang', '2023-02-07 23:33:59'),
(84, 'zaki', 'Menghapus Cabang Baru Bandung, Dengan Kode BDG', 'Master Cabang', '2023-02-07 23:35:30'),
(85, 'zaki', 'Mengubah Cabang Baru Yogyakarta, Dengan Kode DIY', 'Master Cabang', '2023-02-07 23:36:51'),
(86, 'ahmadhusain11', 'Mengaktifkan user indra', 'Aktifasi Akun', '2023-02-07 23:44:26'),
(87, 'ahmadhusain11', 'Menambahkan Barang Baru ultra milk 20ml, Dengan Kode MGL-BRG0002', 'Master Barang', '2023-02-08 10:03:44'),
(88, 'ahmadhusain11', 'Mengubah Barang Ultra milk 20ml, Dengan Kode MGL-BRG0002', 'Master Barang', '2023-02-08 10:05:55'),
(89, 'ahmadhusain11', 'Menambahkan Barang Baru nuvo, Dengan Kode MGL-BRG0003', 'Master Barang', '2023-02-08 21:14:14'),
(90, 'ahmadhusain11', 'Mengubah Barang Nuvo, Dengan Kode MGL-BRG0003', 'Master Barang', '2023-02-08 21:32:19'),
(91, 'ahmadhusain11', 'Mengubah Barang Nuvo Family, Dengan Kode MGL-BRG0003', 'Master Barang', '2023-02-08 21:32:39'),
(92, 'ahmadhusain11', 'Mengubah Barang Nuvo Family, Dengan Kode MGL-BRG0003', 'Master Barang', '2023-02-08 21:32:54'),
(93, 'ahmadhusain11', 'Menambahkan Barang Baru Rinso, Dengan Kode MGL-BRG0004', 'Master Barang', '2023-02-08 22:17:55'),
(94, 'ahmadhusain11', 'Menghapus Barang Rinso, Dengan Kode MGL-BRG0004', 'Master Barang', '2023-02-08 22:23:35'),
(95, 'ahmadhusain11', 'Menambahkan Barang Baru Rinso, Dengan Kode MGL-BRG0004', 'Master Barang', '2023-02-08 22:24:14'),
(96, 'ahmadhusain11', 'Menghapus Barang Rinso, Dengan Kode MGL-BRG0004', 'Master Barang', '2023-02-08 22:24:59'),
(97, 'ahmadhusain11', 'Menghapus Barang Indomie goreng isi 2 ayam kecap, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-08 22:25:10'),
(98, 'ahmadhusain11', 'Menghapus Barang Ultra milk 20ml, Dengan Kode MGL-BRG0002', 'Master Barang', '2023-02-08 22:25:13'),
(99, 'ahmadhusain11', 'Menghapus Barang Nuvo Family, Dengan Kode MGL-BRG0003', 'Master Barang', '2023-02-08 22:25:16'),
(100, 'ahmadhusain11', 'Menambahkan Barang Baru Rinso, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-08 22:27:06'),
(101, 'ahmadhusain11', 'Menghapus Barang Rinso, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-08 22:29:51'),
(102, 'ahmadhusain11', 'Menambahkan Barang Baru Rinso, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-08 22:30:30'),
(103, 'ahmadhusain11', 'Menghapus Barang Rinso, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-08 22:31:40'),
(104, 'ahmadhusain11', 'Menambahkan Barang Baru Rinso, Dengan Kode MGL-BRG0001', 'Master Barang', '2023-02-08 22:32:38'),
(105, 'ahmadhusain11', 'Menambahkan Barang Baru Aqua, Dengan Kode MGL-BRG0002', 'Master Barang', '2023-02-08 22:54:47'),
(106, 'ahmadhusain11', 'Menambahkan Barang Baru Mie Goreng isi 2 Ayam Kecap, Dengan Kode MGL-BRG0003', 'Master Barang', '2023-02-08 22:55:46'),
(107, 'ahmadhusain11', 'Menambahkan Barang Baru Nabati, Dengan Kode MGL-BRG0004', 'Master Barang', '2023-02-08 22:56:22'),
(108, 'ahmadhusain11', 'Menambahkan Barang Baru Roti Tawar, Dengan Kode MGL-BRG0005', 'Master Barang', '2023-02-09 01:01:36'),
(109, 'ahmadhusain11', 'Menambahkan Barang Baru Coca - cola, Dengan Kode MGL-BRG0006', 'Master Barang', '2023-02-09 01:06:36'),
(110, 'ahmadhusain11', 'Menambahkan Barang Baru Sprit, Dengan Kode MGL-BRG0007', 'Master Barang', '2023-02-09 01:14:04'),
(111, 'ahmadhusain11', 'Menambahkan Barang Baru Downy, Dengan Kode MGL-BRG0008', 'Master Barang', '2023-02-09 01:14:42'),
(112, 'ahmadhusain11', 'Mengubah Barang Mie Goreng isi 2 Ayam Kecap, Dengan Kode MGL-BRG0003', 'Master Barang', '2023-02-09 22:09:44'),
(113, 'ahmadhusain11', 'Mengubah Barang Roti Tawar, Dengan Kode MGL-BRG0005', 'Master Barang', '2023-02-09 22:31:09'),
(114, 'ahmadhusain11', 'Menambahkan satuan botol, Dengan Kode MGL-SAT0006', 'Core Satuan', '2023-02-17 18:32:11'),
(115, 'ahmadhusain11', 'Mengubah satuan Botol a, Dengan Kode MGL-SAT0006', 'Core Satuan', '2023-02-17 18:32:22'),
(116, 'ahmadhusain11', 'Mengubah satuan Botol, Dengan Kode MGL-SAT0006', 'Core Satuan', '2023-02-17 18:32:28'),
(117, 'ahmadhusain11', 'Menambahkan Barang Baru Ayam Bakar Kecap, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 18:41:56'),
(118, 'ahmadhusain11', 'Menghapus Barang Ayam Bakar Kecap, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 21:20:16'),
(119, 'ahmadhusain11', 'Menambahkan Barang Baru Ayam Bakar Kecap, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 21:21:38'),
(120, 'ahmadhusain11', 'Menambahkan Barang Baru Ayam Bakar Kecap, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 21:21:40'),
(121, 'ahmadhusain11', 'Menambahkan Barang Baru Ayam Bakar Kecap, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 21:21:51'),
(122, 'ahmadhusain11', 'Menambahkan Barang Baru Ayam Bakar Kecap, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 21:22:52'),
(123, 'ahmadhusain11', 'Menghapus Barang Ayam Bakar Kecap, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 21:23:07'),
(124, 'ahmadhusain11', 'Menghapus Barang Ayam Bakar Kecap, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 21:23:13'),
(125, 'ahmadhusain11', 'Menghapus Barang Ayam Bakar Kecap, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 21:23:19'),
(126, 'ahmadhusain11', 'Menghapus Barang Ayam Bakar Kecap, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 21:23:26'),
(127, 'ahmadhusain11', 'Menambahkan Barang Baru Ayam Bakar Kecap Manis, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 21:24:10'),
(128, 'ahmadhusain11', 'Mengubah Barang Ayam Bakar Kecap Manis, Dengan Kode MGL-BRG0009', 'Master Barang', '2023-02-17 21:36:06'),
(130, 'indra', 'Melakukan Order Barang Roti Tawar, Dengan Kode MGL-BRG0005', 'Penjualan', '2023-02-17 22:38:40'),
(131, 'ahmadhusain11', 'Menurunkan user zaki menjadi Anggota', 'Akses Cabang', '2023-02-17 22:39:06'),
(132, 'zaki', 'Melakukan Order Barang Roti Tawar, Dengan Kode MGL-BRG0005', 'Penjualan', '2023-02-18 00:12:26'),
(133, 'zaki', 'Melakukan Order Barang Mie Goreng isi 2 Ayam Kecap, Dengan Kode MGL-BRG0003', 'Penjualan', '2023-02-18 00:13:06'),
(134, 'indra', 'Melakukan Order Barang Roti Tawar, Dengan Kode MGL-BRG0005', 'Penjualan', '2023-02-18 00:15:16'),
(135, 'ahmadhusain11', 'Mengaktifkan user shali', 'Aktifasi Akun', '2023-05-17 14:29:29'),
(136, 'ahmadhusain11', 'Mengaktifkan user riski', 'Aktifasi Akun', '2023-05-17 14:34:17'),
(137, 'ahmadhusain11', 'Memberikan akses cabang DIY ke user riski', 'Akses Cabang', '2023-05-17 14:34:44'),
(138, 'ahmadhusain11', 'Mengaktifkan user shalirus', 'Aktifasi Akun', '2023-05-17 17:16:41'),
(139, 'ahmadhusain11', 'Memberikan akses cabang MGL ke user shalirus', 'Akses Cabang', '2023-05-17 17:16:54'),
(140, 'ahmadhusain11', 'Memberikan akses cabang DIY ke user shalirus', 'Akses Cabang', '2023-05-17 17:16:56'),
(141, 'ahmadhusain11', 'Memberikan akses cabang TMG ke user shalirus', 'Akses Cabang', '2023-05-17 17:16:58'),
(142, 'ahmadhusain11', 'Memberikan akses cabang SMG ke user shalirus', 'Akses Cabang', '2023-05-17 17:17:00'),
(143, 'ahmadhusain11', 'Memberikan akses cabang SLO ke user shalirus', 'Akses Cabang', '2023-05-17 17:17:02'),
(144, 'ahmadhusain11', 'Menambahkan kategori Snack, Dengan Kode SLO-KAT0001', 'Core Kategori', '2023-06-08 15:44:55'),
(145, 'ahmadhusain11', 'Menambahkan satuan Pcs, Dengan Kode SLO-SAT0001', 'Core Satuan', '2023-06-08 15:45:28'),
(146, 'ahmadhusain11', 'Menambahkan Barang Baru Sari Roti, Dengan Kode SLO-BRG0001', 'Master Barang', '2023-06-08 15:46:01'),
(147, 'ahmadhusain11', 'Menonaktikan user riski', 'Aktifasi Akun', '2023-06-08 15:46:45'),
(148, 'ahmadhusain11', 'Mengaktifkan user riski', 'Aktifasi Akun', '2023-06-08 15:46:50'),
(149, 'ahmadhusain11', 'Memberikan akses cabang JKT ke user riski', 'Akses Cabang', '2023-06-08 15:47:09'),
(150, 'zaki', 'Melakukan Order Barang Ayam Bakar Kecap Manis, Dengan Kode MGL-BRG0009', 'Penjualan', '2023-07-20 22:58:22'),
(151, 'zaki', 'Melakukan Order Barang Roti Tawar, Dengan Kode MGL-BRG0005', 'Penjualan', '2023-07-20 23:28:07'),
(152, 'zaki', 'Melakukan Order Barang Ayam Bakar Kecap Manis, Dengan Kode MGL-BRG0009', 'Penjualan', '2023-07-21 11:50:11'),
(153, 'ahmadhusain11', 'Menghapus Anggota Baru Shali, Dengan Username shali', 'Master Anggota', '2023-07-21 16:39:50'),
(154, 'ahmadhusain11', 'Menghapus satuan Dus, Dengan Kode DIY-SAT0001', 'Core Satuan', '2023-07-21 16:45:40'),
(155, 'ahmadhusain11', 'Menghapus satuan Pcs, Dengan Kode DIY-SAT0002', 'Core Satuan', '2023-07-21 16:45:43'),
(156, 'ahmadhusain11', 'Menghapus satuan Botol, Dengan Kode DIY-SAT0003', 'Core Satuan', '2023-07-21 16:45:46'),
(157, 'ahmadhusain11', 'Menghapus satuan Saset, Dengan Kode DIY-SAT0004', 'Core Satuan', '2023-07-21 16:45:48'),
(158, 'ahmadhusain11', 'Menambahkan satuan Dus, Dengan Kode DIY-SAT0001', 'Core Satuan', '2023-07-21 16:51:51'),
(159, 'ahmadhusain11', 'Menambahkan satuan Botol, Dengan Kode DIY-SAT0002', 'Core Satuan', '2023-07-21 16:52:11'),
(160, 'ahmadhusain11', 'Menambahkan satuan Saset, Dengan Kode DIY-SAT0003', 'Core Satuan', '2023-07-21 16:52:20'),
(161, 'ahmadhusain11', 'Menambahkan satuan Box, Dengan Kode DIY-SAT0004', 'Core Satuan', '2023-07-21 16:52:38'),
(162, 'ahmadhusain11', 'Mengubah satuan Box Asda, Dengan Kode DIY-SAT0004', 'Core Satuan', '2023-07-21 16:52:46'),
(163, 'ahmadhusain11', 'Menghapus satuan Box Asda, Dengan Kode DIY-SAT0004', 'Core Satuan', '2023-07-21 16:52:50'),
(164, 'ahmadhusain11', 'Menambahkan kategori Snack, Dengan Kode DIY-KAT0001', 'Core Kategori', '2023-07-21 16:55:40'),
(165, 'ahmadhusain11', 'Menambahkan kategori Sabun, Dengan Kode DIY-KAT0002', 'Core Kategori', '2023-07-21 16:55:49'),
(166, 'ahmadhusain11', 'Menambahkan kategori Minuman Botol, Dengan Kode DIY-KAT0003', 'Core Kategori', '2023-07-21 16:55:59'),
(167, 'ahmadhusain11', 'Menambahkan kategori Minuman Gelas, Dengan Kode DIY-KAT0004', 'Core Kategori', '2023-07-21 16:56:11'),
(168, 'ahmadhusain11', 'Menambahkan kategori Kebutuhan Pokok, Dengan Kode DIY-KAT0005', 'Core Kategori', '2023-07-21 16:56:26'),
(169, 'zaki', 'Melakukan Order Barang Ayam Bakar Kecap Manis, Dengan Kode MGL-BRG0009', 'Penjualan', '2023-07-23 23:17:20'),
(170, 'zaki', 'Melakukan Order Barang Sprit, Dengan Kode MGL-BRG0007', 'Penjualan', '2023-07-23 23:17:53'),
(171, 'ahmadhusain11', 'Menambahkan supplier Pt Pratama Garuda, Dengan Kode MGL-SUP0001', 'Core Supplier', '2023-07-24 01:49:08'),
(172, 'ahmadhusain11', 'Menambahkan supplier Pt Pratama Garuda, Dengan Kode MGL-SUP0001', 'Core Supplier', '2023-07-24 01:54:43'),
(173, 'ahmadhusain11', 'Mengubah supplier Pt Pratama Garuda, Dengan Kode MGL-SUP0001', 'Core Supplier', '2023-07-24 02:12:20'),
(174, 'ahmadhusain11', 'Menghapus supplier Pt Pratama Garuda, Dengan Kode MGL-SUP0001', 'Core Supplier', '2023-07-24 02:14:04'),
(175, 'ahmadhusain11', 'Menambahkan supplier Pt. Pratama Garuda, Dengan Kode MGL-SUP0001', 'Core Supplier', '2023-07-24 02:15:06'),
(176, 'ahmadhusain11', 'Menambahkan ppn Ppn 10%, Dengan Id ', 'Core PPN', '2023-07-24 17:33:33'),
(177, 'ahmadhusain11', 'Menghapus PPN PPN 11%, Dengan Kode 1', 'Core PPN', '2023-07-24 17:33:53'),
(178, 'ahmadhusain11', 'Menambahkan ppn Ppn 11%, Dengan Id ', 'Core PPN', '2023-07-24 17:34:48'),
(179, 'ahmadhusain11', 'Mengubah PPN Ppn 2020 (10%), Dengan Value 10', 'Core PPN', '2023-07-24 17:37:04'),
(180, 'ahmadhusain11', 'Mengubah PPN Ppn 2020 (10%), Dengan Value 10', 'Core PPN', '2023-07-24 17:37:36'),
(181, 'ahmadhusain11', 'Mengubah PPN Ppn 2023 (11%), Dengan Value 11', 'Core PPN', '2023-07-24 17:37:51'),
(182, 'ahmadhusain11', 'Meningkatkan user shalirus menjadi Administrator', 'Akses Cabang', '2023-07-25 15:24:34'),
(183, 'ahmadhusain11', 'Menonaktikan user riski', 'Aktifasi Akun', '2023-07-25 15:25:07'),
(184, 'ahmadhusain11', 'Mengaktifkan user riski', 'Aktifasi Akun', '2023-07-25 15:25:13'),
(185, 'ahmadhusain11', 'Menonaktikan user riski', 'Aktifasi Akun', '2023-07-26 10:03:46'),
(186, 'ahmadhusain11', 'Menambahkan Tingkatan Member, Dengan ID Tingkatan 4', 'Core Tingkatan', '2023-07-27 13:42:23'),
(187, 'ahmadhusain11', 'Mengubah Tingkatan Kasir, Dengan Kode 2', 'Core Tingkatan', '2023-07-27 13:46:15'),
(188, 'ahmadhusain11', 'Menghapus Tingkatan Member, Dengan ID Tingkatan 4', 'Core Tingkatan', '2023-07-27 13:49:18'),
(189, 'ahmadhusain11', 'Menambahkan Tingkatan Member, Dengan ID Tingkatan 5', 'Core Tingkatan', '2023-07-27 13:49:57'),
(190, 'ahmadhusain11', 'Mengubah Tingkatan Admin, Dengan ID Tingkatan 1', 'Core Tingkatan', '2023-07-27 14:03:57'),
(191, 'ahmadhusain11', 'Merubah Tingkatan User zaki dari Member menjadi Kasir', 'Akses Cabang', '2023-07-27 14:45:52'),
(192, 'ahmadhusain11', 'Merubah Tingkatan User zaki dari Kasir menjadi Member', 'Akses Cabang', '2023-07-27 14:46:29'),
(193, 'ahmadhusain11', 'Merubah Tingkatan User zaki dari Member menjadi Kasir', 'Akses Cabang', '2023-07-27 14:48:16'),
(194, 'ahmadhusain11', 'Merubah Tingkatan User zaki dari Kasir menjadi Member', 'Akses Cabang', '2023-07-27 14:48:44'),
(195, 'ahmadhusain11', 'Merubah Tingkatan User zaki dari Kasir menjadi ', 'Akses Cabang', '2023-07-27 14:50:59'),
(196, 'ahmadhusain11', 'Merubah Tingkatan User zaki dari Member menjadi Kasir', 'Akses Cabang', '2023-07-27 14:51:50'),
(197, 'ahmadhusain11', 'Merubah Tingkatan User zaki dari Kasir menjadi Member', 'Akses Cabang', '2023-07-27 14:51:58'),
(198, 'ahmadhusain11', 'Merubah Tingkatan User zaki dari Member menjadi Kasir', 'Akses Cabang', '2023-07-27 14:57:19'),
(199, 'ahmadhusain11', 'Merubah Tingkatan User zaki dari Kasir menjadi Member', 'Akses Cabang', '2023-07-27 14:57:31'),
(200, 'ahmadhusain11', 'Merubah Tingkatan User zaki dari Member menjadi Kasir', 'Akses Cabang', '2023-07-27 14:59:01'),
(201, 'ahmadhusain11', 'Merubah Tingkatan User zaki dari Kasir menjadi Member', 'Akses Cabang', '2023-07-27 14:59:05'),
(202, 'ahmadhusain11', 'Mengubah PPN 2020 (10%), Dengan Value 10', 'Core PPN', '2023-07-27 15:23:59'),
(203, 'ahmadhusain11', 'Mengubah PPN 2023 (11%), Dengan Value 11', 'Core PPN', '2023-07-27 15:24:07'),
(204, 'ahmadhusain11', 'Menambahkan ppn 2024 (12%), Dengan Value 12', 'Core PPN', '2023-07-27 15:24:21'),
(205, 'ahmadhusain11', 'Menambahkan Menu Laporan, Dengan ID Menu 9', 'Core Menu', '2023-07-27 21:04:59'),
(206, 'ahmadhusain11', 'Mengubah Menu Laporan Keseluruhan, Dengan ID Menu 9', 'Core Menu', '2023-07-27 21:14:18'),
(207, 'ahmadhusain11', 'Mengubah Menu Laporan, Dengan ID Menu 9', 'Core Menu', '2023-07-27 21:14:43'),
(208, 'ahmadhusain11', 'Menghapus Menu Laporan, Dengan ID Menu 9', 'Core Menu', '2023-07-27 21:37:23'),
(209, 'ahmadhusain11', 'Menambahkan Menu Laporan, Dengan ID Menu 10', 'Core Menu', '2023-07-27 21:37:42'),
(210, 'ahmadhusain11', 'Menambahkan Sub Menu Laporan Pembelian, Dengan ID Sub Menu 21', 'Core Sub Menu', '2023-07-27 22:24:51'),
(211, 'ahmadhusain11', 'Mengubah Sub Menu Laporan Beli, Dengan ID Sub Menu 21', 'Core Sub Menu', '2023-07-27 22:31:25'),
(212, 'ahmadhusain11', 'Menghapus Sub Menu Laporan Beli, Dengan ID Sub Menu 21', 'Core Menu', '2023-07-27 22:33:44'),
(213, 'ahmadhusain11', 'Menghapus Menghapus Akses Laporan, Pada Tingkatan 1', 'Core Akses Menu', '2023-07-28 00:23:29'),
(214, 'ahmadhusain11', 'Menghapus Memberikan Akses Laporan, Pada Tingkatan 1', 'Core Akses Menu', '2023-07-28 00:24:44'),
(215, 'ahmadhusain11', 'Menghapus Menghapus Akses Laporan, Pada Tingkatan 1', 'Core Akses Menu', '2023-07-28 00:26:52'),
(216, 'ahmadhusain11', 'Menghapus Memberikan Akses Laporan, Pada Tingkatan 1', 'Core Akses Menu', '2023-07-28 00:27:46'),
(217, 'ahmadhusain11', 'Menghapus Menghapus Akses Laporan, Pada Tingkatan 1', 'Core Akses Menu', '2023-07-28 00:28:03'),
(218, 'ahmadhusain11', 'Menghapus Memberikan Akses Laporan, Pada Tingkatan 1', 'Core Akses Menu', '2023-07-28 00:32:45'),
(219, 'ahmadhusain11', 'Menghapus Menghapus Akses Laporan, Pada Tingkatan 1', 'Core Akses Menu', '2023-07-28 00:37:01'),
(220, 'ahmadhusain11', 'Menambahkan Tingkatan Kurir, Dengan ID Tingkatan 6', 'Core Tingkatan', '2023-07-28 03:28:08'),
(221, 'ahmadhusain11', 'Menghapus Tingkatan Kurir, Dengan ID Tingkatan 6', 'Core Tingkatan', '2023-07-28 03:28:33'),
(222, 'ahmadhusain11', 'Menambahkan supplier Pt. Sukamulya, Dengan Kode MGL-SUP0002', 'Core Supplier', '2023-07-28 13:41:27'),
(223, 'ahmadhusain11', 'Menambahkan Data PO, Dengan Invoice MGL-PRE2307280001', 'Pembelian Barang PO', '2023-07-28 15:27:53'),
(224, 'ahmadhusain11', 'Mengubah Data PO, Dengan Invoice MGL-PRE2307280001', 'Pembelian Barang PO', '2023-07-28 15:28:21'),
(225, 'ahmadhusain11', 'Mengubah Data PO, Dengan Invoice MGL-PRE2307280001', 'Pembelian Barang PO', '2023-07-28 15:33:51'),
(226, 'ahmadhusain11', 'Mengubah Data PO pada Invoice MGL-PRE2307280001, Dengan alasan : salah qty', 'Pembelian Barang PO', '2023-07-28 15:34:54'),
(227, 'ahmadhusain11', 'Menghapus Data PO, Dengan Invoice MGL-PRE2307280001', 'Pembelian Barang PO', '2023-07-28 15:41:38'),
(228, 'ahmadhusain11', 'Menambahkan Data Terima, Dengan Invoice MGL-TER2307280001', 'Pembelian Barang Terima', '2023-07-28 15:49:58'),
(229, 'ahmadhusain11', 'Menghapus Data Terima, Dengan Invoice MGL-TER2307280001', 'Pembelian Barang Terima', '2023-07-28 15:53:35'),
(230, 'ahmadhusain11', 'Menambahkan Data PO, Dengan Invoice MGL-PRE2307280001', 'Pembelian Barang PO', '2023-07-28 15:53:59'),
(231, 'ahmadhusain11', 'Menambahkan Data Terima, Dengan Invoice MGL-TER2307280001', 'Pembelian Barang Terima', '2023-07-28 15:54:10'),
(232, 'ahmadhusain11', 'Mengubah Data Terima pada Invoice MGL-TER2307280001, Dengan alasan : kelebihan qty, dan salah ppn', 'Pembelian Barang Terima', '2023-07-28 16:58:33'),
(233, 'ahmadhusain11', 'Menambahkan Menu Pesan, Dengan ID Menu 11', 'Core Menu', '2023-07-29 00:51:00'),
(234, 'ahmadhusain11', 'Menghapus Memberikan Akses Pesan, Pada Tingkatan 1', 'Core Akses Menu', '2023-07-29 00:51:18'),
(235, 'ahmadhusain11', 'Menghapus Menghapus Akses Pesan, Pada Tingkatan 1', 'Core Akses Menu', '2023-07-29 00:52:42'),
(236, 'ahmadhusain11', 'Menghapus Menu Laporan, Dengan ID Menu 10', 'Core Menu', '2023-07-29 00:52:54'),
(237, 'ahmadhusain11', 'Menghapus Menu Pesan, Dengan ID Menu 11', 'Core Menu', '2023-07-29 00:52:59'),
(238, 'ahmadhusain11', 'Menambahkan Sub Menu Pesan, Dengan ID Sub Menu 22', 'Core Sub Menu', '2023-07-29 00:53:56'),
(239, 'ahmadhusain11', 'Menambahkan Tingkatan Kurir, Dengan ID Tingkatan 7', 'Core Tingkatan', '2023-07-30 16:48:11'),
(240, 'ahmadhusain11', 'Menghapus Tingkatan Kurir, Dengan ID Tingkatan 7', 'Core Tingkatan', '2023-07-30 16:48:47'),
(241, 'ahmadhusain11', 'Menambahkan Data Terima, Dengan Invoice MGL-TER2308030001', 'Pembelian Barang Terima', '2023-08-03 00:00:31'),
(242, 'ahmadhusain11', 'Menambahkan supplier Pt Nusantara, Dengan Kode DIY-SUP0001', 'Core Supplier', '2023-12-14 01:33:52'),
(243, 'ahmadhusain11', 'Menambahkan Barang Baru Lifeboy, Dengan Kode DIY-BRG0001', 'Master Barang', '2023-12-14 01:34:56'),
(244, 'ahmadhusain11', 'Menambahkan Barang Baru Taro, Dengan Kode DIY-BRG0002', 'Master Barang', '2023-12-14 01:35:39'),
(245, 'ahmadhusain11', 'Menambahkan Data PO, Dengan Invoice DIY-PRE2312140001', 'Pembelian Barang PO', '2023-12-14 01:36:19'),
(246, 'ahmadhusain11', 'Menambahkan Data PO, Dengan Invoice DIY-PRE2312140002', 'Pembelian Barang PO', '2023-12-14 01:36:48'),
(247, 'ahmadhusain11', 'Menambahkan Data Terima, Dengan Invoice DIY-TER2312140001', 'Pembelian Barang Terima', '2023-12-14 01:46:15'),
(248, 'ahmadhusain11', 'Mengubah Data Terima pada Invoice DIY-TER2312140001, Dengan alasan : ', 'Pembelian Barang Terima', '2023-12-14 01:47:28'),
(249, 'ahmadhusain11', 'Menghapus Data Terima, Dengan Invoice DIY-TER2312140001', 'Pembelian Barang Terima', '2023-12-14 01:47:49'),
(250, 'ahmadhusain11', 'Menambahkan Sub Menu Gudang, Dengan ID Sub Menu 23', 'Core Sub Menu', '2023-12-14 01:51:27'),
(251, 'ahmadhusain11', 'Menghapus Menghapus Akses Orang - orang, Pada Tingkatan 3', 'Core Akses Menu', '2023-12-14 01:53:16'),
(252, 'ahmadhusain11', 'Menghapus Menghapus Akses Orang - orang, Pada Tingkatan 2', 'Core Akses Menu', '2023-12-14 01:53:23'),
(253, 'ahmadhusain11', 'Menghapus Menghapus Akses Orang - orang, Pada Tingkatan 1', 'Core Akses Menu', '2023-12-14 01:53:29'),
(254, 'ahmadhusain11', 'Menambahkan gudang Backdoor, Dengan Kode DIY-GUD0001', 'Core gudang', '2023-12-14 02:07:56'),
(255, 'ahmadhusain11', 'Mengubah gudang Red, Dengan Kode DIY-GUD0001', 'Core gudang', '2023-12-14 02:09:22'),
(256, 'ahmadhusain11', 'Menambahkan gudang Blue, Dengan Kode DIY-GUD0002', 'Core gudang', '2023-12-14 02:09:28'),
(257, 'ahmadhusain11', 'Menambahkan gudang Yellow, Dengan Kode DIY-GUD0003', 'Core gudang', '2023-12-14 02:09:35'),
(258, 'ahmadhusain11', 'Menambahkan gudang Green, Dengan Kode DIY-GUD0004', 'Core gudang', '2023-12-14 02:09:46'),
(259, 'ahmadhusain11', 'Menambahkan Data PO, Dengan Invoice DIY-PRE2312140001', 'Pembelian Barang PO', '2023-12-14 02:20:05'),
(260, 'ahmadhusain11', 'Mengubah Data PO pada Invoice DIY-PRE2312140001, Dengan alasan : salah gudang', 'Pembelian Barang PO', '2023-12-14 02:26:55'),
(261, 'ahmadhusain11', 'Mengubah Data PO pada Invoice DIY-PRE2312140001, Dengan alasan : salah total', 'Pembelian Barang PO', '2023-12-14 02:35:20'),
(262, 'ahmadhusain11', 'Menambahkan Data Terima, Dengan Invoice DIY-TER2312140001', 'Pembelian Barang Terima', '2023-12-14 02:35:49'),
(263, 'ahmadhusain11', 'Menghapus Data Terima, Dengan Invoice DIY-TER2312140001', 'Pembelian Barang Terima', '2023-12-14 02:36:54'),
(264, 'ahmadhusain11', 'Menambahkan Data Terima, Dengan Invoice DIY-TER2312140001', 'Pembelian Barang Terima', '2023-12-14 02:37:06'),
(265, 'ahmadhusain11', 'Mengubah Data Terima pada Invoice DIY-TER2312140001, Dengan alasan : salahh gudang dari PO', 'Pembelian Barang Terima', '2023-12-14 02:44:04'),
(266, 'ahmadhusain11', 'Mengubah Data Terima pada Invoice DIY-TER2312140001, Dengan alasan : ', 'Pembelian Barang Terima', '2023-12-14 02:44:35'),
(267, 'ahmadhusain11', 'Mengubah Data Terima pada Invoice DIY-TER2312140001, Dengan alasan : ', 'Pembelian Barang Terima', '2023-12-14 02:44:43'),
(268, 'ahmadhusain11', 'Mengubah Data Terima pada Invoice DIY-TER2312140001, Dengan alasan : salah po', 'Pembelian Barang Terima', '2023-12-14 02:45:50'),
(269, 'ahmadhusain11', 'Mengubah Barang Lifeboy (Botol), Dengan Kode DIY-BRG0001', 'Master Barang', '2023-12-14 03:11:56'),
(270, 'ahmadhusain11', 'Mengubah Barang Taro (Saset), Dengan Kode DIY-BRG0002', 'Master Barang', '2023-12-14 03:12:09'),
(271, 'ahmadhusain11', 'Menambahkan Barang Baru Le Mineral (Botol), Dengan Kode DIY-BRG0003', 'Master Barang', '2023-12-14 03:16:47'),
(272, 'ahmadhusain11', 'Menghapus Data Terima, Dengan Invoice DIY-TER2312140001', 'Pembelian Barang Terima', '2023-12-14 15:41:18'),
(273, 'ahmadhusain11', 'Menghapus Data PO, Dengan Invoice DIY-PRE2312140001', 'Pembelian Barang PO', '2023-12-14 15:41:24'),
(274, 'ahmadhusain11', 'Menambahkan Data PO, Dengan Invoice DIY-PRE2312140001', 'Pembelian Barang PO', '2023-12-14 18:06:42'),
(275, 'ahmadhusain11', 'Mengubah Data PO pada Invoice DIY-PRE2312140001, Dengan alasan : lupa ppn dan barang 1', 'Pembelian Barang PO', '2023-12-14 18:10:45'),
(276, 'ahmadhusain11', 'Mengubah Data PO pada Invoice DIY-PRE2312140001, Dengan alasan : salah tahun', 'Pembelian Barang PO', '2023-12-14 18:12:46'),
(277, 'ahmadhusain11', 'Mengubah Data PO pada Invoice DIY-PRE2312140001, Dengan alasan : salah expire', 'Pembelian Barang PO', '2023-12-14 18:13:58'),
(278, 'ahmadhusain11', 'Menambahkan Data Terima, Dengan Invoice DIY-TER2312140001', 'Pembelian Barang Terima', '2023-12-14 18:34:27'),
(279, 'ahmadhusain11', 'Mengubah Data Terima pada Invoice DIY-TER2312140001, Dengan alasan : kelebihan 1 barang', 'Pembelian Barang Terima', '2023-12-14 18:40:13'),
(280, 'ahmadhusain11', 'Menambahkan gudang A, Dengan Kode MGL-GUD0001', 'Core gudang', '2023-12-16 21:15:37'),
(281, 'ahmadhusain11', 'Menambahkan gudang B, Dengan Kode MGL-GUD0002', 'Core gudang', '2023-12-16 21:15:41'),
(282, 'ahmadhusain11', 'Menambahkan gudang C, Dengan Kode MGL-GUD0003', 'Core gudang', '2023-12-16 21:15:46'),
(283, 'ahmadhusain11', 'Menambahkan gudang D, Dengan Kode MGL-GUD0004', 'Core gudang', '2023-12-16 21:15:52'),
(284, 'ahmadhusain11', 'Menambahkan gudang E, Dengan Kode MGL-GUD0005', 'Core gudang', '2023-12-16 21:15:57'),
(285, 'ahmadhusain11', 'Menambahkan Data Retur Penerimaan, Dengan Invoice DIY-RET7012170001', 'Retur Pembelian', '2023-12-17 00:23:19'),
(286, 'ahmadhusain11', 'Menambahkan Data Retur Penerimaan, Dengan Invoice DIY-RET7012170001', 'Retur Pembelian', '2023-12-17 00:29:29'),
(287, 'ahmadhusain11', 'Menambahkan Data Retur Penerimaan, Dengan Invoice DIY-RET7012170001', 'Retur Pembelian', '2023-12-17 00:30:04'),
(288, 'ahmadhusain11', 'Menambahkan Data Retur Penerimaan, Dengan Invoice DIY-RET7012170001', 'Retur Pembelian', '2023-12-17 00:30:50'),
(289, 'ahmadhusain11', 'Menambahkan Data Retur Penerimaan, Dengan Invoice DIY-RET2312170001', 'Retur Pembelian', '2023-12-17 00:31:25'),
(290, 'ahmadhusain11', 'Mengubah Data Retur Penerimaan pada Invoice DIY-RET2312170001, Dengan alasan : salah qty dan ppn', 'Retur Pembelian', '2023-12-17 00:52:14'),
(291, 'ahmadhusain11', 'Menghapus Data Retur, Dengan Invoice DIY-RET2312170001', 'Retur Penerimaan Barang', '2023-12-17 00:57:56'),
(292, 'ahmadhusain11', 'Menambahkan Data Retur Penerimaan, Dengan Invoice DIY-RET7012170001', 'Retur Pembelian', '2023-12-17 00:58:40'),
(293, 'ahmadhusain11', 'Menambahkan Data Retur Penerimaan, Dengan Invoice DIY-RET2312170001', 'Retur Pembelian', '2023-12-17 01:01:06'),
(294, 'ahmadhusain11', 'Menghapus Data Retur, Dengan Invoice DIY-RET2312170001', 'Retur Penerimaan Barang', '2023-12-17 01:07:10'),
(295, 'ahmadhusain11', 'Mengubah Data Terima pada Invoice DIY-TER2312140001, Dengan alasan : salah qty', 'Pembelian Barang Terima', '2023-12-17 01:09:43'),
(296, 'ahmadhusain11', 'Menambahkan Data Retur Penerimaan, Dengan Invoice DIY-RET2312170001', 'Retur Pembelian', '2023-12-17 01:10:33'),
(297, 'ahmadhusain11', 'Mengubah Data Retur Penerimaan pada Invoice DIY-RET2312170001, Dengan alasan : salah qty', 'Retur Pembelian', '2023-12-17 01:10:53'),
(298, 'ahmadhusain11', 'Menambahkan Data Terima, Dengan Invoice DIY-TER2312170001', 'Pembelian Barang Terima', '2023-12-17 01:12:16'),
(299, 'ahmadhusain11', 'Menambahkan Data Retur Penerimaan, Dengan Invoice DIY-RET2312170002', 'Retur Pembelian', '2023-12-17 01:13:07'),
(300, 'ahmadhusain11', 'Menghapus Menghapus Akses Transaksi, Pada Tingkatan 1', 'Core Akses Menu', '2023-12-17 01:47:52'),
(301, 'ahmadhusain11', 'Mengaktifkan user riski', 'Aktifasi Akun', '2023-12-17 01:48:59'),
(302, 'ahmadhusain11', 'Merubah Tingkatan User riski dari Member menjadi Kasir', 'Akses Cabang', '2023-12-17 01:49:20');

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
(18, 8, 3),
(19, 5, 2),
(26, 8, 1);

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
  `kontak_cabang` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`id_cabang`, `kode_cabang`, `nama_cabang`, `alamat_cabang`, `kontak_cabang`) VALUES
(1, 'MGL', 'Magelang', 'Mungkid, Magelang', 'magelang@gmail.com'),
(2, 'DIY', 'Yogyakarta', 'Sleman, Yogyakarta', 'yogyakarta@gmail.com'),
(3, 'SMG', 'Semarang', 'Ambarawa, Semarang', 'semarang@gmail.com'),
(5, 'TMG', 'Temanggung', 'Maroon, Temanggung', 'temanggung@gmail.com'),
(6, 'SLO', 'Solo', 'Solo', 'solo@gmail.com'),
(7, 'JKT', 'Jakarta', 'Kebon Jeruk, Jakarta', 'jakarta@gmail.com');

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

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id_chat`, `tgl`, `dari`, `ke`, `pesan`, `status`) VALUES
(1, '2023-01-26 17:40:27', 'ahmadhusain11', 'zaki', 'Hallo', 1),
(2, '2023-01-26 17:41:27', 'zaki', 'ahmadhusain11', 'Apa', 1),
(4, '2023-01-26 17:43:27', 'ahmadhusain11', 'zaki', 'gapapa', 1),
(15, '2023-01-28 20:17:19', 'ahmadhusain11', 'zaki', 'dolan njo', 1),
(16, '2023-01-28 20:20:39', 'zaki', 'ahmadhusain11', 'dolan nandi', 1),
(17, '2023-01-28 20:21:40', 'ahmadhusain11', 'zaki', 'neng artos wae po ?', 1),
(18, '2023-01-28 20:37:42', 'ahmadhusain11', 'zaki', 'po meh nandi ?', 1),
(20, '2023-01-28 20:40:47', 'zaki', 'ahmadhusain11', 'neng arah salaman wae po', 1),
(21, '2023-01-28 20:41:53', 'zaki', 'ahmadhusain11', 'soale ben cedak', 1),
(22, '2023-01-28 21:04:15', 'ahmadhusain11', 'zaki', 'yo yapopo', 0),
(23, '2023-01-28 21:56:08', 'ahmadhusain11', 'zaki', 'po meh nandi ?', 0),
(24, '2023-01-30 12:42:58', 'zaki', 'ahmadhusain11', 'bebas', 0),
(25, '2023-02-08 00:26:51', 'indra', 'ahmadhusain11', 'mbok aku dadeke admin', 0),
(26, '2023-02-08 00:27:51', 'ahmadhusain11', 'indra', 'ok', 0),
(27, '2023-05-17 14:37:23', 'riski', 'ahmadhusain11', 'tes', 0),
(28, '2023-05-17 14:39:12', 'ahmadhusain11', 'riski', 'ada yg bisa di bantu', 0),
(29, '2023-05-17 14:39:33', 'riski', 'ahmadhusain11', 'bisa tanya tanya', 0),
(30, '2023-05-17 14:40:59', 'ahmadhusain11', 'riski', 'boleh ka silahkan', 0),
(31, '2023-05-17 14:43:18', 'riski', 'ahmadhusain11', 'jQuery3510010775444849778992_1684309391125?', 0),
(32, '2023-05-17 14:49:31', 'riski', 'ahmadhusain11', 'ini gimana ya cara buatnya', 0),
(33, '2023-05-17 14:50:25', 'ahmadhusain11', 'riski', 'cara buat sistemnya', 0),
(34, '2023-05-17 14:50:35', 'riski', 'ahmadhusain11', 'iya', 0),
(35, '2023-05-17 15:11:03', 'riski', 'ahmadhusain11', 'trus gimana', 0),
(36, '2023-05-17 15:11:18', 'riski', 'ahmadhusain11', 'gimana apanya', 0),
(37, '2023-05-17 15:11:32', 'ahmadhusain11', 'riski', 'lah ko bingungin', 0),
(38, '2023-06-01 20:57:25', 'shali', 'ahmadhusain11', 'hallo', 0),
(39, '2023-06-01 20:57:47', 'ahmadhusain11', 'shali', 'apa', 0),
(40, '2023-07-29 00:28:38', 'ahmadhusain11', 'shalirus', 'halo', 0),
(41, '2023-07-29 00:30:45', 'shalirus', 'ahmadhusain11', 'iya', 0),
(42, '2023-07-30 16:54:13', 'zaki', 'shalirus', 'hai', 0),
(43, '2023-07-30 17:00:43', 'zaki', 'shalirus', 'juga', 0),
(44, '2023-07-30 17:00:54', 'shalirus', 'zaki', 'apa', 0),
(45, '2023-07-30 17:01:43', 'shalirus', 'zaki', 'gimana', 0);

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
(8, 'Transaksi', '<i class=\"fa-solid fa-bag-shopping nav-icon\"></i>', 'Penjualan');

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
(43, 'DIY-TER2312140001', 'DIY-BRG0001', '2025-12-14', 'Lifeboy (Botol)', 'DIY-SAT0002', 1000, 15000, 10, 150000, 14850000),
(44, 'DIY-TER2312140001', 'DIY-BRG0003', '2025-12-14', 'Le Mineral (Botol)', 'DIY-SAT0002', 1000, 3000, 0, 0, 3000000),
(45, 'DIY-TER2312170001', 'DIY-BRG0001', '2024-12-17', 'Lifeboy (Botol)', 'DIY-SAT0002', 100, 15000, 0, 0, 1500000);

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
(20, 'DIY-TER2312140001', 'DIY-PRE2312140001', 'DIY', 'DIY-GUD0001', 'DIY-SUP0001', '2023-12-14', '18:06:02', 'ahmadhusain11', 1, 2, 18000000, 150000, 1785000, 19635000, 'salah qty', 'ahmadhusain11', 1),
(21, 'DIY-TER2312170001', NULL, 'DIY', 'DIY-GUD0001', 'DIY-SUP0001', '2023-12-17', '01:11:33', 'ahmadhusain11', 1, 4, 1500000, 0, 180000, 1680000, NULL, 'ahmadhusain11', 1);

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
(69, 'DIY-PRE2312140001', 'DIY-BRG0001', '2026-12-14', 'Lifeboy (Botol)', 'DIY-SAT0002', 100, 15000, 10, 150000, 1350000),
(70, 'DIY-PRE2312140001', 'DIY-BRG0002', '2025-12-14', 'Taro (Saset)', 'DIY-SAT0003', 100, 5000, 10, 50000, 450000),
(71, 'DIY-PRE2312140001', 'DIY-BRG0003', '2026-12-14', 'Le Mineral (Botol)', 'DIY-SAT0002', 100, 3000, 0, 0, 300000);

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
(40, 'DIY-PRE2312140001', 'DIY', 'DIY-GUD0001', 'DIY-SUP0001', '2023-12-14', '18:06:02', 'ahmadhusain11', 1, 2, 2300000, 200000, 210000, 2310000, 'salah expire');

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
(13, 'DIY-RET2312170002', 'DIY-BRG0001', '2024-12-17', 'Lifeboy (Botol)', 'DIY-SAT0002', 100, 15000, 0, 0, 1500000);

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
(6, 'DIY-RET2312170001', 'DIY-TER2312140001', 'DIY', 'DIY-GUD0001', 'DIY-SUP0001', '2023-12-17', '01:10:12', 'ahmadhusain11', 1, 2, 180000, 15000, 16500, 181500, 'salah qty', 'ahmadhusain11', 1),
(7, 'DIY-RET2312170002', 'DIY-TER2312170001', 'DIY', 'DIY-GUD0001', 'DIY-SUP0001', '2023-12-17', '01:12:56', 'ahmadhusain11', 1, 4, 1500000, 0, 180000, 1680000, '', 'ahmadhusain11', 1);

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
(9, 'DIY', 'DIY-GUD0001', 'DIY-BRG0001', '2025-12-14', 1000, 10, 990),
(10, 'DIY', 'DIY-GUD0001', 'DIY-BRG0003', '2025-12-14', 1000, 10, 990),
(11, 'DIY', 'DIY-GUD0001', 'DIY-BRG0001', '2024-12-17', 100, 100, 0);

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
(23, 'Gudang', '<i class=\"fa-solid fa-warehouse nav-icon\"></i>', 'Inti/gudang', 4);

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
(1, 'ahmadhusain11', '21232f297a57a5a743894a0e4a801fc3', 'litch_98', 'P', '0895363260970', 'Mungkid, Magelang', '6b05d976ece72e5d920d8514e583e9c5.jpg', 1, 0, '2023-01-19 09:49:32', 1),
(11, 'indra', 'e24f6e3ce19ee0728ff1c443e4ff488d', 'Indra suryo', 'P', '0909', 'Mertoyudan, Magelang', 'default.png', 1, 0, '2023-01-23 13:50:21', 3),
(12, 'zaki', '9784ea3da268563469df99b2e6593564', 'Zakky Eko', 'P', '0808', 'Kajoran, Magelang', 'default.png', 1, 0, '2023-01-23 17:16:47', 3),
(15, 'riski', '6e24184c9f8092a67bcd413cbcf598da', '', 'P', '', '', 'pria.png', 1, 0, '2023-05-17 14:33:44', 2),
(16, 'shalirus', '9d5581fc0d8a4dc1512f09d5e6a8e3d9', '', 'W', '', '', 'wanita.png', 1, 0, '2023-05-17 17:15:55', 2);

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
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`);

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
  MODIFY `id_activity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `activity_user`
--
ALTER TABLE `activity_user`
  MODIFY `id_activity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303;

--
-- AUTO_INCREMENT for table `akses_cabang`
--
ALTER TABLE `akses_cabang`
  MODIFY `id_akses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `akses_menu`
--
ALTER TABLE `akses_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `id_follow` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id_gudang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `pembelian_h`
--
ALTER TABLE `pembelian_h`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `po_d`
--
ALTER TABLE `po_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `po_h`
--
ALTER TABLE `po_h`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `ppn`
--
ALTER TABLE `ppn`
  MODIFY `id_ppn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `retur_beli_d`
--
ALTER TABLE `retur_beli_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `retur_beli_h`
--
ALTER TABLE `retur_beli_h`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
