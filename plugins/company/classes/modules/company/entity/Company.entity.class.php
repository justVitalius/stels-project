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

class PluginCompany_ModuleCompany_EntityCompany extends Entity 
{    
    public function getId() {
        return $this->_aData['company_id'];
    }  
    public function getOwnerId() {
        return $this->_aData['user_owner_id'];
    }
	public function getUrl() {
        return $this->_aData['company_url'];
    }
	public function getUrlFull() {
		return Config::Get('module.company.url').'/'.$this->getUrl();
    }
    public function getName() {
        return $this->_aData['company_name'];
    }
	public function getLegalName() {
        return $this->_aData['company_name_legal'];
    }
    public function getDescription() {
        return $this->_aData['company_description'];
    }
	public function getSite($bHtml=false) {
		if ($bHtml) {
    		if (strpos($this->_aData['company_site'],'http://')!==0) {
    			return 'http://'.$this->_aData['company_site'];
    		}
    	}
        return $this->_aData['company_site'];   
    }
	public function getEmail() {
        return $this->_aData['company_email'];
    }
	public function getPhone() {
        return $this->_aData['company_phone'];
    }
	public function getFax() {
        return $this->_aData['company_fax'];
    }
	public function getBoss() {
        return $this->_aData['company_boss'];
    }
    public function getDateBasis() {
        return $this->_aData['company_date_basis'];
    }
    public function getDateAdd() {
        return $this->_aData['company_date_add'];
    }
    public function getDateEdit() {
        return $this->_aData['company_date_edit'];
    }
    public function getRating() {        
        return number_format(round($this->_aData['company_rating'],2), 2, '.', '');
    }
	public function getTags() {
        return $this->_aData['company_tags'];
    }
	public function getTagsLink() {
    	$aTags=explode(',',$this->getTags());
    	foreach ($aTags as $key => $value) {
    		$aTags[$key]='<a href="'.Config::Get('module.company.url').'tag/'.htmlspecialchars($value).'/" class="smalltags">'.htmlspecialchars($value).'</a>';
    	}
        return trim(join(', ',$aTags));
    }
	public function getCountry() {
        return $this->_aData['company_country'];
    }
	public function getCity() {
        return $this->_aData['company_city'];
    }
	public function getAddress() {
        return $this->_aData['company_address'];
    }
	public function getBlogId() {
        return $this->_aData['blog_id'];
    }
	public function getCountWorkers() {
        return $this->_aData['company_count_workers'];
    }
	public function getVacancies() {
        return $this->_aData['company_vacancies'];
    }
    public function getCountVote() {
        return $this->_aData['company_count_vote'];
    }
	public function getLogo() {
        return $this->_aData['company_logo'];
    }
    public function getLogoType() {
        return $this->_aData['company_logo_type'];
    }
	public function getLogoPath($iSize=48) {   
    	if ($this->getLogo()) { 	
        	return Config::Get('path.root.web').Config::Get('path.uploads.images').'/company/'.$this->getId()."/logo_company_{$this->getUrl()}_".$iSize.'x'.$iSize.'.'.$this->getLogoType();
    	} else {
    		return Config::Get('path.static.skin').'/images/avatar_blog_'.$iSize.'x'.$iSize.'.gif';
    	}
    }
	public function getCountFeedback() {
        return $this->_aData['company_count_feedback'];
    }

    /*    */
    public function getCountUser() {
        return $this->_aData['blog_count_user'];
    }
    public function getLimitRatingTopic() {
        return $this->_aData['blog_limit_rating_topic'];
    }
    
    public function getUserLogin() {
        return $this->_aData['user_login'];
    }    
	public function getUserProfileAvatar() {
        return $this->_aData['user_profile_avatar'];
    }
    public function getUserProfileAvatarType() {
        return $this->_aData['user_profile_avatar_type'];
    }
    public function getUserProfileAvatarPath($iSize=100) {   
    	if ($this->getUserProfileAvatar()) { 	
        	return Config::Get('path.root.web').Config::Get('path.uploads.images').'/'.$this->getOwnerId().'/avatar_'.$iSize.'x'.$iSize.'.'.$this->getUserProfileAvatarType();
    	} else {
    		return Config::Get('path.static.skin').'/images/avatar_'.$iSize.'x'.$iSize.'.jpg';
    	}
    }
    public function getUserIsVote() {
        return $this->_aData['user_is_vote'];
    }
    public function getUserVoteDelta() {
        return $this->_aData['user_vote_delta'];
    }
    
