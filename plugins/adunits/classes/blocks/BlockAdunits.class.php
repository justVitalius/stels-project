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
* @File Name: BlockAdunits.class.php
* @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*----------------------------------------------------------------------------
*/

class PluginAdunits_BlockAdunits extends Block {

	public function Exec() {
    if ($sUserId = $this->PluginAdunits_Adunits_InitActionAdunits()){
      if ($oAdunits = $this->PluginAdunits_Adunits_GetAdunitsByFilter($sUserId)) {
        if(empty($oAdunits['bl'])) $oAdunits = $this->PluginAdunits_Adunits_GetAdunitsByFilter(1);
        if (!empty($oAdunits['bl']))
          $this->Viewer_Assign('aAdunits', $oAdunits['bl']);
    	}
  	}
	}
	
}
?>
