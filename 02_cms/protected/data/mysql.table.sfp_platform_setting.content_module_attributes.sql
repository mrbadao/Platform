CREATE TABLE `sfp_platform_setting`.`content_module_attributes` (
  `id`         INT          NOT NULL AUTO_INCREMENT,
  `module_id`  INT          NOT NULL,
  `attr_name`  VARCHAR(128) NOT NULL,
  `attr_value` TEXT         NOT NULL,
  `created`    DATETIME     NULL     DEFAULT NULL,
  `modified`   DATETIME     NULL     DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;
