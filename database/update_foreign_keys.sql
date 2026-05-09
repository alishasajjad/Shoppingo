-- Drop existing foreign key constraints
ALTER TABLE `users_items` 
DROP FOREIGN KEY `users_items_ibfk_1`,
DROP FOREIGN KEY `users_items_ibfk_2`;

-- Add foreign key constraints with CASCADE
ALTER TABLE `users_items` 
ADD CONSTRAINT `users_items_ibfk_1` 
FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `users_items_ibfk_2` 
FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE; 