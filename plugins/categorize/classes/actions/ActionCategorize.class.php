<?php
class PluginCategorize_ActionCategorize extends Action {
	protected $sMenuHeadItemSelect = 'blog';

	public function Init() {
		$this -> SetDefaultEvent('index');
	}

	protected function RegisterEvent() {
		$this -> AddEvent('index', 'EventCategorizeBlogs');
		$this -> AddEventPreg('/^(page(\d+))?$/i', 'EventCategorizeBlogs');
	}

	

	public function EventCategorizeBlogs() {

		/**
 		* Передан ли номер страницы
 		*/
		$iPage = preg_match("/^\d+$/i", $this -> GetEventMatch(2)) ? $this -> GetEventMatch(2) : 1;

		/*
 		*Get filter data
 		*/
		$aCategories = null;
		if(isset($_GET['cat'])) {
			$aTmp = is_array($_GET['cat']) ? $_GET['cat'] : explode(',', $_GET['cat']);
			foreach($aTmp as $cat) {
				$aCat = $this -> PluginCategorize_ModuleCategorize_getCategoryChildren($cat);
				foreach($aCat as $catready) {
					$aCategories[] = $catready;
				}
			}
		}

		/**
 		* Получаем список блогов
 		*/

		$aResult = $this -> PluginCategorize_ModuleBlog_GetBlogsRatingCategory($aCategories, $iPage, Config::Get('module.blog.per_page'));
		$aBlogs = $aResult['collection'];

		/**
 		* Формируем постраничность
 		*/
		$aPaging=$this->MakePaging($aResult['count'],$iPage,Config::Get('module.blog.per_page'),4,Router::GetPath('blogs'),$_GET);	
		/**
 		* Загружаем переменные в шаблон
 		*/
		$this -> Viewer_Assign('aPaging', $aPaging);
		$this -> Viewer_Assign("aBlogs", $aBlogs);
		$this -> Viewer_AddHtmlTitle($this -> Lang_Get('blog_menu_all_list'));
	}

	public function EventShutdown() {
		#Menu
		$this -> Viewer_Assign('sMenuHeadItemSelect', $this -> sMenuHeadItemSelect);
		#Modified blogs page template
		$this -> SetTemplate(Plugin::GetTemplatePath('categorize') . 'index.blogs.tpl');
		#Add Block
		//$this -> Viewer_AddBlock('right', 'categorize', array('plugin' => 'categorize'));
	}
	/**
	 * Формирует постраничный вывод 
	 * FIXED BUG
	 * @param int $iCount
	 * @param int $iCurrentPage
	 * @param int $iCountPerPage
	 * @param int $iCountPageLine
	 * @param string $sBaseUrl
	 * @param array(name=>value) $aGetParamsList
	 * @return array()
	 */
	public function MakePaging($iCount,$iCurrentPage,$iCountPerPage,$iCountPageLine,$sBaseUrl,$aGetParamsList=null) {		
		if ($iCount==0) {
			return false;
		}
		
		$iCountPage=ceil($iCount/$iCountPerPage); 
		if (!preg_match("/^[1-9]\d*$/i",$iCurrentPage)) {
			$iCurrentPage=1;
		}		
		if ($iCurrentPage>$iCountPage) {
			$iCurrentPage=$iCountPage;
		}
		
		$aPagesLeft=array();		
		$iTemp=$iCurrentPage-$iCountPageLine;
		$iTemp = $iTemp<1 ? 1 : $iTemp; 
		for ($i=$iTemp;$i<$iCurrentPage;$i++) {
			$aPagesLeft[]=$i;
		}
		
		$aPagesRight=array();				 
		for ($i=$iCurrentPage+1;$i<=$iCurrentPage+$iCountPageLine and $i<=$iCountPage;$i++) {
			$aPagesRight[]=$i;
		}
		
		$iNextPage = $iCurrentPage<$iCountPage ? $iCurrentPage+1 : false;
		$iPrevPage = $iCurrentPage>1 ? $iCurrentPage-1 : false;
		# CORE FIX
		$sGetParams='';
		if (isset($aGetParamsList)){
		$sGetParams=urldecode(is_array($aGetParamsList)? '?'.http_build_query($aGetParamsList):'?'.$aGetParamsList);
		}
		$aPaging=array(
			'aPagesLeft' => $aPagesLeft,
			'aPagesRight' => $aPagesRight,
			'iCountPage' => $iCountPage,
			'iCurrentPage' => $iCurrentPage,
			'iNextPage' => $iNextPage,
			'iPrevPage' => $iPrevPage,
			'sBaseUrl' => rtrim($sBaseUrl,'/'),
			'sGetParams' => $sGetParams,
		);
		return $aPaging;
	}
	#END OF CLASS
}
?>