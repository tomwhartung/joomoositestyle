#
# @author      Tom Hartung <webmaster@tomhartung.com>
# @database    MySql
# @copyright   Copyright (C) 2009 Tom Hartung. All rights reserved.
# @license     TBD
#
# 
#  SQL to create jos_joomoositestyle table
#  Save values by user id or (optionally) IP address
#
#  Notes:
#  ------
#  Default values specified for the styles below are really ignored in favor of the
#     values set in the back end, but I'd rather they get set to something than null
#  IP v6 uses IPs of 40 chars (max) eg. 2001:0db8:85a3:0000:0000:8a2e:0370:7334
#     leading zeros may be omitted (S/b OK) eg. 2001:db8:85a3:0:0:8a2e:370:7334
#
DROP TABLE IF EXISTS `jos_joomoositestyle`;
CREATE TABLE IF NOT EXISTS `jos_joomoositestyle`
(
	`id` int(11) unsigned NOT NULL DEFAULT NULL AUTO_INCREMENT,
	`user_id`           int(11) NOT NULL DEFAULT 0,
	`ip_address`        varchar(40) NOT NULL DEFAULT '',
	`background`        varchar(20) NOT NULL DEFAULT 'dark_blue',
	`border_color_name` varchar(20) NOT NULL DEFAULT 'grey',
	`border_style`      varchar(20) NOT NULL DEFAULT 'double',
	`border_width`      tinyint(1)  unsigned NOT NULL DEFAULT 8,
	`font_size`         smallint(2) unsigned NOT NULL DEFAULT 85,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	KEY (`user_id`),
	KEY (`ip_address`)
) CHARACTER SET `utf8` COLLATE `utf8_general_ci`;

