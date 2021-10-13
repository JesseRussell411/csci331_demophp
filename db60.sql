-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 13, 2021 at 02:56 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db60`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `user` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `friend` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`user`, `friend`) VALUES
('w', 'garfield');

-- --------------------------------------------------------

--
-- Table structure for table `marketplaceitems`
--

CREATE TABLE `marketplaceitems` (
  `user` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `price_cents` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marketplaceitems`
--

INSERT INTO `marketplaceitems` (`user`, `title`, `description`, `price_cents`) VALUES
('tim', '', '', 0),
('tim', 'all work and no play', 'makes jack a dull boy', 666),
('tim', 'asdf', 'asdf', 234),
('tim', 'fred', 'Stupid high pitched voice', 102),
('tim', 'geeves', 'My butler\'s getting very old, I don\'t want him anymore', 1055),
('tim', 'qggwegfasdgads', '', 0),
('tim', 'tom', 'I\'m selling my friend', 489),
('tim', 'tom dick or ', 'harry', 489);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `user` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pass` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`user`, `pass`) VALUES
('john', '$2y$10$tJAWHyOp/8ewc7X/uOrfoOnnK67an41M51Uku/tT.dcAGaYYbhgSi'),
('tim', '$2y$10$77h87hNKXsFhlksUbe/pgex4Uu5Wy6ApjLV6F5fTesPNEX1LWMGc.'),
('tom', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `auth` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `recip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pm` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` int(10) UNSIGNED DEFAULT NULL,
  `message` varchar(4096) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `auth`, `recip`, `pm`, `time`, `message`) VALUES
(1, 'test', 'test', '0', 1632896871, 'test message'),
(2, 'garfield', 'garfield', '0', 1633735890, 'hello world');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `user` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text` varchar(4096) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`user`, `text`) VALUES
('garfield', 'I hate mondays');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD KEY `user` (`user`(6)),
  ADD KEY `friend` (`friend`(6));

--
-- Indexes for table `marketplaceitems`
--
ALTER TABLE `marketplaceitems`
  ADD PRIMARY KEY (`user`,`title`),
  ADD KEY `user` (`user`,`title`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`user`),
  ADD KEY `user` (`user`(6));

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth` (`auth`(6)),
  ADD KEY `recip` (`recip`(6));

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD KEY `user` (`user`(6));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marketplaceitems`
--
ALTER TABLE `marketplaceitems`
  ADD CONSTRAINT `marketplaceitems_ibfk_1` FOREIGN KEY (`user`) REFERENCES `members` (`user`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
