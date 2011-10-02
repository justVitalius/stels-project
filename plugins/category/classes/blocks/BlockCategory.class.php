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

class PluginCategory_BlockCategory extends Block
{

    public function Exec()
    {

	$sAction = Router::GetAction();
	$sEvent = Router::GetActionEvent();
	$aParams = Router::GetParams();
	$sType = str_replace('category_', '', $sAction);
	$sType = ($sType == 'index' or $sType == 'blog') ? 'topic' : $sType;
	$aType = $this->PluginCategory_Category_GetType();

	//print_r($aType[$sType]);
	if (!empty($aType[$sType])) {
	    $aCategory = $this->PluginCategory_Category_GetCategoryTree($aType[$sType]->getPrefix());
	    $this->Viewer_Assign('sTypeCategory', $sType);
	    $this->Viewer_Assign('aCategory', $aCategory);
	}
	$this->Viewer_Assign('sTemplatePathPlugin', rtrim(Plugin::GetTemplatePath(__CLASS__), '/'));
	$this->Viewer_Assign('sTemplateCategoryPathPlugin', rtrim(Plugin::GetTemplateWebPath(__CLASS__), '/'));
    }

}

?>
