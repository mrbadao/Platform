CREATE TABLE `sfp_platform_setting`.`module_relation` (
  `id`        INT      NOT NULL AUTO_INCREMENT,
  `module_id` INT      NOT NULL,
  `site_id`   INT      NOT NULL,
  `created`   DATETIME NULL     DEFAULT NULL,
  `modified`  DATETIME NULL     DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;
