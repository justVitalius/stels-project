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

if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginCategory extends Plugin
{

    public function Activate()
    {

	if (!$this->isTableExists('prefix_category')) {
	    $this->ExportSQL(dirname(__FILE__) . '/dump.sql');
	}

	return true;
    }

    public function Init()
    {
	
    }

    public function Deactivate()
    {
	//$this->ExportSQL(dirname(__FILE__).'/dump_deactivate.sql');
	return true;
    }

}

?>
