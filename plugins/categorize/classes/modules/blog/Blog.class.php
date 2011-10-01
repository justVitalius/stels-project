<?php
class PluginCategorize_ModuleBlog extends PluginCategorize_Inherit_ModuleBlog {

	public function Init() {
		parent::Init();
		# Catch up my mapper
		$this -> oMapperBlog = Engine::GetMapper('PluginCategorize_ModuleBlog');
	}

	public function GetBlogsRatingCategory($aCategories=null, $iCurrPage, $iPerPage) {
		$s = serialize($aCategories);
		$iCount = 0;
		if(false === ($iCount = $this -> Cache_Get("blogs_category_{$s}_count"))) {
			$iCount = $this -> oMapperBlog -> GetCountBlogsByCategory($aCategories);
			$this -> Cache_Set($iCount, "blogs_category_{$s}_count", array("blog_update", "blog_new"), 60 * 60 * 24 * 2);
		}

		if(false === ($data = $this -> Cache_Get("blogs_category_{$s}_{$iCurrPage}_{$iPerPage}"))) {
			$data = array('collection' => $this -> oMapperBlog -> GetBlogsByCategory($aCategories, $iCount, $iCurrPage, $iPerPage), 'count' => $iCount);
			$this -> Cache_Set($data, "blogs_category_{$s}_{$iCurrPage}_{$iPerPage}", array("blog_update", "blog_new"), 60 * 60 * 24 * 2);
		}
		$data['idlist'] = $data['collection'];
		$data['collection'] = $this -> GetBlogsAdditionalData($data['collection'], array('owner' => array(), 'relation_user'));
		return $this -> addBlogEntityCategory($data);
	}

	public function addBlogEntityCategory($data) {
		$s = serialize($data['idlist']);
		$_data = null;
		if(false === ($_data = $this -> Cache_Get("blogs_category_{$s}"))) {
			$_data = $this -> oMapperBlog -> GetBlogCategoryByArrayId($data['idlist']);
			$this -> Cache_Set($_data, "blogs_category_{$s}", array("blog_update", "blog_new"), 60 * 60 * 24 * 2);
		}
		$i = 0;
		foreach($data['collection'] as $oBlog) {
			$oBlog -> setCategory($_data[$oBlog -> GetId()]);
		}
		return $data;
	}

}
?>