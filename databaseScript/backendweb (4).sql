-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 06:11 AM
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
(1, 'Classic Lace Veil', 'Veil', 149.99, 'BackendWebDev/image/accessories/Pearl-Embellished-Sandals.jpg'),
(2, 'Embroidered Cathedral Veil', 'Veil', 199.50, 'BackendWebDev/image/accessories/embroidered_cathedral_veil.jpg'),
(3, 'Beaded Edge Veil', 'Veil', 239.99, 'BackendWebDev/image/accessories/beaded_edge_veil.jpg'),
(4, 'Crystal Princess Tiara', 'Tiara', 189.99, 'BackendWebDev/image/accessories/crystal_princess_tiara.jpg'),
(5, 'Gold Floral Tiara', 'Tiara', 225.75, 'BackendWebDev/image/accessories/gold_floral_tiara.jpg'),
(6, 'Silver Rhinestone Tiara', 'Tiara', 249.50, 'BackendWebDev/image/accessories/silver_rhinestone_tiara.jpg'),
(7, 'White Satin Heels', 'Shoes', 179.99, 'BackendWebDev/image/accessories/white_satin_heels.jpg'),
(8, 'Lace Wedding Flats', 'Shoes', 129.50, 'BackendWebDev/image/accessories/lace_wedding_flats.jpg'),
(9, 'Pearl Embellished Sandals', 'Shoes', 210.25, 'BackendWebDev/image/accessories/pearl_embellished_sandals.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

CREATE TABLE `analytics` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `search_count` int(11) DEFAULT 0,
  `visit_count` int(11) DEFAULT 0,
  `order_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `analytics`
--

INSERT INTO `analytics` (`id`, `product_id`, `search_count`, `visit_count`, `order_count`, `created_at`) VALUES
(1, 1, 0, 16, 0, '2025-04-02 13:04:18'),
(2, 2, 0, 6, 0, '2025-04-02 13:05:09'),
(3, 3, 0, 1, 0, '2025-04-02 13:11:44'),
(4, 5, 0, 1, 0, '2025-04-03 06:03:42'),
(5, 1, 1, 9, 0, '2025-04-03 06:53:24'),
(6, 5, 1, 0, 0, '2025-04-03 06:53:24'),
(7, 3, 1, 0, 0, '2025-04-03 06:53:24'),
(8, 4, 1, 1, 0, '2025-04-03 06:53:24'),
(9, 1, 1, 9, 0, '2025-04-03 06:53:42'),
(10, 5, 1, 0, 0, '2025-04-03 06:53:42'),
(11, 3, 1, 0, 0, '2025-04-03 06:53:42'),
(12, 4, 1, 1, 0, '2025-04-03 06:53:42');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `total_price`, `created_at`) VALUES
(3, 6, 3.00, '2025-03-27 00:37:20'),
(4, 7, 3.00, '2025-03-28 10:34:54');

-- --------------------------------------------------------

--
-- Table structure for table `cart_accessories`
--

CREATE TABLE `cart_accessories` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `cart_item_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `fabric` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `size`, `color`, `fabric`, `price`, `quantity`) VALUES
(13, 4, 1, 'S', 'White', 'None', 3.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `delivery_method` enum('Delivery','Collection') NOT NULL,
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `delivery_method`, `status`, `created_at`) VALUES
(1, 6, 4475.75, 'Delivery', 'Delivered', '2025-03-27 00:38:42'),
(2, 7, 8.00, 'Delivery', 'Pending', '2025-03-28 11:17:19'),
(3, 7, 3999.99, 'Delivery', 'Pending', '2025-03-28 11:20:07'),
(4, 7, 4729.99, 'Delivery', 'Pending', '2025-03-28 11:23:02'),
(5, 7, 9099.00, 'Collection', 'Pending', '2025-03-30 14:43:46'),
(6, 7, 5804.72, 'Delivery', 'Pending', '2025-03-30 14:51:56'),
(7, 6, 3.00, 'Delivery', 'Pending', '2025-04-17 01:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `order_accessories`
--

CREATE TABLE `order_accessories` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_accessories`
--

INSERT INTO `order_accessories` (`id`, `order_id`, `order_item_id`, `accessory_id`) VALUES
(1, 1, 1, 5),
(2, 3, 4, 1),
(3, 4, 5, 7),
(4, 5, 6, 2),
(5, 5, 7, 2),
(6, 6, 8, 1),
(7, 6, 8, 2),
(8, 6, 8, 3),
(9, 6, 8, 4),
(10, 6, 8, 5),
(11, 6, 8, 6);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `size` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `fabric` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `name`, `size`, `color`, `fabric`, `price`, `quantity`) VALUES
(1, 1, 2, '', 'S', 'Champagne', 'Lace', 4475.75, 1),
(2, 2, 5, '', 'L', 'Ivory', 'Lace', 4.00, 1),
(3, 2, 5, '', 'L', 'Ivory', 'Lace', 4.00, 1),
(4, 3, 1, '', 'S', 'White', 'Lace', 3999.99, 1),
(5, 4, 5, '', 'S', 'White', 'Lace', 4729.99, 1),
(6, 5, 5, '', 'S', 'White', 'None', 4699.50, 1),
(7, 5, 2, '', 'S', 'White', 'None', 4399.50, 1),
(8, 6, 5, '', 'S', 'Ivory', 'Lace', 5804.72, 1),
(9, 7, 1, '', 'S', 'Ivory', 'None', 3.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` enum('Pending','Paid','Failed','Refunded') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `user_id`, `amount`, `payment_method`, `status`, `created_at`) VALUES
(1, 1, 6, 4475.75, '', 'Paid', '2025-03-27 00:38:46'),
(2, 4, 7, 4729.99, '', 'Pending', '2025-03-28 11:27:49'),
(3, 4, 7, 4729.99, '', 'Pending', '2025-03-28 11:28:18'),
(4, 5, 7, 9099.00, '', 'Pending', '2025-03-30 14:43:50'),
(5, 6, 7, 5804.72, '', 'Pending', '2025-03-30 14:51:59'),
(6, 7, 6, 3.00, '', 'Pending', '2025-04-17 01:30:35');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `type`, `price`, `image`, `description`) VALUES
(1, 'Enchanted White Belle Dress', 'wedding dress', 3800.00, '/BackendWebDev/image/dress/dress1/dress1.jpg', 'Elegant white gown with lace details.'),
(2, 'Majestic Pearl Elegance Gown', 'wedding dress', 4200.00, '/BackendWebDev/image/dress/dress2/dress2.jpg', 'A timeless pearl-colored wedding dress.'),
(3, 'White Bow Puffy Dress', 'wedding dress', 2800.00, '/BackendWebDev/image/dress/dress3/dress3.jpg', 'A cute and stylish dress.'),
(4, 'White Satin Strapless Puff Sleeve Wedding Dress', 'wedding dress', 4000.00, '/BackendWebDev/image/dress/dress4/dress4.jpg', 'A stunning off-shoulder satin wedding gown with a delicate bow detail.'),
(5, 'Vintage White Satin Strapless Wedding Dress', 'wedding dress', 4500.00, '/BackendWebDev/image/dress/dress5/dress5.jpg', 'A luxurious strapless wedding ball gown with a structured bodice and a voluminous skirt.'),
(7, 'Build Your Own Dress', 'custom', 4800.00, NULL, 'Customize your own wedding dress from fabric to fit!');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `review_text`, `created_at`) VALUES
(1, 6, 2, 5, 'test', '2025-05-04 03:17:31'),
(2, 6, 2, 5, 'test2', '2025-05-04 03:18:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `safe_key_question` varchar(255) NOT NULL,
  `safe_key_answer` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `password`, `created_at`, `safe_key_question`, `safe_key_answer`, `role`) VALUES
