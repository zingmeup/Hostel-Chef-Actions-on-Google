-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2019 at 07:15 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostel_menu`
--

-- --------------------------------------------------------

--
-- Table structure for table `female_menu`
--

CREATE TABLE `female_menu` (
  `day_id` int(1) NOT NULL,
  `breakfast` text NOT NULL,
  `lunch` text NOT NULL,
  `snacks` text NOT NULL,
  `dinner` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `female_menu`
--

INSERT INTO `female_menu` (`day_id`, `breakfast`, `lunch`, `snacks`, `dinner`) VALUES
(0, ' 1, 51, 54, 55', ' 2, 47, 50, 49, 48, 52, 53', ' 3, 55', ' 4, 47, 49, 48, 52, 5, 53'),
(1, ' 6, 7, 55', ' 8, 47, 50, 49, 48, 52, 53', ' 9, 55', '10, 11, 49, 48, 52, 12, 53'),
(2, '13, 14, 15, 16, 17, 51, 54, 55', '18, 47, 50, 49, 48, 52, 53', '19, 55', '20, 21, 22, 49, 48, 52, 53'),
(3, '23, 51, 53, 54, 55', '24, 25, 50, 49, 48, 52, 53', '26, 55', '27, 47, 49, 48, 52, 28, 53'),
(4, '29, 55, 53', '30, 47, 50, 49, 48, 52, 53', '31, 55', '32, 33, 49, 48, 52, 34, 53'),
(5, '35, 51, 53, 54, 55', '36, 47, 50, 49, 48, 52, 53', '37, 55', '38, 39, 40, 48, 52, 53'),
(6, '41, 55', '42, 47, 50, 43, 48, 52, 53', '44, 55', '45, 21, 46, 49, 48, 52, 53');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(3) NOT NULL,
  `name` varchar(64) NOT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `type`) VALUES
(1, 'Aloo Parantha', 0),
(2, 'Channa Dal', 0),
(3, 'Pastry', 0),
(4, 'Malka Masoor', 0),
(5, 'Sewayian', 0),
(6, 'Puri', 0),
(7, 'Aloo Sabzi', 0),
(8, 'Safed Lobia', 0),
(9, 'Samosa', 0),
(10, 'Dal Makhni', 0),
(11, 'Aloo Nutri', 0),
(12, 'Gulab Jamun', 0),
(13, 'Daliya', 0),
(14, 'Boiled Egg', 1),
(15, 'Banana', 0),
(16, 'Toast', 0),
(17, 'Jam', 0),
(18, 'Black Dal Tadka', 0),
(19, 'Biscuits', 0),
(20, 'Chicken', 1),
(21, 'Paneer', 0),
(22, 'Moong sabut Dal', 0),
(23, 'Onion Parantha', 0),
(24, 'Kadhai Pakoda', 0),
(25, 'Aloo Matar', 0),
(26, 'Muffins', 0),
(27, 'White Channa', 0),
(28, 'Rasgulla', 0),
(29, 'Pav Bhaji', 0),
(30, 'Arhal Dal', 0),
(31, 'Namak Pare', 0),
(32, 'Rajma', 0),
(33, 'Nutri Matar', 0),
(34, 'Suji Halwa', 0),
(35, 'Mix Parantha', 0),
(36, 'Black Channa', 0),
(37, 'Namkeen Bhujia', 0),
(38, 'Fried Rice', 0),
(39, 'Manchurian', 0),
(40, 'Moong Dhulli Dal', 0),
(41, 'Chole Bhature', 0),
(42, 'Mix Dal', 0),
(43, 'Jeera Rice', 0),
(44, 'Bread Pakoda', 0),
(45, 'Egg Curry', 1),
(46, 'Malka Masoor Dal', 0),
(47, 'Seasonal Veg', 0),
(48, 'Chappati', 0),
(49, 'Rice', 0),
(50, 'Raita', 0),
(51, 'Butter', 0),
(52, 'Salad', 0),
(53, 'Pickle', 0),
(54, 'Milk', 0),
(55, 'Tea', 0);

-- --------------------------------------------------------

--
-- Table structure for table `male_menu`
--

CREATE TABLE `male_menu` (
  `day_id` int(1) NOT NULL,
  `breakfast` text NOT NULL,
  `lunch` text NOT NULL,
  `snacks` text NOT NULL,
  `dinner` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `male_menu`
--

INSERT INTO `male_menu` (`day_id`, `breakfast`, `lunch`, `snacks`, `dinner`) VALUES
(0, ' 1, 51, 54, 55', '2, 47, 50, 49, 48, 52, 53', ' 3, 55', ' 4, 47, 49, 48, 52, 5, 53'),
(1, ' 6, 7, 55', '8, 47, 50, 49, 48, 52, 53', ' 9, 55', '10, 11, 49, 48, 52, 12, 53'),
(2, '13, 14, 15, 16, 17, 51, 54, 55', '18, 47, 50, 49, 48, 52, 53', '19, 55', '20, 21, 22, 49, 48, 52, 53'),
(3, '23, 51, 53, 54, 55', '24, 25, 50, 49, 48, 52, 53', '26, 55', '27, 47, 49, 48, 52, 28, 53'),
(4, '29, 55, 53', '30, 47, 50, 49, 48, 52, 53', '31, 55', '32, 33, 49, 48, 52, 34, 53'),
(5, '35, 51, 53, 54, 55', '36, 47, 50, 49, 48, 52, 53', '37, 55', '38, 39, 40, 48, 52, 53'),
(6, '41, 55', '42, 47, 50, 43, 48, 52, 53', '44, 55', '45, 21, 46, 49, 48, 52, 53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `female_menu`
--
ALTER TABLE `female_menu`
  ADD PRIMARY KEY (`day_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `male_menu`
--
ALTER TABLE `male_menu`
  ADD PRIMARY KEY (`day_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
