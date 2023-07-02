CREATE SCHEMA `simple_ckecklist_ml` DEFAULT CHARACTER SET utf8mb4 ;

USE `simple_ckecklist_ml`;

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

CREATE TABLE `simple_ckecklist_ml`.`checklists` (
  `id_checklist` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(1023) NULL,
  PRIMARY KEY (`id_checklist`));

INSERT INTO `simple_ckecklist_ml`.`checklists` (`name`, `description`) VALUES ('Чеклист технического аудита сайта', 'Краткое пояснение(комментарий)');
INSERT INTO `simple_ckecklist_ml`.`checklists` (`name`) VALUES ('Тестовый чеклист');

CREATE TABLE `simple_ckecklist_ml`.`checklist_items` (
  `id_item` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_checklist` INT UNSIGNED NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(4095) NULL,
  PRIMARY KEY (`id_item`),
  INDEX `fk_checklist_items_checklists_idx` (`id_checklist` ASC) VISIBLE,
  CONSTRAINT `fk_checklist_items_checklists`
    FOREIGN KEY (`id_checklist`)
    REFERENCES `simple_ckecklist_ml`.`checklists` (`id_checklist`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);

INSERT INTO `simple_ckecklist_ml`.`checklist_items` (`id_checklist`, `name`, `description`) VALUES ('1', 'Robots.txt', 'Robots.txt - это специальный ... <a href=\"http://google.com\">Google</a>');
INSERT INTO `simple_ckecklist_ml`.`checklist_items` (`id_checklist`, `name`, `description`) VALUES ('1', 'Sitemap.xml', 'Описание');
