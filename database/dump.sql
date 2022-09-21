CREATE TABLE IF NOT EXISTS `users` (
            `user_id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `username` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `verified` tinyint(1) NOT NULL DEFAULT '0',
            `token` varchar(255) DEFAULT NULL,
            `password` varchar(255) NOT NULL,
            `is_admin` INT(1) NOT NULL
        );