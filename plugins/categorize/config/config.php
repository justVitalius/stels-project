<?php
/********************************************
 * Author: Vladimir Linkevich
 * e-mail: Vladimir.Linkevich@gmail.com
 * since 2011-02-25
 ********************************************/
$config = array();
# Array of categories
$config['blog']['categories'] = array('cat1', 'cat2', 'cat3', 'cat4', 'cat5', 'cat6');
# Allow selecting 'parent' category (which has subcategories) when creating blog;
$config['blog']['AllowParentCategory'] = false;


#page with the list of blogs
$config['blog']['categorypage'] = 'blogs';
Config::Set('router.page.blogs', 'PluginCategorize_ActionCategorize');
#db settings
$config['table']['categorize_blog'] = '___db.table.prefix___categorize_blog';
return $config;
?>
