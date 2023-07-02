CREATE SCHEMA `simple_ckecklist_ml` DEFAULT CHARACTER SET utf8mb4 ;

CREATE TABLE `simple_ckecklist_ml`.`users` (
  `id_user` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NULL,
  `password` VARCHAR(255) NULL,
  `google_id` VARCHAR(255) NULL,
  `vk_id` VARCHAR(255) NULL,
  `display_name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `google_id_UNIQUE` (`google_id` ASC) VISIBLE,
  UNIQUE INDEX `vk_id_UNIQUE` (`vk_id` ASC) VISIBLE);