-- Add image column to items table
ALTER TABLE `items` ADD COLUMN `image` varchar(255) NULL AFTER `price`;

-- Update existing products with their image paths
UPDATE `items` SET `image` = 'cannon_eos.jpg' WHERE `name` = 'Cannon EOS';
UPDATE `items` SET `image` = 'sony_dslr.jpeg' WHERE `name` = 'Sony DSLR' AND `price` = 40000;
UPDATE `items` SET `image` = 'sony_dslr2.jpeg' WHERE `name` = 'Sony DSLR' AND `price` = 50000;
UPDATE `items` SET `image` = 'olympus.jpg' WHERE `name` = 'Olympus DSLR';
UPDATE `items` SET `image` = 'titan301.jpg' WHERE `name` = 'Titan Model #301';
UPDATE `items` SET `image` = 'titan201.jpg' WHERE `name` = 'Titan Model #201';
UPDATE `items` SET `image` = 'hmt.JPG' WHERE `name` = 'HMT Milan';
UPDATE `items` SET `image` = 'favreleuba.jpg' WHERE `name` = 'Favre Lueba #111';
UPDATE `items` SET `image` = 'raymond.jpg' WHERE `name` = 'Raymond';
UPDATE `items` SET `image` = 'charles.jpg' WHERE `name` = 'Charles';
UPDATE `items` SET `image` = 'HXR.jpg' WHERE `name` = 'HXR';
UPDATE `items` SET `image` = 'pink.jpg' WHERE `name` = 'PINK'; 