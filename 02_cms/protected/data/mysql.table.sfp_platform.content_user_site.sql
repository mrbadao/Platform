CREATE TABLE `sfp_platform`.`content_user_site` (
  `id`          INT          NOT NULL AUTO_INCREMENT,
  `site_name`   VARCHAR(128) NOT NULL,
  `site_domain` VARCHAR(128) NOT NULL,
  `created`     DATETIME     NULL     DEFAULT NULL,
  `modified`    DATETIME     NULL     DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;
