CREATE DATABASE IF NOT EXISTS `hot-side`;

CREATE TABLE IF NOT EXISTS `hot-side`.`users` (
    `user_id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `first_name` VARCHAR(50) NOT NULL,
    `middle_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `contact_no` VARCHAR(12) NOT NULL,
    `verified` TINYINT(1) NOT NULL DEFAULT '0',
    `token` VARCHAR(255) DEFAULT NULL,
    `otp` INT(6) DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role_id` TINYINT(1) NOT NULL DEFAULT '0'
);

CREATE TABLE IF NOT EXISTS `hot-side`.`table_list` (
    `table_id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `table_no` INTEGER NOT NULL,
    `name` INTEGER NOT NULL,
    `description` INTEGER NOT NULL,
    `coordinates` TEXT NOT NULL,
    `status` INTEGER NOT NULL DEFAULT 1,
    `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `is_delete` INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS `hot-side`.`reservation_list` (
    `reservation_id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `table_id` INTEGER NOT NULL,
    `menu_id` INTEGER NOT NULL,
    `datetime` TIMESTAMP NOT NULL,
    `status` INTEGER NOT NULL DEFAULT 0,
    `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `is_delete` INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS `hot-side`.`role_list` (
    `role_id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `role_name` VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS `hot-side`.`contact_list` (
    `contact_id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `address` VARCHAR(50) NOT NULL,
    `phone number` VARCHAR(50) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `facebook_link` VARCHAR(50) NOT NULL,
    `twitter_link` VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS `hot-side`.`menu_list` (
    `menu_id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `type` VARCHAR(50) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `price` INT(11) NOT NULL,
    `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `is_delete` INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE `menu_variation` (
  `variation_id`  INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `menu_id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_delete` INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE `sales` (
  `sales_id`  INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `menu_id` INT(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_delete` INTEGER NOT NULL DEFAULT 0
);


