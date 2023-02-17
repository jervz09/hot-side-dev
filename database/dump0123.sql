
CREATE TABLE `contact_list` (
  `contact_id` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone number` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `facebook_link` varchar(50) NOT NULL,
  `twitter_link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `menu_list` (
  `menu_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `base_menu_image` longtext NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `menu_order_list` (
  `menu_order_list` int(11) NOT NULL,
  `menu_id` int(5) NOT NULL,
  `qty` int(5) NOT NULL,
  `reservation_id` int(5) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `menu_variation` (
  `variation_id` int(11) NOT NULL,
  `menu_id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `reasons` (
  `reason_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reservation_list` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0,
  `reason` text DEFAULT NULL,
  `other_reason` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `role_list` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `table_list` (
  `table_id` int(11) NOT NULL,
  `table_no` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `coordinates` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `party_size` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` bigint(12) DEFAULT NULL,
  `profile_img` longtext NOT NULL DEFAULT '\'./uploads/default_profile.png\'',
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `contact_list`
  ADD PRIMARY KEY (`contact_id`);

ALTER TABLE `menu_list`
  ADD PRIMARY KEY (`menu_id`);

ALTER TABLE `menu_order_list`
  ADD PRIMARY KEY (`menu_order_list`);

ALTER TABLE `menu_variation`
  ADD PRIMARY KEY (`variation_id`);

ALTER TABLE `reasons`
  ADD PRIMARY KEY (`reason_id`);

ALTER TABLE `reservation_list`
  ADD PRIMARY KEY (`reservation_id`);

ALTER TABLE `role_list`
  ADD PRIMARY KEY (`role_id`);

ALTER TABLE `table_list`
  ADD PRIMARY KEY (`table_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `contact_list`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `menu_list`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `menu_order_list`
  MODIFY `menu_order_list` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

ALTER TABLE `menu_variation`
  MODIFY `variation_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `reasons`
  MODIFY `reason_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `reservation_list`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

ALTER TABLE `role_list`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `table_list`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=520;
