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
  `image` varchar(255) NULL,
  `description` TEXT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Users_items table (for cart and orders)
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

-- Insert default admin user (username: admin, password: admin123)
INSERT INTO `admin` (`username`, `password`, `email`) VALUES
('admin', '0192023a7bbd73250516f069df18b500', 'admin@store.com');

-- Insert sample products
INSERT INTO `items` (`name`, `price`, `image`, `description`, `stock`) VALUES
('Cannon EOS', 36000, 'cannon_eos.jpg', 'Professional DSLR camera with high resolution', 10),
('Sony DSLR', 40000, 'sony_dslr.jpeg', 'Advanced DSLR camera with 4K video', 8),
('Sony DSLR', 50000, 'sony_dslr2.jpeg', 'Professional DSLR camera with advanced features', 5),
('Olympus DSLR', 80000, 'olympus.jpg', 'High-end DSLR camera with weather sealing', 3),
('Titan Model #301', 13000, 'titan301.jpg', 'Classic analog watch with leather strap', 15),
('Titan Model #201', 3000, 'titan201.jpg', 'Digital watch with multiple features', 20),
('HMT Milan', 8000, 'hmt.JPG', 'Vintage style watch with mechanical movement', 12),
('Favre Leuba #111', 18000, 'favreleuba.jpg', 'Luxury watch with Swiss movement', 7),
('Raymond', 1500, 'raymond.jpg', 'Classic formal shirt', 25),
('Charles', 1000, 'charles.jpg', 'Casual shirt with modern design', 30),
('HXR', 900, 'HXR.jpg', 'Stylish casual shirt', 20),
('PINK', 1200, 'pink.jpg', 'Fashionable pink shirt', 15);

-- Insert sample users
INSERT INTO `users` (`name`, `email`, `password`, `contact`, `city`, `address`) VALUES
('John Doe', 'john@example.com', '14e1b600b1fd579f47433b88e8d85291', '1234567890', 'New York', '123 Main St'),
('Jane Smith', 'jane@example.com', '14e1b600b1fd579f47433b88e8d85291', '0987654321', 'Los Angeles', '456 Oak Ave');

-- Insert sample cart items
INSERT INTO `users_items` (`user_id`, `item_id`, `status`, `quantity`, `total_amount`) VALUES
(1, 1, 'Added to cart', 1, 36000.00),
(1, 3, 'Added to cart', 2, 100000.00),
(2, 5, 'Confirmed', 1, 13000.00); 