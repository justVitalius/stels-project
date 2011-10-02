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
*/

set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__));
require_once(Config::Get('path.root.server').'/classes/modules/comment/mapper/Comment.mapper.class.php');
/**
 * Модуль для работы с комментариями
 *
 */
require_once(Config::Get('path.root.server').'/classes/modules/comment/Comment.class.php');
class PluginCompany_ModuleComment extends PluginCompany_Inherit_ModuleComment {	

	/**
	 * Получить новые комменты для топика
	 *
	 * @param unknown_type $sId
	 * @param unknown_type $sTargetType
	 * @param unknown_type $sIdCommentLast - last read comment
	 * @return unknown
	 */
	public function GetCommentsNewByTargetId($sId,$sTargetType,$sIdCommentLast) {
		if (false === ($aComments = $this->Cache_Get("comment_target_{$sId}_{$sTargetType}_{$sIdCommentLast}"))) {			
			$aComments=$this->oMapper->GetCommentsNewByTargetId($sId,$sTargetType,$sIdCommentLast);			
			$this->Cache_Set($aComments, "comment_target_{$sId}_{$sTargetType}_{$sIdCommentLast}", array("comment_new_{$sTargetType}_{$sId}"), 60*60*24*1);
		}			
		if (count($aComments)==0) {
			return array('comments'=>array(),'iMaxIdComment'=>0);
		}
		
		$iMaxIdComment=max($aComments);		
		$aCmts=$this->GetCommentsAdditionalData($aComments);				
		if (!class_exists('ModuleViewer')) {
			require_once(Config::Get('path.root.engine')."/modules/viewer/Viewer.class.php");
		}
		$oViewerLocal=$this->Viewer_GetLocalViewer();
		$oViewerLocal->Assign('oUserCurrent',$this->User_GetUserCurrent());
		$oViewerLocal->Assign('bOneComment',true);
		if($sTargetType!='topic') {
			$oViewerLocal->Assign('bNoCommentFavourites',true);
		} 
		if ($sTargetType=='company'){
			$aCmt = $this->formComments($aCmts,Config::Get('path.root.server').'/plugins/company/templates/skin/default/feedback.tpl');
		}else {
			$aCmt = $this->formComments($aCmts,'comment.tpl');		
		}
			
		return array('comments'=>$aCmt,'iMaxIdComment'=>$iMaxIdComment);		
	}
	
	protected function formComments($aCmts,$sTemplate) {
		$aCmt=array();
		$oViewerLocal=$this->Viewer_GetLocalViewer();
		foreach ($aCmts as $oComment) {			
			$oViewerLocal->Assign('oComment',$oComment);					
			$sText=$oViewerLocal->Fetch($sTemplate);
			$aCmt[]=array(
				'html' => $sText,
				'obj'  => $oComment,
			);			
		}
		return $aCmt;
	}
	
	/**
	 * Получает дополнительные данные(объекты) для комментов по их ID
	 *
	 */
	public function GetCommentsAdditionalData($aCommentId,$aAllowData=array('vote','target','favourite','user'=>array())) {
		func_array_simpleflip($aAllowData);
		if (!is_array($aCommentId)) {
			$aCommentId=array($aCommentId);
		}
		/**
		 * Получаем комменты
		 */
		$aComments=$this->GetCommentsByArrayId($aCommentId);
		/**
		 * Формируем ID дополнительных данных, которые нужно получить
		 */
		$aUserId=array();	
		$aTargetId=array('topic'=>array(),'talk'=>array(),'company'=>array());	
		foreach ($aComments as $oComment) {
			if (isset($aAllowData['user'])) {
				$aUserId[]=$oComment->getUserId();
			}
			if (isset($aAllowData['target'])) {
				$aTargetId[$oComment->getTargetType()][]=$oComment->getTargetId();
			}			
		}
		
		/**
		 * Получаем дополнительные данные
		 */
		$aUsers=isset($aAllowData['user']) && is_array($aAllowData['user']) ? $this->User_GetUsersAdditionalData($aUserId,$aAllowData['user']) : $this->User_GetUsersAdditionalData($aUserId);
		/**
		 * В зависимости от типа target_type достаем данные
		 */
		$aTargets=array();
		//$aTargets['topic']=isset($aAllowData['target']) && is_array($aAllowData['target']) ? $this->Topic_GetTopicsAdditionalData($aTargetId['topic'],$aAllowData['target']) : $this->Topic_GetTopicsAdditionalData($aTargetId['topic']);
		$aTargets['topic']=$this->Topic_GetTopicsAdditionalData($aTargetId['topic'],array('blog'=>array('owner'=>array())));
		$aTargets['company']=$this->PluginCompany_Company_GetCompaniesAdditionalData($aTargetId['company'],array('blog'=>array('owner'=>array(),'relation_user'))); 
		$aVote=array();
		if (isset($aAllowData['vote']) and $this->oUserCurrent) {
			$aVote=$this->Vote_GetVoteByArray($aCommentId,'comment',$this->oUserCurrent->getId());			
		}
		if (isset($aAllowData['favourite']) and $this->oUserCurrent) {
			$aFavouriteComments=$this->Favourite_GetFavouritesByArray($aCommentId,'comment',$this->oUserCurrent->getId());	
		}
		
		/**
		 * Добавляем данные к результату
		 */
		foreach ($aComments as $oComment) {
			if (isset($aUsers[$oComment->getUserId()])) {
				$oComment->setUser($aUsers[$oComment->getUserId()]);
			} else {
				$oComment->setUser(null); // или $oComment->setUser(new UserEntity_User());
			} 
			if (isset($aTargets[$oComment->getTargetType()][$oComment->getTargetId()])) {
				$oComment->setTarget($aTargets[$oComment->getTargetType()][$oComment->getTargetId()]); 
			} else { 
				$oComment->setTarget(null); 
			}
			if (isset($aVote[$oComment->getId()])) {
				$oComment->setVote($aVote[$oComment->getId()]);				
			} else {
				$oComment->setVote(null);
			}
			if (isset($aFavouriteComments[$oComment->getId()])) {
				$oComment->setIsFavourite(true);
			} else {
				$oComment->setIsFavourite(false);
			}						
		}
		return $aComments;
	}
	
	/**
	 * Обновляет коммент
	 *
	 * @param  CommentEntity_Comment $oComment
	 * @return bool
	 */
	/*public function UpdateFeedback(CommentEntity_Comment $oComment) {		
		if ($this->oMapperEx->UpdateFeeback($oComment)) {		
			//чистим зависимые кеши
			$this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array("comment_update","comment_update_{$oComment->getTargetType()}","comment_update_{$oComment->getTargetType()}_{$oComment->getTargetId()}"));				
			$this->Cache_Delete("comment_{$oComment->getId()}");
			return true;
		}
		return false;
	}*/
}
?>