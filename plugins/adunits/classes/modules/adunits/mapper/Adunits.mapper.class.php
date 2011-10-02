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
* @File Name: Adunits.mapper.class.php
* @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*----------------------------------------------------------------------------
*/

class PluginAdunits_ModuleAdunits_MapperAdunits extends Mapper {

	public function GetAdunitsIdByUser($sUserId) {
		$sql = "SELECT * FROM ".Config::Get('plugin.adunits.table.adunits')." WHERE user_id = ? ";
		$aCollection=array();
		if ($aRows=$this->oDb->select($sql,$sUserId)) {
			foreach ($aRows as $aRow) {
				$aCollection[]=Engine::GetEntity('PluginAdunits_Adunits',$aRow);
			}
		}
		return $aCollection;
	}

	public function AddAdunits(PluginAdunits_ModuleAdunits_EntityAdunits $oAdunits) {
		$sql = "INSERT INTO ".Config::Get('plugin.adunits.table.adunits')."
			(
        user_id,
  			adunits_code,
  			adunits_setting,
  			adunits_date_add
			)
			VALUES(?d, ?,	?,	?)
		";
		if ($iId=$this->oDb->query($sql,$oAdunits->getAdunitsUserId(),$oAdunits->getAdunitsCode(),$oAdunits->getAdunitsSetting(),$oAdunits->getAdunitsDateAdd())){
			return $iId;
		}
		return false;
	}

  public function GetAdunitsId($sAdunitsId) {
		$sql = "SELECT * FROM ".Config::Get('plugin.adunits.table.adunits')." WHERE adunits_id = ? ";
		if ($aRow=$this->oDb->selectRow($sql,$sAdunitsId)) {
			return Engine::GetEntity('PluginAdunits_Adunits',$aRow);
		}
		return null;
	}

  public function UpdAdunits($oAdunits) {
    $sql = "update ".Config::Get('plugin.adunits.table.adunits')."
            set
              adunits_code = ?,
              adunits_setting = ?,
              adunits_date_edit = ?
            where adunits_id = ?d";

    if ($this->oDb->query($sql,$oAdunits->getAdunitsCode(),$oAdunits->getAdunitsSetting(),$oAdunits->getAdunitsDateEdit(),$oAdunits->getAdunitsId())){
			return true;
		}
		return false;
	}

  public function DeleteAdunitsId($sAdunitsId) {
		$sql = "DELETE FROM ".Config::Get('plugin.adunits.table.adunits')." WHERE `adunits_id` = ? ";
		return $this->oDb->query($sql,$sAdunitsId);
	}

}
?>
