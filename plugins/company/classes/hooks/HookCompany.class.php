<?php 
class Plugincompany_HookCompany extends Hook {  
	public function RegisterHook() {
		$this->AddHook('topic_add_before', 'TopicBeforeAdd', __CLASS__, -5);
		$this->AddHook('profile_whois_show', 'ProfileShow', __CLASS__, -5);	
		$this->AddHook('template_main_menu', 'tplMainMenu', __CLASS__, 2);
		$this->AddHook('template_menu_profile', 'tplMenuProfile', __CLASS__, -5);   
		$this->AddHook('action_shutdown_actionindex_after', 'ActionShutdown', __CLASS__, -5); 
		$this->AddHook('action_shutdown_actionpersonalblog_after', 'ActionShutdown', __CLASS__, -5); 
		$this->AddHook('action_shutdown_actiontop_after', 'ActionShutdown', __CLASS__, -5); 
		$this->AddHook('action_shutdown_actionblog_after', 'ActionShutdown', __CLASS__, -5); 
		$this->AddHook('action_shutdown_actionnew_after', 'ActionShutdown', __CLASS__, -5);  
	}

	public function TopicBeforeAdd($aVars) {
		if ($aVars["oBlog"]->getType()=='company'){
			// Топики компаний сразу попадают на главную
			if (Config::Get('module.company.topic_on_index')){
				$aVars["oTopic"]->setPublishIndex(1);
			}
		}
	} 
         
	public function ProfileShow($aVars) {
		$aCompanyEmployee = $this->PluginCompany_Company_GetCompaniesByUserId($aVars["oUserProfile"]->getId(),array(ModuleBlog::BLOG_USER_ROLE_USER,ModuleBlog::BLOG_USER_ROLE_MODERATOR,ModuleBlog::BLOG_USER_ROLE_ADMINISTRATOR));
		$aCompanyAdmirer = $this->PluginCompany_Company_GetCompaniesByUserId($aVars["oUserProfile"]->getId(),array(ModuleBlog::BLOG_USER_ROLE_GUEST));
		$this->Viewer_Assign('aCompanyEmployee',$aCompanyEmployee);
		$this->Viewer_Assign('aCompanyAdmirer',$aCompanyAdmirer); 
	}

	public function tplMainMenu($aVars) {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath('company').'/inject.header_top.tpl');
	} 
	
	public function tplMenuProfile($aVars) {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath('company').'/inject.menu.profile.tpl');
	} 
	
	public function ActionShutdown($aVars) {
		$iCountTopicsCollectiveNew=$this->Topic_GetCountTopicsCollectiveNew();
		$iCountTopicsPersonalNew=$this->Topic_GetCountTopicsPersonalNew();
		$iCountTopicsCompanyNew=$this->PluginCompany_Company_GetCountTopicsCompanyNew();
		$iCountTopicsNew=$iCountTopicsCollectiveNew+$iCountTopicsPersonalNew+$iCountTopicsCompanyNew;

		$this->Viewer_Assign('iCountTopicsCompanyNew',$iCountTopicsCompanyNew);
		$this->Viewer_Assign('iCountTopicsPersonalNew',$iCountTopicsPersonalNew);	
		$this->Viewer_Assign('iCountTopicsNew',$iCountTopicsNew);
	} 
	
}
?>