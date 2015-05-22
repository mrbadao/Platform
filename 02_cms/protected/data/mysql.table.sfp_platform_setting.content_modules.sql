CREATE TABLE `sfp_platform_setting`.`content_modules` (
  `id`            INT          NOT NULL AUTO_INCREMENT,
  `module_name`   VARCHAR(128) NOT NULL,
  `module_type`   VARCHAR(128) NOT NULL,
  `module_access` VARCHAR(45)  NULL     DEFAULT 'Common',
  `created`       DATETIME     NULL     DEFAULT NULL,
  `modified`      DATETIME     NULL     DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;
