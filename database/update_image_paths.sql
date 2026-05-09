-- Update image paths for existing products
UPDATE items SET image = CONCAT('products/', image) WHERE image IS NOT NULL AND image NOT LIKE 'products/%';

-- Update specific products with their correct image paths
UPDATE items SET image = 'products/cannon_eos.jpg' WHERE name = 'Cannon EOS';
UPDATE items SET image = 'products/sony_dslr.jpeg' WHERE name = 'Sony DSLR' AND price = 40000;
UPDATE items SET image = 'products/sony_dslr2.jpeg' WHERE name = 'Sony DSLR' AND price = 50000;
UPDATE items SET image = 'products/olympus.jpg' WHERE name = 'Olympus DSLR';
UPDATE items SET image = 'products/titan301.jpg' WHERE name = 'Titan Model #301';
UPDATE items SET image = 'products/titan201.jpg' WHERE name = 'Titan Model #201';
UPDATE items SET image = 'products/hmt.JPG' WHERE name = 'HMT Milan';
UPDATE items SET image = 'products/favreleuba.jpg' WHERE name = 'Favre Leuba #111';
UPDATE items SET image = 'products/raymond.jpg' WHERE name = 'Raymond';
UPDATE items SET image = 'products/charles.jpg' WHERE name = 'Charles';
UPDATE items SET image = 'products/HXR.jpg' WHERE name = 'HXR';
UPDATE items SET image = 'products/pink.jpg' WHERE name = 'PINK'; 