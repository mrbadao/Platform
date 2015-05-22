INSERT INTO `sfp_platform_setting`.`content_modules` (`module_name`, `module_type`, `module_access`, `created`, `modified`) VALUES ('PicasaWeb', 'component', 'Common', NOW(), NOW());

INSERT INTO `sfp_platform_setting`.`content_modules` (`module_name`, `module_type`, `module_access`, `created`, `modified`) VALUES ('viewRenderer', 'component', 'Common', NOW(), NOW());

INSERT INTO `sfp_platform_setting`.`content_module_attributes` (`module_id`, `attr_name`, `attr_value`, `created`, `modified`) VALUES ('1', 'class', 'ext.PicasaWebEXT', NOW(), NOW());

INSERT INTO `sfp_platform_setting`.`content_module_attributes` (`module_id`, `attr_name`, `attr_value`, `created`, `modified`) VALUES ('2', 'class', 'ext.PHPTALViewRenderer', NOW(), NOW());

INSERT INTO `sfp_platform_setting`.`content_module_attributes` (`module_id`, `attr_name`, `attr_value`, `created`, `modified`) VALUES ('2', 'fileExtension', '.html', NOW(), NOW());

INSERT INTO `sfp_platform`.`content_user_site` (`site_name`, `site_domain`, `created`, `modified`) VALUES ('mrbadao', 'mrbadao', NOW(), NOW());

INSERT INTO `sfp_platform`.`content_user_site` (`site_name`, `site_domain`, `created`, `modified`) VALUES ('hieunc', 'hieunc.dev', NOW(), NOW());

INSERT INTO `sfp_platform_setting`.`module_relation` (`module_id`, `site_id`, `created`, `modified`) VALUES ('2', '1', NOW(), NOW());

INSERT INTO `sfp_platform`.`content_themes` (`theme_name`, `theme_domain`, `created`, `modified`) VALUES ('helios', 'helios', '2015-05-22 12:25:38', '2015-05-22 12:25:38');
INSERT INTO `sfp_platform`.`content_themes` (`theme_name`, `theme_domain`, `created`, `modified`) VALUES ('strongly', 'strongly', '2015-05-22 12:25:38', '2015-05-22 12:25:38');
