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

class PluginCompany_ActionCompany extends ActionPlugin {
	/**
	 * Главное меню
	 *
	 */
	protected $sMenuHeadItemSelect='company';
	/**
	 * Меню
	 *
	 */
	protected $sMenuItemSelect='company';
	/**
	 * Субменю
	 *
	 */
	protected $sMenuSubItemSelect='good';
	/**
	 * Текущий пользователь
	 *
	 */
	protected $oUserCurrent=null;
	protected $aBadCompanyUrl = array('new','good','bad','edit','add','admin','vacancies','feedbacks','blog','page','city','rss','company','test','user','my');
	
	/**
	 * Инициализация
	 *
	 */
	public function Init() {		
		$this->SetDefaultEvent('');
		/**
		 * Достаём текущего пользователя
		 */
		$this->oUserCurrent=$this->User_GetUserCurrent();
		$this->Viewer_AddBlock('right','stream');
		$this->Viewer_AddBlock('right','companytags',array('plugin'=>'company'));
		$this->Viewer_AddBlock('right','companycities',array('plugin'=>'company'));	
	}
	
	
	/**
	 * Регистрируем необходимые евенты
	 *
	 */
	protected function RegisterEvent() {		
		$this->AddEvent('add','EventAddCompany');
		$this->AddEvent('edit','EventEditCompany');
		$this->AddEvent('admin','EventAdminCompany');
		$this->AddEvent('blog','EventShowCorporativeBlogs');
		$this->AddEvent('delete','EventDelete');
		$this->AddEvent('city','EventShowCompaniesByCity');
		$this->AddEvent('test','EventTest');
		$this->AddEvent('ajaxaddfeedback','AjaxAddFeedback');		
		$this->AddEvent('convert','EventConvert');	
		$this->AddEvent('repair','EventRepair');
		$this->AddEvent('activate','EventActivate');		
		$this->AddEvent('deactivate','EventActivate');	
		
		
		$this->AddEventPreg('/^user$/i','/^[\w\-\_]+$/i','/^feedbacks$/i','/^(page(\d+))?$/i','EventUser');	
		$this->AddEventPreg('/^my$/i','/^(page(\d+))?$/i','EventShowMyCompanies');	
		$this->AddEventPreg('/^(page(\d+))?$/i','EventShowCompanies');	
		$this->AddEventPreg('/^[\w\-\_]+$/i','/^(\d+)\.html$/i','EventShowTopic');
		$this->AddEventPreg('/^[\w\-\_]+$/i','/^$/i','EventShowCompanyProfile');
		$this->AddEventPreg('/^[\w\-\_]+$/i','/^blog$/i','/^(\d+)\.html$/i','EventShowTopic');
		$this->AddEventPreg('/^[\w\-\_]+$/i','/^blog$/','EventShowCompanyBlog');
		
		$this->AddEventPreg('/^[\w\-\_]+$/i','/^comments$/','EventShowCompanyBlog');	// add comment routing
		
		$this->AddEventPreg('/^[\w\-\_]+$/i','/^vacancies$/','EventShowCompanyVacancies');
		$this->AddEventPreg('/^[\w\-\_]+$/i','/^feedbacks$/','EventShowCompanyFeedbacks');	
		$this->AddEventPreg('/^[\w\-\_]+$/i','/^rss$/','RssCompanyBlog');	
	}
		
	
	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */
	

	
	/**
	 * Создает новую компанию
	 *
	 */
	protected function EventAddCompany() {	
		$this->sMenuSubItemSelect='add';
		/**
		 * Проверяем авторизован ли пользователь
		 */
		if (!$this->User_IsAuthorization()) {
			$this->Message_AddErrorSingle($this->Lang_Get('not_access'),$this->Lang_Get('error')); 
			return Router::Action('error'); 
		}
		
		/**
		 * Проверяем хватает ли рейтинга пользователю чтобы зарегистрировать компанию
		 */ 
		if (!$this->PluginCompany_Company_CanCreateCompany($this->oUserCurrent) and !$this->oUserCurrent->isAdministrator()) {
			$this->Message_AddErrorSingle($this->Lang_Get('company_error_lowrating'),$this->Lang_Get('error'));
			return Router::Action('error');
		}	
		/**
		 * Если нажали кнопку "Зарегистрировать"
		 */
		if (isset($_REQUEST['submit_add_company'])) {

			
			if (!$this->checkCompanyFields()){
				return false;
			}

			$oCompany = Engine::GetEntity('PluginCompany_Company_Company');
			$oCompany->setOwnerId($this->oUserCurrent->getId());
			$oCompany->setName(getRequest('company_name'));
			if (Config::Get('module.company.use_convert_url')){
				$oCompany->setUrl(func_translit_url($oCompany->getName()));
			} else{
				$oCompany->setUrl(getRequest('company_url'));
			}
			// убираем все теги из текста.
			$sText=$this->Text_Parser(getRequest('company_description'));
			$oCompany->setDescription($sText);
			$oCompany->setTags(getRequest('company_tags'));
			$oCompany->setCountry(getRequest('company_country'));
			$oCompany->setCity(getRequest('company_city'));
			$oCompany->setDateAdd(date("Y-m-d H:i:s"));
			/**
		 	* Создаём компанию
		 	*/
			if ($this->PluginCompany_Company_AddCompany($oCompany)) {
				func_header_location(Config::Get('module.company.url').'/edit/'.$oCompany->getId().'/');
			} else {
				$this->Message_AddError($this->Lang_Get('system_error'));
			}
		}
		$this->Viewer_AddHtmlTitle($this->Lang_Get('company_title_add')); 
		$this->Viewer_AddBlock('right','companies',array('plugin'=>'company'));	
		$this->SetTemplateAction('add');	
	}
	
	/**
	 * Редактирование компании
	 *
	 * @return unknown
	 */
	protected function EventEditCompany() {	
		$this->Viewer_AddMenu('company_edit',Plugin::GetTemplatePath('company').'menu.company_edit.tpl'); 	
		/**
		 * Меню
		 */
		$this->sMenuSubItemSelect='';
		$this->sMenuItemSelect='profile';
		
		/**
		 * Проверяем передан ли в УРЛе номер блога
		 */
		$sCompanyId=$this->GetParam(0);
		if (!$oCompany=$this->PluginCompany_Company_GetCompanyById($sCompanyId)) {
			return parent::EventNotFound();
		}
		/**
		 * Проверям авторизован ли пользователь
		 */
		if (!$this->User_IsAuthorization()) {
			$this->Message_AddErrorSingle($this->Lang_Get('not_access'),$this->Lang_Get('error')); 
			return Router::Action('error'); 
		}
		
		/**
		 * Явлется ли авторизованный пользователь хозяином компании, либо ее администратором
		 */
		$oBlogUser=$this->Blog_GetBlogUserByBlogIdAndUserId($oCompany->getBlogId(),$this->oUserCurrent->getId());		
		$bIsAdministratorBlog=$oBlogUser ? $oBlogUser->getIsAdministrator() : false;
		if ($oCompany->getOwnerId()!=$this->oUserCurrent->getId()  and !$this->oUserCurrent->isAdministrator() and !$bIsAdministratorBlog) {
			return parent::EventNotFound();
		}
		$this->Viewer_AddHtmlTitle($oCompany->getName());
		$this->Viewer_AddHtmlTitle($this->Lang_Get('company_title_edit')); 
		
		$this->Viewer_Assign('oCompanyEdit',$oCompany);
		/**
		 * Устанавливаем шалон для вывода
		 */		
		$this->SetTemplateAction('edit');
		/**
		 * Если нажали кнопку "Сохранить изменения"
		 */
		if (isset($_REQUEST['submit_edit_company'])) {
			if (!$this->checkCompanyFields($oCompany)) {
				return false;
			}		
			return $this->SubmitEdit($oCompany);
		}	
		$this->Viewer_AddBlock('right','companies',array('plugin'=>'company'));	
	}
	
