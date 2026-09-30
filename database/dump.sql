-- Users table for authentication + email verification
CREATE TABLE IF NOT EXISTS `users` (
    `user_id`  INTEGER      NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `email`    VARCHAR(100) NOT NULL,
    `verified` TINYINT(1)   NOT NULL DEFAULT 0,
    `token`    VARCHAR(255) DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `is_admin` INT(1)       NOT NULL DEFAULT 0
);

-- Prevent duplicate registrations with the same email
CREATE INDEX IF NOT EXISTS `idx_users_email` ON `users` (`email`);
