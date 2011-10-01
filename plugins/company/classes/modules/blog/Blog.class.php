<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__));
//require_once(Config::Get('path.root.server').'/classes/modules/blog/mapper/Blog.mapper.class.php');
require_once(Config::Get('path.root.server').'/plugins/company/classes/modules/blog/mapper/Blog.mapper.class.php');
//require_once('mapper/Blog.mapper.class.php');

/**
 * Модуль для работы с блогами
 *
 */
//require_once(Config::Get('path.root.server').'/classes/modules/blog/Blog.class.php');
class PluginCompany_ModuleBlog extends PluginCompany_Inherit_ModuleBlog {	

	
	protected $oMapperBlog;	
	protected $oMapperBlogEx;	
	protected $oUserCurrent=null;
		
	/**
	 * Инициализация
	 *
	 */
	public function Init() {
		$this->oMapperBlog=Engine::GetMapper('ModuleBlog');						
		//$this->oMapperBlog=new Mapper_Blog($this->Database_GetConnect());
		$this->oMapperBlog->SetUserCurrent($this->User_GetUserCurrent());
		$this->oMapperBlogEx=new Mapper_BlogEx($this->Database_GetConnect());
		$this->oUserCurrent=$this->User_GetUserCurrent();		
	}
	
	/**
	 * Получает список всех НЕ персональных блогов
	 *
	 * @return unknown
	 */
	public function GetBlogs($bReturnIdOnly=false) {
		$data=$this->oMapperBlogEx->GetBlogs();
		/**
		 * Возвращаем только иденитификаторы
		 */
		if($bReturnIdOnly) return $data;
				
		$data=$this->GetBlogsAdditionalData($data);
		return $data;
	}
		
	/**
	 * Получает список блогов по рейтингу
	 *
	 * @param unknown_type $iLimit
	 * @return unknown
	 */
	public function GetBlogsRating($iCurrPage,$iPerPage) {		
		if (false === ($data = $this->Cache_Get("blog_rating_{$iCurrPage}_{$iPerPage}"))) {				
			$data = array('collection'=>$this->oMapperBlogEx->GetBlogsRating($iCount,$iCurrPage,$iPerPage),'count'=>$iCount);
			$this->Cache_Set($data, "blog_rating_{$iCurrPage}_{$iPerPage}", array("blog_update","blog_new"), 60*60*24*2);
		}
		$data['collection']=$this->GetBlogsAdditionalData($data['collection'],array('owner'=>array(),'relation_user'));
		return $data;
	}
	/**
	 * Список подключенных блогов по рейтингу
	 *
	 * @param unknown_type $sUserId
	 * @param unknown_type $iLimit
	 * @return unknown
	 */
	public function GetBlogsRatingJoin($sUserId,$iLimit) { 		
		if (false === ($data = $this->Cache_Get("blog_rating_join_{$sUserId}_{$iLimit}"))) {				
			$data = $this->oMapperBlogEx->GetBlogsRatingJoin($sUserId,$iLimit);			
			$this->Cache_Set($data, "blog_rating_join_{$sUserId}_{$iLimit}", array('blog_update',"blog_relation_change_{$sUserId}"), 60*60*24);
		}
		return $data;		
	}
	/**
	 * Список сових блогов по рейтингу
	 *
	 * @param unknown_type $sUserId
	 * @param unknown_type $iLimit
	 * @return unknown
	 */
	public function GetBlogsRatingSelf($sUserId,$iLimit) { 		
		if (false === ($data = $this->Cache_Get("blog_rating_self_{$sUserId}_{$iLimit}"))) {				
			$data = $this->oMapperBlogEx->GetBlogsRatingSelf($sUserId,$iLimit);			
			$this->Cache_Set($data, "blog_rating_self_{$sUserId}_{$iLimit}", array('blog_update',"blog_new_user_{$sUserId}"), 60*60*24);
		}
		return $data;		
	}	

	public function GetInaccessibleBlogsByUser($oUser=null) {
		$aCloseBlogs = parent::GetInaccessibleBlogsByUser($oUser);
		$aCloseInactiveBlogs = $this->PluginCompany_Company_GetInaccessibleCompanyBlogs(); //print_r($aCloseInactiveBlogs);
		return array_merge($aCloseBlogs,$aCloseInactiveBlogs);
	}
}
?>