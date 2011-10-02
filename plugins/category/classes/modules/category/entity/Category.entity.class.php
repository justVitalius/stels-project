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

class PluginCategory_ModuleCategory_EntityCategory extends Entity
{

    public function getId()
    {
	return $this->_aData['category_id'];
    }

    public function getParentId()
    {
	return $this->_aData['parent_id'];
    }

    public function getType()
    {
	return $this->_aData['target_type'];
    }

    public function getTitle()
    {
	return $this->_aData['category_title'];
    }

    public function getUrl()
    {
	return $this->_aData['category_url'];
    }

    public function getCountSub()
    {
	return $this->_aData['category_count_sub'];
    }

    public function getCountTarget()
    {
	return $this->_aData['category_count_target'];
    }

    public function getCategoryUrl()
    {
	if (Router::GetActionEvent() == 'settings') {
	    $aParams = Router::GetParams();
	    return Router::GetPath($aParams['0']) . $this->getUrl() . '/';
	}
	else
	    $aType = $this->PluginCategory_Category_GetType();
	return Router::GetPath($this->getType()) . $this->getUrl() . '/';
    }

    public function setId($data)
    {
	$this->_aData['category_id'] = $data;
    }

    public function setParentId($data)
    {
	$this->_aData['parent_id'] = $data;
    }

    public function setType($data)
    {
	$this->_aData['target_type'] = $data;
    }

    public function setTitle($data)
    {
	$this->_aData['category_title'] = $data;
    }

    public function setUrl($data)
    {
	$this->_aData['category_url'] = $data;
    }

    public function setCountSub($data)
    {
	$this->_aData['category_count_sub'] = $data;
    }

    public function setCountTarget($data)
    {
	$this->_aData['category_count_target'] = $data;
    }

}

?>
