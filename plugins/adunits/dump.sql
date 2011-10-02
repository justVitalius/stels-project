CREATE TABLE `prefix_adunits` (
  `adunits_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `adunits_code` longtext character set utf8,
  `adunits_setting` text character set utf8,
  `adunits_setting_more` longtext character set utf8,
  `adunits_date_add` datetime NOT NULL,
  `adunits_date_edit` datetime NOT NULL,
  PRIMARY KEY  (`adunits_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
