<?php
class PluginCategorize_HookCategorize extends Hook {
		
	public function RegisterHook() {
		$this -> AddHook('template_form_add_blog_end', 'InjectBlogAddCategory', __CLASS__);
		$this->AddHook('check_blog_fields','CheckBlog');
		$this->AddHook('blog_add_after','AddBlog');
		$this->AddHook('blog_add_before','fillBlogEntity');
		$this->AddHook('blog_edit_before', 'EditBlogBefore');
		$this->AddHook('blog_edit_after', 'EditBlogAfter');
	}

	#Drop-down box in blog posting template
	public function InjectBlogAddCategory() {
		$this -> Viewer_Assign('aCategories', $this -> PluginCategorize_ModuleCategorize_getCategories(Config::Get('plugin.categorize.blog.categories')));
		$this -> Viewer_Assign('bAllowParentCategory', Config::Get('plugin.categorize.blog.AllowParentCategory'));
		return $this -> Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'inject_blog_end.tpl');
	}
	
	#validate category
	public function CheckBlog($var) {
		$bOk = $var['bOk'];
	if(!func_check(getRequest('blog_category', null, 'post'), 'text', 2, 255)) {
		$this -> Message_AddError($this -> Lang_Get('categorize_blog_error_category'), $this -> Lang_Get('error'));
		$var['bOk'] = false;
	}
	return $var['bOk'];
	}

	public function fillBlogEntity($aoBlog){
		return $aoBlog['oBlog']->setCategory($_REQUEST['blog_category']);
	}

	public function AddBlog($aoBlog) {
	$oBlog = $aoBlog['oBlog'];
	$this->PluginCategorize_ModuleCategorize_setBlogCategory($oBlog->getId(),$oBlog->getCategory());
	$_REQUEST['blog_category']=$oBlog->getCategory();
	}

	public function EditBlogBefore($arr) {
		$oBlog=$arr['oBlog'];
	if(!isset($_REQUEST['blog_category'])){
		$oBlog->setCategory($this->PluginCategorize_ModuleCategorize_addBlogEntityCategory(array('idlist'=>$oBlog->getId(),'collection'=>array($oBlog))));
	}else{
		$oBlog->setCategory(getRequest('blog_category'));
	}
	$_REQUEST['blog_category']=$oBlog->getCategory();
	return $arr['oBlog']=$oBlog;
	}

	public function EditBlogAfter($arr){
	$oBlog = $arr['oBlog'];
	$this->PluginCategorize_ModuleCategorize_updateBlogCategory($oBlog->getId(),$oBlog->getCategory());
	$_REQUEST['blog_category']=$oBlog->getCategory();
	return $arr['oBlog']=$oBlog;
	}
	
	#END OF CLASS
}
?>