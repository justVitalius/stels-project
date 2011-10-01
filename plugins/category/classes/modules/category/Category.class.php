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

class PluginCategory_ModuleCategory extends Module
{

    protected $oMapper;

    public function Init()
    {
	$this->oMapper = Engine::GetMapper(__CLASS__);
    }

    public function GetType()
    {
	$aType = Config::Get('plugin.category.aType');
	$aTypes = array();
	foreach ($aType as $key => $val) {
	    $aTypes[$val['prefix']] = new PluginCategory_ModuleCategory_EntityCategoryType($val);
	}
	return $aTypes;
    }

    /* селект дерева категорий массив id */

    public function GetCategoryArrayIdTree($sType, $sParentId=0, $aArrayId=array())
    {
	if ($aCategory = $this->oMapper->GetCategoryTree($sType, $sParentId)) {
	    foreach ($aCategory as $oCategory) {
		$aArrayId[] = $oCategory->getId();
		if ($oCategory->getCountSub() > 0) {
		    return $this->GetCategoryArrayIdTree($sType, $oCategory->getId(), $aArrayId);
		}
	    }
	    return $aArrayId;
	}
	return $aArrayId;
    }

    /* селект дерева категорий */

    public function GetCategoryTree($sType, $sParentId=0)
    {
	if ($aCategory = $this->oMapper->GetCategoryTree($sType, $sParentId)) {
	    foreach ($aCategory as $oCategory) {
		//$aSubCategoy

		if ($oCategory->getCountSub() > 0) {
		    $oCategory->setSubCategory($this->GetCategoryTree($sType, $oCategory->getId()));
		}
	    }
	    return $aCategory;
	}
	return false;
    }

    /* изменение родителя у массива категорий */

    public function UpdCategoryTreeParrentId($aCategory, $sParentId)
    {
	foreach ($aCategory as $oCategory) {
	    $oCategory->setParentId($sParentId);
	    $this->EditCategory($oCategory);
	}
    }

    /* удаление дерева категорий */

    public function DellCategoryTree($sType, $aCategory)
    {
	foreach ($aCategory as $oCategory) {
	    if ($this->DellCategory($oCategory)) {
		if ($aCategoryTree = $this->PluginCategory_Category_GetCategoryTree($sType, $oCategory->getId())) {
		    $this->DellCategoryTree($sType, $aCategoryTree);
		}
	    }
	}
    }

    /* удаление категории по id */

    public function DellCategory($oCategory)
    {
	if ($this->oMapper->DellCategory($oCategory->getId())) {
	    $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array("category_update_{$oCategory->getId()}"));
	    return true;
	}
	return false;
    }

    /* селект категории по url */

    public function GetCategoryByUrl($sCategoryUrl)
    {
	if ($oCategory = $this->oMapper->GetCategoryByUrl($sCategoryUrl)) {
	    $aCategory = $this->GetCategoryByArrayId($oCategory->getId());
	    if (!empty($aCategory[$oCategory->getId()])) {
		return $aCategory[$oCategory->getId()];
	    }
	}
	return false;
    }

    /* селект категории по id */

    public function GetCategoryById($sCategoryId)
    {

	$aCategory = $this->GetCategoryByArrayId($sCategoryId);
	if (!empty($aCategory[$sCategoryId])) {
	    return $aCategory[$sCategoryId];
	}
	return false;
    }

    /* селект массива соленых категорий */

    public function GetCategoryByArrayIdSolid($aCategoryId)
    {

	if (!is_array($aCategoryId)) {
	    $aCategoryId = array($aCategoryId);
	}
	$aCategoryId = array_unique($aCategoryId);
	$aCategorys = array();
	$s = join(',', $aCategoryId);

	if (false === ($data = $this->Cache_Get("category_id_{$s}"))) {
	    $data = $this->oMapper->GetCategoryByArrayId($aCategoryId);

	    foreach ($data as $oCategory) {
		$aCategorys[$oCategory->getId()] = $oCategory;
	    }
	    $this->Cache_Set($aCategorys, "category_id_{$s}", array("category_update"), 60 * 60 * 24 * 1);
	    return $aCategorys;
	}
	return $data;
    }

    /* селект массива категорий */

    public function GetCategoryByArrayId($aCategoryId)
    {

	if (!is_array($aCategoryId)) {
	    $aCategoryId = array($aCategoryId);
	}

	if (Config::Get('sys.cache.solid')) {
	    $data = $this->GetCategoryByArrayIdSolid($aCategoryId);
	} else
	    $data = $this->oMapper->GetCategoryByArrayId($aCategoryId);

	if ($data) {

	    foreach ($data as $oCategory) {
		if ($oCategory->getParentId()) {
		    $oCategory->setParent($this->GetCategoryById($oCategory->getParentId()));
		}
		/*
		  if ($aCategorySub=$this->GetCategoryTree($oCategory->getType(), $oCategory->getId())){
		  $oCategory->setSub($aCategorySub);
		  } */
	    }

	    return $data;
	}
	return false;
    }

    /* добавление категории */

    public function AddCategory($oCategory)
    {
	if ($sId = $this->oMapper->AddCategory($oCategory)) {
	    //if ($oCategory->getParentId()){
	    if ($oCategoryParent = $this->GetCategoryById($oCategory->getParentId())) {
		$oCategoryParent->setCountSub($oCategoryParent->getCountSub() + 1);
		$this->EditCategory($oCategoryParent);
	    }
	    //}
	    $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('category_new', "category_update_url_{$oCategory->getUrl()}"));
	    return $sId;
	}
	return false;
    }

    /* редактирование категории */

    public function EditCategory($oCategory)
    {
	if ($res = $this->oMapper->EditCategory($oCategory)) {
	    //if ($oCategory->getParentId()){
	    if ($oCategoryParent = $this->GetCategoryById($oCategory->getParentId())) {
		$oCategoryParent->setCountSub($oCategoryParent->getCountSub() + 1);
		$this->EditCategory($oCategoryParent);
	    }
	    //}
	    $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('category_update', "category_update_{$oCategory->getId()}", "track_update"));
	    $this->Cache_Delete("category_{$oCategory->getId()}");
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
	return $this->oMapper->AddRelation($oRelation);
    }

    /* удалени связи */

    public function DellRelation($oRelation)
    {
	return $this->oMapper->DellRelation($oRelation->getId());
    }

    /* редактирование связи */

    public function EditRelation($oRelation)
    {
	return $this->oMapper->EditRelation($oRelation);
    }

    /* поиск связи */

    public function GetRelationByTargetIdByTargetType($sTargetId, $sTargetType)
    {
	return $this->oMapper->GetRelationByTargetIdByTargetType($sTargetId, $sTargetType);
    }

    /*     * ************************************************
     *
     *
     * ************************************************* */

    /* селект всех типов */

    public function GetTypeAll()
    {
	return $this->oMapper->GetTypeAll();
    }

}

?>
