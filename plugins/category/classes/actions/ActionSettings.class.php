<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (v.0.4.2 and 0.5)
 *   Plugin Category (v.0.1.1)
 *   Copyright © 2011 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
  ---------------------------------------------------------
 */

class PluginCategory_ActionSettings extends ActionPlugin
{

    protected $sMenuItemSelect = 'category';
    protected $sMenuSubItemSelect = '';
    protected $oUserCurrent = null;
    protected $aUser = null;

    public function Init()
    {
	$this->oUserCurrent = $this->User_GetUserCurrent();
	$this->Viewer_AddBlock('right', 'CategoryAdmin', array('plugin' => 'category'), 100);
    }

    protected function RegisterEvent()
    {
	$this->AddEventPreg('/^settings$/i', '/^ajaxaddcategory$/i', 'AjaxAddCategory');
	$this->AddEventPreg('/^settings$/i', '/^ajaxeditcategory$/i', 'AjaxEditCategory');
	$this->AddEventPreg('/^settings$/i', '/^ajaxdellcategory$/i', 'AjaxDellCategory');
	$this->AddEventPreg('/^settings$/i', '/^ajaxtogglecategory/i', 'AjaxToggleCategory');

	$this->AddEventPreg('/^settings$/i', 'EventCategory');
    }

    protected function EventCategory()
    {

	if (!$this->oUserCurrent or !$this->oUserCurrent->isAdministrator()) {
	    return Router::Action('error');
	}

	$this->sMenuSubItemSelect = $sShowType = $this->GetParam(0) ? $this->GetParam(0) : 'topic';

	$aTypes = $this->PluginCategory_Category_GetType();

	if (empty($aTypes[$sShowType]))
	    return Router::Action('error');

	$aCategory = $this->PluginCategory_Category_GetCategoryTree($sShowType);

	$this->Viewer_Assign('aCategory', $aCategory);
	$this->Viewer_Assign('sType', $sShowType);

	$this->SetTemplateAction('category');
    }

    protected function AjaxDellCategory()
    {

	$this->Viewer_SetResponseAjax('json');

	if (!$this->oUserCurrent or !$this->oUserCurrent->isAdministrator()) {
	    $this->Message_AddErrorSingle($this->Lang_Get('not_access'), $this->Lang_Get('error'));
	    return Router::Action('error');
	}
	$sCategoryId = getRequest('sId', null, 'post');
	if (!($oCategory = $this->PluginCategory_Category_GetCategoryById($sCategoryId))) {
	    $this->Message_AddErrorSingle($this->Lang_Get('not_access'), $this->Lang_Get('error'));
	    return Router::Action('error');
	}
	$aCategoryTree = $this->PluginCategory_Category_GetCategoryTree(getRequest('sType'), $sCategoryId);

	if ($this->PluginCategory_Category_DellCategory($oCategory)) {

	    if (!empty($aCategoryTree)) {
		// поднятие уровня дочерним категориям
		$this->PluginCategory_Category_UpdCategoryTreeParrentId($aCategoryTree, $oCategory->getParentId());

		// удаление дочерних категорий
		//$this->PluginCategory_Category_DellCategoryTree(getRequest('sType'),$aCategoryTree);
	    }
	    $this->Message_AddNoticeSingle($this->Lang_Get('cat_ok_dellete_category'), $this->Lang_Get('attention'));
	    return;
	}

	$this->Message_AddErrorSingle($this->Lang_Get('system_error'), $this->Lang_Get('error'));
	return;
    }

    protected function AjaxAddCategory()
    {

	$this->Viewer_SetResponseAjax('json');

	if (!$this->oUserCurrent or !$this->oUserCurrent->isAdministrator()) {
	    $this->Message_AddErrorSingle($this->Lang_Get('not_access'), $this->Lang_Get('error'));
	    return false;
	}

	$bOk = true;
	$aOk = array();

	$aCategory = getRequest('category_title', null, 'post');

	if (!func_check(getRequest('category_title'), 'text', 2, 200)) {
	    $aOk[] = $this->Lang_Get('cat_error_creat_title');
	    $bOk = false;
	}
	if (getRequest('category_url')) {
	    $sUrl = func_translit(getRequest('category_url'));
	} else {
	    $sUrl = func_translit(getRequest('category_title'));
	}

	if ($oCategory = $this->PluginCategory_Category_GetCategoryByUrl($sUrl)) {
	    $aOk[] = $this->Lang_Get('cat_error_creat_isset_url');
	    $bOk = false;
	}

	if (!$bOk) {
	    $sError = join('<br>', $aOk);
	    $this->Message_AddErrorSingle($sError, $this->Lang_Get('error'));
	    return;
	}

	$oCategory = Engine::GetEntity('PluginCategory_Category');
	$oCategory->setTitle(getRequest('category_title'));
	$oCategory->setUrl($sUrl);
	$oCategory->setParentId(getRequest('parent_id'));
	$oCategory->setType(getRequest('target_type'));

	if ($sId = $this->PluginCategory_Category_AddCategory($oCategory)) {
	    $oCategory->setId($sId);
	    $this->Message_AddNoticeSingle($this->Lang_Get('cat_ok_creat_category'), $this->Lang_Get('attention'));
	    return;
	}

	$this->Message_AddErrorSingle($this->Lang_Get('system_error'), $this->Lang_Get('error'));
	return;
    }

