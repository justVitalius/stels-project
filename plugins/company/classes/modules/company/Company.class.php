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
*
*	Module "Company"
*	Author: Grebenkin Anton 
*	Contact e-mail: 4freework@gmail.com
*
---------------------------------------------------------
*/

/**
 * Модуль для работы с компаниями
 *
 */
class PluginCompany_ModuleCompany extends Module {	
	protected $oMapperCompany;	
	protected $oUserCurrent=null;
		
	/**
	 * Инициализация
	 *
	 */
	public function Init() {	
		$this->oMapperCompany=Engine::GetMapper(__CLASS__);			
		//$this->oMapperCompany = new PluginCompany_Mapper_Company($this->Database_GetConnect());
		$this->oMapperCompany->SetUserCurrent($this->User_GetUserCurrent());
		$this->oUserCurrent=$this->User_GetUserCurrent();		
	}
	
	/**
	 * Получить компанию по айдишнику(номеру)
	 *
	 */
	public function GetCompanyById($sCompanyId) {
		return $this->oMapperCompany->GetCompanyById($sCompanyId);
	}
	
	/**
	 * Получить компанию по УРЛу
	 *
	 */
	public function GetCompanyByUrl($sCompanyUrl) {
		$s2=-1;		
		if ($this->oUserCurrent) {
			$s2=$this->oUserCurrent->getId();
		}
		if (false === ($data = $this->Cache_Get("company_url_{$sCompanyUrl}_{$s2}"))) {						
			if ($data = $this->oMapperCompany->GetCompanyByUrl($sCompanyUrl)) {				
				$this->Cache_Set($data, "company_url_{$sCompanyUrl}_{$s2}", array("company_update_{$data->getId()}",'company_new'), 60*5);				
			} else {
				$this->Cache_Set($data, "company_url_{$sCompanyUrl}_{$s2}", array('company_update','company_new'), 60*5);
			}
		}
		return $data;		
	}
	
	/**
	 * Получить компанию по названию
	 *
	 */
	public function GetCompanyByName($sName) {		
		if (false === ($data = $this->Cache_Get("company_name_{$sName}"))) {						
			if ($data = $this->oMapperCompany->GetCompanyByName($sName)) {				
				$this->Cache_Set($data, "company_name_{$sName}", array("company_update_{$data->getId()}",'company_new'), 60*5);				
			} else {
				$this->Cache_Set($data, "company_name_{$sName}", array('company_update','company_new'), 60*5);
			}
		}
		return $data;		
	}
	
	/**
	 * Получить компанию по ид отзыва
	 *
	 */
	public function GetCompanyByFeedbackId($sCompanyId) {
		return $this->oMapperCompany->GetCompanyByFeedbackId($sCompanyId);
	}
	
	public function GetCompaniesRating($iCurrPage,$iPerPage) { 
		$s1=-1;		
		if ($this->oUserCurrent) {
			$s1=$this->oUserCurrent->getId();
		}
		if (false === ($data = $this->Cache_Get("company_rating_{$iCurrPage}_{$iPerPage}_$s1"))) {				
			$data = array('collection'=>$this->oMapperCompany->GetCompaniesRating($iCount,$iCurrPage,$iPerPage),'count'=>$iCount);
			$this->Cache_Set($data, "company_rating_{$iCurrPage}_{$iPerPage}_$s1", array("company_update","company_new"), 60*15);
		}
		return $data;		
	}
	
	public function GetCompaniesRatingByUserId($sUserId,$iCurrPage,$iPerPage) { 
		$Ids = $this->Blog_GetBlogUsersByUserId($sUserId, null, true);
		$Ids = array_merge($this->Blog_GetBlogsByOwnerId($sUserId,true), $Ids); 
		
		$aFilter = array('blog_id' => $Ids,);
		$s=serialize($aFilter);	

		if (false === ($data = $this->Cache_Get("company_rating_{$iCurrPage}_{$iPerPage}_$s"))) {				
			$data = array('collection'=>$this->oMapperCompany->GetCompaniesRatingByFilter($iCount,$iCurrPage,$iPerPage,$aFilter),'count'=>$iCount);
			$this->Cache_Set($data, "company_rating_{$iCurrPage}_{$iPerPage}_$s", array("company_update","company_new"), 60*15);
		}
		return $data;		
	}
	