(6, 'MonicaCheng', 'Lim', 'Chun Xin', 'moyasuxin@gmail.com', '+600129365933', 'Nilai University, Persiaran Kolej Bbn, Bandar Baru Nilai, Nilai, Negeri Sembilan, Malaysia', '$2y$10$OCVW64MA270S4tNLfDF1SOz4kG24ukjTtd9cal5lQ.1VRaITHwNPe', '2025-03-02 06:22:14', 'pet_name', '$2y$10$1wbKaaOP4pDXwvNo1XkF3elm9Q8kfwBGRkIcVm950MbUJ7qnrnTr.', 'user'),
(7, '1', '1', '1', '1@1.1', '+601111111', '1111', '$2y$10$JcYcncGk/PhTerMOL3ufM.RDn6hwk2f2ZkyujtyGAUKuE7ZIj7c72', '2025-03-28 09:46:42', 'pet_name', '$2y$10$r7WdeXmBGzS4.QZYEEIzd.IQ.am6SBXNvfFWZ.fg.d6MzhRUYB7Xi', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `analytics`
--
ALTER TABLE `analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_accessories`
--
ALTER TABLE `cart_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `cart_item_id` (`cart_item_id`),
  ADD KEY `accessory_id` (`accessory_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_accessories`
--
ALTER TABLE `order_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_item_id` (`order_item_id`),
  ADD KEY `accessory_id` (`accessory_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `analytics`
--
ALTER TABLE `analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart_accessories`
--
ALTER TABLE `cart_accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_accessories`
--
ALTER TABLE `order_accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `analytics`
--
ALTER TABLE `analytics`
  ADD CONSTRAINT `analytics_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_accessories`
--
ALTER TABLE `cart_accessories`
  ADD CONSTRAINT `cart_accessories_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_accessories_ibfk_2` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_accessories_ibfk_3` FOREIGN KEY (`accessory_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_accessories`
--
ALTER TABLE `order_accessories`
  ADD CONSTRAINT `order_accessories_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_accessories_ibfk_2` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_accessories_ibfk_3` FOREIGN KEY (`accessory_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
