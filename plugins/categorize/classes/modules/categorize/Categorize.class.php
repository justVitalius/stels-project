<?php
/********************************************
 * Author: Vladimir Linkevich
 * e-mail: Vladimir.Linkevich@gmail.com
 * since 2011-02-25
 ********************************************/
  class PluginCategorize_ModuleCategorize extends Module {
  		
  	public function Init(){
  		$this -> oMapperCategorize = Engine::GetMapper(__CLASS__);
  	}
	
	
	public function setBlogCategory($iBlog,$sCategory){
		$this->oMapperCategorize->setBlogCategory($iBlog,$sCategory);
	}
	
	public function updateBlogCategory($iBlog,$sCategory){
		$this->oMapperCategorize->updateBlogCategory($iBlog,$sCategory);
	}
	
	/*
 	* Parsing categories array recursively
 	* @rarams: array
 	* @return: single dimentional array(Item, Level, haschildren)
 	*/
	public function getCategories($arrResult, $depth=-1, $aResult= array()) {
		$depth++;
		while(list($key, $value) = each($arrResult)) {
			if(is_array($value)) {
				$aResult[] = array('Item' => "$key", 'Level' => $depth, 'haschildren' => 1);
				$aResult = $this -> getCategories($value, $depth, $aResult);
			} else {
				for($i = 0; $i < count($value); $i++) {
					$aResult[] = array('Item' => $value, 'Level' => $depth, 'haschildren' => 0);
				}
			}
		}
		return $aResult;
	}

	/*
 	* Return array of all category children
 	* @Param: String Category
 	* @Param: [Array Categories]
 	* return: Array()
 	*/
	public function getCategoryChildren($sCategory, $aCategories=null) {
		if($aCategories == null) {
			$aCategories = $this -> getCategories(Config::Get('plugin.categorize.blog.categories'));
		}
		$depth = 0;
		$found = false;
		$aResult = array();
		for($i = 0; $i < count($aCategories); $i++) {
			if($found and intval($aCategories[$i]['Level']) <= $depth) {
				return $aResult;
			}
			if($found==true) {
				$aResult[] = $aCategories[$i]['Item'];
			}
			if($aCategories[$i]['Item'] == $sCategory) {
				$found = true;
				$aResult[] = $sCategory;
				if($aCategories[$i]['haschildren'] == 0) {
					return $aResult;
				}
			}
		}
		return $aResult;
	}
	
#End of class	
  }
?>