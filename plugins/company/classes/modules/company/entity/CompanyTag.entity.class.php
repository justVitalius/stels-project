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

class PluginCompany_ModuleCompany_EntityCompanyTag extends Entity 
{    
    public function getId() {
        return $this->_aData['company_tag_id'];
    }  
    public function getCompanyId() {
        return $this->_aData['company_id'];
    }
    public function getUserId() {
        return $this->_aData['user_id'];
    }
    public function getText() {
        return $this->_aData['company_tag_text'];
    }
    
    public function getCount() {
        return $this->_aData['count'];
    }
    public function getSize() {
        return $this->_aData['size'];
    }

  
    
	public function setId($data) {
        $this->_aData['company_tag_id']=$data;
    }
    public function setCompanyId($data) {
        $this->_aData['company_id']=$data;
    }
    public function setUserId($data) {
        $this->_aData['user_id']=$data;
    }
    public function setText($data) {
        $this->_aData['company_tag_text']=$data;
    }
    
	public function setSize($data) {
        $this->_aData['size']=$data;
    }
}
?>