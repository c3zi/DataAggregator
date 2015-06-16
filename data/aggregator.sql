DROP TABLE IF EXISTS `aggregator_entry`;
DROP TABLE IF EXISTS `aggregator_user`;

CREATE TABLE `aggregator_user` (
  `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `provider_id` VARCHAR(40) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `aggregator_entry` (
  `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(6) UNSIGNED NOT NULL,
  `content` TEXT NOT NULL
) ENGINE = InnoDB;

ALTER TABLE `aggregator_entry`
  ADD CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `aggregator_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
