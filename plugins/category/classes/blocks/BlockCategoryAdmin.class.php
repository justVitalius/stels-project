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

class PluginCategory_BlockCategoryAdmin extends Block
{

    public function Exec()
    {

	$sAction = Router::GetAction();
	$sEvent = Router::GetActionEvent();
	$aParams = Router::GetParams();
	if (empty($aParams))
	    $aParams['0'] = 'topic';

	$aTypes = $this->PluginCategory_Category_GetType();
	if (!empty($aTypes[$aParams['0']])) {

	    $aCategory = $this->PluginCategory_Category_GetCategoryTree($aTypes[$aParams['0']]->getPrefix());

	    $this->Viewer_Assign('sTypeCategory', $aParams['0']);
	    $this->Viewer_Assign('aCategory', $aCategory);
	    $this->Viewer_Assign('sAdmin', true);
	}
	$this->Viewer_Assign('sTemplatePathPlugin', rtrim(Plugin::GetTemplatePath(__CLASS__), '/'));
	$this->Viewer_Assign('sTemplateCategoryPathPlugin', rtrim(Plugin::GetTemplateWebPath(__CLASS__), '/'));
    }

}

?>
