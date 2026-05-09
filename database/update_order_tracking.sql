-- Add updated_by column to order_tracking table
ALTER TABLE `order_tracking` 
ADD COLUMN `updated_by` int(11) NOT NULL AFTER `notes`,
ADD KEY `updated_by` (`updated_by`),
ADD CONSTRAINT `order_tracking_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

-- Update order_tracking table to include 'Confirmed' status
ALTER TABLE `order_tracking` 
MODIFY COLUMN `status` ENUM('Confirmed', 'Processing', 'Shipped', 'Delivered', 'Cancelled') NOT NULL;

-- Ensure admin table has at least one record
INSERT IGNORE INTO `admin` (`username`, `password`, `email`) 
VALUES ('admin', '0192023a7bbd73250516f069df18b500', 'admin@store.com');

-- Add created_at column if it doesn't exist
ALTER TABLE `order_tracking` 
ADD COLUMN IF NOT EXISTS `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `updated_by`; 