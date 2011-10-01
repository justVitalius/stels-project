CREATE TABLE IF NOT EXISTS `prefix_categorize_blog` (
	cat_id 		int(11) unsigned NOT NULL AUTO_INCREMENT,
	blog_id    	int(11) unsigned NOT NULL,
    blog_category			varchar(255) NOT NULL,
    PRIMARY KEY(cat_id),
    FOREIGN KEY(blog_id) REFERENCES `prefix_blog`(blog_id) ON DELETE CASCADE ON UPDATE CASCADE
) Engine=InnoDB DEFAULT CHARSET=utf8;



