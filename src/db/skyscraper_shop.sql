-- phpMyAdmin SQL Dump
-- version 4.7.0-rc1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 31, 2017 at 12:29 AM
-- Server version: 5.7.19-0ubuntu0.16.04.1
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
-- Database: `skyscraper_shop`
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
(1, 'dfg', 'dfg@dfg.dfg', '$2y$11$uuFapAzWWjEJEAfLspfEGu3R1.au4W7JkNHZXP9w5Nm8.YzUJ9fKy');

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE `Messages` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `message` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 1, 'not paid', 0, 'cash', 'user1', 'userski', 'kasztanowa'),
(2, 1, NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ProductGroups`
--

CREATE TABLE `ProductGroups` (
  `id` int(11) NOT NULL,
  `name` varchar(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ProductGroups`
--

INSERT INTO `ProductGroups` (`id`, `name`) VALUES
(1, 'offices'),
(2, 'residential'),
(3, 'hotels'),
(4, 'mixed');

-- --------------------------------------------------------

--
-- Table structure for table `ProductPhotos`
--

CREATE TABLE `ProductPhotos` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ProductPhotos`
--

INSERT INTO `ProductPhotos` (`id`, `product_id`, `path`) VALUES
(1, 1, '/db/photos/1_PKiN.jpg'),
(2, 1, '/db/photos/DSC03126.JPG'),
(3, 1, '/db/photos/DSC03202.JPG'),
(4, 1, '/db/photos/DSC03233.JPG'),
(5, 1, '/db/photos/DSC03273.JPG'),
(6, 2, '/db/photos/2_WTT.jpg'),
(7, 2, '/db/photos/DSC02099.JPG'),
(8, 2, '/db/photos/DSC02237.JPG'),
(9, 2, '/db/photos/DSC02375.JPG'),
(10, 2, '/db/photos/DSC02952.JPG'),
(11, 3, '/db/photos/3_Zlota.jpg'),
(12, 3, '/db/photos/DSC01964.JPG'),
(13, 3, '/db/photos/DSC02512.JPG'),
(14, 3, '/db/photos/DSC02846.JPG'),
(15, 3, '/db/photos/DSC03088.JPG'),
(16, 4, '/db/photos/4_Rondo1.jpg'),
(17, 4, '/db/photos/DSC02143.JPG'),
(18, 4, '/db/photos/DSC02411.JPG'),
(19, 4, '/db/photos/DSC02492.JPG'),
(20, 4, '/db/photos/DSC02995.JPG'),
(21, 5, '/db/photos/5_Mariot.jpg'),
(22, 5, '/db/photos/DSC01986.JPG'),
(23, 5, '/db/photos/DSC02525.JPG'),
(24, 5, '/db/photos/DSC02868.JPG'),
(25, 5, '/db/photos/DSC03098.JPG'),
(26, 6, '/db/photos/6_WCF.jpg'),
(27, 6, '/db/photos/DSC01931.JPG'),
(28, 6, '/db/photos/DSC02498.JPG'),
(29, 6, '/db/photos/DSC02824.JPG'),
(30, 6, '/db/photos/DSC03064.JPG'),
(31, 7, '/db/photos/7_Intercontinental.jpg'),
(32, 7, '/db/photos/DSC01948.JPG'),
(33, 7, '/db/photos/DSC02502.JPG'),
(34, 7, '/db/photos/DSC02835.JPG'),
(35, 7, '/db/photos/DSC03075.JPG'),
(36, 8, '/db/photos/8_Cosmopolitan.jpg'),
(37, 8, '/db/photos/DSC01923.JPG'),
(38, 8, '/db/photos/DSC02465.JPG'),
(39, 8, '/db/photos/DSC02818.JPG'),
(40, 8, '/db/photos/DSC03060.JPG'),
(41, 9, '/db/photos/9_OxfordTower.jpg'),
(42, 9, '/db/photos/DSC01999.JPG'),
(43, 9, '/db/photos/DSC02434.JPG'),
(44, 9, '/db/photos/DSC02537.JPG'),
(45, 9, '/db/photos/DSC02885.JPG'),
(46, 10, '/db/photos/10_IntracoI.jpg'),
(47, 10, '/db/photos/DSC02157.JPG'),
(48, 10, '/db/photos/DSC02324.JPG'),
(49, 10, '/db/photos/DSC02586.JPG'),
(50, 10, '/db/photos/DSC02784.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `description` text NOT NULL,
  `inStock` int(11) NOT NULL,
  `productGroup_id` int(11) DEFAULT NULL,
  `del_by_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`id`, `name`, `price`, `description`, `inStock`, `productGroup_id`, `del_by_admin`) VALUES
