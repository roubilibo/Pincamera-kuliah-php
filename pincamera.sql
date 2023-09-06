-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 27, 2017 at 12:08 
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pincamera`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Nature'),
(2, 'People'),
(3, 'Technology'),
(4, 'Arts'),
(5, 'Character'),
(6, 'Interior'),
(7, 'Exterior'),
(8, 'Gadget'),
(11, 'Culture');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_post` int(3) DEFAULT NULL,
  `komentar` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id_user` int(11) NOT NULL,
  `nama_depan` varchar(30) NOT NULL,
  `nama_belakang` varchar(30) NOT NULL,
  `status` text NOT NULL,
  `location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id_user`, `nama_depan`, `nama_belakang`, `status`, `location`) VALUES
(2, 'Budi', 'Santoso', '', 'profil/1st_Guardians.PNG'),
(3, 'Joko', 'Susilo', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitat.', 'profil/a4.jpg'),
(0, 'admin', 'pincamera', 'Selaku admin, semoga bisa memberi yang terbaik', 'profil/logo.png'),
(4, 'M. Roubil', 'Ridlo', 'Uang masih bisa dicari, berbeda dengan investasi teman', 'profil/a1.jpg'),
(1, 'user', 'pincamera', 'Tanpa status', '');

-- --------------------------------------------------------

--
-- Table structure for table `upload`
--

CREATE TABLE `upload` (
  `id_post` int(3) NOT NULL,
  `judul_post` varchar(50) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tag` text NOT NULL,
  `name` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  `location` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `suka` int(9) NOT NULL,
  `lihat` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upload`
--

INSERT INTO `upload` (`id_post`, `judul_post`, `id_kategori`, `keterangan`, `tag`, `name`, `size`, `location`, `id_user`, `suka`, `lihat`) VALUES
(3, 'Owl', 1, 'Owl at Night', '', 'dfd4e9f8041ba50abe9883c2cad5132b.jpg', 50054, 'data/dfd4e9f8041ba50abe9883c2cad5132b.jpg', 0, 0, 4),
(5, 'Free to Play', 3, 'Hyhy', '', '1535508_755119591210147_7681114764032536499_n.jpg', 14052, 'data/1535508_755119591210147_7681114764032536499_n.jpg', 0, 0, 4),
(6, 'Mac OS', 3, 'This is the mockup of iMac, with Mac OS X', '#admin', 'imac-gallery1-2015.jpg', 605277, 'data/imac-gallery1-2015.jpg', 0, 0, 0),
(7, 'Samurai', 2, 'Japan Samurai', '', '98545cd716557aadbd985581a92c93e1.jpg', 16616, 'data/98545cd716557aadbd985581a92c93e1.jpg', 0, 0, 0),
(8, 'DoTA ', 4, 'This is the Defend of The Ancients ', '', '65046_458891447479817_1054062773_n.jpg', 90082, 'data/65046_458891447479817_1054062773_n.jpg', 1, 0, 0),
(9, 'Random', 4, 'Random art for your inspiration', '#vongola#art#character#decimo#tsuna', '1st_Guardians.PNG', 755405, 'data/1st_Guardians.PNG', 3, 0, 0),
(11, 'Graffity', 4, 'Graffity character vector', '#graffity#art#character', '56375-cute-kid-spraypaint-vandal.jpg', 60713, 'data/56375-cute-kid-spraypaint-vandal.jpg', 4, 0, 0),
(12, 'Web Template', 3, 'This is the Cesis freebie for your web template', '#web#template#ui#design#graphic#graphicdesigner', 'Cesis Free Sample.jpg', 4195181, 'data/Cesis Free Sample.jpg', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(90) NOT NULL,
  `password` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`) VALUES
(0, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(1, 'user', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'budi19', '00dfc53ee86af02e742515cdcf075ed3'),
(3, 'joko69', '9ba0009aa81e794e628a04b51eaf7d7f'),
(4, 'roubilibo', '121118a7c64ab3f879fa8f3856e39334');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_post` (`id_post`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `upload`
--
ALTER TABLE `upload`
  MODIFY `id_post` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `upload` (`id_post`) ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE;

--
-- Constraints for table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `upload`
--
ALTER TABLE `upload`
  ADD CONSTRAINT `upload_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
