<?php
/*---------------------------------------------------------------------------
* @Plugin Name: Ad units
* @Plugin Id: adunits
* @Plugin URI:
* @Description: Advertise on users
* @Version: 1.0.0
* @Author: Nikolay Bishovec (netlanc)
* @Author URI: http://netlanc.net
* @LiveStreet Version: 0.4.2
* @File Name: config.php
* @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*----------------------------------------------------------------------------
*/

$config = array();

$config['table']['adunits'] = '___db.table.prefix___adunits';

Config::Set('router.page.adunits_settings', 'PluginAdunits_ActionSettings');

Config::Set('config.adunits.permit.user', 'all');

$a1 = Config::Get('block.rule_index_blog.blocks.right');
$a2 = array('adunits'=>array('params'=>array('plugin'=>'adunits'), 'priority'=>10));
Config::Set('block.rule_index_blog.blocks.right', array_merge ($a1, $a2));

return $config;
?>