(1, 'The Palace of Culture and Science', '1.00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', 10, 4, 0),
(2, 'Warsaw Trade Tower', '1.00', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.', 10, 1, 0),
(3, 'ZÅ‚ota 44', '1.00', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.', 10, 2, 0),
(4, 'Rondo 1', '1.00', 'Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Maecenas malesuada elit lectus felis, malesuada ultricies. Curabitur et ligula. Ut molestie a, ultricies porta urna. Vestibulum commodo volutpat a, convallis ac, laoreet enim. Phasellus fermentum in, dolor. Pellentesque facilisis. Nulla imperdiet sit amet magna. Vestibulum dapibus, mauris nec malesuada fames ac turpis velit, rhoncus eu, luctus et interdum adipiscing wisi. Aliquam erat ac ipsum. Integer aliquam purus.', 9, 1, 0),
(5, 'Hotel Mariott', '1.00', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus', 10, 3, 0),
(6, 'Warsaw Financial Center', '1.00', 'omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 10, 1, 0),
(7, 'InterContinental', '1.00', 'Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Maecenas malesuada elit lectus felis, malesuada ultricies. Curabitur et ligula. Ut molestie a, ultricies porta urna. Vestibulum commodo volutpat a, convallis ac, laoreet enim. Phasellus fermentum in, dolor. Pellentesque facilisis. Nulla imperdiet sit amet magna. Vestibulum dapibus, mauris nec malesuada fames ac turpis velit, rhoncus eu, luctus et interdum adipiscing wisi. Aliquam erat ac ipsum. Integer aliquam purus.', 10, 3, 0),
(8, 'Cosmopolitan', '1.00', 'Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Maecenas malesuada elit lectus felis, malesuada ultricies. Curabitur et ligula. Ut molestie a, ultricies porta urna. Vestibulum commodo volutpat a, convallis ac, laoreet enim. Phasellus fermentum in, dolor. Pellentesque facilisis. Nulla imperdiet sit amet magna. Vestibulum dapibus, mauris nec malesuada fames ac turpis velit, rhoncus eu, luctus et interdum adipiscing wisi. Aliquam erat ac ipsum. Integer aliquam purus.', 10, 2, 0),
(9, 'Oxford Tower', '1.00', 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur', 10, 1, 0),
(10, 'Intraco I', '1.00', 'cati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis', 3, 1, 0);

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
(1, 10, 1, '1.00', 7),
(2, 4, 1, '1.00', 1),
(3, 5, 2, '1.00', 1),
(4, 3, 2, '1.00', 1);

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
(1, 'user1', 'userski', 'user1@host.pl', '$2y$11$MfY7/Xg6bRfsp.vtFPBM2uIyVFxEu6Lg9Y05f/7scjxnEn0s299ea', 'kasztanowa');

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
-- Indexes for table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ProductGroups`
--
ALTER TABLE `ProductGroups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ProductPhotos`
--
ALTER TABLE `ProductPhotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ProductPhotos_ibfk_1` (`product_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Messages`
--
ALTER TABLE `Messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ProductGroups`
--
ALTER TABLE `ProductGroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ProductPhotos`
--
ALTER TABLE `ProductPhotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Products_Orders`
--
ALTER TABLE `Products_Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ProductPhotos`
--
ALTER TABLE `ProductPhotos`
  ADD CONSTRAINT `ProductPhotos_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
