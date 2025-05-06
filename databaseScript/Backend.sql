-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2025-05-06 17:35:45
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `backendweb`
--

-- --------------------------------------------------------

--
-- 表的结构 `accessories`
--

CREATE TABLE `accessories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `accessories`
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

-- --------------------------------------------------------

--
-- 表的结构 `analytics`
--

CREATE TABLE `analytics` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `search_count` int(11) DEFAULT 0,
  `visit_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `analytics`
--

INSERT INTO `analytics` (`id`, `product_id`, `search_count`, `visit_count`, `created_at`) VALUES
(1, 1, 0, 4, '2025-05-06 15:01:46'),
(2, 3, 0, 8, '2025-05-06 15:02:12'),
(3, 7, 0, 4, '2025-05-06 15:04:07'),
(4, 2, 0, 4, '2025-05-06 15:04:52'),
(5, 5, 0, 1, '2025-05-06 15:05:04'),
(6, 7, 1, 0, '2025-05-06 15:14:31'),
(7, 1, 1, 0, '2025-05-06 15:14:31'),
(8, 2, 1, 1, '2025-05-06 15:14:31'),
(9, 5, 1, 0, '2025-05-06 15:14:31'),
(10, 3, 1, 2, '2025-05-06 15:14:31'),
(11, 4, 1, 1, '2025-05-06 15:14:31'),
(12, 1, 1, 0, '2025-05-06 15:14:41'),
(13, 1, 1, 0, '2025-05-06 15:14:51'),
(14, 3, 1, 0, '2025-05-06 15:15:04'),
(15, 3, 1, 0, '2025-05-06 15:16:40'),
(16, 3, 1, 0, '2025-05-06 15:16:42'),
(17, 3, 1, 0, '2025-05-06 15:16:57'),
(18, 3, 1, 0, '2025-05-06 15:17:14'),
(19, 3, 1, 0, '2025-05-06 15:17:14'),
(20, 3, 1, 0, '2025-05-06 15:17:38'),
(21, 4, 1, 0, '2025-05-06 15:17:53'),
(22, 4, 1, 0, '2025-05-06 15:17:58'),
(23, 4, 1, 0, '2025-05-06 15:18:03'),
(24, 2, 1, 0, '2025-05-06 15:18:14');

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `total_price`, `created_at`) VALUES
(1, 9, 5229.98, '2025-05-06 15:01:57'),
(2, 10, 5199.49, '2025-05-06 15:05:10');

-- --------------------------------------------------------

--
-- 表的结构 `cart_accessories`
--

CREATE TABLE `cart_accessories` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `cart_item_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `custom_config_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `custom_dress_configurations`
--

CREATE TABLE `custom_dress_configurations` (
  `id` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `design` varchar(50) NOT NULL,
  `length` varchar(50) NOT NULL,
  `sleeve` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `custom_dress_configurations`
--

INSERT INTO `custom_dress_configurations` (`id`, `color`, `design`, `length`, `sleeve`, `image`) VALUES
(1, 'black', 'design3', 'midi', 'sleeveless', NULL),
(2, 'black', 'design2', 'midi', 'sleeveless', NULL),
(3, 'black', 'design3', 'midi', 'sleeveless', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
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
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `delivery_method`, `status`, `created_at`) VALUES
(1, 9, 4355.73, 'Collection', 'Delivered', '2025-05-06 15:02:01'),
(2, 9, 3189.49, 'Delivery', 'Delivered', '2025-05-06 15:02:19'),
(3, 9, 5229.98, 'Collection', 'Delivered', '2025-05-06 15:04:17'),
(4, 10, 4939.49, 'Delivery', 'Delivered', '2025-05-06 15:05:11'),
(5, 10, 4999.50, 'Delivery', 'Delivered', '2025-05-06 15:05:31'),
(6, 10, 3149.49, 'Delivery', 'Delivered', '2025-05-06 15:05:42'),
(7, 10, 5199.49, 'Collection', 'Delivered', '2025-05-06 15:06:18');

-- --------------------------------------------------------

--
-- 表的结构 `order_accessories`
--

CREATE TABLE `order_accessories` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `order_accessories`
--

INSERT INTO `order_accessories` (`id`, `order_id`, `order_item_id`, `accessory_id`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 5),
(3, 1, 1, 7),
(4, 2, 2, 2),
(5, 2, 2, 4),
(7, 3, 3, 3),
(8, 3, 3, 4),
(10, 4, 4, 2),
(11, 4, 4, 3),
(13, 5, 5, 2),
(14, 6, 6, 2),
(15, 6, 6, 1),
(17, 7, 7, 1),
(18, 7, 7, 6);

-- --------------------------------------------------------

--
-- 表的结构 `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `size` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `custom_config_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `name`, `size`, `price`, `custom_config_id`, `quantity`) VALUES
(1, 1, 1, '', 'M', 4355.73, NULL, 1),
(2, 2, 3, '', 'M', 3189.49, NULL, 1),
(3, 3, 7, '', 'S', 5229.98, 1, 1),
(4, 4, 5, '', 'M', 4939.49, NULL, 1),
(5, 5, 7, '', 'S', 4999.50, 2, 1),
(6, 6, 3, '', 'S', 3149.49, NULL, 1),
(7, 7, 7, '', 'L', 5199.49, 3, 1);

