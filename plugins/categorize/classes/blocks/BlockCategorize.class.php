<?php
class PluginCategorize_BlockCategorize extends Block {
	protected $aCategories;
	/**
 	* Выполняется при вызове блока
 	* @return void
 	*/
	public function Exec() {
		#assign category list
		$aCategories = $this -> PluginCategorize_ModuleCategorize_getCategories(Config::Get('plugin.categorize.blog.categories'));
		$aBlogSelectedCategories = array();
		$aFilter = null;
		#_GET filter
		if(isset($_GET) && count($_GET) > 0) {
			$aGet['get'] = urldecode(http_build_query($_GET));
			$this -> Viewer_Assign('aGet', $aGet);
			if(isset($_GET['cat'])) {
				$tmp = is_array($_GET['cat']) ? $_GET['cat'] : explode(',', $_GET['cat']);
				foreach($tmp as $val) {
					$aKill = $_GET;
					$sKill = count($tmp) > 1 ? implode(',', array_diff($tmp, array($val))) : null;
					$aKill['cat'] = $sKill;
					$aFilter['category'][$val] = array('name' => '', 'value' => $val, 'kill' => urldecode(http_build_query($aKill)));
					$aBlogSelectedCategories[] = $val;
				}
			}

			$this -> Viewer_Assign('aFilter', $aFilter);

			################
		}

		$aBlogCategories = $this -> PluginCategorize_ModuleCategorize_GetCategories(Config::Get('plugin.categorize.blog.categories'));
		$this -> Viewer_Assign('tgt', Config::Get('plugin.categorize.blog.categorypage'));
		$this -> Viewer_Assign('aCategories', $aBlogCategories);
		$this -> Viewer_Assign('aSelectedCategories', $aBlogSelectedCategories);
	}

	#End Of Class
}
?>