	/**
	 * Администрирование компании
	 *
	 * @return unknown
	 */
	protected function EventAdminCompany() {
		$this->Viewer_AddMenu('company_edit',Plugin::GetTemplatePath('company').'menu.company_edit.tpl'); 
		$this->Viewer_AddBlock('right','companies',array('plugin'=>'company'));			
		/**
		 * Меню
		 */
		$this->sMenuSubItemSelect='';
		$this->sMenuItemSelect='admin';
		
		/**
		 * Проверяем передан ли в УРЛе номер блога
		 */
		$sCompanyId=$this->GetParam(0);
		if (!$oCompany=$this->PluginCompany_Company_GetCompanyById($sCompanyId)) {
			return parent::EventNotFound();
		}
		
		$oBlog = $this->Blog_GetBlogById($oCompany->getBlogId());
		/**
		 * Проверям авторизован ли пользователь
		 */
		if (!$this->User_IsAuthorization()) {
			$this->Message_AddErrorSingle($this->Lang_Get('not_access'),$this->Lang_Get('error')); 
			return Router::Action('error');
		}
	
		/**
		 * Явлется ли авторизованный пользователь хозяином компании, либо ее администратором
		 */
		$oBlogUser=$this->Blog_GetBlogUserByBlogIdAndUserId($oBlog->getId(),$this->oUserCurrent->getId());		
		$bIsAdministratorBlog=$oBlogUser ? $oBlogUser->getIsAdministrator() : false;
		if ($oBlog->getOwnerId()!=$this->oUserCurrent->getId()  and !$this->oUserCurrent->isAdministrator() and !$bIsAdministratorBlog) {
			return parent::EventNotFound();
		}					
		/**
		 * Обрабатываем сохранение формы
		 */
		if (isPost('submit_company_admin')) {
			
			$aUserRank=getRequest('user_rank',array());
			if (!is_array($aUserRank)) {
				$aUserRank=array();
			}
			foreach ($aUserRank as $sUserId => $sRank) {
				if (!($oBlogUser=$this->Blog_GetBlogUserByBlogIdAndUserId($oBlog->getId(),$sUserId))) {
					$this->Message_AddError($this->Lang_Get('system_error'),$this->Lang_Get('error'));
					break;
				}
				
				switch ($sRank) {
					case 'administrator':
						$oBlogUser->setUserRole(ModuleBlog::BLOG_USER_ROLE_ADMINISTRATOR);
						break;
					case 'moderator':
						$oBlogUser->setUserRole(ModuleBlog::BLOG_USER_ROLE_MODERATOR);
						break;
					case 'employee':
						$oBlogUser->setUserRole(ModuleBlog::BLOG_USER_ROLE_USER);
						break;
					default:
						$oBlogUser->setUserRole(ModuleBlog::BLOG_USER_ROLE_GUEST);						
				}
				$this->Blog_UpdateRelationBlogUser($oBlogUser);
				$this->Message_AddNoticeSingle($this->Lang_Get('company_notice_edit_users'));
			}
		}
		
		/**
		 * Получаем список подписчиков блога
		 */
		$aBlogUsers=$this->Blog_GetBlogUsersByBlogId(
			$oBlog->getId(),
			array(
				ModuleBlog::BLOG_USER_ROLE_GUEST,
				ModuleBlog::BLOG_USER_ROLE_USER,
				ModuleBlog::BLOG_USER_ROLE_MODERATOR,
				ModuleBlog::BLOG_USER_ROLE_ADMINISTRATOR
			)
		);
		
		$this->Viewer_Assign('oBlog',$oBlog);
		$this->Viewer_Assign('aBlogUsers',$aBlogUsers);
		
		$this->Viewer_Assign('BLOG_USER_ROLE_GUEST', ModuleBlog::BLOG_USER_ROLE_GUEST);
		$this->Viewer_Assign('BLOG_USER_ROLE_USER', ModuleBlog::BLOG_USER_ROLE_USER);
		$this->Viewer_Assign('BLOG_USER_ROLE_MODERATOR', ModuleBlog::BLOG_USER_ROLE_MODERATOR);
		$this->Viewer_Assign('BLOG_USER_ROLE_ADMINISTRATOR', ModuleBlog::BLOG_USER_ROLE_ADMINISTRATOR);
		
		if (isset($_REQUEST['submit_company_own'])) {
			if ($oBlog->getOwnerId() == $this->oUserCurrent->getId() or $this->oUserCurrent->isAdministrator()){
				$sUsers=getRequest('own_user');
				$aUsers=explode(',',$sUsers);
				//берем первого пользователя
				$sUser=$aUsers[0];
				if ($oUser=$this->User_GetUserByLogin($sUser)){
					$this->PluginCompany_Company_ReplaceCompanyOwner($oBlog, $oUser);
					$this->Message_AddNoticeSingle($this->Lang_Get('company_notice_edit_users_owner'));	
					func_header_location($oCompany->getUrlFull());			
				} else {
					$this->Message_AddError($this->Lang_Get('talk_create_users_error_not_found').' «'.htmlspecialchars($sUser).'»',$this->Lang_Get('error'));
				}	
				$_REQUEST['talk_users']	= $sUser;
			} else{
				$this->Message_AddErrorSingle($this->Lang_Get('not_access'),$this->Lang_Get('error')); 
			}
		}
		
		$this->Viewer_AddHtmlTitle($oCompany->getName());
		$this->Viewer_AddHtmlTitle($this->Lang_Get('company_title_edit_users'));
		$this->Viewer_Assign('oCompanyEdit',$oCompany);
		/**
		 * Устанавливаем шалон для вывода
		 */		
		$this->SetTemplateAction('admin');	
	}
		/**
	 * Показать профайл компании
	 * @return unknown
	 */
	protected function EventShowCompanyProfile() {
		// получаем параметры из ссылки
		$sCompanyUrl=$this->sCurrentEvent;
		$iPage=$this->GetParam(1);
		/**
		 * Меню
		 */
		$this->sMenuSubItemSelect='about';
		$this->sMenuItemSelect='index';
		
		/**
		 * Проверяем есть ли блог с таким УРЛ
		 */
		if (!($oCompany=$this->PluginCompany_Company_GetCompanyWithAddData($sCompanyUrl))) {
			return parent::EventNotFound();
		}
		
		/**
		 * Получаем список юзеров блога
		 */
		$aCompanyUsers=$this->Blog_GetBlogUsersByBlogId($oCompany->getBlogId(),0);
		$aCompanyEmployees=$this->Blog_GetBlogUsersByBlogId($oCompany->getBlogId(),ModuleBlog::BLOG_USER_ROLE_USER);
		$aCompanyModerators=$this->Blog_GetBlogUsersByBlogId($oCompany->getBlogId(),ModuleBlog::BLOG_USER_ROLE_MODERATOR);
		$aCompanyAdministrators=$this->Blog_GetBlogUsersByBlogId($oCompany->getBlogId(),ModuleBlog::BLOG_USER_ROLE_ADMINISTRATOR);	
    
		/**
		 * Выставляем SEO данные
		 */
		$sTextSeo=preg_replace("/<.*>/Ui",' ',$oCompany->getDescription());
		$this->Viewer_SetHtmlDescription(func_text_words($sTextSeo,20));		
		/**
		 * Загружаем переменные в шаблон
		 */			
		$this->Viewer_Assign('oCompany',$oCompany);
		$this->Viewer_Assign('iCountCompanyUsers',count($aCompanyUsers));
		$this->Viewer_Assign('iCountCompanyEmployees',count($aCompanyEmployees));
		$this->Viewer_Assign('iCountCompanyModerators',count($aCompanyModerators));
		$this->Viewer_Assign('iCountCompanyAdministrators',count($aCompanyAdministrators)+1);
		
		$this->Viewer_Assign('aCompanyUsers',$aCompanyUsers);	
		$this->Viewer_Assign('aCompanyEmployees',$aCompanyEmployees);		
		$this->Viewer_Assign('aCompanyModerators',$aCompanyModerators);
		$this->Viewer_Assign('aCompanyAdministrators',$aCompanyAdministrators);
		
		if ($this->oUserCurrent){
			$this->Viewer_Assign('isEmployee',$this->PluginCompany_Company_GetUserIsEmployee($this->oUserCurrent->getId(),$oCompany));
		}
		$this->Viewer_AddHtmlTitle($oCompany->getName());
		$this->Viewer_AddHtmlTitle($this->Lang_Get('company_title_view_profile'));
		$this->Viewer_AddBlock('right','companiesincity',array($oCompany->GetCity(),'plugin'=>'company',));		
		$this->Viewer_AddMenu('company',Plugin::GetTemplatePath('company').'menu.company.tpl'); 
		$this->SetTemplateAction('index');
	}
	
