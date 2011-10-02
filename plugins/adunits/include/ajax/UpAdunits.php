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
* @File Name: UpAdunits.php
* @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*----------------------------------------------------------------------------
*/

set_include_path(get_include_path().PATH_SEPARATOR.dirname(dirname(dirname(__FILE__))));
$sDirRoot=dirname(dirname(dirname(dirname(dirname(__FILE__)))));
require_once($sDirRoot."/config/config.ajax.php");

$sAdunitsId=getRequest('adunits_id',null,'post');

$bStateError=true;
$sText='';
$sMsg=$oEngine->Lang_Get('system_error');
$sMsgTitle=$oEngine->Lang_Get('error');

if ($oEngine->User_IsAuthorization()) {

  $oUserCurrent=$oEngine->User_GetUserCurrent();
  if ($oUserCurrent->isAdministrator() or (Config::Get('config.adunits.permit.user') == 'all')){
    if($oAdunits=$oEngine->PluginAdunits_Adunits_GetAdunitsId($sAdunitsId)){
      if ($oAdunits->getAdunitsUserId() == $oUserCurrent->getUserId()){
        if($oUserCurrent->isAdministrator())
          $code = getRequest('adunits_code');
        else
          $code = $oEngine->Text_Parser(getRequest('adunits_code'));
        if (!$code){
          $sMsg=$oEngine->Lang_Get('adunits_error_no_code');
        }else{
          $oAdunits->setAdunitsCode($code);
          $oAdunits->setAdunitsSetting(getRequest('adunits_setting_viev_1',null,'post'));
          $oAdunits->setAdunitsDateEdit(date("Y-m-d H:i:s"));
          if($oEngine->PluginAdunits_Adunits_UpdAdunits($oAdunits)){
            $bStateError=false;
            $sMsgTitle=$oEngine->Lang_Get('attention');
    				$sMsg=$oEngine->Lang_Get('adunits_attention_ok');
    				$oViewerLocal=$oEngine->Viewer_GetLocalViewer();
            $oViewerLocal->Assign('oAdunits',$oAdunits);
            $HtmlEditForm = $oViewerLocal->Fetch(Plugin::GetTemplatePath('adunits').'html_edit_form.tpl');
          }
        }
      }
      else{
        $sMsg=$oEngine->Lang_Get('adunits_error_no_user');
      }
    }
    else {
      $sMsg=$oEngine->Lang_Get('adunits_error_no_id');
    }
  }
}

$GLOBALS['_RESULT'] = array(
	"bStateError" => $bStateError,
	"sText"       => $sText,
	"sMsgTitle"   => $sMsgTitle,
	"sMsg"        => $sMsg,
  "HtmlEditForm"    => $HtmlEditForm
);

?>
