CREATE DATABASE IF NOT EXISTS `my_bots` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `my_bots`;

CREATE TABLE IF NOT EXISTS `first_bot` (
  `user_id` varchar(255) NOT NULL,
  `wait_for_name` tinyint(1) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

