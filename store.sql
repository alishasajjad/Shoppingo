-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 04:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin@store.com', '2025-05-29 08:34:34');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `image`, `description`, `stock`, `created_at`, `updated_at`) VALUES
(1, 'Cannon EOS', 36000, 'products/cannon_eos.jpg', 'Professional DSLR camera with high resolution', 10, '2025-05-29 08:34:34', '2025-05-29 08:40:33'),
(2, 'Sony DSLR', 40000, 'products/sony_dslr.jpeg', 'Advanced DSLR camera with 4K video', 8, '2025-05-29 08:34:34', '2025-05-29 08:40:33'),
(3, 'Sony DSLR', 50000, 'products/sony_dslr2.jpeg', 'Professional DSLR camera with advanced features', 5, '2025-05-29 08:34:34', '2025-05-29 08:40:33'),
(4, 'Olympus DSLR', 80000, 'products/olympus.jpg', 'High-end DSLR camera with weather sealing', 3, '2025-05-29 08:34:34', '2025-05-29 08:40:33'),
(5, 'Titan Model #301', 13000, 'products/titan301.jpg', 'Classic analog watch with leather strap', 15, '2025-05-29 08:34:34', '2025-05-29 08:40:33'),
(6, 'Titan Model #201', 3000, 'products/titan201.jpg', 'Digital watch with multiple features', 20, '2025-05-29 08:34:34', '2025-05-29 08:40:33'),
(7, 'HMT Milan', 800, 'products/hmt.JPG', 'Vintage style watch with mechanical movement', 12, '2025-05-29 08:34:34', '2025-05-29 09:42:33'),
(8, 'Favre Leuba #111', 18000, 'products/favreleuba.jpg', 'Luxury watch with Swiss movement', 7, '2025-05-29 08:34:34', '2025-05-29 08:40:33'),
(9, 'Raymond', 1500, 'products/raymond.jpg', 'Classic formal shirt', 25, '2025-05-29 08:34:34', '2025-05-29 08:40:33'),
(10, 'Charles', 1000, 'products/charles.jpg', 'Casual shirt with modern design', 30, '2025-05-29 08:34:34', '2025-05-29 08:40:33'),
(11, 'HXR', 900, 'products/HXR.jpg', 'Stylish casual shirt', 20, '2025-05-29 08:34:34', '2025-05-29 08:40:33'),
(12, 'PINK', 1200, 'products/pink.jpg', 'Fashionable pink shirt', 15, '2025-05-29 08:34:34', '2025-05-29 08:40:33');

-- --------------------------------------------------------

--
-- Table structure for table `order_tracking`
--

CREATE TABLE `order_tracking` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` enum('Confirmed','Processing','Shipped','Delivered','Cancelled') NOT NULL,
  `tracking_number` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_tracking`
--

