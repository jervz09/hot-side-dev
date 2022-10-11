ALTER TABLE `hot-side`.`users`
ADD COLUMN `address` VARCHAR(255) NULL AFTER `contact_no`,
ADD COLUMN `landmark` VARCHAR(45) NULL AFTER `address`;
