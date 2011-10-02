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

class PluginCategory_ActionTopic extends ActionPlugin
{

    protected $sMenuItemSelect = 'topic';
    protected $oUserCurrent = null;

    public function Init()
    {
	$this->oUserCurrent = $this->User_GetUserCurrent();
    }

    protected function RegisterEvent()
    {
	$this->AddEventPreg('/^([\w\-\_]+)$/i', 'EventCategory');
	$this->AddEventPreg('/^([\w\-\_]+)$/i', '/^(page(\d+))?$/i', 'EventCategory');
    }

    protected function EventCategory()
    {

	$sCategoryUrl = $this->sCurrentEvent;
	if (!($oCategory = $this->PluginCategory_Category_GetCategoryByUrl($sCategoryUrl))) {
	    return Router::Action('error');
	}

	$sPage = $this->GetParam(0);
	if (preg_match("/^page(\d+)$/i", $sPage, $aMatch)) {
	    $iPage = $aMatch[1];
	} else {
	    $iPage = 1;
	}

	$aResult = $this->PluginCategory_Topic_GetTopicsAll($iPage, Config::Get('module.topic.per_page'), $oCategory);
	$aTopics = $aResult['collection'];

	$aPaging = $this->Viewer_MakePaging($aResult['count'], $iPage, Config::Get('module.topic.per_page'), 4, Router::GetPath('topic') . $sCategoryUrl);

	$this->Viewer_Assign('aTopics', $aTopics);
	$this->Viewer_Assign('aPaging', $aPaging);
	$this->Viewer_Assign('oCategory', $oCategory);

	$this->SetTemplateAction('index');
	$this->AddBlock();
    }

    public function AddBlock()
    {
	$this->Viewer_ClearBlocks('right');
	$this->Viewer_AddBlock('right', 'Category', array('plugin' => 'category'), 100);
    }

    public function EventShutdown()
    {
	$this->Viewer_Assign('sMenuItemSelect', $this->sMenuItemSelect);
	$this->Viewer_Assign('sTemplatePath', rtrim(Plugin::GetTemplatePath('category'), '/'));
	$this->Viewer_Assign('sTemplateCategoryWebPathPlugin', rtrim(Plugin::GetTemplateWebPath('category'), '/'));
    }

}

?>