-- --------------------------------------------------------

--
-- 表的结构 `payments`
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
-- 转存表中的数据 `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `user_id`, `amount`, `payment_method`, `status`, `created_at`) VALUES
(1, 1, 9, 4355.73, 'Online Banking', 'Paid', '2025-05-06 15:02:05'),
(2, 2, 9, 3189.49, 'e-Wallet', 'Paid', '2025-05-06 15:02:23'),
(3, 3, 9, 5229.98, 'e-Wallet', 'Paid', '2025-05-06 15:04:22'),
(4, 4, 10, 4939.49, 'Online Banking', 'Paid', '2025-05-06 15:05:15'),
(5, 5, 10, 4999.50, 'Online Banking', 'Paid', '2025-05-06 15:05:33'),
(6, 6, 10, 3149.49, 'Online Banking', 'Pending', '2025-05-06 15:05:45'),
(7, 7, 10, 5199.49, 'Online Banking', 'Paid', '2025-05-06 15:06:20');

-- --------------------------------------------------------

--
-- 表的结构 `products`
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
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`id`, `name`, `type`, `price`, `image`, `description`) VALUES
(1, 'Enchanted White Belle Dress', 'wedding dress', 3800.00, '/BackendWebDev/image/dress/dress1/dress1.jpg', 'Elegant white gown with lace details.'),
(2, 'Majestic Pearl Elegance Gown', 'wedding dress', 4200.00, '/BackendWebDev/image/dress/dress2/dress2.jpg', 'A timeless pearl-colored wedding dress.'),
(3, 'White Bow Puffy Dress', 'wedding dress', 2800.00, '/BackendWebDev/image/dress/dress3/dress3.jpg', 'A cute and stylish dress.'),
(4, 'White Satin Strapless Puff Sleeve Wedding Dress', 'wedding dress', 4000.00, '/BackendWebDev/image/dress/dress4/dress4.jpg', 'A stunning off-shoulder satin wedding gown with a delicate bow detail.'),
(5, 'Vintage White Satin Strapless Wedding Dress', 'wedding dress', 4500.00, '/BackendWebDev/image/dress/dress5/dress5.jpg', 'A luxurious strapless wedding ball gown with a structured bodice and a voluminous skirt.'),
(7, 'Build Your Own Dress', 'custom', 4800.00, '/BackendWebDev/image/dress/BuildYourOwnDress.png', 'Customize your own wedding dress from fabric to fit!');

-- --------------------------------------------------------

--
-- 表的结构 `reviews`
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
-- 转存表中的数据 `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `review_text`, `created_at`) VALUES
(1, 9, 7, 5, 'Absolutely stunning! This gown made me feel like a true princess on my big day. The fit was perfect and the fabric felt so luxurious.', '2025-05-06 09:09:40'),
(2, 9, 3, 3, 'I received so many compliments on my wedding dress! The lace details were breathtaking and it photographed beautifully.', '2025-05-06 09:09:53'),
(3, 9, 1, 4, 'This gown exceeded my expectations. It was elegant, comfortable, and the craftsmanship was impeccable.', '2025-05-06 09:10:04'),
(4, 10, 7, 4, 'The gown made my wedding unforgettable. Everyone kept asking where I got it!', '2025-05-06 09:12:00'),
(5, 10, 7, 5, 'Classic, flattering, and beautifully made. I’ll treasure my wedding photos forever.', '2025-05-06 09:12:11'),
(6, 10, 7, 5, 'Stunning design with just the right amount of glam. I felt like royalty.', '2025-05-06 09:12:21'),
(7, 10, 5, 4, 'I was nervous buying online, but the dress was exactly like the photos and the sizing chart was accurate!', '2025-05-06 09:12:38');

