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

-- Modify items table to add more fields
ALTER TABLE `items` 
ADD COLUMN `description` TEXT NULL AFTER `price`,
ADD COLUMN `image` VARCHAR(255) NULL AFTER `description`,
ADD COLUMN `stock` INT NOT NULL DEFAULT 0 AFTER `image`,
ADD COLUMN `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Modify users_items table to add order status
ALTER TABLE `users_items` 
MODIFY COLUMN `status` ENUM('Added to cart', 'Confirmed', 'Processing', 'Shipped', 'Delivered', 'Cancelled') NOT NULL DEFAULT 'Added to cart',
ADD COLUMN `quantity` INT NOT NULL DEFAULT 1 AFTER `item_id`,
ADD COLUMN `order_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN `total_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00;

-- Add order tracking table
CREATE TABLE `order_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `status` ENUM('Processing', 'Shipped', 'Delivered', 'Cancelled') NOT NULL,
  `notes` TEXT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `order_tracking_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `users_items` (`id`),
  CONSTRAINT `order_tracking_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 