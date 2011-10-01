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

/**
 * Обработка УРЛа вида /question/ - управление своими топиками(тип: вопрос)
 *
 */
class PluginPreview_ActionQuestion extends PluginPreview_Inherit_ActionQuestion {

	protected $sMenuHeadItemSelect='blog';

	protected $sMenuItemSelect='question';

	protected $sMenuSubItemSelect='add';

	protected $oUserCurrent=null;


	public function Init() {
		return parent::Init();
	}

	protected function RegisterEvent() {
		return parent::RegisterEvent();
	}


	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */


	protected function EventEdit() {
		return parent::EventEdit();
	}

	protected function EventAdd() {
		return parent::EventAdd();
	}


	protected function SubmitAdd() {

		if (!isPost('submit_topic_publish') and !isPost('submit_topic_save')) {
			return false;
		}

		if (!$this->checkTopicFields()) {
			return false;
		}

		$iBlogId=getRequest('blog_id');
		if ($iBlogId==0) {
			$oBlog=$this->Blog_GetPersonalBlogByUserId($this->oUserCurrent->getId());
		} else {
			$oBlog=$this->Blog_GetBlogById($iBlogId);
		}

		if (!$oBlog) {
			$this->Message_AddErrorSingle($this->Lang_Get('topic_create_blog_error_unknown'),$this->Lang_Get('error'));
			return false;
		}

		if (!$this->ACL_IsAllowBlog($oBlog,$this->oUserCurrent)) {
			$this->Message_AddErrorSingle($this->Lang_Get('topic_create_blog_error_noallow'),$this->Lang_Get('error'));
			return false;
		}

		if (isPost('submit_topic_publish') and !$this->ACL_CanPostTopicTime($this->oUserCurrent)) {
			$this->Message_AddErrorSingle($this->Lang_Get('topic_time_limit'),$this->Lang_Get('error'));
			return;
		}

		$oTopic=Engine::GetEntity('Topic');
		$oTopic->setBlogId($oBlog->getId());
		$oTopic->setUserId($this->oUserCurrent->getId());
		$oTopic->setType('question');
		$oTopic->setTitle(getRequest('topic_title'));
		$oTopic->setText(htmlspecialchars(getRequest('topic_text')));
		$oTopic->setTextShort(htmlspecialchars(getRequest('topic_text')));
		$oTopic->setTextSource(getRequest('topic_text'));
		$oTopic->setTags(getRequest('topic_tags'));
		$oTopic->setDateAdd(date("Y-m-d H:i:s"));
		$oTopic->setUserIp(func_getIp());
		$oTopic->setCutText(null);
		$oTopic->setTextHash(md5($oTopic->getType().$oTopic->getText().$oTopic->getTitle()));

		if ($oTopicEquivalent=$this->Topic_GetTopicUnique($this->oUserCurrent->getId(),$oTopic->getTextHash())) {
			$this->Message_AddErrorSingle($this->Lang_Get('topic_create_text_error_unique'),$this->Lang_Get('error'));
			return false;
		}

		$oTopic->clearQuestionAnswer();
		foreach (getRequest('answer',array()) as $sAnswer) {
			$oTopic->addQuestionAnswer($sAnswer);
		}

		if (isset($_REQUEST['submit_topic_publish'])) {
			$oTopic->setPublish(1);
			$oTopic->setPublishDraft(1);
		} else {
			$oTopic->setPublish(0);
			$oTopic->setPublishDraft(0);
		}

		$oTopic->setPublishIndex(0);
		if ($this->oUserCurrent->isAdministrator())	{
			if (getRequest('topic_publish_index')) {
				$oTopic->setPublishIndex(1);
			}
		}

		$oTopic->setForbidComment(0);
		if (getRequest('topic_forbid_comment')) {
			$oTopic->setForbidComment(1);
		}
                $this->Hook_Run('topic_add_before', array('oTopic'=>$oTopic,'oBlog'=>$oBlog));

		if ($this->Topic_AddTopic($oTopic)) {
                    $this->Hook_Run('topic_add_after', array('oTopic'=>$oTopic,'oBlog'=>$oBlog));

			$oTopic=$this->Topic_GetTopicById($oTopic->getId());

			if ($oTopic->getPublish()==1 and $oBlog->getType()!='personal') {
				$this->Topic_SendNotifyTopicNew($oBlog,$oTopic,$this->oUserCurrent);
			}
			Router::Location($oTopic->getUrl());
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
			return Router::Action('error');
		}
	}

