-- Create database
CREATE DATABASE IF NOT EXISTS `store` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `store`;

-- Users table
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Items table
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `description` TEXT NULL,
  `image` varchar(255) NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Users_items table
CREATE TABLE `users_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `status` ENUM('Added to cart', 'Confirmed', 'Processing', 'Shipped', 'Delivered', 'Cancelled') NOT NULL DEFAULT 'Added to cart',
  `quantity` int(11) NOT NULL DEFAULT 1,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `users_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `users_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Admin table
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Order tracking table
CREATE TABLE `order_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `status` ENUM('Processing', 'Shipped', 'Delivered', 'Cancelled') NOT NULL,
  `notes` TEXT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `order_tracking_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `users_items` (`id`),
  CONSTRAINT `order_tracking_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert default admin user (username: admin, password: admin123)
INSERT INTO `admin` (`username`, `password`, `email`) VALUES
('admin', '0192023a7bbd73250516f069df18b500', 'admin@store.com');

-- Sample products
INSERT INTO `items` (`name`, `price`, `description`, `stock`) VALUES
('Samsung Galaxy S21', 69999, 'Latest Samsung smartphone with amazing camera and performance', 50),
('Apple iPhone 13', 79999, 'Powerful iPhone with A15 Bionic chip and great camera system', 30),
('Sony WH-1000XM4', 29999, 'Premium noise-cancelling headphones with exceptional sound quality', 25),
('MacBook Pro M1', 129999, 'Powerful laptop with Apple M1 chip and stunning display', 20),
('Nike Air Max', 9999, 'Comfortable and stylish running shoes', 100),
('Samsung 4K Smart TV', 49999, '55-inch 4K Smart TV with amazing picture quality', 15),
('Canon EOS R5', 299999, 'Professional mirrorless camera with 8K video capability', 10),
('Apple Watch Series 7', 39999, 'Latest Apple Watch with health monitoring features', 40),
('Bose SoundLink Mini', 14999, 'Portable Bluetooth speaker with deep bass', 35),
('Dell XPS 13', 99999, 'Premium ultrabook with InfinityEdge display', 25); 