    public function getCurrentUserIsJoin() {
        return $this->_aData['current_user_is_join'];
    }
    
    public function getUserIsJoin() {
        return $this->_aData['user_is_join'];
    }
    public function getUserIsAdministrator() {
        return $this->_aData['user_is_administrator'];
    }
    public function getUserIsModerator() {
        return $this->_aData['user_is_moderator'];
    }
    public function getOwner() {
        return $this->_aData['owner'];
    }  
    
    public function getBlog() {
        return $this->_aData['blog'];
    }
    
    public function getDateRead() {
        return $this->_aData['date_read'];
    } 
    public function getActive() {
        return $this->_aData['company_active'];
    }
    
    
    /*     */
       
    
	public function setId($data) {
        $this->_aData['company_id']=$data;
    }
    public function setOwnerId($data) {
        $this->_aData['user_owner_id']=$data;
    }
	public function setUrl($data) {
        $this->_aData['company_url']=$data;
    }
    public function setName($data) {
        $this->_aData['company_name']=$data;
    }
	public function setLegalName($data) {
        $this->_aData['company_name_legal']=$data;
    }
    public function setDescription($data) {
        $this->_aData['company_description']=$data;
    }
    public function setSite($data) {
        $this->_aData['company_site']=$data;
    }
 	public function setEmail($data) {
        $this->_aData['company_email']=$data;
    }
	public function setPhone($data) {
        $this->_aData['company_phone']=$data;
    }
	public function setFax($data) {
        $this->_aData['company_fax']=$data;
    }
	public function setBoss($data) {
        $this->_aData['company_boss']=$data;
    }
	public function setDateBasis($data) {
        $this->_aData['company_date_basis']=$data;
    }
    public function setDateAdd($data) {
        $this->_aData['company_date_add']=$data;
    }   
    public function setDateEdit($data) {
        $this->_aData['company_date_edit']=$data;
    } 
    public function setRating($data) {
        $this->_aData['company_rating']=$data;
    }
	public function setTags($data) {
        $this->_aData['company_tags']=$data;
    }
	public function setCountry($data) {
        $this->_aData['company_country']=$data;
    }
	public function setCity($data) {
        $this->_aData['company_city']=$data;
    }
	public function setAddress($data) {
        $this->_aData['company_address']=$data;
    }
	public function setBlogId($data) {
        $this->_aData['blog_id']=$data;
    }
	public function setCountWorkers($data) {
        $this->_aData['company_count_workers']=$data;
    }	
	public function setVacancies($data) {
        $this->_aData['company_vacancies']=$data;
    }
	public function setCountVote($data) {
        $this->_aData['company_count_vote']=$data;
    }
	public function setCountFeedback($data) {
        $this->_aData['company_count_feedback']=$data;
    }
    public function setLogo($data) {
        $this->_aData['company_logo']=$data;
    }
    public function setLogoType($data) {
        $this->_aData['company_logo_type']=$data;
    }
    public function setUserIsJoin($data) {
        $this->_aData['user_is_join']=$data;
    }
    public function setUserIsAdministrator($data) {
        $this->_aData['user_is_administrator']=$data;
    }
    public function setUserIsModerator($data) {
        $this->_aData['user_is_moderator']=$data;
    }
    public function setOwner($data) {
        $this->_aData['owner']=$data;
    }
    
    public function setBlog($data) {
        $this->_aData['blog']=$data;
    }
    
    public function setDateRead($data) {
        $this->_aData['date_read']=$data;
    }
    /**/
    
    public function setCountUser($data) {
        $this->_aData['blog_count_user']=$data;
    }
    public function setLimitRatingTopic($data) {
        $this->_aData['blog_limit_rating_topic']=$data;
    }
    public function setActive($data) {
        $this->_aData['company_active']=$data;
    }
    
    
}
?>