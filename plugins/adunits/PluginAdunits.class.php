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
* @File Name: PluginAdunits.class.php
* @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*----------------------------------------------------------------------------
*/
if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginAdunits extends Plugin {

	public function Activate() {		
		if (!$this->isTableExists('prefix_adunits')) {
			$this->ExportSQL(dirname(__FILE__).'/dump.sql');
		}
		return true;
	}

	public function Init() {
		
	}

}
?>
