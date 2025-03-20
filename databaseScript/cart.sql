CREATE TABLE `cart_accessories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `cart_id` INT NOT NULL, -- Link to `cart` table
  `accessory_id` INT NOT NULL, -- Accessory ID
  `name` VARCHAR(255) NOT NULL, -- Accessory name
  `category` VARCHAR(255) DEFAULT NULL, -- Accessory category (e.g., Jewelry, Veil)
  `price` DECIMAL(10,2) NOT NULL, -- Accessory price
  `image` VARCHAR(255) DEFAULT NULL, -- Accessory image
  `quantity` INT DEFAULT 1, -- Quantity (user can select more than 1)
  FOREIGN KEY (`cart_id`) REFERENCES `cart`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`accessory_id`) REFERENCES `products`(`id`)
);

CREATE TABLE `cart` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL, -- Associate with a user
  `product_id` INT NOT NULL, -- Bridal gown ID
  `name` VARCHAR(255) NOT NULL, -- Bridal gown name
  `size` VARCHAR(50) DEFAULT NULL, -- Bridal size
  `color` VARCHAR(50) DEFAULT NULL, -- Bridal color
  `fabric` VARCHAR(100) DEFAULT NULL, -- Bridal fabric type
  `price` DECIMAL(10,2) NOT NULL, -- Bridal price
  `image` VARCHAR(255) DEFAULT NULL, -- Bridal image
  `quantity` INT DEFAULT 1, -- Quantity (usually 1 for gowns)
  `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
);