	protected function EventShowCompanyBlog() {
		$sCompanyUrl=$this->sCurrentEvent;
		$sPage=$this->GetParam(1);
		/**
		 * Меню
		 */
		$this->sMenuItemSelect='blog';
		$this->sMenuSubItemSelect='good';
		$this->sMenuSubCompanyUrl=Config::Get('module.company.url').'/'.$sCompanyUrl;
		/**
		 * Проверяем есть ли компания с таким УРЛ
		 */		
		if (!($oCompany=$this->PluginCompany_Company_GetCompanyWithAddData($sCompanyUrl))) {
			return parent::EventNotFound();
		}	
		
		/**
		 * Передан ли номер страницы
		 */
		if (preg_match("/^page(\d+)$/i",$sPage,$aMatch)) {			
			$iPage=$aMatch[1];
		} else {
			$iPage=1;
		}		
		/**
		 * Получаем список топиков
		 */
		$iCount=0;	
		$oBlog = $this->Blog_GetBlogById($oCompany->getBlogId());	
		$aResult=$this->PluginCompany_Company_GetTopicsByBlog($oBlog,$iCount,$iPage,Config::Get('module.topic.per_page'));	
		$aTopics=$aResult['collection']; 
		/**
		 * Формируем постраничность
		 */			
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),4,Config::Get('module.company.url').'/'.$sCompanyUrl.'/blog');			
		/**
		 * Получаем число новых топиков в текущем блоге
		 */
		$this->iCountTopicsCompanyNew=$this->Topic_GetCountTopicsByBlogNew($oBlog);	
		/**
		 * Выставляем SEO данные
		 */
		$sTextSeo=preg_replace("/<.*>/Ui",' ',$oCompany->getDescription());
		$this->Viewer_SetHtmlDescription(func_text_words($sTextSeo,20));	
		/**
		 * Загружаем переменные в шаблон
		 */				
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('aTopics',$aTopics);
		$this->Viewer_Assign('oBlog',$oBlog);
		$this->Viewer_Assign('oCompany',$oCompany);
		if ($this->oUserCurrent){
			$this->Viewer_Assign('isEmployee',$this->PluginCompany_Company_GetUserIsEmployee($this->oUserCurrent->getId(),$oCompany));
		}
		$this->Viewer_AddHtmlTitle($oCompany->getName());		
		$this->Viewer_AddBlock('right','companiesincity',array($oCompany->GetCity(),'plugin'=>'company',));
		$this->Viewer_AddMenu('company',Plugin::GetTemplatePath('company').'menu.company.tpl'); 
		$this->SetTemplateAction('blog');
	}
	
	/**
	 * Выводит вакансии компании
	 *
	 */
	protected function EventShowCompanyVacancies() {	
		$sCompanyUrl=$this->sCurrentEvent;
		/**
		 * Меню
		 */
		$this->sMenuItemSelect='vacancies';
		$this->sMenuSubItemSelect='';
		
		/**
		 * Проверяем есть ли блог с таким УРЛ
		 */
		if (!($oCompany=$this->PluginCompany_Company_GetCompanyWithAddData($sCompanyUrl))) {
			return parent::EventNotFound();
		}
		
		$aVacancies = array();
		if (Config::Get('module.company.use_jobs')){
			$aResult = $this->PluginJob_Job_GetVacanciesByCompanyId(1,10,$oCompany->getId());
			$aVacancies=$aResult['collection']; 
		}
		$this->Viewer_Assign('aVacancies',$aVacancies);
		$this->Viewer_Assign('oCompany',$oCompany);
		
		if ($this->oUserCurrent){
			$this->Viewer_Assign('isEmployee',$this->PluginCompany_Company_GetUserIsEmployee($this->oUserCurrent->getId(),$oCompany));
		}
		$this->Viewer_AddBlock('right','companiesincity',array($oCompany->GetCity(),'plugin'=>'company',));
		$this->Viewer_AddMenu('company',Plugin::GetTemplatePath('company').'menu.company.tpl'); 
		$this->SetTemplateAction('vacancies');
	}
	
	
	/**
	 * Выводит отзывы о компании
	 *
	 */
	protected function EventShowCompanyFeedbacks() {		
		$sCompanyUrl=$this->sCurrentEvent;
		/**
		 * Меню
		 */
		$this->sMenuItemSelect='feedbacks';
		//$this->sMenuSubItemSelect='feedbacks';
		
		/**
		 * Проверяем есть ли компания с таким УРЛ
		 */
		if (!($oCompany=$this->PluginCompany_Company_GetCompanyWithAddData($sCompanyUrl))) {
			return parent::EventNotFound();
		}
		
		$aReturn=$this->Comment_GetCommentsByTargetId($oCompany->getId(),'company');
		$iMaxIdComment=$aReturn['iMaxIdComment'];	
		$aComments=$aReturn['comments'];
		
		$dDate=date("Y-m-d H:i:s");
		if ($this->oUserCurrent) {
			if ($oFeebackRead=$this->PluginCompany_Company_GetFeedbackRead($oCompany->getId(),$this->oUserCurrent->getId())) {
				$dDate=$oFeebackRead->getDateRead();
			}
		}
		$oCompany->setDateRead($dDate);
		/**
		 * Отмечаем дату прочтения топика
		 */
		if ($this->oUserCurrent) {
			$oFeebackRead= Engine::GetEntity('PluginCompany_Company_CompanyFeedbackRead');//new PluginCompany_CompanyEntity_CompanyFeedbackRead();
			$oFeebackRead->setCompanyId($oCompany->getId());
			$oFeebackRead->setUserId($this->oUserCurrent->getId());
			$oFeebackRead->setFeedbackCountLast($oCompany->getCountFeedback());
			$oFeebackRead->setFeedbackIdLast($iMaxIdComment);
			$oFeebackRead->setDateRead(date("Y-m-d H:i:s"));
			$this->PluginCompany_Company_SetFeedbackRead($oFeebackRead);
		}		
		$this->Viewer_Assign('oCompany',$oCompany);
		$this->Viewer_Assign('aComments',$aComments);
		$this->Viewer_Assign('iMaxIdComment',$iMaxIdComment);
		
		if ($this->oUserCurrent){
			$this->Viewer_Assign('isEmployee',$this->PluginCompany_Company_GetUserIsEmployee($this->oUserCurrent->getId(),$oCompany));
		}
		
		$this->Viewer_AddBlock('right','companiesincity',array($oCompany->GetCity(),'plugin'=>'company',));
		$this->Viewer_AddMenu('company',Plugin::GetTemplatePath('company').'menu.company.tpl'); 
		$this->SetTemplateAction('feedbacks');
	}
	
	
	protected function EventShowCorporativeBlogs() {
		//$this->Viewer_AddBlocks('right',array('companies'));	
		$sCompanyUrl=$this->sCurrentEvent;
		$sPage=$this->GetParam(0);
		$this->sMenuItemSelect='companies';
		//$this->sMenuSubCompanyUrl=Config::Get('module.company.url').'/'.$sCompanyUrl;
		
		/**
		 * Передан ли номер страницы
		 */
		if (preg_match("/^page(\d+)$/i",$sPage,$aMatch)) {			
			$iPage=$aMatch[1];
		} else {
			$iPage=1;
		}		

		$iCount=0;	
		$aResult=$this->PluginCompany_Company_GetTopicsCompany($iCount,$iPage,Config::Get('module.topic.per_page'));	
		$aTopics=$aResult['collection']; 
		/**
		 * Формируем постраничность
		 */			
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),4,Config::Get('module.company.url').'/'.$sCompanyUrl);			
	
		/**
		 * Загружаем переменные в шаблон
		 */				
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('aTopics',$aTopics);
		$this->Viewer_AddHtmlTitle($this->Lang_Get('company_title_view_blogs'));
		$this->SetTemplateAction('blogs');
	}
	
	/**
	 * Показ топика из корпоративного блога
	 *
	 * @param unknown_type $sBlogUrl
	 * @param unknown_type $iTopicId
	 * @return unknown
	 */
	protected function EventShowTopic() {	
		$sCompanyUrl=$this->sCurrentEvent;
		$iTopicId=$this->GetParamEventMatch(1,1);
		/**
		 * Меню
		 */
		$this->sMenuSubItemSelect='';
		/**
		 * Проверяем есть ли такой топик
		 */
		if (!($oTopic=$this->Topic_GetTopicById($iTopicId,null,-1))) {
			return parent::EventNotFound();
		}
		/**
		 * Проверяем права на просмотр топика
		 */
		if (!$oTopic->getPublish() and (!$this->oUserCurrent or ($this->oUserCurrent->getId()!=$oTopic->getUserId() and !$this->oUserCurrent->isAdministrator()))) {
			return parent::EventNotFound();
		}
		
		/**
		 * Обрабатываем добавление коммента
		 */
		$this->SubmitComment($oTopic);
		/**
		 * Достаём комменты к топику
		 */
		$aReturn=$this->Comment_GetCommentsByTargetId($oTopic->getId(),'topic');
		$iMaxIdComment=$aReturn['iMaxIdComment'];	
		$aComments=$aReturn['comments'];	
		$aCommentsNew=array();
		foreach ($aComments as $oCom) {
			$array=$oCom->_getData();
			$array['obj']=$oCom;
			$aCommentsNew[]=$array;
		}
		/**
		 * Проверяем находится ли топик в избранном у текущего юзера
		 */
		$bInFavourite=false;
		if ($this->oUserCurrent) {
			if ($this->Topic_GetFavouriteTopic($oTopic->getId(),$this->oUserCurrent->getId())) {
				$bInFavourite=true;
			}
		}
		/**
		 * Получаем дату прочтения топика
		 */
		$dDate=date("Y-m-d H:i:s");
		$iCommentLastTopicRead=0;
		if ($this->oUserCurrent) {
			if ($oTopicRead=$this->Topic_GetTopicRead($oTopic->getId(),$this->oUserCurrent->getId())) {
				$dDate=$oTopicRead->getDateRead();
				$iCommentLastTopicRead=$oTopicRead->getCommentIdLast();
			}
		}
		/**
		 * Отмечаем дату прочтения топика
		 */
		if ($this->oUserCurrent) {
			$oTopicRead= Engine::GetEntity('Topic_TopicRead');
			$oTopicRead->setTopicId($oTopic->getId());
			$oTopicRead->setUserId($this->oUserCurrent->getId());
			$oTopicRead->setCommentCountLast($oTopic->getCountComment());
			$oTopicRead->setCommentIdLast($iMaxIdComment);
			$oTopicRead->setDateRead(date("Y-m-d H:i:s"));
			$this->Topic_SetTopicRead($oTopicRead);
		}		
		/**
		 * Выставляем SEO данные
		 */
		$sTextSeo=preg_replace("/<.*>/Ui",' ',$oTopic->getText());
		$this->Viewer_SetHtmlDescription(func_text_words($sTextSeo,20));
		$this->Viewer_SetHtmlKeywords($oTopic->getTags());
		/**
		 * Загружаем переменные в шаблон
		 */		
		$this->Viewer_Assign('bInFavourite',$bInFavourite);
		$this->Viewer_Assign('dDateTopicRead',$dDate);
		$this->Viewer_Assign('iCommentLastTopicRead',$iCommentLastTopicRead);
		$this->Viewer_Assign('oTopic',$oTopic);
		$this->Viewer_Assign('aComments',$aComments);	
		$this->Viewer_Assign('aCommentsNew',$aCommentsNew);
		$this->Viewer_Assign('iMaxIdComment',$iMaxIdComment);
		$this->Viewer_AddHtmlTitle($oTopic->getBlogTitle());
		$this->Viewer_AddHtmlTitle($oTopic->getTitle());
		$this->SetTemplateAction('topic');
	}
	
	/**
	 * Отображение компаний
	 * @return unknown
	 */
	protected function EventShowCompanies() {
		//$this->Viewer_AddMenu('main',Plugin::GetTemplatePath('company').'menu.main.tpl'); 
		$this->sMenuItemSelect='companies';
		$this->sMenuSubItemSelect='';
		
		$sPage=$this->sCurrentEvent;	
		if (preg_match("/^page(\d+)$/i",$sPage,$aMatch)) {			
			$iPage=$aMatch[1];
		} else {
			$iPage=1;
		}
		$this->Topic_GetTopicsLast(20);
		/**
		 * Получаем список компаний
		 */
		$aResult=$this->PluginCompany_Company_GetCompaniesRating($iPage,Config::Get('module.company.per_page'));		
		$aCompany=$aResult['collection']; 
		/**
		 * Формируем постраничность
		 */		
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.company.per_page'),4,Config::Get('module.company.url'));		
		/**
		 * Загружаем переменные в шаблон
		 */			
		$this->Viewer_Assign('aPaging',$aPaging);
	
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign("aCompany",$aCompany);
		if ($this->oUserCurrent)
			$this->Viewer_Assign("aUserCompany",$this->PluginCompany_Company_GetCompaniesByUserId($this->oUserCurrent->getId(),null,true));
		$this->SetTemplateAction('companies');
	}	
	
	protected function EventShowMyCompanies() {
		//$this->Viewer_AddMenu('main',Plugin::GetTemplatePath('company').'menu.main.tpl'); 
		$this->sMenuItemSelect='companies_my';
		$this->sMenuSubItemSelect='';
		
		$sPage=$this->GetParam(0);	
		if (preg_match("/^page(\d+)$/i",$sPage,$aMatch)) {			
			$iPage=$aMatch[1];
		} else {
			$iPage=1;
		}

		/**
		 * Получаем список компаний
		 */
		$aResult=$this->PluginCompany_Company_GetCompaniesRatingByUserId($this->oUserCurrent->getId(),$iPage,Config::Get('module.company.per_page'));		
		$aCompany=$aResult['collection']; 
		/**
		 * Формируем постраничность
		 */		
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.company.per_page'),4,Config::Get('module.company.url').'/my');		
		/**
		 * Загружаем переменные в шаблон
		 */			
		$this->Viewer_Assign('aPaging',$aPaging);
		
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign("aCompany",$aCompany);
		if ($this->oUserCurrent)
			$this->Viewer_Assign("aUserCompany",$this->PluginCompany_Company_GetCompaniesByUserId($this->oUserCurrent->getId(),null,true));
		$this->SetTemplateAction('companies');
	}
	
	/**
	 * Отображение компаний по городу
	 * @return unknown
	 */
	protected function EventShowCompaniesByCity() {
		//$this->Viewer_AddMenu('main',Plugin::GetTemplatePath('company').'menu.main.tpl'); 
		$sCity=urldecode($this->GetParam(0));
		$sPage=$this->GetParam(1); 	
		if (preg_match("/^page(\d+)$/i",$sPage,$aMatch)) {			
			$iPage=$aMatch[1];
		} else {
			$iPage=1;
		}	
		/**
		 * Получаем список топиков
		 */
		$aResult=$this->PluginCompany_Company_GetCompaniesByCity($sCity,$iPage,Config::Get('module.company.per_page'));		
		$aCompany=$aResult['collection'];
		/**
		 * Формируем постраничность
		 */		
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.company.per_page'),4,Config::Get('module.company.url'));		
		/**
		 * Загружаем переменные в шаблон
		 */			
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign("aCompany",$aCompany);
		$this->SetTemplateAction('companies');
	}	
	
	
	/**
	 * Обработка редактирования топика
	 */
	protected function SubmitEdit($oCompany) {
		$this->Security_ValidateSendForm();
		$aParams = $this->Image_BuildParams('company_logo');
		
		if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
			$sFileTmp=$_FILES['logo']['tmp_name'];
			if ($sFileLogo=$this->Image_Resize($sFileTmp,Config::Get('path.uploads.images').'/company/'.$oCompany->getId(),"logo_company_{$oCompany->getUrl()}_48x48",3000,3000,48,48,true,$aParams)) {
				$this->Image_Resize($sFileTmp,Config::Get('path.uploads.images').'/company/'.$oCompany->getId(),"logo_company_{$oCompany->getUrl()}_24x24",3000,3000,24,24,true,$aParams);
				$this->Image_Resize($sFileTmp,Config::Get('path.uploads.images').'/company/'.$oCompany->getId(),"logo_company_{$oCompany->getUrl()}",3000,3000,true,$aParams);
				$oCompany->setLogo(1);
				$aFileInfo=pathinfo($sFileLogo);
				$oCompany->setLogoType($aFileInfo['extension']);
			} else {
				$this->Message_AddError($this->Lang_Get('company_error_edit_load_logo'),$this->Lang_Get('error'));
				return false;
			}
		}	
		/**
		* Удалить логотип
		*/
		if (isset($_REQUEST['logo_delete'])) {
			$oCompany->setLogo(0);				
			@unlink(Config::Get('path.uploads.images').'/company/'.$oCompany->getId()."/logo_company_{$oCompany->getUrl()}_48x48.".$oCompany->getLogoType());
			@unlink(Config::Get('path.uploads.images').'/company/'.$oCompany->getId()."/logo_company_{$oCompany->getUrl()}_24x24.".$oCompany->getLogoType());
			@unlink(Config::Get('path.uploads.images').'/company/'.$oCompany->getId()."/logo_company_{$oCompany->getUrl()}.".$oCompany->getLogoType());
			$oCompany->setLogoType(null);
		}			
		$oCompany->setName(getRequest('company_name'));	
		$oCompany->setLegalName(getRequest('company_name_legal'));	
		$oCompany->setDescription(getRequest('company_description'));	
		
		/**
		 * Проверяем cайт
		 */
		if (func_check(getRequest('company_site'),'text',1,100)) {
			$oCompany->setSite(getRequest('company_site'));
		} else {
			$oCompany->setSite(null);
		}
		/**
		 * Проверяем почту
		 */
		if (func_check(getRequest('company_email'),'text',1,50)) {
			if (!func_check(getRequest('company_email'),'mail')) {
				$this->Message_AddError($this->Lang_Get('company_error_edit_email'),$this->Lang_Get('error'));
			} else{
				$oCompany->setEmail(getRequest('company_email'));
			}
		} else {
			$oCompany->setEmail(null);
		}
		/**
		 * Проверяем телефон
		 */
		if (func_check(getRequest('company_phone'),'text',1,50)) {
			$oCompany->setPhone(getRequest('company_phone'));
		} else {
			$oCompany->setPhone(null);
		}
		/**
		 * Проверяем факс
		 */
		if (func_check(getRequest('company_fax'),'text',1,50)) {
			$oCompany->setFax(getRequest('company_fax'));
		} else {
			$oCompany->setFax(null);
		}
		
		/**
		 * Проверяем босс
		 */
		if (func_check(getRequest('company_boss'),'text',1,50)) {
			$oCompany->setBoss(getRequest('company_boss')); 
		} else {
			$oCompany->setBoss(null);
		}
		
		/**
		* Проверяем дату рождения
		*/
		if (func_check(getRequest('company_basis_day'),'id',1,2) and func_check(getRequest('company_basis_month'),'id',1,2) and func_check(getRequest('company_basis_year'),'id',4,4)) {
			$oCompany->setDateBasis(date("Y-m-d H:i:s",mktime(0,0,0,getRequest('company_basis_month'),getRequest('company_basis_day'),getRequest('company_basis_year'))));
		} else {
			$oCompany->setDateBasis(null);
		}
		
		$oCompany->setDateEdit(date("Y-m-d H:i:s"));	
		$oCompany->setTags(getRequest('company_tags'));	
		
		/**
		 * Проверяем страну
		 */
		if (func_check(getRequest('company_country'),'text',1,30)) {
			$oCompany->setCountry(getRequest('company_country'));
		} else {
			$oCompany->setCountry(null);
		}
		/**
		 * Проверяем город
		 */
		if (func_check(getRequest('company_city'),'text',1,30)) {
			$oCompany->setCity(getRequest('company_city'));
		} else {
			$oCompany->setCity(null);
		}
		
		/**
		 * Проверяем город
		 */
		if (func_check(getRequest('company_address'),'text',1,100)) {
			$oCompany->setAddress(getRequest('company_address'));
		} else {
			$oCompany->setAddress(null);
		}
		$oCompany->setCountWorkers(getRequest('company_count_workers'));
		
		/**
		* Проверяем вакансии
		*/
		if (func_check(getRequest('company_vacancies'),'text',1,70000)) {
			$oCompany->setVacancies($this->Text_Parser(getRequest('company_vacancies')));
		} else {
			$oCompany->setVacancies(null);
		} 

	
		if ($this->PluginCompany_Company_UpdateCompany($oCompany)) {
			/**
			 * Добавляем страну
			 */
			if ($oCompany->getCountry()) {
				if (!($oCountry=$this->User_GetCountryByName($oCompany->getCountry()))) {
					$oCountry = Engine::GetEntity('User_Country'); //new PluginCompany_CompanyEntity_Country();
					$oCountry->setName($oCompany->getCountry());
					$this->User_AddCountry($oCountry);
				}
				$this->PluginCompany_Company_SetCompanyCountry($oCompany->getId(),$oCountry->getId());
			}
			/**
			 * Добавляем город
			 */
			if ($oCompany->getCity()) {
				if (!($oCity=$this->User_GetCityByName($oCompany->getCity()))) {
					$oCity= Engine::GetEntity('User_City');//new PluginCompany_CompanyEntity_City();
					$oCity->setName($oCompany->getCity());
					$this->User_AddCity($oCity);
				}
				$this->PluginCompany_Company_SetCompanyCity($oCompany->getId(),$oCity->getId());
			}
			
			$this->Message_AddNoticeSingle($this->Lang_Get('company_notice_edit_profile'),$this->Lang_Get('company_congratulation')); 
			return true;
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
			return false;
		}	
	}
	
	/**
	 * Обработка добавление комментария к топику
	 *
	 * @param unknown_type $oTopic
	 * @return unknown
	 */
	protected function SubmitComment($oTopic) {
		/**
		 * Если нажали кнопку "Отправить"
		 */
		if (isset($_REQUEST['submit_comment'])) {
			$this->Security_ValidateSendForm();
			/**
			 * Проверяем авторизованл ли пользователь
			 */
			if (!$this->oUserCurrent) {
				$this->Message_AddErrorSingle($this->Lang_Get('not_access'),$this->Lang_Get('error'));
				return Router::Action('error');
			}
			/**
			 * Проверяем разрешено ли постить комменты
			 */
			if (!$this->ACL_CanPostComment($this->oUserCurrent) and !$this->oUserCurrent->isAdministrator()) {
				$this->Message_AddError($this->Lang_Get('topic_comment_acl'),$this->Lang_Get('error'));
				return false;
			}
			/**
			 * Проверяем разрешено ли постить комменты по времени
			 */
			if (!$this->ACL_CanPostCommentTime($this->oUserCurrent) and !$this->oUserCurrent->isAdministrator()) {
				$this->Message_AddError($this->Lang_Get('topic_comment_limit'),$this->Lang_Get('error'));
				return false;
			}
			/**
			 * Проверяем запрет на добавления коммента автором топика
			 */
			if ($oTopic->getForbidComment()) {
				$this->Message_AddError($this->Lang_Get('topic_comment_notallow'),$this->Lang_Get('error'));
				return false;
			}
			/**
			 * Проверяем текст комментария
			 */
			$sText=$this->Text_Parser(getRequest('comment_text'));
			if (!func_check($sText,'text',2,10000)) {
				$this->Message_AddError($this->Lang_Get('topic_comment_add_text_error'),$this->Lang_Get('error'));
				return false;
			}			
			/**
			 * Проверям на какой коммент отвечаем
			 */
			$sParentId=getRequest('reply',0);
			if (!func_check($sParentId,'id')) {
				$this->Message_AddError($this->Lang_Get('system_error'),$this->Lang_Get('error'));
				return false;
			}
			$oCommentParent=null;
			if ($sParentId!=0) {
				/**
				 * Проверяем существует ли комментарий на который отвечаем
				 */
				if (!($oCommentParent=$this->Comment_GetCommentById($sParentId))) {
					return false;
				}
				/**
				 * Проверяем из одного топика ли новый коммент и тот на который отвечаем
				 */
				if ($oCommentParent->getTopicId()!=$oTopic->getId()) {
					return false;
				}
			} else {
				/**
				 * Корневой комментарий
				 */
				$sParentId=null;
			}
			/**
			 * Проверка на дублирующий коммент
			 */
			if ($this->Comment_GetCommentUnique($oTopic->getId(),$this->oUserCurrent->getId(),$sParentId,md5($sText))) {
				$this->Message_AddError($this->Lang_Get('topic_comment_spam'),$this->Lang_Get('error'));
				return false;
			}
			//exit();
			/**
			 * Создаём коммент
			 */
			$oCommentNew=new CommentEntity_TopicComment();
			$oCommentNew->setTopicId($oTopic->getId());
			$oCommentNew->setUserId($this->oUserCurrent->getId());
			/**
			 * Парсим коммент на предмет ХТМЛ тегов
			 */
						
			$oCommentNew->setText($sText);
			$oCommentNew->setDate(date("Y-m-d H:i:s"));
			$oCommentNew->setUserIp(func_getIp());
			$oCommentNew->setPid($sParentId);
			$oCommentNew->setTextHash(md5($sText));
			/**
			 * Добавляем коммент
			 */
			if ($this->Comment_AddComment($oCommentNew)) {
				if ($oTopic->getPublish()) {
					/**
			 		* Добавляем коммент в прямой эфир если топик не в черновиках
			 		*/					
					$oTopicCommentOnline=new CommentEntity_TopicCommentOnline();
					$oTopicCommentOnline->setTopicId($oCommentNew->getTopicId());
					$oTopicCommentOnline->setCommentId($oCommentNew->getId());
					$this->Comment_AddTopicCommentOnline($oTopicCommentOnline);
				}
				/**
				 * Сохраняем дату последнего коммента для юзера
				 */
				$this->oUserCurrent->setDateCommentLast(date("Y-m-d H:i:s"));
				$this->User_Update($this->oUserCurrent);
				/**
				 * Отправка уведомления автору топика
				 */
				$oUserTopic=$this->User_GetUserById($oTopic->getUserId());
				if ($oCommentNew->getUserId()!=$oUserTopic->getId()) {					
					$this->Notify_SendCommentNewToAuthorTopic($oUserTopic,$oTopic,$oCommentNew,$this->oUserCurrent);
				}
				/**
				 * Отправляем уведомление тому на чей коммент ответили
				 */
				if ($oCommentParent and $oCommentParent->getUserId()!=$oTopic->getUserId() and $oCommentNew->getUserId()!=$oCommentParent->getUserId()) {					
					$oUserAuthorComment=$this->User_GetUserById($oCommentParent->getUserId());					
					$this->Notify_SendCommentReplyToAuthorParentComment($oUserAuthorComment,$oTopic,$oCommentNew,$this->oUserCurrent);					
				}
				func_header_location($oTopic->getBlogUrlFull().$oTopic->getId().'.html#comment'.$oCommentNew->getId());
			} else {
				$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
				return false;
			}
		}
	}
	
	protected function AjaxAddFeedback() {
		$this->Viewer_SetResponseAjax();
		$this->SubmitFeedback();
	}	
	
	
	/**
	 * Обработка добавление отзыва к компании
	 *	 
	 * @return bool
	 */
	protected function SubmitFeedback() {
		/**
		 * Проверям авторизован ли пользователь
		 */
		if (!$this->User_IsAuthorization()) {
			$this->Message_AddErrorSingle($this->Lang_Get('need_authorization'),$this->Lang_Get('error'));
			return;
		}
		/**
		 * Проверяем компанию
		 */
		if (!($oCompany=$this->PluginCompany_Company_GetCompanyById(getRequest('cmt_target_id')))) {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
			return;
		}
		
		/**
		* Проверяем разрешено ли постить комменты
		*/
		if (!$this->PluginCompany_Company_CanPostFeedback($this->oUserCurrent) and !$this->oUserCurrent->isAdministrator()) {			
			$this->Message_AddErrorSingle($this->Lang_Get('company_feedback_acl'),$this->Lang_Get('error'));
			return;
		}
		/**
		* Проверяем запрет на добавления коммента автором топика
		*/
		/*
		if ($oCompany->getForbidComment()) {
			$this->Message_AddErrorSingle($this->Lang_Get('topic_comment_notallow'),$this->Lang_Get('error'));
			return;
		}	*/
		/**
		* Проверяем текст комментария
		*/
		$sText=$this->Text_Parser(getRequest('comment_text'));
		if (!func_check($sText,'text',2,3000)) {			
			$this->Message_AddErrorSingle($this->Lang_Get('company_feedback_add_text_error'),$this->Lang_Get('error'));
			return;
		}
		/**
		* Проверям на какой коммент отвечаем
		*/
		$sParentId=(int)getRequest('reply');
		if (!func_check($sParentId,'id')) {			
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
			return;
		}
		$oCommentParent=null;
		if ($sParentId!=0) {
			/**
			* Проверяем существует ли комментарий на который отвечаем
			*/
			if (!($oCommentParent=$this->Comment_GetCommentById($sParentId))) {				
				$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
				return;
			}
			/**
			* Проверяем из одного топика ли новый коммент и тот на который отвечаем
			*/
			if ($oCommentParent->getTargetId()!=$oCompany->getId()) {
				$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
				return;
			}
		} else {
			/**
			* Корневой комментарий
			*/
			$sParentId=null;
		}
		/**
		* Проверка на дублирующий коммент
		*/
		if ($this->Comment_GetCommentUnique($oCompany->getId(),'company',$this->oUserCurrent->getId(),$sParentId,md5($sText))) {			
			$this->Message_AddErrorSingle($this->Lang_Get('topic_comment_spam'),$this->Lang_Get('error'));
			return;
		}
		/**
		* Создаём коммент
		*/
		$oCommentNew = Engine::GetEntity('Comment');
		$oCommentNew->setTargetId($oCompany->getId());
		$oCommentNew->setTargetType('company');
		//$oCommentNew->setTargetParentId(0);//($oCompany->getBlog()->getId());
		$oCommentNew->setUserId($this->oUserCurrent->getId());		
		$oCommentNew->setText($sText);
		$oCommentNew->setDate(date("Y-m-d H:i:s"));
		$oCommentNew->setUserIp(func_getIp());
		$oCommentNew->setPid($sParentId);
		$oCommentNew->setTextHash(md5($sText));
			
		/**
		* Добавляем коммент
		*/
		//$this->Hook_Run('feedback_add_before', array('oCommentNew'=>$oCommentNew,'oCommentParent'=>$oCommentParent,'oCompany'=>$oCompany));
		if ($this->Comment_AddComment($oCommentNew)) {
			//$this->Hook_Run('feedback_add_after', array('oCommentNew'=>$oCommentNew,'oCommentParent'=>$oCommentParent,'oCompany'=>$oCompany));
			$this->PluginCompany_Company_increaseCompanyCountFeedbacks($oCompany->getId());
			$this->Viewer_AssignAjax('sCommentId',$oCommentNew->getId());
			
			//if ($oTopic->getPublish()) {
			 	// Добавляем коммент в прямой эфир если топик не в черновиках					
				$oCommentOnline=Engine::GetEntity('Comment_CommentOnline');
				$oCommentOnline->setTargetId($oCommentNew->getTargetId());
				$oCommentOnline->setTargetType($oCommentNew->getTargetType());
				//$oCommentOnline->setTargetParentId(0);
				$oCommentOnline->setCommentId($oCommentNew->getId());
				
				$this->Comment_AddCommentOnline($oCommentOnline);
			//}
			/**
			* Сохраняем дату последнего коммента для юзера
			*/
			$this->oUserCurrent->setDateCommentLast(date("Y-m-d H:i:s"));
			$this->User_Update($this->oUserCurrent);
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
		}
	}	
	

	/**
	 * Проверка полей компании
	 *
	 * @return unknown
	 */
	protected function checkCompanyFields($oCompany=null) {
		$bOk=true;
		
		/**
		* Проверяем заполнено ли наименование компании
		*/
		if (!func_check(getRequest('company_name'),'text',2,255)) {
			$this->Message_AddError($this->Lang_Get('company_error_add_name_text'),$this->Lang_Get('error'));
			$bOk=false;
		} 
		
		/**
		 * Проверяем есть ли уже компания с таким наименованием
		 */
		if ($oCompanyExists=$this->PluginCompany_Company_GetCompanyByName(getRequest('company_name'))) {
			if (!$oCompany or $oCompany->getId()!=$oCompanyExists->getId()) {
				$this->Message_AddError($this->Lang_Get('company_error_add_name_exsist'),$this->Lang_Get('error'));
				$bOk=false;
			}
		}
		
		/* Проверка URL
		 * Проверка только в том случаи если создаём новую компанию, т.к при редактировании URL нельзя менять
		 */	
		if (!$oCompany) {
			/**
			* Проверяем есть ли URL компании, с заменой всех пробельных символов на "_"
			*/	
			
			if (Config::Get('module.company.use_convert_url')){
				$companyUrl = func_translit_url(getRequest('company_name'));
			} else{
				$companyUrl = getRequest('company_url');
			}
			$companyUrl=preg_replace("/\s+/",'_',$companyUrl);
			$_REQUEST['company_url']= mb_strtolower($companyUrl);
			
			/**
			 * Проверяем есть ли уже компания с таким url
			 */
			if ($oCompanyExists=$this->PluginCompany_Company_GetCompanyByUrl(getRequest('company_url'))) {
				$this->Message_AddError($this->Lang_Get('company_error_add_url_exsist'),$this->Lang_Get('error'));
				$bOk=false;
			}
			/*
			 * Проверяем на допустимую длинну URL
			 */
			if (!func_check(getRequest('company_url'),'login',4,50)) {
				$this->Message_AddError($this->Lang_Get('company_error_add_url_text'),$this->Lang_Get('error'));
				$bOk=false;
			}
			/**
	 		* Проверяем на счет плохих УРЛов
	 		*/
			if (in_array(getRequest('company_url'),$this->aBadCompanyUrl) or preg_match("/^page(\d+)$/i",getRequest('company_url'),$aMatch) or strpos(getRequest('company_url'),'company') !== false) {
				$this->Message_AddError($this->Lang_Get('company_error_add_url_bad').': '.join(',',$this->aBadCompanyUrl),$this->Lang_Get('error'));
				$bOk=false;
			}
		}
		/**
	 	* Проверяем есть ли описание компании
	 	*/
		if (!func_check(getRequest('company_description'),'text',10,255)) {
			$this->Message_AddError($this->Lang_Get('company_error_add_description_text'),$this->Lang_Get('error'));
			$bOk=false;
		}
		/**
		* Проверяем заполнено ли наименование компании
		*/
		if (!func_check(getRequest('company_name'),'text',2,255)) {
			$this->Message_AddError($this->Lang_Get('company_error_add_name_text'),$this->Lang_Get('error'));
			$bOk=false;
		} 
		
		/**
		 * Проверяем количество сотрудников
		 */
		if (!func_check(getRequest('company_count_workers'),'id',0,9999)) {
			$this->Message_AddError($this->Lang_Get('company_error_edit_countworkers'),$this->Lang_Get('error'));
			$bOk=false;
		} 
		/**
		 * проверяем ввод тегов 
		 */
		$sTags=getRequest('company_tags');
		$aTags=explode(',',$sTags);
		$aTagsNew=array();
		$aTagsNewLow=array();
		foreach ($aTags as $sTag) {
			$sTag=trim($sTag);
			if (func_check($sTag,'text',2,50) and !in_array(mb_strtolower($sTag,'UTF-8'),$aTagsNewLow)) {
				$aTagsNew[]=$sTag;
				$aTagsNewLow[]=mb_strtolower($sTag,'UTF-8');
			}
		}
		if (!count($aTagsNew)) {
			$this->Message_AddError($this->Lang_Get('company_error_edit_tags'),$this->Lang_Get('error'));
			$bOk=false;
		} else {
			$_REQUEST['company_tags']=join(',',$aTagsNew);
		}
		
		return $bOk;
	}
	
	/**
	 * Удаление компании
	 *
	 * @return unknown
	 */
	protected function EventDelete() {
		/**
		 * Получаем номер топика из УРЛ и проверяем существует ли он
		 */
		$sCompanyId=$this->GetParam(0);
		if (!$oCompany=$this->PluginCompany_Company_GetCompanyById($sCompanyId)) {
			return parent::EventNotFound();
		}
		
		if (!$this->oUserCurrent->isAdministrator()) {
			return parent::EventNotFound();
		}
		/**
		 * Удаляем компанию
		 */
		$this->PluginCompany_Company_DeleteCompany($oCompany->getId());
		func_header_location(Config::Get('path.root.web'));
	}
	
	/**
	 * Удаление компании
	 *
	 * @return unknown
	 */
	protected function EventActivate() {
		if (!$this->oUserCurrent->isAdministrator()) {
			return parent::EventNotFound();
		}
		/**
		 * Получаем номер топика из УРЛ и проверяем существует ли он
		 */
		$sCompanyId=$this->GetParam(0);
		if (!$oCompany=$this->PluginCompany_Company_GetCompanyById($sCompanyId)) {
			return parent::EventNotFound();
		}
		if ($this->sCurrentEvent == 'activate'){
			$oCompany->setActive(1);
		} else{
			$oCompany->setActive(0);
		}
		/**
		 * Активируем компанию
		 */
		
		$this->PluginCompany_Company_UpdateCompany($oCompany);
		func_header_location($oCompany->getUrlFull());
	}
	
	
	protected function RssCompanyBlog() {
		$sBlogUrl=$this->sCurrentEvent;
		if (!$sBlogUrl or !($oBlog=$this->Blog_GetBlogByUrl('company_'.$sBlogUrl))) {			
			return parent::EventNotFound();
		}else{	
			$aResult=$this->Topic_GetTopicsByBlog($oBlog,1,Config::Get('module.topic.per_page')*2,'good');
		}
		$aTopics=$aResult['collection'];
		$aChannel['title']=Config::Get('path.root.web');
		$aChannel['link']=Config::Get('path.root.web');
		$aChannel['description']=Config::Get('path.root.web').' / '.$oBlog->getTitle().' / RSS channel';
		$aChannel['language']='ru';
		$aChannel['managingEditor']=Config::Get('general.rss_editor_mail');
		$aChannel['generator']=Config::Get('path.root.web');
		
		$topics=array(); 
		foreach ($aTopics as $oTopic){
			$item['title']=$oTopic->getTitle();
			$item['guid']=$oTopic->getUrl();
			$item['link']=$oTopic->getUrl();
			$item['description']=$oTopic->getTextShort();
			$item['pubDate']=$oTopic->getDateAdd();
			$item['author']=$oTopic->getUserLogin();
			$item['category']=htmlspecialchars($oTopic->getTags());
			$topics[]=$item;
		}
		header('Content-Type: application/rss+xml; charset=utf-8');	
		$this->Viewer_Assign('aChannel',$aChannel);
		$this->Viewer_Assign('aItems',$topics);
		$this->SetTemplateAction('rss');
	}
	
	/**
	 * Тествое событие, исользуется для отладки
	 *
	 * @return unknown
	 */
	protected function EventTest() {

		$this->SetTemplateAction('add');
	}
	
	/**
	 * Конвертирование базы
	 *
	 * @return unknown
	 */
	protected function EventConvert() {
		if (!$this->oUserCurrent->isAdministrator()) {
			return parent::EventNotFound();
		}
		$this->SetTemplateAction('convert');
		if (isset($_REQUEST['submit_convert'])) {
			list($bResult,$aErrors) = array_values($this->PluginCompany_Company_Convert());
				if(!$bResult) {
					foreach($aErrors as $sError) $this->Message_AddError($sError,$this->Lang_Get('error'));
				} else{
					$this->Message_AddNoticeSingle('Модуль компании успешно переведен на новую версию.');
				}
		}
	}
	
	protected function EventRepair() {
		if (!$this->oUserCurrent->isAdministrator()) {
			return parent::EventNotFound();
		}
		$this->SetTemplateAction('repair');
		if (isset($_REQUEST['submit_repair'])) {
				if(!$this->PluginCompany_Company_RepairUrl()) {
					$this->Message_AddError('Произошла ошибка при восстановлении',$this->Lang_Get('error'));
				} else{
					$this->Message_AddNoticeSingle('Восстановление прошло успешно.');
				}
		}
	}
	
	
