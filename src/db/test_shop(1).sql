-- phpMyAdmin SQL Dump
-- version 4.7.0-rc1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2017 at 11:16 PM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE `Admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`id`, `name`, `email`, `password`) VALUES
(1, 'dfg', 'dfg@dfg.dfg', '$2y$11$uuFapAzWWjEJEAfLspfEGu3R1.au4W7JkNHZXP9w5Nm8.YzUJ9fKy'),
(2, 'Jan', 'example2@op.pl', '$2y$10$oMGBpY/5lrqGE8fgU0fp6e9YA40ljc0lQrXN8xcLWQVQIWNHU4P/y');

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL,
  `isCart` tinyint(1) NOT NULL DEFAULT '0',
  `paymentType` varchar(32) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `surname` varchar(256) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`id`, `user_id`, `status`, `isCart`, `paymentType`, `name`, `surname`, `address`) VALUES
(1, 1, 'paid', 0, 'cash', 'John', 'Rambo', 'USA'),
(3, 1, 'paid', 0, 'cash', 'Joe', 'Kowalsky', 'bukowa street'),
(4, 2, NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ProductPhotos`
--

CREATE TABLE `ProductPhotos` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ProductPhotos`
--

INSERT INTO `ProductPhotos` (`id`, `product_id`, `path`, `name`) VALUES
(1, 1, '/db/photos/1_PKiN.jpg', 'a'),
(2, 1, '/db/photos/2_WTT.jpg', 'b'),
(3, 1, '/db/photos/3_Zlota.jpg', 'c'),
(4, 2, '/db/photos/1_PKiN.jpg', 'd'),
(5, 2, '/db/photos/2_WTT.jpg', 'e'),
(6, 3, '/db/photos/3_Zlota.jpg', 'f'),
(7, 5, '/db/photos/1_PKiN.jpg', 'g'),
(8, 4, '/db/photos/2_WTT.jpg', 'h'),
(9, 6, '/db/photos/3_Zlota.jpg', 'i'),
(10, 3, 'path', 'k');

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `inStock` int(11) NOT NULL,
  `type` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`id`, `name`, `price`, `description`, `inStock`, `type`) VALUES
(1, 'bread', '3.35', 'very good', 6, 'breadstuff'),
(2, 'butter', '5.29', 'quite good', 3, 'dairy'),
(3, 'pen', '1.00', 'nice', 4, 'residential'),
(4, 'WTT', '122.00', 'sdgsdg', 6, 'offices'),
(5, 'pen', '1.00', 'nice', 4, 'residential'),
(6, 'lkop', '23.00', 'aasdf', 4, 'residential'),
(7, 'hotel', '2.00', 'ttrewop', 7, 'hotels'),
(8, 'bread', '3.35', 'very good', 6, 'offices'),
(9, 'butter', '5.29', 'quite good', 3, 'mixed'),
(10, 'water', '1.35', 'still', 5, 'cos');

-- --------------------------------------------------------

--
-- Table structure for table `Products_Orders`
--

CREATE TABLE `Products_Orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `fixed_price` decimal(5,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Products_Orders`
--

INSERT INTO `Products_Orders` (`id`, `product_id`, `order_id`, `fixed_price`, `quantity`) VALUES
(1, 1, 3, '2.00', 2),
(2, 2, 1, '3.00', 5),
(3, 2, 3, '2.00', 11);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `name`, `surname`, `email`, `password`, `address`) VALUES
(1, 'Michal', 'Nowak', 'example@op.pl', '$2y$10$zLCx9sq3o13F6MmvMZsI.OBuh1sTJW3CMO4KOqrMVwbf8loPN5VxG', 'bukowa'),
(2, 'Jan', 'Kowalski', 'example2@op.pl', '$2y$10$oMGBpY/5lrqGE8fgU0fp6e9YA40ljc0lQrXN8xcLWQVQIWNHU4P/y', 'lipowa'),
(3, 'Johny', 'Bravo', 'example5@op.pl', '$2y$11$1sZN1ROXAORxjiXFnuzLO.Di.UBpH8O8UBvD6qDkMvgqeRxjdfnRG', 'Sosnowa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ProductPhotos`
--
ALTER TABLE `ProductPhotos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Products_Orders`
--
ALTER TABLE `Products_Orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ProductPhotos`
--
ALTER TABLE `ProductPhotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Products_Orders`
--
ALTER TABLE `Products_Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ProductPhotos`
--
ALTER TABLE `ProductPhotos`
  ADD CONSTRAINT `ProductPhotos_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Products_Orders`
--
ALTER TABLE `Products_Orders`
  ADD CONSTRAINT `Products_Orders_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Products_Orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
