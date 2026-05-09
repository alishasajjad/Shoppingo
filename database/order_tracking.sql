-- Create order_tracking table
CREATE TABLE IF NOT EXISTS `order_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `status` ENUM('Confirmed', 'Processing', 'Shipped', 'Delivered', 'Cancelled') NOT NULL,
  `tracking_number` varchar(50) DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `order_tracking_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `users_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_tracking_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 