	public function GetCompaniesByCity($sCity, $iCurrPage, $iPerPage) { 
		$s1=-1;		
		if ($this->oUserCurrent) {
			$s1=$this->oUserCurrent->getId();
		}
		if (false === ($data = $this->Cache_Get("company_city_{$sCity}_{$iCurrPage}_{$iPerPage}_$s1"))) {				
			$data = array('collection'=>$this->oMapperCompany->GetCompaniesByCity($iCount,$iCurrPage,$iPerPage,$sCity),'count'=>$iCount);
			$this->Cache_Set($data, "company_city_{$sCity}_{$iCurrPage}_{$iPerPage}_$s1", array("company_update","company_new"), 60*15);
		}
		return $data;		
	}
	
	/**
	 * Изменяет владельца компании
	 *
	 */
	public function ReplaceCompanyOwner(ModuleBlog_EntityBlog $oBlog, ModuleUser_EntityUser $oUser) {
		$oBlog->setOwnerId($oUser->getId());
		$this->oMapperCompany->UpdateCompanyBlogOwner($oBlog);
		$this->oMapperCompany->UpdateCompanyOwner($oBlog);
		// Если пользователь был в уже в компании.
		$oBlogUser=$this->Blog_GetBlogUserByBlogIdAndUserId($oBlog->getId(),$oUser->getId());	
		if ($oBlogUser){
			$this->Blog_DeleteRelationBlogUser($oBlogUser);
		}
		return true;
	}
	/**
	 * Добавляет компанию
	 *
	 */
	public function AddCompany(PluginCompany_ModuleCompany_EntityCompany $oCompany) {
		// Создаем блог компании		
		if ($oBlog = $this->CreateCompanyBlog($oCompany)){
			$oCompany->setBlogId($oBlog->getId());
		
			// Создаем саму компанию
			if ($sId=$this->oMapperCompany->AddCompany($oCompany)) {
				$oCompany->setId($sId);
				// разбираем и добавляем теги.
				$aTags=explode(',',$oCompany->getTags());
				foreach ($aTags as $sTag) {
					$oTag=Engine::GetEntity('PluginCompany_Company_CompanyTag');//new ModuleCompany_EntityCompanyTag();
					$oTag->setCompanyId($oCompany->getId());
					$oTag->setUserId($oCompany->getOwnerId());
					$oTag->setText(trim($sTag));
					$this->oMapperCompany->AddCompanyTag($oTag);
				}
				// Добавляем админа в связь
				/*$oCompanyUserNew=Engine::GetEntity('PluginCompany_Company_CompanyUser');//new ModuleCompany_EntityCompanyUser();
				$oCompanyUserNew->setCompanyId($oCompany->getId());
				$oCompanyUserNew->setUserId($oCompany->getOwnerId());
				$oCompanyUserNew->setUserRole(100); // делаем админом сразу
				$this->AddRelationCompanyUser($oCompanyUserNew); */
				//чистим зависимые кеши
				$this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array('company_new'));	
								
				return $oCompany;
			}
		}
		return false;
	}
	
	/**
	 * Удаляет теги у компании
	 *
	 */
	public function DeleteCompanyTagsByCompanyId($sCompanyId) {
		return $this->oMapperCompany->DeleteCompanyTagsByCompanyId($sCompanyId);
	}
	/**
	 * Обновляет компанию
	 *
	 * @param ModuleCompany_EntityCompany $oCompany
	 * @return unknown
	 */
	public function UpdateCompany(PluginCompany_ModuleCompany_EntityCompany $oCompany) {		
		if ($this->oMapperCompany->UpdateCompany($oCompany)) {		
			// разбираем и добавляем теги.
			$aTags=explode(',',$oCompany->getTags());
			$this->DeleteCompanyTagsByCompanyId($oCompany->getId());
			foreach ($aTags as $sTag) {
				$oTag= Engine::GetEntity('PluginCompany_Company_CompanyTag');//ModuleCompany_EntityCompanyTag();
				$oTag->setCompanyId($oCompany->getId());
				$oTag->setUserId($oCompany->getOwnerId());
				$oTag->setText($sTag);
				$this->oMapperCompany->AddCompanyTag($oTag);
			}	
			$this->UpdateCompanyBlog($oCompany);
			//чистим зависимые кеши
			$this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array('company_update',"company_update_{$oCompany->getId()}"));
			return true;
		}
		return false;
	}
	
	/**
	 * Удаление компании
	 * Если тип таблиц в БД InnoDB, то удалятся всё связи по компании.
	 *
	 */
	public function DeleteCompany($sCompanyId) {
		$oCompany = $this->oMapperCompany->GetCompanyById($sCompanyId); 
		$this->oMapperCompany->DeleteBlog($oCompany->getBlogId());
		$this->Comment_DeleteCommentByTargetId($sCompanyId,'company');
		//чистим зависимые кеши			
		$this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array('company_update',"company_update_{$oCompany->getId()}"));						
		return $this->oMapperCompany->DeleteCompany($sCompanyId);
	}
	
	/**
	 * Добавляет голосование за компанию
	 *
	 */
	public function AddCompanyVote(PluginCompany_ModuleCompany_EntityCompanyVote $oCompanyVote) {
		if ($this->oMapperCompany->AddCompanyVote($oCompanyVote)) {			
			return true;
		}
		return false;
	}
	
	/**
	 * Получает список компаний по тегу
	 *
	 */
	public function GetCompaniesByTag($sTag,$iCount,$iPage,$iPerPage) {		
		if (false === ($data = $this->Cache_Get("company_tag_{$sTag}_{$iPage}_{$iPerPage}"))) {			
			$data = array('collection'=>$this->oMapperCompany->GetCompaniesByTag($sTag,$iCount,$iPage,$iPerPage),'count'=>$iCount);
			$this->Cache_Set($data, "company_tag_{$sTag}_{$iPage}_{$iPerPage}", array('company_update','company_new'), 60*15);
		}
		return $data;		
	}
	
	/**
	 * Получает список тегов компаний по первым буквам тега
	 *
	 */
	public function GetCompanyTagsByLike($sTag,$iLimit) {
		if (false === ($data = $this->Cache_Get("company_tag_like_{$sTag}_{$iLimit}"))) {			
			$data = $this->oMapperCompany->GetCompanyTagsByLike($sTag,$iLimit);
			$this->Cache_Set($data, "company_tag_like_{$sTag}_{$iLimit}", array("company_update","company_new"), 60*15);
		}
		return $data;		
	}
	
	/**
	 * Получает список тегов компаний
	 *
	 */
	public function GetCompanyTags($iLimit) {
		if (false === ($data = $this->Cache_Get("companytag_{$iLimit}"))) {			
			$data = $this->oMapperCompany->GetCompanyTags($iLimit);
			$this->Cache_Set($data, "companytag_{$iLimit}", array('company_update','company_new'), 60*15);
		}
		return $data;		
	}
	
	/**
	 * Получает список городов компаний
	 *
	 */
	public function GetCompanyCities($iLimit) {
		if (false === ($data = $this->Cache_Get("company_cities_{$iLimit}"))) {			
			$data = $this->oMapperCompany->GetCompanyCities($iLimit);
			$this->Cache_Set($data, "company_cities_{$iLimit}", array('company_update','company_new'), 60*15);
		}
		return $data;		
	}
	
	
	/**
	 * Получает голосование за компанию(проверяет голосовал ли юзер за эту компанию)
	 *
	 */
	public function GetCompanyVote($sCompanyId,$sUserId) {
		return $this->oMapperCompany->GetCompanyVote($sCompanyId,$sUserId);
	}
	
	/**
	 * Увеличивает число отзывов о компании
	 *
	 */
	public function increaseCompanyCountFeedbacks($sCompanyId) {
		$this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array('company_update',"company_update_{$sCompanyId}"));						
		return $this->oMapperCompany->increaseCompanyCountFeedbacks($sCompanyId);
	}
		
	/**
	 * Обновляем/устанавливаем дату прочтения отзыва, если читаем его первый раз то добавляем
	 * 
	 */
	public function SetFeedbackRead(PluginCompany_ModuleCompany_EntityCompanyFeedbackRead $oFeedbackRead) {		
		if ($this->GetFeedbackRead($oFeedbackRead->getCompanyId(),$oFeedbackRead->getUserId())) {
			$this->oMapperCompany->UpdateFeedbackRead($oFeedbackRead);
		} else {
			$this->oMapperCompany->AddFeedbackRead($oFeedbackRead);
		}
		return true;		
	}	
	/**
	 * Получаем дату прочтения отзыва юзером
	 *
	 */
	public function GetFeedbackRead($sCompanyId,$sUserId) {
		return $this->oMapperCompany->GetFeedbackRead($sCompanyId,$sUserId);
	}
	
	/**
	 * Привязывает страну к компании
	 *
	 */
	public function SetCompanyCountry($sCompanyId,$sCountryId) {
		return $this->oMapperCompany->SetCompanyCountry($sCompanyId,$sCountryId);
	}
	
	/**
	 * Привязывает город к компании
	 *
	 */
	public function SetCompanyCity($sCompanyId,$sCityId) {
		return $this->oMapperCompany->SetCompanyCity($sCompanyId,$sCityId);
	}
	
	
	/* Проверки прав*/
	/**
	 * Проверяет может ли пользователь создавать компании
	 *
	 */
	public function CanCreateCompany(ModuleUser_EntityUser $oUser) {
		if ($oUser->getRating()>=Config::Get('acl.create.company.rating') or $oUser->isAdministrator()) {
			return true;
		}
		return false;
	}
	
	/**
	 * Проверяет может ли пользователь голосовать за конкретный блог
	 *
	 */
	public function CanVoteCompany(ModuleUser_EntityUser $oUser, PluginCompany_ModuleCompany_EntityCompany $oCompany) {
		if ($oUser->getRating()>=Config::Get('acl.vote.company.rating') or $oUser->isAdministrator()) {
			return true;
		}
		return false;
	}
	
	/**
	 * Проверяет может ли пользователь писать отзывы
	 *
	 */
	public function CanPostFeedback(ModuleUser_EntityUser $oUser) {
		if ($oUser->getRating()>=Config::Get('acl.create.feedback.rating') or $oUser->isAdministrator()) {
			return true;
		}
		return false;
	}
	
	/**
	 * Получает список топиков из компании
	 *
	 */
	public function GetTopicsCompany($iCount,$iPage,$iPerPage) {
		$aFilter=array(
			'blog_type' => array(
				'company',
			),
			'topic_publish' => 1,
		);
		return $this->Topic_GetTopicsByFilter($aFilter,$iPage,$iPerPage);		
	}
	
	/**
	 * Получает число новых топиков в корпоративных блогах
	 *
	 */
	public function GetCountTopicsCompanyNew() {
		$sDate=date("Y-m-d H:00:00",time()-Config::Get('module.topic.new_time'));
		$aFilter=array(
			'blog_type' => array(
				'company',
			),
			'topic_publish' => 1,
			'topic_new' => $sDate,
		);				
		return $this->Topic_GetCountTopicsByFilter($aFilter);
	}
	
	/**
	 * Создаёт корпоративный блог
	 *
	 */
	public function CreateCompanyBlog(PluginCompany_ModuleCompany_EntityCompany $oCompany) {
		$oBlog = Engine::GetEntity('Blog');//BlogEntity_Blog();
		$oBlog->setOwnerId($oCompany->getOwnerId());
		$oBlog->setTitle($this->Lang_Get('company_blog_prefix').' '.$oCompany->getName());
		$oBlog->setType('company');
		$oBlog->setDescription($oCompany->getDescription());
		$oBlog->setDateAdd(date("Y-m-d H:i:s")); 
		$oBlog->setLimitRatingTopic(-100);
		$oBlog->setUrl('company_company_'.$oCompany->GetUrl());	// company_ вырезается в getUrl() поэтому при создании пишем 2 раза..
		$oBlog->setAvatar(0);
		return $this->Blog_AddBlog($oBlog);		
	}
	
	/**
	 * Обновляет описание и заголовок корпоративного блога
	 *
	 */
	public function UpdateCompanyBlog(PluginCompany_ModuleCompany_EntityCompany $oCompany) {
		$oBlog = $this->Blog_GetBlogById($oCompany->getBlogId());	
		$oBlog->setTitle($this->Lang_Get('company_blog_prefix').' '.$oCompany->getName());
		$oBlog->setDescription($oCompany->getDescription());
		$oBlog->setUrl('company_company_'.$oCompany->GetUrl()); // Для того чтобы не терялся префикс при апдейте
		return $this->Blog_UpdateBlog($oBlog);		
	}
	
	/**
	 * Получает информацию о компании, с данными по правам
	 *
	 */
	public function GetCompanyWithAddData($sCompanyUrl) {
		if (!($oCompany=$this->GetCompanyByUrl($sCompanyUrl))) {
			return false;
		} 
		return $this->GetCompanyAddData($oCompany);
	}
	
	public function GetCompanyAddData($oCompany) {
		$oBlog = $this->Blog_GetBlogById($oCompany->getBlogId());
		$oCompany->setUserIsJoin($oBlog->getUserIsJoin());  
		$oCompany->setUserIsAdministrator($oBlog->getUserIsAdministrator()); 
		$oCompany->setUserIsModerator($oBlog->getUserIsModerator()); 
		$oCompany->setOwner($oBlog->getOwner()); 
		$oCompany->setBlog($oBlog); 
		return $oCompany;
	}
	
	public function GetTopicsByBlog($oBlog,$iPage,$iPerPage,$sShowType='good') {
		$aFilter=array(
			'blog_type' => array(
				'company',
			),
			'topic_publish' => 1,
			'blog_id' => $oBlog->getId(),
		);
		return $this->Topic_GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}
	
	/**
	 * Расчет рейтинга и силы при голосовании за компанию
	 *
	 * @param UserEntity_User $oUser
	 * @param ModuleCompany_EntityCompany $oCompany
	 * @param unknown_type $iValue
	 */
	public function VoteCompany(ModuleUser_EntityUser $oUser, PluginCompany_ModuleCompany_EntityCompany $oCompany, $iValue) {		
		/**
		 * Устанавливаем рейтинг блога, используя логарифмическое распределение
		 */		
		$skill=$oUser->getSkill();	
		$iMinSize=1.13;
		$iMaxSize=15;
		$iSizeRange=$iMaxSize-$iMinSize;
		$iMinCount=log(0+1);
		$iMaxCount=log(500+1);
		$iCountRange=$iMaxCount-$iMinCount;
		if ($iCountRange==0) {
			$iCountRange=1;
		}		
		if ($skill>50 and $skill<200) {
			$skill_new=$skill/20;
		} elseif ($skill>=200) {
			$skill_new=$skill/10;
		} else {
			$skill_new=$skill/50;
		}
		$iDelta=$iMinSize+(log($skill_new+1)-$iMinCount)*($iSizeRange/$iCountRange);
		/**
		 * Сохраняем рейтинг
		 */
		$oCompany->setRating($oCompany->getRating()+$iValue*$iDelta);		
	}
	
	public function GetCompaniesByUserId($sUserId,$iRole=null,$bWithOwner=false) {		
		$Ids = $this->Blog_GetBlogUsersByUserId($sUserId, $iRole, true);
		if ($bWithOwner){ // Добавляем еще хозяев компаний
			$Ids = array_merge($this->Blog_GetBlogsByOwnerId($sUserId,true), $Ids); 
		}
		return $this->oMapperCompany->GetCompaniesByBlogId($Ids);	
	}
	
	public function GetUserIsEmployee($sUserId,$oCompany) {		
		$aUserCompanies = $this->GetCompaniesByUserId($sUserId,array(ModuleBlog::BLOG_USER_ROLE_USER,ModuleBlog::BLOG_USER_ROLE_MODERATOR,ModuleBlog::BLOG_USER_ROLE_ADMINISTRATOR), true);
		if (isset($aUserCompanies[$oCompany->getId()])) {
			return true;
		}
		return false;
	}
	
