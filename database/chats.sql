-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09 Apr 2015 pada 11.30
-- Versi Server: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chats`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `isi_pesan`
--

CREATE TABLE IF NOT EXISTS `isi_pesan` (
`id_pesan` int(11) NOT NULL,
  `pengirim` varchar(32) NOT NULL,
  `penerima` varchar(32) NOT NULL,
  `isi_pesan` text NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dibaca` tinyint(1) NOT NULL,
  `tampil` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data untuk tabel `isi_pesan`
--

INSERT INTO `isi_pesan` (`id_pesan`, `pengirim`, `penerima`, `isi_pesan`, `waktu`, `dibaca`, `tampil`) VALUES
(1, 'aries', 'nomura', 'bro', '2015-04-09 05:21:00', 1, 1),
(2, 'aries', 'nomura', 'bro', '2015-04-09 05:23:06', 1, 1),
(3, 'aries', 'nomura', 'tes', '2015-04-09 05:24:18', 1, 1),
(4, 'aries', 'nomura', 'tes', '2015-04-09 05:24:33', 1, 1),
(5, 'aries', 'nomura', 'hahah', '2015-04-09 05:24:41', 1, 1),
(6, 'aries', 'nomura', 'wew', '2015-04-09 05:26:08', 1, 1),
(7, 'aries', 'nomura', 'wew', '2015-04-09 05:26:14', 1, 1),
(8, 'aries', 'nomura', 'tes', '2015-04-09 05:27:27', 1, 1),
(9, 'nomura', 'aries', 'oi', '2015-04-09 05:33:36', 1, 1),
(10, 'aries', 'nomura', 'apo?', '2015-04-09 05:33:43', 1, 1),
(11, 'nomura', 'aries', 'oi', '2015-04-09 05:33:48', 1, 1),
(12, 'nomura', 'aries', 'oi', '2015-04-09 05:33:50', 1, 1),
(13, 'nomura', 'aries', 'oi', '2015-04-09 05:33:56', 1, 1),
(14, 'nomura', 'aries', 'hahahaha', '2015-04-09 05:33:58', 1, 1),
(15, 'aries', 'nomura', 'ho', '2015-04-09 05:38:18', 1, 1),
(16, 'aries', 'nomura', 'bro', '2015-04-09 05:38:40', 1, 1),
(17, 'aries', 'nomura', 'yt', '2015-04-09 05:39:40', 1, 1),
(18, 'aries', 'nomura', 'rt', '2015-04-09 05:40:34', 1, 1),
(19, 'aries', 'nomura', 'we', '2015-04-09 05:41:43', 1, 1),
(20, 'aries', 'nomura', 'haha', '2015-04-09 05:41:47', 1, 1),
(21, 'aries', 'nomura', 'tr', '2015-04-09 05:42:01', 1, 1),
(22, 'aries', 'nomura', 'bro', '2015-04-09 05:45:01', 1, 1),
(23, 'aries', 'nomura', 'bro', '2015-04-09 05:45:12', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE IF NOT EXISTS `pesan` (
`id_pesan` int(11) NOT NULL,
  `user1` varchar(32) NOT NULL,
  `user2` varchar(32) NOT NULL,
  `tampil` tinyint(1) NOT NULL,
  `buka` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data untuk tabel `pesan`
--

INSERT INTO `pesan` (`id_pesan`, `user1`, `user2`, `tampil`, `buka`) VALUES
(1, 'nomura', 'aries', 1, 0),
(2, 'aries', 'nomura', 1, 1),
(3, 'nomura', 'koyoko', 0, 0),
(4, 'koyoko', 'nomura', 0, 0),
(9, 'aries', 'koyoko', 0, 0),
(10, 'koyoko', 'aries', 0, 0),
(11, 'nomura', 'legia', 0, 0),
(12, 'legia', 'nomura', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`username`, `password`) VALUES
('nomura', 'fc198e7ec26fcbc753d1563b2fcc2ed6'),
('aries', 'a482921766272cebfcdad751e6244f5b'),
('koyoko', '9bbd8fbc1ff81acd3f3bfc56eedb998f'),
('legia', '22292f4756dfed68e8397e356c28b32a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `isi_pesan`
--
ALTER TABLE `isi_pesan`
 ADD PRIMARY KEY (`id_pesan`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
 ADD PRIMARY KEY (`id_pesan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `isi_pesan`
--
ALTER TABLE `isi_pesan`
MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
