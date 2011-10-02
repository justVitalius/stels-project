<?php
class PluginCategorize_ModuleBlog_MapperBlog extends PluginCategorize_Inherit_ModuleBlog_MapperBlog {
	
	public function GetBlogsByCategory($aCategories=null, $iCount, $iCurrPage, $iPerPage) {
		$sWhere = '';
		if($aCategories) {
			$sWhere = $this -> CategorizeFilter( array('blog_category' => $aCategories));
		}
		$sql = "SELECT
		b.blog_id
		FROM
		" . Config::Get('db.table.blog') . " as b
		JOIN " . Config::Get('plugin.categorize.table.categorize_blog') . " as bc on b.blog_id=bc.blog_id
		WHERE
		b.blog_type<>'personal' " . $sWhere . "
		ORDER by b.blog_rating desc
		LIMIT ?d, ?d 	";
		$aReturn = array();
		if($aRows = $this -> oDb -> selectPage($iCount, $sql, ($iCurrPage - 1) * $iPerPage, $iPerPage)) {
			foreach($aRows as $aRow) {
				$aReturn[] = $aRow['blog_id'];
			}
		}
		return $aReturn;
	}

	public function GetBlogCategoryByArrayId($aBlogId) {
		$sWhere = '';
		if($aBlogId) {
			$sWhere = $this -> CategorizeFilter( array('blog_id' => $aBlogId));
		}
		$sql = "SELECT
		*
		FROM
		" . Config::Get('plugin.categorize.table.categorize_blog') . " as bc
		WHERE
		1=1 " . $sWhere;
		$aReturn = array();
		if($aRows = $this -> oDb -> select($sql)) {
			foreach($aRows as $aRow) {
				$aReturn[$aRow['blog_id']] = $aRow['blog_category'];
			}
		}
		return $aReturn;
	}

	public function GetCountBlogsByCategory($aCategories=null) {
		$sWhere = '';
		if($aCategories) {
			$sWhere = $this -> CategorizeFilter( array('blog_category' => $aCategories));
		}
		$sql = "SELECT
		count(bc.blog_id) as count
		FROM
		" . Config::Get('plugin.categorize.table.categorize_blog') . " as bc
		WHERE
		1=1 " . $sWhere . "
		";
		$iReturn = 0;
		if($aRow = $this -> oDb -> selectRow($sql)) {
			$iReturn = $aRow['count'];
		}
		return $iReturn;
	}

	/*
 	* Build filter
 	*/
	public function CategorizeFilter($aFilter) {
		$sWhere = '';
		if($aFilter == null) {
			return null;
		}
		if(isset($aFilter['blog_category'])) {
			$sWhere .= is_array($aFilter['blog_category']) ? " AND bc.blog_category IN('" . implode("', '", $aFilter['blog_category']) . "')" : " AND bc.blog_category =  '" . $aFilter['blog_category'] . "'";
		}
		if(isset($aFilter['blog_id'])) {
			$sWhere .= is_array($aFilter['blog_id']) ? " AND bc.blog_id IN('" . implode("', '", $aFilter['blog_id']) . "')" : " AND bc.blog_id =  '" . $aFilter['blog_id'] . "'";
		}
		return $sWhere;
	}

	# End of class
}

?>