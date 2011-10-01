<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (v.0.4.2 and 0.5)
 *   Plugin Category (v.0.1.1)
 *   Copyright © 2011 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
  ---------------------------------------------------------
 */

$config = array();

$config['table']['category'] = '___db.table.prefix___category';
$config['table']['category_relation'] = '___db.table.prefix___category_relation';


// массив типов категорий, привязанный к экшенам
$config['aType'] = array(
    'index' => array('title' => 'Топики', 'prefix' => 'topic'),
    'topic' => array('title' => 'Топики', 'prefix' => 'topic'),
    'blog' => array('title' => 'Топики', 'prefix' => 'topic'),
);
$config['user'] = array('admin');

Config::Set('router.page.category_settings', 'PluginCategory_ActionSettings');
Config::Set('router.page.category_topic', 'PluginCategory_ActionTopic');


Config::Set('block.rule_index_blog', array(
    'action' => array(
	'index', 'blog', 'topic'
    ),
    'blocks' => array(
	'right' => array(
	    'stream' => array('priority' => 100),
	    'Category' => array('params' => array('plugin' => 'category'), 'priority' => 150),
	    'tags' => array('priority' => 50),
	    'blogs' => array('params' => array(), 'priority' => 1),
	)
    ),
    'clear' => false,
));

return $config;
?>
