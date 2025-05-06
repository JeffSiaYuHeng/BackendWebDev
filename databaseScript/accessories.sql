-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 11:24 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `backendweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE `accessories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`id`, `name`, `category`, `price`, `image`) VALUES
(1, 'Classic Lace Veil', 'Veil', 149.99, '/BackendWebDev/image/accessories/Classic-Lace-Veil.jpg'),
(2, 'Embroidered Cathedral Veil', 'Veil', 199.50, '/BackendWebDev/image/accessories/Embroidered-Cathedral-Veil.jpg'),
(3, 'Beaded Edge Veil', 'Veil', 239.99, '/BackendWebDev/image/accessories/Beaded-Edge-Veil.jpg'),
(4, 'Crystal Princess Tiara', 'Tiara', 189.99, '/BackendWebDev/image/accessories/Crystal-Princess-Tiara.jpg'),
(5, 'Gold Floral Tiara', 'Tiara', 225.75, '/BackendWebDev/image/accessories/Gold-Floral-Tiara.jpg'),
(6, 'Silver Rhinestone Tiara', 'Tiara', 249.50, '/BackendWebDev/image/accessories/Silver-Rhinestone-Tiara.jpg'),
(7, 'White Satin Heels', 'Shoes', 179.99, '/BackendWebDev/image/accessories/White-Satin-Heels.jpg'),
(8, 'Lace Wedding Flats', 'Shoes', 129.50, '/BackendWebDev/image/accessories/Lace-Wedding-Flats.jpg'),
(9, 'Pearl Embellished Sandals', 'Shoes', 210.25, '/BackendWebDev/image/accessories/Pearl-Embellished-Sandals.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
