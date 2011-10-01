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

class PluginCompany_ModuleCompany_EntityCompanyFeedbackRead extends Entity 
{    
    public function getCompanyId() {
        return $this->_aData['company_id'];
    }  
    public function getUserId() {
        return $this->_aData['user_id'];
    }
    public function getDateRead() {
        return $this->_aData['date_read'];
    }
    public function getFeedbackCountLast() {
        return $this->_aData['feedback_count_last'];
    }
    public function getFeedbackIdLast() {
        return $this->_aData['feedback_id_last'];
    }

    
    
	public function setCompanyId($data) {
        $this->_aData['company_id']=$data;
    }
    public function setUserId($data) {
        $this->_aData['user_id']=$data;
    }
    public function setDateRead($data) {
        $this->_aData['date_read']=$data;
    }
    public function setFeedbackCountLast($data) {
        $this->_aData['feedback_count_last']=$data;
    }
    public function setFeedbackIdLast($data) {
        $this->_aData['feedback_id_last']=$data;
    }
}
?>