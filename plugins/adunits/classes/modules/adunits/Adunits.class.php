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
* @File Name: Adunits.class.php
* @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*----------------------------------------------------------------------------
*/

class PluginAdunits_ModuleAdunits extends Module {

	protected $oMapper;
  protected $aBadurl = array('admin','settings','adunits_settings','openid_settings');

	public function Init() {
		$this->oMapper=Engine::GetMapper(__CLASS__);
	}


  public function InitActionAdunits() {
    $sGetAction = Router::GetAction();
    $aGetParams = Router::GetParams();
    $sGetActionEvent = Router::GetActionEvent();
    if ($sGetAction == 'my'){
      if ($sGetActionEvent){
        $oUser = $this->User_GetUserByLogin($sGetActionEvent);
        $sUserId = $oUser->getId();
      }
    }
    elseif ($sGetAction == 'blog'){
      if ($sGetActionEvent){
        $sTopicId = substr($sGetActionEvent, 0, strpos($sGetActionEvent, '.'));
        if ($oTopic = $this->Topic_GetTopicById($sTopicId)){
          $sUserId = $oTopic->getUserId();
        }
      }
    }
    if(!$sUserId){
      $sUserId = 1;
      if (in_array($sGetAction, $this->aBadurl)) return false;
      return $sUserId;
    }
    return $sUserId;
  }

  public function AdCheckCode(){
    return $this->Text_Parser(getRequest('adunits_code'));
  }

	public function AddAdunits(PluginAdunits_ModuleAdunits_EntityAdunits $oAdunits) {
		if ($sId=$this->oMapper->AddAdunits($oAdunits)) {
			//$oAdunits->setAdunitsId($sId);
			return true;
		}
		return false;
	}

	public function GetAdunitsByFilter($sUserId) {
		if ($oAdunits = $this->oMapper->GetAdunitsIdByUser($sUserId)){
      $aReturn = array();
      foreach ($oAdunits as $key => $aAdunits){
        $tAu = $aAdunits->getAdunitsSetting();
        $aReturn[$tAu][$key] = $aAdunits;
      }
      return $aReturn;
		}
    return false;
  }

	public function GetAdunitsIdByUser($sUserId) {
		return $this->oMapper->GetAdunitsIdByUser($sUserId);
	}

	public function GetAdunitsId($sAdunitsId) {
		return $this->oMapper->GetAdunitsId($sAdunitsId);
	}

  public function UpdAdunits($oAdunits) {
		return $this->oMapper->UpdAdunits($oAdunits);
	}

  public function DeleteAdunitsId($sAdunitsId) {
		return $this->oMapper->DeleteAdunitsId($sAdunitsId);
	}

}
?>
