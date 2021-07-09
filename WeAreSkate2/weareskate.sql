-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 15, 2020 at 09:46 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weareskate`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `password` varchar(120) NOT NULL,
  `address` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `fname`, `password`, `address`, `phone`) VALUES
(1, 'emma@gmail.com', 'Emmanuel  Ajungo', '$2y$10$NhytOMBRm2o1eXRTBAO/Z.QsjFqtLpQjFyxUsWQrzPTRrZm8WTUr.', 'No. 4, Awele street Backoloi', ''),
(2, 'admin@gmail.com', 'Emmanuel  Ajungo', '$2y$10$NhytOMBRm2o1eXRTBAO/Z.QsjFqtLpQjFyxUsWQrzPTRrZm8WTUr.', 'No. 4, Awele street Backoloi', '');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` varchar(20) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(6, 'Board '),
(7, 'Head Wear'),
(3, 'Jacket'),
(5, 'Shoe'),
(2, 'Shorts'),
(1, 'T-Shirt'),
(8, 'Wheel');

-- --------------------------------------------------------

--
-- Table structure for table `contact_me`
--

DROP TABLE IF EXISTS `contact_me`;
CREATE TABLE IF NOT EXISTS `contact_me` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `gender` varchar(6) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact_me`
--

INSERT INTO `contact_me` (`id`, `email`, `fname`, `message`, `gender`, `phone`) VALUES
(1, 'emma@gmail.com', 'Emmanuel  Ajungo', 'No. 4, Awele street Backoloi', 'Male', '');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(30) NOT NULL,
  `is_main` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`product_id`, `image_path`, `is_main`) VALUES
(1, 'skateshirt1.jpg', '1'),
(1, 'skateshirt2.jpg', '0'),
(2, 'skateshoe1.jpg', '1'),
(2, 'skateshoe2.jpg', '0'),
(2, 'skateshoe3.jpg', '0'),
(2, 'skateshoe4.jpg', '0'),
(3, 'skateshirt3.jpg', '1'),
(3, 'skateshirt4.jpg', '0'),
(4, 'beanie1.jpg', '1'),
(4, 'beanie2.jpg', '0'),
(5, 'skatejacket1.jpg', '1'),
(5, 'skatejacket2.jpg', '0'),
(6, 'skatepants1.jpg', '1'),
(6, 'skatepants2.jpg', '0'),
(6, 'skatepants3.jpg', '0'),
(6, 'skatepants4.jpg', '0'),
(7, 'skatehat1.jpg', '1'),
(7, 'skatehat2.jpg', '0'),
(7, 'skatehat3.jpg', '0'),
(7, 'skatehat4.jpg', '0'),
(8, 'skateboard1.jpg', '1'),
(8, 'skateboard2.jpg', '0'),
(9, 'longboard1.jpg', '1'),
(9, 'longboard2.jpg', '0'),
(10, 'skatewheel1.jpg', '1'),
(10, 'skatewheel2.jpg', '0'),
(11, 'nikeshoe1.jpg', '1'),
(11, 'nikeshoe2.jpg', '0'),
(11, 'nikeshoe3.jpg', '0'),
(12, 'skateshirt5.jpg', '1'),
(12, 'skateshirt6.jpg', '0');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `uid` int(10) UNSIGNED NOT NULL,
  `order_id` varchar(18) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `payment_status` char(1) NOT NULL DEFAULT '0',
  `tran_id` varchar(20) DEFAULT '',
  `date` date NOT NULL DEFAULT current_timestamp(),
  `order_status` char(1) DEFAULT '0',
  KEY `uid` (`uid`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `order_id` varchar(18) NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quant` smallint(5) UNSIGNED NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `extra` varchar(50) DEFAULT '',
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `category_id` smallint(5) UNSIGNED NOT NULL,
  `featured` char(1) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `unit_price`, `category_id`, `featured`) VALUES
(1, 'Obey Eyes Icon 2 T-Shirt White', '550.00', 1, '1'),
(2, 'Vans Old Skool Black/White', '1200.00', 5, '1'),
(3, 'Thrasher Flame T-Shirt Charcoal', '550.00', 1, '1'),
(4, 'Nike SB Fisherman Beanie Medium Olive/White', '400.00', 7, '1'),
(5, 'Primitive Two-Fer Varsity Jacket Navy', '1800.00', 3, '0'),
(6, 'Carhartt WIP Master Shorts Leather Rinsed', '650.00', 2, '0'),
(7, 'Obey Royal Reversible Bucket Hat Black ', '400.00', 7, '0'),
(8, 'Baker Riley Hawk Ribbon Name B2 Shape Skateboard Deck Green 8.38', '799.00', 6, '0'),
(9, 'Long Island Breath Complete Pintail Longboard 9.85 x 41.0', '2500.00', 6, '0'),
(10, 'Tada Single T Filmer Wheel White 58mm', '350.00', 8, '0'),
(11, 'Nike SB Chron Slr Sail/Mystic Navy/Sail/Gum Light Brown', '1400.00', 2, '0'),
(12, 'Vans Kw Classic Rose T-Shirt White', '650.00', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

DROP TABLE IF EXISTS `sizes`;
CREATE TABLE IF NOT EXISTS `sizes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(10) UNSIGNED NOT NULL,
  `size` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `product_id`, `size`) VALUES
(1, 1, 'XXL'),
(2, 1, 'XL'),
(3, 1, 'Large'),
(4, 1, 'Medium'),
(5, 1, 'Small'),
(6, 3, 'XXL'),
(7, 3, 'XL'),
(8, 3, 'Large'),
(9, 3, 'Medium'),
(10, 3, 'Small'),
(11, 2, '7'),
(12, 2, '8'),
(13, 2, '9'),
(14, 2, '10'),
(15, 2, '11'),
(16, 11, '7'),
(17, 11, '8'),
(18, 11, '9'),
(19, 11, '10'),
(20, 11, '11'),
(21, 4, 'Large'),
(22, 4, 'Medium'),
(23, 4, 'Small'),
(24, 7, 'Large'),
(25, 7, 'Medium'),
(26, 7, 'Small'),
(27, 5, 'XXL'),
(28, 5, 'XL'),
(29, 5, 'Large'),
(30, 5, 'Medium'),
(31, 5, 'Small'),
(32, 6, 'XXL'),
(33, 6, 'XL'),
(34, 6, 'Large'),
(35, 6, 'Medium'),
(36, 6, 'Small'),
(37, 12, 'XXL'),
(38, 12, 'XL'),
(39, 12, 'Large'),
(40, 12, 'Medium'),
(41, 12, 'Small');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `password` varchar(120) NOT NULL,
  `address` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `fname`, `password`, `address`, `phone`) VALUES
(1, 'emma@gmail.com', 'Emmanuel  Ajungo', '$2y$10$I2x041c0TRCa3FVnUcM/0.JNAkLMDY.uITUMF8zgQMA7YQfChob4G', 'No. 4, Awele street Backoloi', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
