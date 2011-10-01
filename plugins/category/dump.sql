CREATE TABLE `prefix_category` (
  `category_id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) default '0',
  `target_type` enum('topic') default 'topic',
  `category_title` varchar(255) default NULL,
  `category_url` varchar(255) default NULL,
  `category_count_sub` int(11) default '0',
  `category_count_target` int(11) default '0',
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `prefix_category_relation` (
  `relation_id` int(11) NOT NULL auto_increment,
  `category_id` int(11) default NULL,
  `target_id` int(11) default NULL,
  `target_type` enum('topic') default 'topic',
  PRIMARY KEY  (`relation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
