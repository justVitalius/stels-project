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
 * Удаление отзыва админом
 */

set_include_path(get_include_path().PATH_SEPARATOR.dirname(dirname(dirname(__FILE__))));
$sDirRoot=dirname(dirname(dirname(dirname(dirname(__FILE__)))));
require_once($sDirRoot."/config/config.ajax.php");

$idComment=getRequest('idComment',null,'post');
$bStateError=true;
$sMsg='';
$sMsgTitle='';
$bState='';
$sTextToggle='';
if ($oEngine->User_IsAuthorization()) {
	$oUserCurrent = $oEngine->User_GetUserCurrent();
	if ($oComment = $oEngine->Comment_GetCommentById($idComment)) {
		$oCompany = $oEngine->PluginCompany_Company_GetCompanyById($oComment->getTargetId());
		$oCompany = $oEngine->PluginCompany_Company_GetCompanyAddData($oCompany);
		$oBlog = $oCompany->getBlog();
		if ($oBlog->getUserIsAdministrator() or $oBlog->getUserIsModerator() or $oUserCurrent->isAdministrator()) {		
			($oComment->getRating() == 0 ? $oComment->setRating(-100) : $oComment->setRating(0));
			if ($oEngine->Comment_UpdateCommentRating($oComment)) {
				$bStateError=false;
				$bState=(bool)$oComment->isBad();
				$sMsgTitle=$oEngine->Lang_Get('company_congratulation');
				if ($bState) {
					$sMsg=$oEngine->Lang_Get('company_notice_feedback_colapce');
					$sTextToggle=$oEngine->Lang_Get('comment_expand');
				} else {
					$sMsg=$oEngine->Lang_Get('company_notice_feedback_expand');
					$sTextToggle=$oEngine->Lang_Get('comment_collapse');
				}
			} else {
				$sMsgTitle=$oEngine->Lang_Get('error');
				$sMsg=$oEngine->Lang_Get('company_error_feedback_edit');
			}
		} else {
			$sMsgTitle=$oEngine->Lang_Get('error');
			$sMsg=$oEngine->Lang_Get('not_access');
		}
	} else {
		$sMsgTitle=$oEngine->Lang_Get('error');
		$sMsg=$oEngine->Lang_Get('company_error_feedback_notfound');
	}
} else {
	$sMsgTitle=$oEngine->Lang_Get('error');
	$sMsg=$oEngine->Lang_Get('not_access');
}


$GLOBALS['_RESULT'] = array(
"bStateError"     => $bStateError,
"bState"     => $bState,
"sTextToggle"     => $sTextToggle,
"sMsgTitle"   => $sMsgTitle,
"sMsg"   => $sMsg,
);

?>