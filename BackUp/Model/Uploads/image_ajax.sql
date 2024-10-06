-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2014 at 08:21 AM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `image_ajax`
--
CREATE DATABASE IF NOT EXISTS `image_ajax` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `image_ajax`;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_image` varchar(250) NOT NULL,
  `thumbnail_image` varchar(250) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `original_image`, `thumbnail_image`, `ip_address`) VALUES
(1, 'wdw', 'def', 'dsf'),
(2, '1409722675.png', 'thumbnail_1409722675.png', '::1'),
(3, '2819445350.png', 'thumbnail_2819445350.png', '::1'),
(4, '4229168025.png', 'thumbnail_4229168025.png', '::1'),
(5, '5638890700.jpg', 'thumbnail_5638890700.jpg', '::1'),
(6, '1409722895.png', 'thumbnail_1409722895.png', '::1'),
(7, '2819445790.png', 'thumbnail_2819445790.png', '::1'),
(8, '4229168685.png', 'thumbnail_4229168685.png', '::1'),
(9, '5638891580.png', 'thumbnail_5638891580.png', '::1'),
(10, '8458337376.jpg', 'thumbnail_8458337376.jpg', '::1'),
(11, '1409722907.png', 'thumbnail_1409722907.png', '::1'),
(12, '2819445814.png', 'thumbnail_2819445814.png', '::1'),
(13, '4229168721.png', 'thumbnail_4229168721.png', '::1'),
(14, '5638891628.png', 'thumbnail_5638891628.png', '::1'),
(15, '7048614535.png', 'thumbnail_7048614535.png', '::1'),
(16, '8458337442.png', 'thumbnail_8458337442.png', '::1'),
(17, '1409755335.png', 'thumbnail_1409755335.png', '::1'),
(18, '2819510672.png', 'thumbnail_2819510672.png', '::1'),
(19, '4229266008.png', 'thumbnail_4229266008.png', '::1'),
(20, '5639021344.png', 'thumbnail_5639021344.png', '::1'),
(21, '7048776680.png', 'thumbnail_7048776680.png', '::1'),
(22, '8458532016.png', 'thumbnail_8458532016.png', '::1'),
(23, '9868287352.png', 'thumbnail_9868287352.png', '::1'),
(24, '1409755350.png', 'thumbnail_1409755350.png', '::1'),
(25, '1409755394.png', 'thumbnail_1409755394.png', '::1'),
(26, '2819510788.png', 'thumbnail_2819510788.png', '::1'),
(27, '4229266182.png', 'thumbnail_4229266182.png', '::1'),
(28, '5639021576.png', 'thumbnail_5639021576.png', '::1'),
(29, '7048776970.png', 'thumbnail_7048776970.png', '::1'),
(30, '8458532364.png', 'thumbnail_8458532364.png', '::1'),
(31, '9868287758.png', 'thumbnail_9868287758.png', '::1'),
(32, '1409755419.png', 'thumbnail_1409755419.png', '::1'),
(33, '2819510838.png', 'thumbnail_2819510838.png', '::1'),
(34, '4229266257.png', 'thumbnail_4229266257.png', '::1'),
(35, '5639021676.png', 'thumbnail_5639021676.png', '::1'),
(36, '7048777095.png', 'thumbnail_7048777095.png', '::1'),
(37, '8458532514.png', 'thumbnail_8458532514.png', '::1'),
(38, '9868287933.png', 'thumbnail_9868287933.png', '::1'),
(39, '1409755942.png', 'thumbnail_1409755942.png', '::1'),
(40, '2819511884.png', 'thumbnail_2819511884.png', '::1'),
(41, '4229267826.png', 'thumbnail_4229267826.png', '::1'),
(42, '5639023768.png', 'thumbnail_5639023768.png', '::1'),
(43, '7048779710.png', 'thumbnail_7048779710.png', '::1'),
(44, '8458535652.png', 'thumbnail_8458535652.png', '::1'),
(45, '9868291594.png', 'thumbnail_9868291594.png', '::1'),
(46, '1409758025.png', 'thumbnail_1409758025.png', '::1'),
(47, '2819516050.png', 'thumbnail_2819516050.png', '::1'),
(48, '4229274075.png', 'thumbnail_4229274075.png', '::1'),
(49, '5639032100.png', 'thumbnail_5639032100.png', '::1'),
(50, '7048790125.png', 'thumbnail_7048790125.png', '::1'),
(51, '8458548150.png', 'thumbnail_8458548150.png', '::1'),
(52, '9868306175.png', 'thumbnail_9868306175.png', '::1'),
(53, '1409759493.png', 'thumbnail_1409759493.png', '::1'),
(54, '2819518988.png', 'thumbnail_2819518988.png', '::1'),
(55, '4229278482.png', 'thumbnail_4229278482.png', '::1'),
(56, '5639037976.png', 'thumbnail_5639037976.png', '::1'),
(57, '7048797470.png', 'thumbnail_7048797470.png', '::1'),
(58, '8458556964.png', 'thumbnail_8458556964.png', '::1'),
(59, '9868316458.png', 'thumbnail_9868316458.png', '::1'),
(60, '1409759542.png', 'thumbnail_1409759542.png', '::1'),
(61, '2819519084.png', 'thumbnail_2819519084.png', '::1'),
(62, '4229278626.png', 'thumbnail_4229278626.png', '::1'),
(63, '5639038168.png', 'thumbnail_5639038168.png', '::1'),
(64, '7048797710.png', 'thumbnail_7048797710.png', '::1'),
(65, '8458557252.png', 'thumbnail_8458557252.png', '::1'),
(66, '9868316794.png', 'thumbnail_9868316794.png', '::1'),
(67, '1409759552.png', 'thumbnail_1409759552.png', '::1'),
(68, '1409759605.png', 'thumbnail_1409759605.png', '::1'),
(69, '2819519210.png', 'thumbnail_2819519210.png', '::1'),
(70, '4229278815.png', 'thumbnail_4229278815.png', '::1'),
(71, '5639038420.png', 'thumbnail_5639038420.png', '::1'),
(72, '7048798025.png', 'thumbnail_7048798025.png', '::1'),
(73, '8458557630.png', 'thumbnail_8458557630.png', '::1'),
(74, '1409759681.png', 'thumbnail_1409759681.png', '::1'),
(75, '2819519362.png', 'thumbnail_2819519362.png', '::1'),
(76, '1409808289.jpg', 'thumbnail_1409808289.jpg', '::1'),
(77, '1409808615.png', 'thumbnail_1409808615.png', '::1'),
(78, '2819617230.png', 'thumbnail_2819617230.png', '::1'),
(79, '4229425845.png', 'thumbnail_4229425845.png', '::1'),
(80, '5639234460.png', 'thumbnail_5639234460.png', '::1'),
(81, '1409808671.png', 'thumbnail_1409808671.png', '::1'),
(82, '2819617342.png', 'thumbnail_2819617342.png', '::1'),
(83, '4229426013.png', 'thumbnail_4229426013.png', '::1'),
(84, '5639234684.jpg', 'thumbnail_5639234684.jpg', '::1'),
(85, '1409810462.jpg', 'thumbnail_1409810462.jpg', '::1'),
(86, '1409810486.jpg', 'thumbnail_1409810486.jpg', '::1'),
(87, '1409810556.jpg', 'thumbnail_1409810556.jpg', '::1'),
(88, '1409810585.jpg', 'thumbnail_1409810585.jpg', '::1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