-- --------------------------------------------------------

--
-- 表的结构 `users`
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
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `password`, `created_at`, `safe_key_question`, `safe_key_answer`, `role`) VALUES
(6, 'MonicaCheng', 'Lim', 'Chun Xin', 'moyasuxin@gmail.com', '+600129365933', 'Nilai University, Persiaran Kolej Bbn, Bandar Baru Nilai, Nilai, Negeri Sembilan, Malaysia', '$2y$10$OCVW64MA270S4tNLfDF1SOz4kG24ukjTtd9cal5lQ.1VRaITHwNPe', '2025-03-02 06:22:14', 'pet_name', '$2y$10$1wbKaaOP4pDXwvNo1XkF3elm9Q8kfwBGRkIcVm950MbUJ7qnrnTr.', 'user'),
(7, '1', '1', '1', '1@1.1', '+601111111', '1111', '$2y$10$JcYcncGk/PhTerMOL3ufM.RDn6hwk2f2ZkyujtyGAUKuE7ZIj7c72', '2025-03-28 09:46:42', 'pet_name', '$2y$10$r7WdeXmBGzS4.QZYEEIzd.IQ.am6SBXNvfFWZ.fg.d6MzhRUYB7Xi', 'admin'),
(8, 'Test', 'adasds', 'asdasd', 'asdasdas@fdfaasdfa.dasfsd', '+60131231232131232', 'jsadfjasdkfjadk@fasdfasd', '$2y$10$vQBYPx/fGonXuYYjqCUGZu3O/3ZkPdk1wVDA/p9/zsqtB5RmMZNxu', '2025-05-06 04:25:11', 'mother_birth', '$2y$10$VokhdQG9oA22eFpzoF3PE.zA5YtVnybIEU23pbn56U0jUsuOWidlO', 'user'),
(9, 'sia', 'fsdfd', 'fsdfdsf', 'dsfsd@afsd.dasassd', '+60123123213213', 'dfasdfasdfadsfads', '$2y$10$KyjMIbLEn5YnBKCSwTxHRu0cI4RAEmd99UPyB2XaVwnWMXpYZWY0e', '2025-05-06 04:32:36', 'pet_name', '$2y$10$gQRvZEFhD51OdTKM16.43erLpauImZi9UUJIp48rfjdBa3AM.5yR.', 'user'),
(10, 'Chong', 'lim', 'lim', 'lim@lmi.lim', '+60792813798173', 'dasdasasdlfhkasdfkfaghsdkl', '$2y$10$mjFfvn1nDDJpo.as2llqCOWCfSZ932FjIRgA08e6M0BAHZqRrIrBq', '2025-05-06 15:04:50', 'pet_name', '$2y$10$RHsCM398X3UWLA1CYrX9EOzaD6IkEF9Lt/6dQdIsWWrvJtnCuTYVO', 'user');

--
-- 转储表的索引
--

--
-- 表的索引 `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `analytics`
--
ALTER TABLE `analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- 表的索引 `cart_accessories`
--
ALTER TABLE `cart_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `cart_item_id` (`cart_item_id`),
  ADD KEY `accessory_id` (`accessory_id`);

--
-- 表的索引 `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `custom_dress_configurations`
--
ALTER TABLE `custom_dress_configurations`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- 表的索引 `order_accessories`
--
ALTER TABLE `order_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_item_id` (`order_item_id`),
  ADD KEY `accessory_id` (`accessory_id`);

--
-- 表的索引 `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 表的索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `analytics`
--
ALTER TABLE `analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `cart_accessories`
--
ALTER TABLE `cart_accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `custom_dress_configurations`
--
ALTER TABLE `custom_dress_configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `order_accessories`
--
ALTER TABLE `order_accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用表AUTO_INCREMENT `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 限制导出的表
--

--
-- 限制表 `analytics`
--
ALTER TABLE `analytics`
  ADD CONSTRAINT `analytics_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- 限制表 `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 限制表 `cart_accessories`
--
ALTER TABLE `cart_accessories`
  ADD CONSTRAINT `cart_accessories_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_accessories_ibfk_2` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_accessories_ibfk_3` FOREIGN KEY (`accessory_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE;

--
-- 限制表 `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 限制表 `order_accessories`
--
ALTER TABLE `order_accessories`
  ADD CONSTRAINT `order_accessories_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_accessories_ibfk_2` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_accessories_ibfk_3` FOREIGN KEY (`accessory_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE;

--
-- 限制表 `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- 限制表 `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 限制表 `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
