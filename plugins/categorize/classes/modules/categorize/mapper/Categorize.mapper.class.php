<?php
   class PluginCategorize_ModuleCategorize_MapperCategorize extends Mapper {
   	public function setBlogCategory($iBlog,$sCategory){
   		$sql="
   		INSERT INTO ".Config::Get('plugin.categorize.table.categorize_blog')."
   		(blog_id,
   		blog_category)
   		VALUES(?,?)
   		";
		return $this -> oDb -> query($sql,$iBlog,$sCategory);
   	}
		public function updateBlogCategory($iBlog,$sCategory){
   		$sql="
   		UPDATE ".Config::Get('plugin.categorize.table.categorize_blog')."
   		SET
   		blog_category=?
   		WHERE blog_id=?d
   		";
		return $this -> oDb -> query($sql,$sCategory,$iBlog);
   	}
   }
?>