/**
	 * Получает дополнительные данные(объекты) для компаний по их ID
	 *
	 */
	public function GetCompaniesAdditionalData($aCompanyId,$aAllowData=array('owner'=>array(),'blog'=>array('owner'=>array()),'vote','favourite','comment_new')) {
		func_array_simpleflip($aAllowData);
		if (!is_array($aCompanyId)) {
			$aCompanyId=array($aCompanyId);
		}
		/**
		 * Получаем "голые" топики
		 */
		$aCompanies=$this->GetCompaniesByArrayId($aCompanyId);
		/**
		 * Формируем ID дополнительных данных, которые нужно получить
		 */
		$aUserId=array();
		$aBlogId=array();		
		foreach ($aCompanies as $oCompany) {
			if (isset($aAllowData['owner'])) {
				$aUserId[]=$oCompany->getOwnerId();
			}
			if (isset($aAllowData['blog'])) {
				$aBlogId[]=$oCompany->getBlogId();
			}
		}
		/**
		 * Получаем дополнительные данные
		 */
		$aUsers=isset($aAllowData['owner']) && is_array($aAllowData['owner']) ? $this->User_GetUsersAdditionalData($aUserId,$aAllowData['owner']) : $this->User_GetUsersAdditionalData($aUserId);
		$aBlogs=isset($aAllowData['blog']) && is_array($aAllowData['blog']) ? $this->Blog_GetBlogsAdditionalData($aBlogId,$aAllowData['blog']) : $this->Blog_GetBlogsAdditionalData($aBlogId);		
		/* 
		$aTopicsVote=array();
		$aFavouriteComapnies=array();
		$aFeebacksRead=array();
		if (isset($aAllowData['vote']) and $this->oUserCurrent) {
			$aTopicsVote=$this->Vote_GetVoteByArray($aCompanyId,'company',$this->oUserCurrent->getId());
		}	
		if (isset($aAllowData['favourite']) and $this->oUserCurrent) {
			$aFavouriteComapnies=$this->GetFavouriteCompaniesByArray($aCompanyId,$this->oUserCurrent->getId());	
		}
		if (isset($aAllowData['comment_new']) and $this->oUserCurrent) {
			$aFeebacksRead=$this->GetFeedbacksReadByArray($aCompanyId,$this->oUserCurrent->getId());	
		}*/
		/**
		 * Добавляем данные к результату - списку топиков
		 */
		foreach ($aCompanies as $oCompany) {
			if (isset($aUsers[$oCompany->getUserId()])) {
				$oCompany->setOwner($aUsers[$oCompany->getUserId()]);
			} else {
				$oCompany->setOwner(null); // или $oTopic->setUser(new UserEntity_User());
			}
			if (isset($aBlogs[$oCompany->getBlogId()])) {
				$oCompany->setBlog($aBlogs[$oCompany->getBlogId()]);
			} else {
				$oCompany->setBlog(null); // или $oTopic->setBlog(new BlogEntity_Blog());
			}
			/*if (isset($aTopicsVote[$oCompany->getId()])) {
				$oCompany->setVote($aTopicsVote[$oCompany->getId()]);				
			} else {
				$oCompany->setVote(null);
			}
			if (isset($aFavouriteComapnies[$oCompany->getId()])) {
				$oCompany->setIsFavourite(true);
			} else {
				$oCompany->setIsFavourite(false);
			}			
			if (isset($aTopicsRead[$oCompany->getId()]))	{		
				$oCompany->setCountCommentNew($oCompany->getCountComment()-$aTopicsRead[$oCompany->getId()]->getCommentCountLast());
				$oTopic->setDateRead($aTopicsRead[$oCompany->getId()]->getDateRead());
			} else {
				$oCompany->setCountCommentNew(0);
				$oCompany->setDateRead(date("Y-m-d H:i:s"));
			}	*/					
		}
		return $aCompanies;
	}
	
	public function GetCompaniesByArrayId($aCompanyId) {		
		if (!$aCompanyId) {
			return array();
		}
		if (!is_array($aCompanyId)) {
			$aCompanyId=array($aCompanyId);
		}
		$aCompanyId=array_unique($aCompanyId);
		$aComapanies=array();
		$aCompanyIdNotNeedQuery=array();
		/**
		 * Делаем мульти-запрос к кешу
		 */
		$aCacheKeys = func_build_cache_keys($aCompanyId,'company_');
		if (false !== ($data = $this->Cache_Get($aCacheKeys))) {
			/**
			 * проверяем что досталось из кеша
			 */
			foreach ($aCacheKeys as $sValue => $sKey ) {
				if (array_key_exists($sKey,$data)) {
					if ($data[$sKey]) {
						$aComapanies[$data[$sKey]->getId()]=$data[$sKey];
					} else {
						$aCompanyIdNotNeedQuery[]=$sValue;
					}
				}
			}
		}
		/**
		 * Смотрим каких юзеров не было в кеше и делаем запрос в БД
		 */		
		$aCompanyIdNeedQuery=array_diff($aCompanyId,array_keys($aComapanies));
		$aCompanyIdNeedQuery=array_diff($aCompanyIdNeedQuery,$aCompanyIdNotNeedQuery);
		$aCompanyIdNeedStore=$aCompanyIdNeedQuery;
		if ($data = $this->oMapperCompany->GetCompaniesByArrayId($aCompanyIdNeedQuery)) {
			foreach ($data as $oCompany) {
				/**
				 * Добавляем к результату и сохраняем в кеш
				 */
				$aComapanies[$oCompany->getId()]=$oCompany;
				$this->Cache_Set($oCompany, "company_{$oCompany->getId()}", array(), 60*60*24*4);
				$aCompanyIdNeedStore=array_diff($aCompanyIdNeedStore,array($oCompany->getId()));
			}
		}
		/**
		 * Сохраняем в кеш запросы не вернувшие результата
		 */
		foreach ($aCompanyIdNeedStore as $sId) {
			$this->Cache_Set(null, "company_{$sId}", array(), 60*60*24*4);
		}
		/**
		 * Сортируем результат согласно входящему массиву
		 */
		$aComapanies = func_array_sort_by_keys($aComapanies,$aCompanyId);
		return $aComapanies;
	}
	
	public function Convert(){
		return $this->oMapperCompany->Convert();
	}
	
	public function RepairUrl(){
		return $this->oMapperCompany->RepairUrl();
	}
	
	public function GetInaccessibleCompanyBlogs() {
		if ($this->oUserCurrent && $this->oUserCurrent->isAdministrator()) {
			return array();
		}
		$aCloseBlogs=array();
		$aCloseBlogs = $this->oMapperCompany->GetCompanyInactiveBlogs();
		return $aCloseBlogs;
	}
	
	public function GetCompanyActiveBlogs($oUser) {
		return $this->oMapperCompany->GetCompanyActiveBlogs($oUser);
	}
	
	/*
	public function GetCompaniesByArrayIdSolid($aCompanyId) {
		if (!is_array($aCompanyId)) {
			$aCompanyId = array($aCompanyId);
		}
		$aCompanyId = array_unique($aCompanyId);
		$aCompanies = array();
		$s=join(',',$aCompanyId);
		if (false === ($data = $this->Cache_Get("company_id_{$s}"))) {
			$data = $this->oMapper->GetCompaniesByArrayId($aCompanyId);
			foreach ($data as $oCompany) {
				$aCompanies[$oUser->getId()] = $oCompany;
			}
			$this->Cache_Set($aCompanies, "company_id_{$s}", array("company_update"), 60*60*24*1);
			return $aCompanies;
		}
		return $data;
	}*/
}
?>