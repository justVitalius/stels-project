<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*
*	Module "Company"
*	Author: Grebenkin Anton 
*	Contact e-mail: 4freework@gmail.com
*
---------------------------------------------------------
*/

/**
 * Получение новых комментов
 */

set_include_path(get_include_path().PATH_SEPARATOR.dirname(dirname(dirname(__FILE__))));
$sDirRoot=dirname(dirname(dirname(dirname(dirname(__FILE__)))));
require_once($sDirRoot."/config/config.ajax.php");

$idCommentLast=getRequest('idCommentLast',null,'post');
$idTopic=getRequest('idTarget',null,'post');
$bStateError=true;
$sMsg='';
$sMsgTitle='';
$iMaxIdComment=0;
$aComments=array();
if ($oEngine->User_IsAuthorization()) {
	$oUserCurrent=$oEngine->User_GetUserCurrent();
	if ($oCompany=$oEngine->PluginCompany_Company_GetCompanyById($idTopic)) {		
		$aReturn=$oEngine->Comment_GetCommentsNewByTargetId($oCompany->getId(),'company',$idCommentLast);
		$iMaxIdComment=$aReturn['iMaxIdComment'];
		
		$oFeebackRead= Engine::GetEntity('PluginCompany_Company_CompanyFeedbackRead');//new PluginCompany_CompanyEntity_CompanyFeedbackRead();
		$oFeebackRead->setCompanyId($oCompany->getId());
		$oFeebackRead->setUserId($oUserCurrent->getId());
		$oFeebackRead->setFeedbackCountLast($oCompany->getCountFeedback());
		$oFeebackRead->setFeedbackIdLast($iMaxIdComment);
		$oFeebackRead->setDateRead(date("Y-m-d H:i:s"));
		$oEngine->PluginCompany_Company_SetFeedbackRead($oFeebackRead);
		
		$aCmts=$aReturn['comments'];
		if ($aCmts and is_array($aCmts)) {
			foreach ($aCmts as $aCmt) {
				$aComments[]=array(
					'html' => $aCmt['html'],
					'idParent' => $aCmt['obj']->getPid(),
					'id' => $aCmt['obj']->getId(),
				);
			}
		}
		$bStateError=false;
	} else {
		$sMsgTitle=$oEngine->Lang_Get('error');
		$sMsg=$oEngine->Lang_Get('system_error');
	}
} else {
	$sMsgTitle=$oEngine->Lang_Get('error');
	$sMsg=$oEngine->Lang_Get('need_authorization');
}

$GLOBALS['_RESULT'] = array(
"bStateError"     => $bStateError,
"sMsgTitle"   => $sMsgTitle,
"sMsg"   => $sMsg,
"aComments" => $aComments,
"iMaxIdComment" => $iMaxIdComment,
);

?>