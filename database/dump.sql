CREATE TABLE `users` (
    `user_id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `first_name` VARCHAR(100) NOT NULL,
    `middle_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `contact_no` VARCHAR(100) NOT NULL,
    `verified` TINYINT(1) NOT NULL DEFAULT '0',
    `token` VARCHAR(255) DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` VARCHAR(5) NOT NULL
);

CREATE TABLE IF NOT EXISTS `table_list` (
    `table_id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `tbl_no` INTEGER NOT NULL,
    `name` INTEGER NOT NULL,
    `description` INTEGER NOT NULL,
    `coordinates` TEXT NOT NULL,
    `status` INTEGER NOT NULL DEFAULT 1,
    `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `is_delete` INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS `reservation_list` (
    `reservation_id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` TEXT NOT NULL,
    `table_id` INTEGER NOT NULL,
    `datetime` TIMESTAMP NOT NULL,
    `status` INTEGER NOT NULL DEFAULT 0,
    `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `is_delete` INTEGER NOT NULL DEFAULT 0
);