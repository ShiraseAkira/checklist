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
INSERT INTO `simple_ckecklist_ml`.`checklist_items` (`id_checklist`, `name`, `description`) VALUES ('1', '301 редирект', 'Описание ...');
INSERT INTO `simple_ckecklist_ml`.`checklist_items` (`id_checklist`, `name`) VALUES ('1', '404 страница');
INSERT INTO `simple_ckecklist_ml`.`checklist_items` (`id_checklist`, `name`) VALUES ('1', 'Ошибки 5**');
INSERT INTO `simple_ckecklist_ml`.`checklist_items` (`id_checklist`, `name`, `description`) VALUES ('2', 'Тестовый элемент чеклиста с описанием и подпунктами', 'Описание подпункта');
INSERT INTO `simple_ckecklist_ml`.`checklist_items` (`id_checklist`, `name`, `description`) VALUES ('2', 'Тестовый элемент чеклиста с описанием', 'Описание подпункта Описание подпункта Описание подпункта Описание подпункта');
INSERT INTO `simple_ckecklist_ml`.`checklist_items` (`id_checklist`, `name`) VALUES ('2', 'Тестовый элемент чеклиста с подпунктами');
INSERT INTO `simple_ckecklist_ml`.`checklist_items` (`id_checklist`, `name`) VALUES ('2', 'Тестовый элемент чеклиста');



CREATE TABLE `simple_ckecklist_ml`.`checklist_subitems` (
  `id_subitem` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_item` INT UNSIGNED NOT NULL,
  `content` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_subitem`),
  INDEX `fk_subitems_items_idx` (`id_item` ASC) VISIBLE,
  CONSTRAINT `fk_subitems_items`
    FOREIGN KEY (`id_item`)
    REFERENCES `simple_ckecklist_ml`.`checklist_items` (`id_item`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);

INSERT INTO `simple_ckecklist_ml`.`checklist_subitems` (`id_item`, `content`) VALUES ('1', 'Закрыты служебные и ненужные разделы.');
INSERT INTO `simple_ckecklist_ml`.`checklist_subitems` (`id_item`, `content`) VALUES ('1', 'Заданы разные User-Agent для Яндекса и других роботов.');
INSERT INTO `simple_ckecklist_ml`.`checklist_subitems` (`id_item`, `content`) VALUES ('1', 'Задано главное зеркало для Яндекса.');
INSERT INTO `simple_ckecklist_ml`.`checklist_subitems` (`id_item`, `content`) VALUES ('1', 'Закрыты страницы с динамическими параметрами.');
INSERT INTO `simple_ckecklist_ml`.`checklist_subitems` (`id_item`, `content`) VALUES ('1', 'Указана ссылка на карту сайта для роботов');
INSERT INTO `simple_ckecklist_ml`.`checklist_subitems` (`id_item`, `content`) VALUES ('6', 'Описание подпункта');
INSERT INTO `simple_ckecklist_ml`.`checklist_subitems` (`id_item`, `content`) VALUES ('6', 'Описание еще одного подпункта');
INSERT INTO `simple_ckecklist_ml`.`checklist_subitems` (`id_item`, `content`) VALUES ('6', 'И еще одно описание');
INSERT INTO `simple_ckecklist_ml`.`checklist_subitems` (`id_item`, `content`) VALUES ('8', 'Описание подпункта');
INSERT INTO `simple_ckecklist_ml`.`checklist_subitems` (`id_item`, `content`) VALUES ('8', 'Описание еще одного подпункта');


CREATE TABLE `simple_ckecklist_ml`.`item_states` (
  `id_item_state` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` INT UNSIGNED NOT NULL,
  `id_item` INT UNSIGNED NOT NULL,
  `is_checked` TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_item_state`),
  UNIQUE KEY `id_user` (`id_user`,`id_item`),
  INDEX `fk_item_states__items_idx` (`id_item` ASC) VISIBLE,
  INDEX `fk_item_states__users_idx` (`id_user` ASC) VISIBLE,
  CONSTRAINT `fk_item_states__items`
    FOREIGN KEY (`id_item`)
    REFERENCES `simple_ckecklist_ml`.`checklist_items` (`id_item`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_states__users`
    FOREIGN KEY (`id_user`)
    REFERENCES `simple_ckecklist_ml`.`users` (`id_user`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);

CREATE TABLE `simple_ckecklist_ml`.`subitem_states` (
  `id_subitem_state` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` INT UNSIGNED NOT NULL,
  `id_subitem` INT UNSIGNED NOT NULL,
  `is_checked` TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_subitem_state`),
  UNIQUE KEY `id_user` (`id_user`,`id_subitem`),
  INDEX `fk_subitem_states__subitems_idx` (`id_subitem` ASC) VISIBLE,
  INDEX `fk_subitem_states__users_idx` (`id_user` ASC) VISIBLE,
  CONSTRAINT `fk_subitem_states__items`
    FOREIGN KEY (`id_subitem`)
    REFERENCES `simple_ckecklist_ml`.`checklist_subitems` (`id_subitem`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_subitem_states__users`
    FOREIGN KEY (`id_user`)
    REFERENCES `simple_ckecklist_ml`.`users` (`id_user`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);
