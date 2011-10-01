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

class PluginCompany_ModuleCompany_EntityCompanyUser extends Entity 
{    
    public function getCompanyId() {
        return $this->_aData['company_id'];
    }  
    public function getUserId() {
        return $this->_aData['user_id'];
    }
	public function getUserOwnerId() {
        return $this->_aData['user_owner_id'];
    }
    
	public function getIsAdministrator() {
        return ($this->_aData['company_user_role']==4);
    }
    public function getIsModerator() {
        return ($this->_aData['company_user_role']==2);
    }
    public function getIsEmployee() {
        return ($this->_aData['company_user_role']==1);
    }

        

    public function getCompanyUrl() {
        return $this->_aData['company_url'];
    }
    public function getCompanyName() {
        return $this->_aData['company_name'];
    }
    public function getUserLogin() {
        return $this->_aData['user_login'];
    }   
    public function getUserMail() {
        return $this->_aData['user_mail'];
    }
	public function getUserProfileAvatar() {
        return $this->_aData['user_profile_avatar'];
    }
    public function getUserProfileAvatarType() {
        return $this->_aData['user_profile_avatar_type'];
    }
    public function getUserProfileAvatarPath($iSize=100) {   
    	if ($this->getUserProfileAvatar()) { 	
        	return Config::Get('path.root.web').'/'.Config::Get('path.uploads.images').'/'.$this->getUserId().'/avatar_'.$iSize.'x'.$iSize.'.'.$this->getUserProfileAvatarType();
    	} else {
    		return Config::Get('path.static.skin').'/images/avatar_'.$iSize.'x'.$iSize.'.jpg';
    	}
    }
    public function getUserSettingsNoticeNewTopic() {
        return $this->_aData['user_settings_notice_new_topic'];
    }
    public function getUserSettingsNoticeNewComment() {
        return $this->_aData['user_settings_notice_new_comment'];
    }
    public function getUserSettingsNoticeNewTalk() {
        return $this->_aData['user_settings_notice_new_talk'];
    }
    public function getUserSettingsNoticeReplyComment() {
        return $this->_aData['user_settings_notice_reply_comment'];
    }
	public function getUserRole() {
        return $this->_aData['company_user_role'];
    }
	public function getBlogId() {
		return $this->_aData['blog_id'];
    }
	public function getBlogTitle() {
		$oEngine=Engine::getInstance();
		return $oEngine->Lang_Get('company_blog_prefix').' '.$this->getCompanyName();
    }
    
	public function setCompanyId($data) {
        $this->_aData['company_id']=$data;
    }
    public function setUserId($data) {
        $this->_aData['user_id']=$data;
    }
	public function setUserRole($data) {
        $this->_aData['company_user_role']=$data;
    }
	public function setBlogId($data) {
        $this->_aData['blog_id']=$data;
    }
	public function setIsAdministrator() {
        $this->_aData['company_user_role']=4;
    }
	public function setIsModerator() {
        $this->_aData['company_user_role']=2;
    }
	public function setIsEmployee() {
        $this->_aData['company_user_role']=1;
    }
	public function setIsAdmirer() {
        $this->_aData['company_user_role']=0;
    }
}
?>