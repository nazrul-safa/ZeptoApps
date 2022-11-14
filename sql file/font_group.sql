-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2022 at 05:17 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zepto`
--

-- --------------------------------------------------------

--
-- Table structure for table `font_group`
--

CREATE TABLE `font_group` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `font` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `font_group`
--

INSERT INTO `font_group` (`id`, `name`, `font`) VALUES
(24, 'Lato', 'Lato-Bold'),
(25, 'Lato', 'Lato-Thin'),
(26, 'Roboto', 'Roboto-Black'),
(27, 'Roboto', 'Roboto-Bold'),
(28, 'Roboto', 'Roboto-Light'),
(29, 'Robo_lato', 'Lato-Bold'),
(30, 'Robo_lato', 'Roboto-Bold');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `font_group`
--
ALTER TABLE `font_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `font_group`
--
ALTER TABLE `font_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
