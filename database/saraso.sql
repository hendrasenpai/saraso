-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2022 at 07:43 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saraso`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$Jw5ZB.iQ3KKIgdvpMV.qyOjl7xS5stgI1nWwJg0Bkrj5IDE9rYkrS');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `aktivitas` text NOT NULL,
  `oleh` varchar(255) DEFAULT NULL,
  `pada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama`, `harga`) VALUES
(1, 'Nasi', 3000),
(2, 'Telur Dadar', 7000),
(3, 'Ayam Goreng', 7000),
(4, 'Ayam Kecap', 7000),
(5, 'Ayam Cabe Hijo', 7000);

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id_profil` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_hp` char(13) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `status` enum('belum','batal','utang','lunas') NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_menu`
--

CREATE TABLE `transaksi_menu` (
  `id_transaksi_menu` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` text DEFAULT NULL,
  `status` enum('aktif','tidak') NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_transaksi_menu`
-- (See below for the actual view)
--
CREATE TABLE `view_transaksi_menu` (
`id_transaksi_menu` int(11)
,`id_transaksi` int(11)
,`id_menu` int(11)
,`nama` varchar(255)
,`harga` bigint(20)
,`created_on` datetime
,`created_by` varchar(100)
,`updated_on` datetime
,`updated_by` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_user_profil`
-- (See below for the actual view)
--
CREATE TABLE `view_user_profil` (
`id_user` int(11)
,`nama` varchar(255)
,`no_hp` char(13)
,`username` varchar(250)
,`password` varchar(255)
,`token` text
,`status` enum('aktif','tidak')
,`foto` text
,`created_on` datetime
,`created_by` varchar(100)
,`updated_on` datetime
,`updated_by` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_user_transaksi`
-- (See below for the actual view)
--
CREATE TABLE `view_user_transaksi` (
`id_user` int(11)
,`id_transaksi` int(11)
,`username` varchar(250)
,`status` enum('belum','batal','utang','lunas')
,`total_harga` bigint(20)
,`keterangan` text
,`created_on` datetime
,`created_by` varchar(100)
,`updated_on` datetime
,`updated_by` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure for view `view_transaksi_menu`
--
DROP TABLE IF EXISTS `view_transaksi_menu`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_transaksi_menu`  AS SELECT `a`.`id_transaksi_menu` AS `id_transaksi_menu`, `a`.`id_transaksi` AS `id_transaksi`, `a`.`id_menu` AS `id_menu`, `b`.`nama` AS `nama`, `b`.`harga` AS `harga`, `a`.`created_on` AS `created_on`, `a`.`created_by` AS `created_by`, `a`.`updated_on` AS `updated_on`, `a`.`updated_by` AS `updated_by` FROM (`transaksi_menu` `a` join `menu` `b` on(`a`.`id_menu` = `b`.`id_menu`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_user_profil`
--
DROP TABLE IF EXISTS `view_user_profil`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_user_profil`  AS SELECT `a`.`id_user` AS `id_user`, `b`.`nama` AS `nama`, `b`.`no_hp` AS `no_hp`, `a`.`username` AS `username`, `a`.`password` AS `password`, `a`.`token` AS `token`, `a`.`status` AS `status`, `b`.`foto` AS `foto`, `a`.`created_on` AS `created_on`, `a`.`created_by` AS `created_by`, `a`.`updated_on` AS `updated_on`, `a`.`updated_by` AS `updated_by` FROM (`user` `a` left join `profil` `b` on(`a`.`id_user` = `b`.`id_user`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_user_transaksi`
--
DROP TABLE IF EXISTS `view_user_transaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_user_transaksi`  AS SELECT `a`.`id_user` AS `id_user`, `b`.`id_transaksi` AS `id_transaksi`, `a`.`username` AS `username`, `b`.`status` AS `status`, `b`.`total_harga` AS `total_harga`, `b`.`keterangan` AS `keterangan`, `b`.`created_on` AS `created_on`, `b`.`created_by` AS `created_by`, `b`.`updated_on` AS `updated_on`, `b`.`updated_by` AS `updated_by` FROM (`user` `a` join `transaksi` `b` on(`a`.`id_user` = `b`.`id_user`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id_profil`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `transaksi_menu`
--
ALTER TABLE `transaksi_menu`
  ADD PRIMARY KEY (`id_transaksi_menu`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id_profil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_menu`
--
ALTER TABLE `transaksi_menu`
  MODIFY `id_transaksi_menu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
