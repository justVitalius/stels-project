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

class PluginCategory_ModuleCategory_EntityCategoryRelation extends Entity
{

    public function getId()
    {
	return $this->_aData['relation_id'];
    }

    public function getCategoryId()
    {
	return $this->_aData['category_id'];
    }

    public function getTargetId()
    {
	return $this->_aData['target_id'];
    }

    public function getTargetType()
    {
	return $this->_aData['target_type'];
    }

    public function setId($data)
    {
	$this->_aData['relation_id'] = $data;
    }

    public function setCategoryId($data)
    {
	$this->_aData['category_id'] = $data;
    }

    public function setTargetId($data)
    {
	$this->_aData['target_id'] = $data;
    }

    public function setTargetType($data)
    {
	$this->_aData['target_type'] = $data;
    }

}

?>
