<?php
   class PluginCategorize_ModuleBlog_EntityBlog extends PluginCategorize_Inherit_ModuleBlog_EntityBlog {
   		/*
	 * GET Functions
	 */
	public function getCategory() {
		return $this -> _aData['goods_item_id'];
	}
	
	/*
	 * SET Functions
	 */
	public function setCategory($data) {
		$this -> _aData['goods_item_id']=$data;
	}
	
   }
?>