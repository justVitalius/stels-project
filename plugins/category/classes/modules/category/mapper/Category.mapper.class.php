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

class PluginCategory_ModuleCategory_MapperCategory extends Mapper
{
    /* селект категории по url */

    public function GetCategoryByUrl($sCategoryUrl)
    {
	$sql = "SELECT * FROM " . Config::Get('plugin.category.table.category') . " WHERE category_url = ?";
	if ($aRow = $this->oDb->selectRow($sql, $sCategoryUrl)) {
	    return Engine::GetEntity('PluginCategory_Category', $aRow);
	}
	return false;
    }

    /* селект по категории ID категории */

    public function GetCategoryByArrayId($aArrayId)
    {
	if (!is_array($aArrayId) or count($aArrayId) == 0) {
	    return array();
	}

	$sql = "SELECT
					c.*
				FROM
					" . Config::Get('plugin.category.table.category') . " as c

				WHERE
					c.category_id IN(?a)
				ORDER BY FIELD(c.category_id,?a) ";
	$aCategorys = array();
	if ($aRows = $this->oDb->select($sql, $aArrayId, $aArrayId)) {
	    foreach ($aRows as $aCategory) {
		$aCategorys[$aCategory['category_id']] = Engine::GetEntity('PluginCategory_Category', $aCategory);
	    }
	}
	return $aCategorys;
    }

    /* селект категории по id */

    public function GetCategoryById($sCategoryId)
    {
	$sql = "SELECT * FROM " . Config::Get('plugin.category.table.category') . " WHERE category_id = ?d";
	if ($aRow = $this->oDb->selectRow($sql, $sCategoryId)) {
	    return Engine::GetEntity('PluginCategory_Category', $aRow);
	}
	return false;
    }

    /* дерево категорий */

    public function GetCategoryTree($sType, $sParentId)
    {
	$sql = "SELECT * FROM " . Config::Get('plugin.category.table.category') . " where target_type = ? AND parent_id = ?d";
	$aReturn = array();
	if ($aRows = $this->oDb->select($sql, $sType, $sParentId)) {
	    foreach ($aRows as $aRow) {
		$aReturn[] = Engine::GetEntity('PluginCategory_Category', $aRow);
	    }
	    return $aReturn;
	}
	return false;
    }

    /* добавление категории */

    public function AddCategory($oCategory)
    {
	$sql = "INSERT INTO " . Config::Get('plugin.category.table.category') . "
			(
        parent_id,
        target_type,
        category_title,
        category_url
			)
			VALUES (?d, ?, ?, ?)
		";
	if ($iId = $this->oDb->query($sql, $oCategory->getParentId(), $oCategory->getType(), $oCategory->getTitle(), $oCategory->getUrl())) {
	    return $iId;
	}

	return false;
    }

    /* редактирование категории */

    public function EditCategory($oCategory)
    {

	$sql = "UPDATE " . Config::Get('plugin.category.table.category') . "
            SET
              parent_id=?d,
              target_type=?,
              category_title=?,
              category_url=?,
              category_count_sub=?d,
              category_count_target=?d
            WHERE
              category_id = ?d
    ";

	if ($this->oDb->query($sql, $oCategory->getParentId(), $oCategory->getType(), $oCategory->getTitle(), $oCategory->getUrl(), $oCategory->getCountSub(), $oCategory->getCountTarget(), $oCategory->getId()
		)
	) {

	    return true;
	}
	return false;
    }

    /* удаление категории */

    public function DellCategory($sCategoryId)
    {
	$sql = "DELETE FROM " . Config::Get('plugin.category.table.category') . "
			WHERE
				category_id = ?d
		";
	if ($this->oDb->query($sql, $sCategoryId)) {
	    return true;
	}
	return false;
    }

    /*     * ************************************************
     *
     *
     * ************************************************* */

    /* добавление связи */

    public function AddRelation($oRelation)
    {
	$sql = "INSERT INTO " . Config::Get('plugin.category.table.category_relation') . "
			(
        category_id,
        target_id,
        target_type
			)
			VALUES (?d, ?d, ?)
		";
	if ($iId = $this->oDb->query($sql, $oRelation->getCategoryId(), $oRelation->getTargetId(), $oRelation->getTargetType())) {
	    return $iId;
	}

	return false;
    }

    /* поиск связи */

    public function GetRelationByTargetIdByTargetType($sTargetId, $sTargetType)
    {
	$sql = "SELECT * FROM " . Config::Get('plugin.category.table.category_relation') . " WHERE target_id = ?d and target_type = ?";
	if ($aRow = $this->oDb->selectRow($sql, $sTargetId, $sTargetType)) {
	    return new PluginCategory_ModuleCategory_EntityCategoryRelation($aRow);
	}
	return false;
    }

    /* удаление связи */

    public function DellRelation($sRelationId)
    {
	$sql = "DELETE FROM " . Config::Get('plugin.category.table.category_relation') . "
			WHERE
				relation_id = ?d
		";
	if ($this->oDb->query($sql, $sRelationId)) {
	    return true;
	}
	return false;
    }

    /* редактирование связи */

    public function EditRelation($oRelation)
    {

	$sql = "UPDATE " . Config::Get('plugin.category.table.category_relation') . "
            SET
              category_id=?d,
              target_id=?d,
              target_type=?
            WHERE
              relation_id = ?d
    ";

	if ($this->oDb->query($sql, $oRelation->getCategoryId(), $oRelation->getTargetId(), $oRelation->getTargetType(), $oRelation->getId()
		)
	) {

	    return true;
	}
	return false;
    }

    /*     * ************************************************
     *
     *
     * ************************************************* */

    /* селект всех типов */

    public function GetTypeAll()
    {
	$sql = "SELECT * FROM " . Config::Get('plugin.category.table.category_type');
	$aReturn = array();
	if ($aRows = $this->oDb->select($sql)) {
	    foreach ($aRows as $aRow) {
		$aReturn[] = new PluginCategory_ModuleCategory_EntityCategoryType($aRow);
	    }
	    return $aReturn;
	}
	return false;
    }

}

?>
