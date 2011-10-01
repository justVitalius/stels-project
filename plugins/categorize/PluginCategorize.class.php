<?php
/********************************************
 * Author: Vladimir Linkevich
 * e-mail: Vladimir.Linkevich@gmail.com
 * since 2011-02-25
 ********************************************/

if(!class_exists('Plugin')) {
	die('Hacking attemp!');
}
class PluginCategorize extends Plugin {
	protected $aInherits = array('entity' => 'ModuleBlog_EntityBlog', 'mapper' => 'ModuleBlog_MapperBlog');

	public function Activate() {
		$oDb = $this -> Database_GetConnect();
		$prefix = Config::Get('db.table.prefix');
		#Create table if not exist
		$this -> ExportSQL(dirname(__FILE__) . '/dump.sql');
		#get existing blogs Id's
		$blogs = $this -> ModuleBlog_GetBlogs(true);
		#get categorized blogs
		$sql = "SELECT blog_id FROM " . $prefix . "categorize_blog";
		$tmp = $oDb -> select($sql);
		$cats = array();
		foreach($tmp as $aRow) {
			$cats[] = $aRow['blog_id'];
		}

		#categorize new blogs as NA category
		$blogs = array_diff($blogs, $cats);
		foreach($blogs as $blog) {
			$sql = "
			INSERT INTO " . $prefix . "categorize_blog
			(blog_id,
			blog_category)
			VALUES(?,?)
			";
			$oDb -> query($sql, $blog, 'NA');
		}

		return true;
	}

	public function Init() {
		$this -> Viewer_Assign('sTemplateWebPathPluginCategorize', Plugin::GetTemplateWebPath(__CLASS__));
		$this -> Viewer_Assign('sTemplatePathPluginCategorize', Plugin::GetTemplatePath(__CLASS__));
		$this -> Viewer_AddBlock('right', 'categorize', array('plugin' => 'categorize'));
		$this->Viewer_AppendStyle(Plugin::GetTemplateWebPath(__CLASS__) . 'css/categorize.css');
		return true;
	}

	public function Deactivate() {
		return true;
	}

}

?>