INSERT INTO `order_tracking` (`id`, `order_id`, `status`, `tracking_number`, `notes`, `updated_by`, `created_at`) VALUES
(12, 41, 'Processing', NULL, '', 1, '2025-05-29 12:03:32'),
(13, 40, 'Confirmed', NULL, '', 1, '2025-05-29 12:03:34'),
(14, 42, 'Shipped', NULL, '', 1, '2025-05-29 12:07:47'),
(15, 41, 'Cancelled', NULL, '', 1, '2025-05-29 12:07:55'),
(16, 40, 'Delivered', NULL, '', 1, '2025-05-29 12:08:00'),
(17, 41, 'Confirmed', NULL, '', 1, '2025-05-29 12:09:42'),
(18, 40, 'Processing', NULL, '', 1, '2025-05-29 12:09:49'),
(19, 42, 'Shipped', NULL, '', 1, '2025-05-29 12:11:25'),
(20, 43, 'Shipped', NULL, '', 1, '2025-05-29 12:11:29'),
(21, 40, 'Cancelled', NULL, '', 1, '2025-05-29 12:12:01'),
(22, 43, 'Cancelled', NULL, '', 1, '2025-05-29 12:15:12'),
(23, 41, 'Cancelled', NULL, '', 1, '2025-05-29 12:15:44'),
(26, 49, 'Confirmed', NULL, 'Order confirmed by customer', 1, '2025-05-29 12:32:06'),
(27, 50, 'Confirmed', NULL, 'Order confirmed by customer', 1, '2025-05-29 12:33:17'),
(28, 50, 'Shipped', NULL, '', 1, '2025-05-29 12:33:54'),
(29, 49, 'Cancelled', NULL, '', 1, '2025-05-29 12:33:59'),
(30, 52, 'Confirmed', NULL, 'Order confirmed by customer', 1, '2025-05-29 12:36:40'),
(31, 53, 'Confirmed', NULL, 'Order confirmed by customer', 1, '2025-05-29 12:50:09'),
(32, 55, 'Confirmed', NULL, 'Order confirmed by customer', 1, '2025-05-29 13:23:51'),
(33, 54, 'Confirmed', NULL, 'Order confirmed by customer', 1, '2025-05-29 13:33:02'),
(34, 60, 'Confirmed', NULL, 'Order confirmed by customer', 1, '2025-05-29 13:47:25'),
(35, 60, 'Shipped', NULL, '', 1, '2025-05-29 13:48:46'),
(36, 62, 'Confirmed', NULL, 'Order confirmed by customer', 1, '2025-05-29 14:08:04'),
(37, 63, 'Confirmed', NULL, 'Order confirmed by customer', 1, '2025-05-29 14:08:10'),
(38, 63, 'Delivered', NULL, '', 1, '2025-05-29 14:08:31'),
(39, 62, 'Confirmed', NULL, '', 1, '2025-05-29 14:08:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `contact`, `city`, `address`) VALUES
(3, 'TAYYAB SAJJAD', 'devtayyabsajjad@gmail.com', '550e1bafe077ff0b0b67f4e32f29d751', '11111', 'Harappa City', 'Harappa City, Chak # 102/6A-R'),
(4, 'talha', 'talha@gmail.com', '550e1bafe077ff0b0b67f4e32f29d751', '1111111', 'hhhHH', 'HHHH'),
(6, 'customer1', 'customer@gmailcom', '550e1bafe077ff0b0b67f4e32f29d751', '12345678', 'Sahiwal', 'Dak Khana Khas, Harappa City, Chak No. 102/6A-R'),
(7, 'customer2', 'customer2@gmail.com', '550e1bafe077ff0b0b67f4e32f29d751', '11111111', 'hHH', 'HH');

-- --------------------------------------------------------

--
-- Table structure for table `users_items`
--

CREATE TABLE `users_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `status` enum('Added to cart','Confirmed','Processing','Shipped','Delivered','Cancelled') NOT NULL DEFAULT 'Added to cart',
  `quantity` int(11) NOT NULL DEFAULT 1,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_items`
--

INSERT INTO `users_items` (`id`, `user_id`, `item_id`, `status`, `quantity`, `order_date`, `total_amount`) VALUES
(40, 6, 6, 'Confirmed', 1, '2025-05-29 12:02:06', 0.00),
(41, 6, 9, 'Confirmed', 1, '2025-05-29 12:02:10', 0.00),
(42, 6, 7, 'Confirmed', 1, '2025-05-29 12:06:08', 0.00),
(43, 6, 7, 'Confirmed', 1, '2025-05-29 12:10:57', 0.00),
(45, 6, 2, 'Confirmed', 1, '2025-05-29 12:16:04', 0.00),
(46, 6, 2, 'Confirmed', 1, '2025-05-29 12:23:59', 0.00),
(47, 6, 2, 'Confirmed', 1, '2025-05-29 12:29:16', 0.00),
(49, 6, 3, 'Cancelled', 1, '2025-05-29 12:32:06', 0.00),
(50, 6, 3, 'Shipped', 1, '2025-05-29 12:33:17', 0.00),
(52, 6, 2, 'Confirmed', 1, '2025-05-29 12:36:40', 0.00),
(53, 6, 3, 'Confirmed', 1, '2025-05-29 12:50:09', 0.00),
(54, 6, 3, 'Confirmed', 4, '2025-05-29 13:33:02', 0.00),
(55, 6, 7, 'Confirmed', 1, '2025-05-29 13:23:51', 0.00),
(56, 6, 10, 'Added to cart', 1, '2025-05-29 13:32:47', 0.00),
(57, 6, 3, 'Added to cart', 1, '2025-05-29 13:38:49', 0.00),
(58, 6, 7, 'Added to cart', 1, '2025-05-29 13:42:40', 0.00),
(59, 6, 4, 'Added to cart', 1, '2025-05-29 13:43:55', 0.00),
(60, 7, 7, 'Shipped', 3, '2025-05-29 13:47:25', 0.00),
(62, 7, 7, 'Confirmed', 1, '2025-05-29 14:08:04', 0.00),
(63, 7, 5, 'Delivered', 1, '2025-05-29 14:08:10', 0.00),
(64, 7, 4, 'Added to cart', 1, '2025-05-29 14:09:12', 0.00),
(65, 7, 1, 'Added to cart', 1, '2025-05-29 14:09:15', 0.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_tracking`
--
ALTER TABLE `order_tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_items`
--
ALTER TABLE `users_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_tracking`
--
ALTER TABLE `order_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_items`
--
ALTER TABLE `users_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_tracking`
--
ALTER TABLE `order_tracking`
  ADD CONSTRAINT `order_tracking_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `users_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_tracking_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_items`
--
ALTER TABLE `users_items`
  ADD CONSTRAINT `users_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