/**
	 * Выводит список отзывов которые написал пользователь
	 *	 
	 */
	protected function EventUser() {
		/**
		 * Получаем логин из УРЛа
		 */
		$sUserLogin=$this->GetParam(0);		
		/**
		 * Проверяем есть ли такой юзер
		 */		
		if (!($oUserProfile=$this->User_GetUserByLogin($sUserLogin))) {			
			return parent::EventNotFound();
		}
		/**
		 * Передан ли номер страницы
		 */	
		$iPage=$this->GetParamEventMatch(2,2) ? $this->GetParamEventMatch(2,2) : 1;
		/**
		 * Получаем список комментов
		 */
		$iCount=0;			
		$aResult=$this->Comment_GetCommentsByUserId($oUserProfile->getId(),'company',$iPage,Config::Get('module.comment.per_page'));
		$aComments=$aResult['collection'];		
		/**
		 * Формируем постраничность
		 */			
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.comment.per_page'),4,Router::GetPath('company').'/user/'.$oUserProfile->getLogin().'/feedbacks');	
		/**
		 * Загружаем переменные в шаблон
		 */		
		$this->Viewer_Assign('aPaging',$aPaging);			
		$this->Viewer_Assign('aComments',$aComments);
		$this->Viewer_Assign('oUserProfile',$oUserProfile);
		$this->Viewer_AddHtmlTitle($this->Lang_Get('user_menu_publication').' '.$oUserProfile->getLogin());
		$this->Viewer_AddHtmlTitle($this->Lang_Get('user_menu_publication_comment'));
		/**
		 * Устанавливаем шаблон вывода
		 */	
		$this->SetTemplateAction('user_feedbacks');		
		//$this->Viewer_AddMenu('profile',Plugin::GetTemplatePath('company').'/menu.profile.tpl');
	}
	
	/**
	 * При завершении экшена загружаем в шаблон необходимые переменные
	 *
	 */
	public function EventShutdown() {
		$bCanAddCompany = false;
		if ($this->oUserCurrent){
			// Проверяем может ли пользователь добавить компанию, нужно для меню
			$bCanAddCompany=$this->PluginCompany_Company_CanCreateCompany($this->oUserCurrent);
			$this->Viewer_Assign('bCanAddCompany',$bCanAddCompany);
		}
		/**
		 * Подсчитываем новые топики
		 */
		$iCountTopicsCollectiveNew=$this->Topic_GetCountTopicsCollectiveNew();
		$iCountTopicsPersonalNew=$this->Topic_GetCountTopicsPersonalNew();
		$iCountTopicsCompanyNew=$this->PluginCompany_Company_GetCountTopicsCompanyNew();
		$iCountTopicsNew=$iCountTopicsCollectiveNew+$iCountTopicsPersonalNew+$iCountTopicsCompanyNew;
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('sMenuHeadItemSelect',$this->sMenuHeadItemSelect);
		$this->Viewer_Assign('sMenuItemSelect',$this->sMenuItemSelect);
		$this->Viewer_Assign('sMenuSubItemSelect',$this->sMenuSubItemSelect);
		$this->Viewer_Assign('iCountTopicsCollectiveNew',$iCountTopicsCollectiveNew);
		$this->Viewer_Assign('iCountTopicsPersonalNew',$iCountTopicsPersonalNew);
		$this->Viewer_Assign('iCountTopicsCompanyNew',$iCountTopicsCompanyNew);
		
		$this->Viewer_Assign('iCountTopicsNew',$iCountTopicsNew);
	}
	
	
	/**
	 * Показ комментариев из корпоративного блога
	 *
	 * @param unknown_type $sBlogUrl
	 * @param unknown_type $iTopicId
	 * @return unknown
	 */
	protected function EventShowCompanyComments() {	
		$sCompanyUrl=$this->sCurrentEvent;
		$iTopicId=$this->GetParamEventMatch(1,1);
		/**
		 * Меню
		 */
		$this->sMenuSubItemSelect='';
		/**
		 * Проверяем есть ли такой топик
		 */
		if (!($oTopic=$this->Topic_GetTopicById($iTopicId,null,-1))) {
			return parent::EventNotFound();
		}
		/**
		 * Проверяем права на просмотр топика
		 */
		if (!$oTopic->getPublish() and (!$this->oUserCurrent or ($this->oUserCurrent->getId()!=$oTopic->getUserId() and !$this->oUserCurrent->isAdministrator()))) {
			return parent::EventNotFound();
		}
		
		/**
		 * Обрабатываем добавление коммента
		 */
		$this->SubmitComment($oTopic);
		/**
		 * Достаём комменты к топику
		 */
		$aReturn=$this->Comment_GetCommentsByTargetId($oTopic->getId(),'topic');
		$iMaxIdComment=$aReturn['iMaxIdComment'];	
		$aComments=$aReturn['comments'];	
		$aCommentsNew=array();
		foreach ($aComments as $oCom) {
			$array=$oCom->_getData();
			$array['obj']=$oCom;
			$aCommentsNew[]=$array;
		}
		/**
		 * Проверяем находится ли топик в избранном у текущего юзера
		 */
		$bInFavourite=false;
		if ($this->oUserCurrent) {
			if ($this->Topic_GetFavouriteTopic($oTopic->getId(),$this->oUserCurrent->getId())) {
				$bInFavourite=true;
			}
		}
		/**
		 * Получаем дату прочтения топика
		 */
		$dDate=date("Y-m-d H:i:s");
		$iCommentLastTopicRead=0;
		if ($this->oUserCurrent) {
			if ($oTopicRead=$this->Topic_GetTopicRead($oTopic->getId(),$this->oUserCurrent->getId())) {
				$dDate=$oTopicRead->getDateRead();
				$iCommentLastTopicRead=$oTopicRead->getCommentIdLast();
			}
		}
		/**
		 * Отмечаем дату прочтения топика
		 */
		if ($this->oUserCurrent) {
			$oTopicRead= Engine::GetEntity('Topic_TopicRead');
			$oTopicRead->setTopicId($oTopic->getId());
			$oTopicRead->setUserId($this->oUserCurrent->getId());
			$oTopicRead->setCommentCountLast($oTopic->getCountComment());
			$oTopicRead->setCommentIdLast($iMaxIdComment);
			$oTopicRead->setDateRead(date("Y-m-d H:i:s"));
			$this->Topic_SetTopicRead($oTopicRead);
		}		
		/**
		 * Выставляем SEO данные
		 */
		$sTextSeo=preg_replace("/<.*>/Ui",' ',$oTopic->getText());
		$this->Viewer_SetHtmlDescription(func_text_words($sTextSeo,20));
		$this->Viewer_SetHtmlKeywords($oTopic->getTags());
		/**
		 * Загружаем переменные в шаблон
		 */		
		$this->Viewer_Assign('bInFavourite',$bInFavourite);
		$this->Viewer_Assign('dDateTopicRead',$dDate);
		$this->Viewer_Assign('iCommentLastTopicRead',$iCommentLastTopicRead);
		$this->Viewer_Assign('oTopic',$oTopic);
		$this->Viewer_Assign('aComments',$aComments);	
		$this->Viewer_Assign('aCommentsNew',$aCommentsNew);
		$this->Viewer_Assign('iMaxIdComment',$iMaxIdComment);
		$this->Viewer_AddHtmlTitle($oTopic->getBlogTitle());
		$this->Viewer_AddHtmlTitle($oTopic->getTitle());
		$this->SetTemplateAction('topic');
	}
	
}
?>