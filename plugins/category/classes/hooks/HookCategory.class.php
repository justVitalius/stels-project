<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (v.0.4.2 and 0.5)
 *   Plugin Category (v.0.1.1)
 *   Copyright В© 2011 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
  ---------------------------------------------------------
 */

class PluginCategory_HookCategory extends Hook
{

    public function RegisterHook()
    {

	$this->AddHook('init_action', 'InitAction', __CLASS__);

	$this->AddHook('template_form_add_topic_topic_begin', 'CategorySelect');

	$this->AddHook('template_content_begin', 'CategoryBc');

	$this->AddHook('topic_add_after', 'TopicAddAfter');

	$this->AddHook('topic_edit_show', 'TopicEditShow');

	$this->AddHook('topic_edit_after', 'TopicEditAfter');
	$aUser = Config::Get('plugin.category.user');

	if ($oUserCurrent = $this->User_GetUserCurrent() and ($oUserCurrent->isAdministrator() or array_search($oUserCurrent->getLogin(), $aUser)))
	    $this->AddHook('template_menu_settings', 'MenuSettings');
    }

    public function InitAction()
    {

	if (Router::GetAction() == 'error') {
	    $this->GetCategory();
	}

	if (Router::GetAction() == 'settings' and Router::GetActionEvent() == 'category') {
	    Router::Action('category_settings', 'settings');
	}
    }

    public function CategoryBc()
    {

	$aType = $this->PluginCategory_Category_GetType();
	$sCategoryId = null;
	$sType = str_replace('category_', '', Router::GetAction());
	$sType = ($sType == 'blog') ? 'topic' : $sType;
	if (!empty($aType[$sType])) {
	    $aId = explode('/', trim(@$_SERVER['REQUEST_URI'], '/'));
	    if (preg_match('/^(\d+)\.html$/', $aId[count($aId) - 1], $aMatch)) {
		if ($oRelation = $this->PluginCategory_Category_GetRelationByTargetIdByTargetType($aMatch['1'], $aType[$sType]->getPrefix())) {
		    $sCategoryId = $oRelation->getCategoryId();
		}
	    }
	}

	if ($oCategory = $this->PluginCategory_Category_GetCategoryById($sCategoryId)) {
	    $this->Viewer_Assign('oCategory', $oCategory);
	}

	$this->Viewer_Assign('sTemplateCategoryPath', rtrim(Plugin::GetTemplatePath('category'), '/'));
	$this->Viewer_Assign('sTemplateCategoryWebPathPlugin', rtrim(Plugin::GetTemplateWebPath('category'), '/'));
	return $this->Viewer_Fetch(Plugin::GetTemplatePath('category') . 'category.bc.tpl');
    }

    public function GetCategory()
    {
	$aUrl = explode('/', trim(@$_SERVER['REDIRECT_URL'], '/'));
	$sAction = empty($aUrl['0']) ? 'error' : $aUrl['0'];
	$sEvent = empty($aUrl['1']) ? 'error' : $aUrl['1'];

	if (!($oCategory = $this->PluginCategory_Category_GetCategoryByUrl($sEvent))) {
	    return;
	}

	if (count($aUrl) <= 2) {
	    $aParams = array();
	} else {
	    unset($aUrl['0']);
	    unset($aUrl['1']);
	    foreach ($aUrl as $sParams) {
		$aParams[] = $sParams;
	    }
	}
	Router::Action('category_' . $sAction, $sEvent, $aParams);
	return;
    }

    public function TopicEditAfter($aVar)
    {

	$oTopic = $aVar['oTopic'];
	if (!($oRelation = $this->PluginCategory_Category_GetRelationByTargetIdByTargetType($oTopic->getId(), Router::GetAction()))) {
	    $this->TopicAddAfter($aVar);
	} else {


	    // print_r($_POST);
	    $sCategoryId = $_POST['category_id'];
	    if ($oRelation->getCategoryId() != $sCategoryId) {

		$oCategoryOld = $this->PluginCategory_Category_GetCategoryById($oRelation->getCategoryId());

		if ($oCategoryOld->getCountTarget() > 0) {
		    $oCategoryOld->setCountTarget($oCategoryOld->getCountTarget() - 1);
		    $this->PluginCategory_Category_EditCategory($oCategoryOld);
		}

		if ($sCategoryId == 0) {
		    $this->PluginCategory_Category_DellRelation($oRelation);
		    return;
		}
		$oCategoryNew = $this->PluginCategory_Category_GetCategoryById($sCategoryId);

		$oRelation->setCategoryId($sCategoryId);
		$this->PluginCategory_Category_EditRelation($oRelation);

		$oCategoryNew->setCountTarget($oCategoryNew->getCountTarget() + 1);
		$this->PluginCategory_Category_EditCategory($oCategoryNew);
	    }
	}
    }

    public function TopicAddAfter($aVar)
    {
	$oTopic = $aVar['oTopic'];
	if ($oCategory = $this->PluginCategory_Category_GetCategoryById(getRequest('category_id'))) {
	    // собираем связь
	    $oRelation = new PluginCategory_ModuleCategory_EntityCategoryRelation();
	    $oRelation->setCategoryId($oCategory->getId());
	    $oRelation->setTargetId($oTopic->getId());
	    $oRelation->setTargetType(Router::GetAction());
	    // добавляем связь
	    if ($this->PluginCategory_Category_AddRelation($oRelation)) {
		$oCategory->setCountTarget($oCategory->getCountTarget() + 1);
		//print_r ($oCategory);
		$this->PluginCategory_Category_EditCategory($oCategory);
	    }
	}
    }

    public function TopicEditShow($aVar)
    {
	$oTopic = $aVar['oTopic'];

	if ($oRelation = $this->PluginCategory_Category_GetRelationByTargetIdByTargetType($oTopic->getId(), Router::GetAction())) {
	    $_REQUEST['category_id'] = $oRelation->getCategoryId();
	}
    }

    public function CategorySelect()
    {
	$oUserCurrent = $this->User_GetUserCurrent();

	$aCategory = $this->PluginCategory_Category_GetCategoryTree(Router::GetAction());

	$this->Viewer_Assign('aCategory', $aCategory);
	$this->Viewer_Assign('oUserCurrent', $oUserCurrent);
	$this->Viewer_Assign('sTemplatePathPlugin', rtrim(Plugin::GetTemplatePath('category'), '/'));
	return $this->Viewer_Fetch(Plugin::GetTemplatePath('category') . 'option.form_add_topic.tpl');
    }

    public function MenuSettings()
    {
	$aType = $this->PluginCategory_Category_GetType();
	$this->Viewer_Assign('aType', $aType);
	return $this->Viewer_Fetch(Plugin::GetTemplatePath('category') . 'menu.settings_category.tpl');
    }

}

?>
