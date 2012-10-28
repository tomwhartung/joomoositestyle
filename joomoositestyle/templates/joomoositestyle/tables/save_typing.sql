#
# @author      Tom Hartung <webmaster@tomhartung.com>
# @database    MySql
# @copyright   Copyright (C) 2010 Tom Hartung. All rights reserved.
# @license     TBD
#
# 
#  sample SQL statements to update the jos_joomoositestyle table
#
## #
## # Original create table statement:
## #
## CREATE TABLE IF NOT EXISTS `jos_joomoositestyle`
## (
## 	`id` int(11) unsigned NOT NULL DEFAULT NULL AUTO_INCREMENT,
## 	`user_id`           int(11) NULL DEFAULT NULL,
## 	`ip_address`        varchar(40) NULL DEFAULT '',
## 	`background`        varchar(20) NOT NULL DEFAULT 'dark_blue',
## 	`border_color_name` varchar(20) NOT NULL DEFAULT 'grey',
## 	`border_style`      varchar(20) NOT NULL DEFAULT 'double',
## 	`border_width`      tinyint(1)  unsigned NOT NULL DEFAULT 8,
## 	`font_size`         smallint(2) unsigned NOT NULL DEFAULT 85,
## 	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
## 	PRIMARY KEY (`id`),
## 	KEY (`user_id`),
## 	KEY (`ip_address`)
## ) CHARACTER SET `utf8` COLLATE `utf8_general_ci`;
## #
## # The statements below were used to change the table into what it is today:
## #
ALTER TABLE `jos_joomoositestyle` CHANGE COLUMN `user_id` `user_id` int(11) NOT NULL DEFAULT 0 AFTER `id`;
ALTER TABLE `jos_joomoositestyle` CHANGE COLUMN `ip_address` `ip_address` varchar(40) NOT NULL DEFAULT '' AFTER `user_id`;