    protected function AjaxEditCategory()
    {

	$this->Viewer_SetResponseAjax('json');

	if (!$this->oUserCurrent or !$this->oUserCurrent->isAdministrator()) {
	    $this->Message_AddErrorSingle($this->Lang_Get('not_access'), $this->Lang_Get('error'));
	    return false;
	}

	$aCategory = getRequest('aCategory', null, 'post');

	if (!($oCategory = $this->PluginCategory_Category_GetCategoryById(getRequest('category_id')))) {
	    $this->Message_AddErrorSingle($this->Lang_Get('cat_error_none_cat'), $this->Lang_Get('error'));
	    return false;
	}

	$bOk = true;
	$aOk = array();

	if (!func_check(getRequest('category_title'), 'text', 2, 200)) {
	    $aOk[] = $this->Lang_Get('cat_error_creat_title');
	    $bOk = false;
	} else {
	    $oCategory->setTitle(getRequest('category_title'));
	}

	if (getRequest('category_url')) {
	    $sUrl = func_translit(getRequest('category_url'));
	} else {
	    $sUrl = func_translit(getRequest('category_title'));
	}

	if ($oCategory->getUrl() != $sUrl) {

	    if ($oCategoryExist = $this->PluginCategory_Category_GetCategoryByUrl($sUrl)) {
		$aOk[] = $this->Lang_Get('cat_error_creat_isset_url');
		$bOk = false;
	    } else {
		$oCategory->setUrl($sUrl);
	    }
	}

	$oCategory->setParentId(getRequest('parent_id'));

	if (!$bOk) {
	    $sError = join('<br>', $aOk);
	    $this->Message_AddErrorSingle($sError, $this->Lang_Get('error'));
	    return;
	}

	if ($this->PluginCategory_Category_EditCategory($oCategory)) {
	    $this->Message_AddNoticeSingle($this->Lang_Get('cat_ok_edit_category'), $this->Lang_Get('attention'));
	    return;
	}
    }

    protected function AjaxToggleCategory()
    {
	$this->Viewer_SetResponseAjax('json');

	$sType = getRequest('sType', null, 'post');
	$sTypeCategory = getRequest('sTypeCategory', null, 'post');

	$aCategory = $this->PluginCategory_Category_GetCategoryTree($sTypeCategory);

	$this->Viewer_Assign('aCategory', $aCategory);
	$this->Viewer_Assign('oUserCurrent', $this->oUserCurrent);
	$this->Viewer_Assign('sTypeCategory', $sTypeCategory);
	$this->Viewer_Assign('sAdmin', true);

	$sType = $sType == 'edit' ? 'option' : $sType;

	$this->Viewer_Assign('sTemplatePathPlugin', rtrim(Plugin::GetTemplatePath('category'), '/'));
	$sHtml = $this->Viewer_Fetch(Plugin::GetTemplatePath('category') . $sType . '.category_toggle.tpl');
	$this->Viewer_AssignAjax('sHtml', $sHtml);
    }

    public function EventShutdown()
    {
	$this->Viewer_Assign('sMenuItemSelect', $this->sMenuItemSelect);
	$this->Viewer_Assign('sMenuSubItemSelect', $this->sMenuSubItemSelect);
	$this->Viewer_Assign('sTemplatePathPlugin', rtrim(Plugin::GetTemplatePath(__CLASS__), '/'));
	$this->Viewer_Assign('sTemplateWebPathPlugin', rtrim(Plugin::GetTemplateWebPath(__CLASS__), '/'));
    }

}

?>
