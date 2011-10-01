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

require_once(Config::Get('path.root.server').'/plugins/company/classes/modules/topic/mapper/Topic.mapper.class.php');
//require_once(Config::Get('path.root.server').'/classes/modules/topic/Topic.class.php');
class PluginCompany_ModuleTopic extends PluginCompany_Inherit_ModuleTopic {
	protected $oMapperTopicEx;	
	
	
	public function Init() {	
		parent::Init();	
		$this->oMapperTopicEx = new Mapper_TopicEx($this->Database_GetConnect());
	}
	
	public function GetTopicsLast($iCount) {		
		$aFilter=array(
			'blog_type' => array(
				'personal',
				'open'
			),
			'topic_publish' => 1,			
		);
		if (!Config::Get('module.company.use_activate')) 
			$aFilter['blog_type'] = array('personal','open','company');
		/**
		 * Если пользователь авторизирован, то добавляем в выдачу
		 * закрытые блоги в которых он состоит
		 */
		if($this->oUserCurrent) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			$aActiveCompanyBlogs = $this->PluginCompany_Company_GetCompanyActiveBlogs($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
			if(count($aActiveCompanyBlogs)) $aFilter['blog_type']['company'] = $aActiveCompanyBlogs;
		}	
		$aReturn=$this->GetTopicsByFilter($aFilter,1,$iCount);
		if (isset($aReturn['collection'])) {
			return $aReturn['collection'];
		}
		return false;
	}
	
	public function GetTopicsGood($iPage,$iPerPage,$bAddAccessible=true) {
		$aFilter=array(
			'blog_type' => array(
				'personal',
				'open',
			),
			'topic_publish' => 1,
			'topic_rating'  => array(
				'value' => Config::Get('module.blog.index_good'),
				'type'  => 'top',
				'publish_index'  => 1,
			)
		);
		if (!Config::Get('module.company.use_activate')) 
			$aFilter['blog_type'] = array('personal','open','company');
		/**
		 * Если пользователь авторизирован, то добавляем в выдачу
		 * закрытые блоги в которых он состоит
		 */
		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			$aActiveCompanyBlogs = $this->PluginCompany_Company_GetCompanyActiveBlogs($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
			if(count($aActiveCompanyBlogs)) $aFilter['blog_type']['company'] = $aActiveCompanyBlogs;		
		}
		
		return $this->GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}
	
	/**
	 * Список топиков из блога
	 *
	 * @param unknown_type $oBlog
	 * @param unknown_type $iPage
	 * @param unknown_type $iPerPage
	 * @param unknown_type $sShowType
	 * @return unknown
	 */
	public function GetTopicsByBlog($oBlog,$iPage,$iPerPage,$sShowType='good') {
		$aFilter=array(
			'blog_type' => array(
				$oBlog->getType(),
			),
			'topic_publish' => 1,
			'blog_id' => $oBlog->getId(),
		);
		switch ($sShowType) {
			case 'good':
				$aFilter['topic_rating']=array(
					'value' => Config::Get('module.blog.collective_good'),
					'type'  => 'top',
				);			
				break;	
			case 'bad':
				$aFilter['topic_rating']=array(
					'value' => Config::Get('module.blog.collective_good'),
					'type'  => 'down',
				);			
				break;	
			case 'new':
				$aFilter['topic_new']=date("Y-m-d H:00:00",time()-Config::Get('module.topic.new_time'));							
				break;
			default:
				break;
		}
		/**
		 * Если пользователь авторизирован, то добавляем в выдачу
		 * закрытые блоги в которых он состоит
		 */
		if($this->oUserCurrent) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			$aActiveCompanyBlogs = $this->PluginCompany_Company_GetCompanyActiveBlogs($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
			if(count($aActiveCompanyBlogs)) $aFilter['blog_type']['company'] = $aActiveCompanyBlogs;
		}
		return $this->GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}
	
	public function GetTopicsNew($iPage,$iPerPage,$bAddAccessible=true) {
		$sDate=date("Y-m-d H:00:00",time()-Config::Get('module.topic.new_time'));
		$aFilter=array(
			'blog_type' => array(
				'personal',
				'open',
			),
			'topic_publish' => 1,
			'topic_new' => $sDate,
		);	
		if (!Config::Get('module.company.use_activate')) 
			$aFilter['blog_type'] = array('personal','open','company');
		/**
		 * Если пользователь авторизирован, то добавляем в выдачу
		 * закрытые блоги в которых он состоит
		 */
		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			$aActiveCompanyBlogs = $this->PluginCompany_Company_GetCompanyActiveBlogs($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
			if(count($aActiveCompanyBlogs)) $aFilter['blog_type']['company'] = $aActiveCompanyBlogs;
		}			
		return $this->GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}
	
	/**
	 * Получает список тегов из топиков открытых блогов (open,personal)
	 *
	 * @param  int $iLimit
	 * @return array
	 */
	public function GetOpenTopicTags($iLimit) {
		if (false === ($data = $this->Cache_Get("tag_{$iLimit}_open"))) {			
			$data = $this->oMapperTopicEx->GetOpenTopicTags($iLimit);
			$this->Cache_Set($data, "tag_{$iLimit}_open", array('topic_update','topic_new'), 60*60*24*3);
		}
		return $data;
	}
	
}

?>