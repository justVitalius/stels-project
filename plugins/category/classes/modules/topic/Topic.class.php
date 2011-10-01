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

class PluginCategory_ModuleTopic extends Module
{

    protected $oMapperTopic;
    protected $oUserCurrent = null;

    public function Init()
    {
	$this->oMapperTopic = Engine::GetMapper(__CLASS__);
	$this->oUserCurrent = $this->User_GetUserCurrent();
    }

    public function GetTopicsAll($iPage, $iPerPage, $oCategory)
    {

	$aArrayId = array();
	$aArrayId[] = $oCategory->getId();

	$aArrayId = $this->PluginCategory_Category_GetCategoryArrayIdTree($oCategory->getType(), $oCategory->getId(), $aArrayId);
	$data = $this->oMapperTopic->GetArrayTopicsByCetegory($iPage, $iPerPage, $aArrayId, $oCategory->getType());
	if (!empty($data['collection'])) {
	    $data['collection'] = $this->Topic_GetTopicsAdditionalData($data['collection']);
	    foreach ($data['collection'] as $oTopic) {
		$oTopic->setCategory($oCategory);
	    }
	}

	return $data;
    }

}

?>
