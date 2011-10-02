CREATE TABLE IF NOT EXISTS `prefix_banner` (
    `banner_id` int(5) unsigned NOT NULL auto_increment,
    `banner_name` varchar(50) character set utf8 default NULL,
    `banner_url` varchar(255) default NULL,
    `banner_image` varchar(255) character set utf8 default NULL,
    `banner_type` int(1) NOT NULL default '1',
    `banner_start_date` date default NULL,
    `banner_end_date` date default NULL,
    `banner_is_active` int(1) unsigned NOT NULL default '1',
    `bannes_is_show` int(1) unsigned NOT NULL DEFAULT '1',
    `banner_add_date` datetime default NULL,
    `banner_edit_date` datetime default NULL,
    PRIMARY KEY  (`banner_id`),
    KEY `banner_place_id` (`banner_is_active`),
    KEY `banner_name` (`banner_name`),
    KEY `banner_active` (`banner_is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `prefix_banner_pages` (
    `place_id` int(5) unsigned NOT NULL auto_increment,
    `place_name` varchar(50) character set utf8 default NULL,
    `place_url` varchar(255) character set utf8 default NULL,
    PRIMARY KEY  (`place_id`),
    KEY `place_name` (`place_name`),
    KEY `place_url` (`place_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `prefix_banner_place_holders` (
    `banner_id` int(5) unsigned NOT NULL default '0',
    `page_id` int(5) unsigned NOT NULL default '0',
    `place_type` int(1) NOT NULL default '0',
    KEY `banner_id` (`banner_id`,`page_id`,`place_type`),
    KEY `banner_id_2` (`banner_id`),
    KEY `page_id` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `prefix_banner_stats` (
    `stats_id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `banner_id` int(5) unsigned NOT NULL ,
    `view_count` int(5) unsigned NOT NULL DEFAULT '0',
    `click_count` int(5) unsigned NOT NULL DEFAULT '0',
    `stat_date` DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `prefix_banner_place_holders`
  ADD CONSTRAINT `prefix_banner_place_holders_ref_banner` FOREIGN KEY (`banner_id`) REFERENCES `prefix_banner` (`banner_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prefix_banner_place_holders_ref_page` FOREIGN KEY (`page_id`) REFERENCES `prefix_banner_pages` (`place_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `prefix_banner_stats` ADD INDEX ( `banner_id`);
ALTER TABLE `prefix_banner_stats` ADD FOREIGN KEY ( `banner_id`) REFERENCES `prefix_banner` (
`banner_id`
) ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE `prefix_banner_stats` ADD UNIQUE `stat_date` ( `banner_id` , `stat_date`);

INSERT INTO `prefix_banner_pages` (`place_id`, `place_name`, `place_url`) VALUES
(1, 'banneroid_place_global', '%'),
(2, 'banneroid_place_blogs', '/blog/%');