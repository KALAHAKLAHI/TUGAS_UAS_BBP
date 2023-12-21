-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2023 at 05:09 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(14, 'Livebearer'),
(15, 'Cichlid'),
(16, 'Labyrinth Fish'),
(18, ' Gourami'),
(19, 'Catfish'),
(20, 'Lamniformes'),
(21, 'Punya Saya'),
(22, 'Kendaraan'),
(24, 'waifu'),
(29, 'games'),
(30, 'Devil My Cry'),
(32, 'wkwkwk'),
(33, 'wek'),
(34, 'Butuh Duit');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `price` double NOT NULL,
  `photo` varchar(300) NOT NULL,
  `detail` text DEFAULT NULL,
  `stock_availability` enum('Habis','Tersedia') DEFAULT 'Tersedia',
  `discount_percentage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `price`, `photo`, `detail`, `stock_availability`, `discount_percentage`) VALUES
(66, 15, 'Hiu', 12, 'vsS3UR5gxsQLZMj6t6vf.jpg', '                                                                                                                                                                                ', 'Habis', 0),
(67, 16, 'Siamese Fighting Fish', 12, 'EN8v4onpkqoC4GN6HsGj.jpg', '                                            ', 'Tersedia', 0),
(68, 22, 'Pulau', 10000000, 'F2wIcRB1UamRJpIJzFgw.jpg', '                                                                                        ', 'Tersedia', 0),
(70, 24, 'Rubah', 1000000, 'B5FBSa095YCWLp89Uslh.jpg', '                                                                                        ', 'Tersedia', 0),
(72, 22, 'Motor', 15000, 'MAJ56ZvBlppRogDHD7qz.jpg', '                                            ', 'Tersedia', 40),
(79, 30, 'Dante', 50000000, 'JNr7YweDgkvmdxre1nlw.jpg', '', 'Tersedia', 15),
(80, 34, 'Rumput Camp Nou', 823000, 'pTsm56GlQghwPdlGF0xo.jpg', 'Butuh Duit Buat Bayar Utang dan Makan Anak-Anak', 'Tersedia', 0),
(82, 15, 'HIU 1', 12000, '55C5YcFUAPL0Ur9rpdl6.jpg', '', 'Tersedia', 40);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(125) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2b$10$LuBph9mb/gAg5iaS8Y1yB.LJqUNdmMwTYm4HDJfFOfsTZcaDn12yO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `category_product` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `category_product` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
