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
 * Голосование за компанию
 */

set_include_path(get_include_path().PATH_SEPARATOR.dirname(dirname(dirname(__FILE__))));
$sDirRoot=dirname(dirname(dirname(dirname(dirname(__FILE__)))));
require_once($sDirRoot."/config/config.ajax.php");
$iValue=getRequest('value',null,'post');
$bStateError=true;
$sMsg='';
$sMsgTitle='';
$iRating=0;
$iCountVote=0;
if ($oEngine->User_IsAuthorization()) {
	if ($oCompany=$oEngine->PluginCompany_Company_GetCompanyById(getRequest('idCompany',null,'post'))) { 
		$oUserCurrent=$oEngine->User_GetUserCurrent();
		if ($oCompany->getOwnerId()!=$oUserCurrent->getId()) {
			if (!($oCompanyVote=$oEngine->PluginCompany_Company_GetCompanyVote($oCompany->getId(),$oUserCurrent->getId()))) {
				if ($oEngine->PluginCompany_Company_CanVoteCompany($oUserCurrent,$oCompany)) {
					if (in_array($iValue,array('1','-1'))) {
						$oCompanyVote=Engine::GetEntity('PluginCompany_Company_CompanyVote');//new CompanyEntity_CompanyVote();
						$oCompanyVote->setCompanyId($oCompany->getId());
						$oCompanyVote->setVoterId($oUserCurrent->getId());
						$oCompanyVote->setDelta($iValue);
						//$oCompany->setRating($oCompany->getRating()+$iValue);
						$oEngine->PluginCompany_Company_VoteCompany($oUserCurrent,$oCompany,$iValue);
						$oCompany->setCountVote($oCompany->getCountVote()+1);
						if ($oEngine->PluginCompany_Company_AddCompanyVote($oCompanyVote) and $oEngine->PluginCompany_Company_UpdateCompany($oCompany)) {
							$bStateError=false;
							$sMsgTitle=$oEngine->Lang_Get('company_congratulation');
							$sMsg=$oEngine->Lang_Get('company_vote_ok');
							$iRating=$oCompany->getRating();
							$iCountVote=$oCompany->getCountVote();
						} else {
							$sMsgTitle=$oEngine->Lang_Get('error');
							$sMsg=$oEngine->Lang_Get('company_vote_after');
						}
					} else {
						$sMsgTitle=$oEngine->Lang_Get('company_attention');
						$sMsg=$oEngine->Lang_Get('company_vote_values');
					}
				} else {
					$sMsgTitle=$oEngine->Lang_Get('company_attention');
					$sMsg=$oEngine->Lang_Get('company_vote_acl');
				}
			} else {
				$sMsgTitle=$oEngine->Lang_Get('company_attention');
				$sMsg=$oEngine->Lang_Get('company_notice_voted');
			}
		} else {
			$sMsgTitle=$oEngine->Lang_Get('company_attention');
			$sMsg=$oEngine->Lang_Get('company_notice_voted_owner');
		}
	} else {
		$sMsgTitle=$oEngine->Lang_Get('error');
		$sMsg=$oEngine->Lang_Get('company_notice_voted_notfound');
	}
} else {
	$sMsgTitle=$oEngine->Lang_Get('error');
	$sMsg=$oEngine->Lang_Get('not_access');
}


$GLOBALS['_RESULT'] = array(
"bStateError"     => $bStateError,
"iRating"   => $iRating,
"iCountVote" => $iCountVote,
"sMsgTitle"   => $sMsgTitle,
"sMsg"   => $sMsg,
);

?>