CREATE TABLE IF NOT EXISTS `prefix_company` (
  `company_id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `blog_id` INTEGER(11) UNSIGNED NOT NULL,
  `user_owner_id` INTEGER(11) UNSIGNED NOT NULL,
  `company_url` VARCHAR(200) NOT NULL DEFAULT '',
  `company_name` VARCHAR(255) NOT NULL DEFAULT '',
  `company_name_legal` VARCHAR(255) DEFAULT NULL,
  `company_description` VARCHAR(255) NOT NULL DEFAULT '',
  `company_tags` VARCHAR(255) NOT NULL DEFAULT '',
  `company_country` VARCHAR(30) DEFAULT NULL,
  `company_city` VARCHAR(30) DEFAULT NULL,
  `company_address` VARCHAR(100) DEFAULT NULL,
  `company_site` VARCHAR(100) DEFAULT NULL,
  `company_phone` VARCHAR(50) DEFAULT NULL,
  `company_fax` VARCHAR(50) DEFAULT NULL,
  `company_boss` VARCHAR(50) DEFAULT NULL,
  `company_date_basis` DATETIME DEFAULT NULL,
  `company_vacancies` TEXT DEFAULT NULL,
  `company_email` VARCHAR(50) DEFAULT NULL,
  `company_logo` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `company_logo_type` VARCHAR(5) DEFAULT NULL,
  `company_date_add` DATETIME NOT NULL,
  `company_date_edit` DATETIME DEFAULT NULL,
  `company_rating` FLOAT(9,3) NOT NULL DEFAULT '0.000',
  `company_count_workers` INTEGER(11) UNSIGNED NOT NULL DEFAULT '0',
  `company_count_vote` INTEGER(11) UNSIGNED NOT NULL DEFAULT '0',
  `company_count_feedback` INTEGER(11) UNSIGNED NOT NULL DEFAULT '0',
  `company_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `company_prefs` TEXT,
  PRIMARY KEY (`company_id`),
   KEY user_owner_id (user_owner_id),
   KEY blog_id (blog_id),
   KEY company_url (company_url),
   KEY company_name (company_name),
  CONSTRAINT prefix_company_fk FOREIGN KEY (user_owner_id) REFERENCES prefix_user (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT prefix_company_fk1 FOREIGN KEY (blog_id) REFERENCES prefix_blog (blog_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `prefix_company_city` (
  `company_id` INTEGER(11) UNSIGNED NOT NULL,
  `city_id` INTEGER(11) UNSIGNED NOT NULL,
  UNIQUE KEY `company_id` (`company_id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `prefix_company_city_fk` FOREIGN KEY (`city_id`) REFERENCES `prefix_city` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prefix_company_city_fk1` FOREIGN KEY (`company_id`) REFERENCES `prefix_company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `prefix_company_country` (
  `company_id` INTEGER(11) UNSIGNED NOT NULL,
  `country_id` INTEGER(11) UNSIGNED NOT NULL,
  UNIQUE KEY `company_id` (`company_id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `prefix_company_country_fk` FOREIGN KEY (`country_id`) REFERENCES `prefix_country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prefix_company_country_fk1` FOREIGN KEY (`company_id`) REFERENCES `prefix_company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `prefix_company_feedback` (
  `feedback_id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `feedback_pid` INTEGER(11) UNSIGNED DEFAULT NULL,
  `company_id` INTEGER(11) UNSIGNED NOT NULL,
  `user_id` INTEGER(11) UNSIGNED NOT NULL,
  `feedback_text` TEXT COLLATE utf8_general_ci NOT NULL,
  `feedback_date` DATETIME NOT NULL,
  `feedback_user_ip` VARCHAR(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `feedback_delete` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `feedback_bad` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`feedback_id`),
  KEY `company_id` (`company_id`),
  KEY `user_id` (`user_id`),
  KEY `feedback_pid` (`feedback_pid`),
  KEY `feedback_delete` (`feedback_delete`),
  KEY `feedback_date` (`feedback_date`),
  CONSTRAINT `prefix_company_feedback_fk` FOREIGN KEY (`company_id`) REFERENCES `prefix_company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prefix_company_feedback_fk1` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prefix_company_feedback_fk3` FOREIGN KEY (`feedback_pid`) REFERENCES `prefix_company_feedback` (`feedback_id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `prefix_company_tag` (
  `company_tag_id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_id` INTEGER(11) UNSIGNED NOT NULL,
  `user_id` INTEGER(11) UNSIGNED NOT NULL,
  `company_tag_text` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`company_tag_id`),
  KEY `company_id` (`company_id`),
  KEY `user_id` (`user_id`),
  KEY `company_tag_text` (`company_tag_text`),
  CONSTRAINT `prefix_company_tag_fk` FOREIGN KEY (`company_id`) REFERENCES `prefix_company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prefix_company_tag_fk1` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `prefix_company_user` (
  `company_id` INTEGER(11) UNSIGNED NOT NULL,
  `user_id` INTEGER(11) UNSIGNED NOT NULL,
  `company_user_role` TINYINT(4) UNSIGNED NOT NULL DEFAULT '0',
  KEY `user_id` (`user_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `prefix_company_vote` (
  `company_id` INTEGER(11) UNSIGNED NOT NULL,
  `user_voter_id` INTEGER(11) UNSIGNED NOT NULL,
  `vote_delta` FLOAT(9,3) NOT NULL DEFAULT '0.000',
  UNIQUE KEY `company_id_user_voter_id_uniq` (`company_id`, `user_voter_id`),
  KEY `company_id` (`company_id`),
  KEY `user_voter_id` (`user_voter_id`),
  CONSTRAINT `prefix_company_vote_fk` FOREIGN KEY (`company_id`) REFERENCES `prefix_company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prefix_company_vote_fk1` FOREIGN KEY (`user_voter_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `prefix_company_feedback_read` (
  `company_id` INTEGER(11) UNSIGNED NOT NULL,
  `user_id` INTEGER(11) UNSIGNED NOT NULL,
  `date_read` DATETIME NOT NULL,
  `feedback_count_last` INTEGER(10) UNSIGNED NOT NULL DEFAULT '0',
  `feedback_id_last` INTEGER(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `company_id_user_id` (`company_id`, `user_id`),
  KEY `company_id` (`company_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `prefix_company_feedback_read_fk` FOREIGN KEY (`company_id`) REFERENCES `prefix_company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prefix_company_feedback_read_fk1` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_bin';

ALTER TABLE `prefix_blog` MODIFY `blog_type` VARCHAR(36) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'personal';

ALTER TABLE `prefix_comment` MODIFY target_type enum('topic','talk','company','clan') DEFAULT 'topic';

ALTER TABLE `prefix_comment_online` MODIFY target_type enum('topic','talk','company','clan') DEFAULT 'topic';

