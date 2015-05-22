CREATE TABLE `sfp_platform`.`content_themes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `theme_name` VARCHAR(128) NOT NULL,
  `theme_domain` VARCHAR(128) NOT NULL,
  `created` DATETIME NULL DEFAULT NULL,
  `modified` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;