	protected function SubmitEdit($oTopic) {

		if (!$this->checkTopicFields($oTopic)) {
			return false;
		}

		$iBlogId=getRequest('blog_id');
		if ($iBlogId==0) {
			$oBlog=$this->Blog_GetPersonalBlogByUserId($oTopic->getUserId());
		} else {
			$oBlog=$this->Blog_GetBlogById($iBlogId);
		}

		if (!$oBlog) {
			$this->Message_AddErrorSingle($this->Lang_Get('topic_create_blog_error_unknown'),$this->Lang_Get('error'));
			return false;
		}

		if (!$this->ACL_IsAllowBlog($oBlog,$this->oUserCurrent)) {
			$this->Message_AddErrorSingle($this->Lang_Get('topic_create_blog_error_noallow'),$this->Lang_Get('error'));
			return false;
		}

		if (isPost('submit_topic_publish') and !$oTopic->getPublishDraft() and !$this->ACL_CanPostTopicTime($this->oUserCurrent)) {
			$this->Message_AddErrorSingle($this->Lang_Get('topic_time_limit'),$this->Lang_Get('error'));
			return;
		}

		$oTopic->setBlogId($oBlog->getId());
		$oTopic->setText(htmlspecialchars(getRequest('topic_text')));
		$oTopic->setTextShort(htmlspecialchars(getRequest('topic_text')));
		$oTopic->setTextSource(getRequest('topic_text'));
		$oTopic->setTags(getRequest('topic_tags'));
		$oTopic->setUserIp(func_getIp());


		if ($oTopic->getQuestionCountVote()==0) {
			$oTopic->setTitle(getRequest('topic_title'));
			$oTopic->clearQuestionAnswer();
			foreach (getRequest('answer',array()) as $sAnswer) {
				$oTopic->addQuestionAnswer($sAnswer);
			}
		}
		$oTopic->setTextHash(md5($oTopic->getType().$oTopic->getText().$oTopic->getTitle()));

		if ($oTopicEquivalent=$this->Topic_GetTopicUnique($this->oUserCurrent->getId(),$oTopic->getTextHash())) {
			if ($oTopicEquivalent->getId()!=$oTopic->getId()) {
				$this->Message_AddErrorSingle($this->Lang_Get('topic_create_text_error_unique'),$this->Lang_Get('error'));
				return false;
			}
		}
		
		$bSendNotify=false;
		if (isset($_REQUEST['submit_topic_publish'])) {
			$oTopic->setPublish(1);
			if ($oTopic->getPublishDraft()==0) {
				$oTopic->setPublishDraft(1);
				$oTopic->setDateAdd(date("Y-m-d H:i:s"));
				$bSendNotify=true;
			}
		} else {
			$oTopic->setPublish(0);
		}

		if ($this->oUserCurrent->isAdministrator())	{
			if (getRequest('topic_publish_index')) {
				$oTopic->setPublishIndex(1);
			} else {
				$oTopic->setPublishIndex(0);
			}
		}

		$oTopic->setForbidComment(0);
		if (getRequest('topic_forbid_comment')) {
			$oTopic->setForbidComment(1);
		}
                 $this->Hook_Run('topic_edit_before', array('oTopic'=>$oTopic,'oBlog'=>$oBlog));

		if ($this->Topic_UpdateTopic($oTopic)) {
                    $this->Hook_Run('topic_edit_after', array('oTopic'=>$oTopic,'oBlog'=>$oBlog,'bSendNotify'=>&$bSendNotify));

			if ($bSendNotify)	 {
				$this->Topic_SendNotifyTopicNew($oBlog,$oTopic,$this->oUserCurrent);
			}
			if (!$oTopic->getPublish() and !$this->oUserCurrent->isAdministrator() and $this->oUserCurrent->getId()!=$oTopic->getUserId()) {
				Router::Location($oBlog->getUrlFull());
			}
			Router::Location($oTopic->getUrl());
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
			return Router::Action('error');
		}
	}

	protected function checkTopicFields($oTopic=null) {
		return parent::checkTopicFields($oTopic=null);

	}
	/**
	 * При завершении экшена загружаем необходимые переменные
	 *
	 */
	public function EventShutdown() {
		return parent::EventShutdown();
	}
}
?>