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

class PluginCompany_ModuleCompany_EntityCompanyFeedback extends Entity 
{    
    public function getId() {
        return $this->_aData['feedback_id'];
    } 
    public function getPid() {
        return $this->_aData['feedback_pid'];
    } 
    public function getCompanyId() {
        return $this->_aData['company_id'];
    }
    public function getUserId() {
        return $this->_aData['user_id'];
    }
    public function getText() {
        return $this->_aData['feedback_text'];
    }
    public function getDate() {
        return $this->_aData['feedback_date'];
    }
    public function getUserIp() {
        return $this->_aData['feedback_user_ip'];
    }    
    public function getDelete() {
        return $this->_aData['feedback_delete'];
    }
    public function getBad() {    	
        return $this->_aData['feedback_bad'];
    }
    public function getUserLogin() {
        return $this->_aData['user_login'];
    }
    public function getLevel() {
        return $this->_aData['level'];
    }
	public function getUserProfileAvatar() {
        return $this->_aData['user_profile_avatar'];
    }
    public function getUserProfileAvatarType() {
        return $this->_aData['user_profile_avatar_type'];
    }
    public function getUserProfileAvatarPath($iSize=100) {     	  
    	if ($this->getUserProfileAvatar()) { 	
        	return DIR_WEB_ROOT.DIR_UPLOADS_IMAGES.'/'.$this->getUserId().'/avatar_'.$iSize.'x'.$iSize.'.'.$this->getUserProfileAvatarType();
    	} else {
    		return DIR_STATIC_SKIN.'/images/avatar_'.$iSize.'x'.$iSize.'.jpg';
    	}
    }
	public function getCompanyName() {
        return $this->_aData['company_name'];
    }
    public function getCompanyCountFeedback() {
        return $this->_aData['company_count_feedback'];
    }

    public function getCompanyUrl() {
    	return DIR_WEB_ROOT.'/company/'.$this->_aData['company_url'].'/';
    }   
    
    
    
    
	public function setId($data) {
        $this->_aData['feedback_id']=$data;
    }
    public function setPid($data) {
        $this->_aData['feedback_pid']=$data;
    }
    public function setCompanyId($data) {
        $this->_aData['company_id']=$data;
    }
    public function setUserId($data) {
        $this->_aData['user_id']=$data;
    }
    public function setText($data) {
        $this->_aData['feedback_text']=$data;
    }
    public function setDate($data) {
        $this->_aData['feedback_date']=$data;
    }
    public function setUserIp($data) {
        $this->_aData['feedback_user_ip']=$data;
    }    
    public function setRating($data) {
        $this->_aData['feedback_rating']=$data;
    }
    public function setCountVote($data) {
        $this->_aData['feedback_count_vote']=$data;
    }
    public function setDelete($data) {
        $this->_aData['feedback_delete']=$data;
    }
	public function setBad($data) {
        $this->_aData['feedback_bad']=$data;
    }
}
?>