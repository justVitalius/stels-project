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

class PluginCompany_ModuleCompany_EntityCompanyCities extends Entity 
{    
    public function getCity() {
        return $this->_aData['company_city'];
    }
    
    public function getCount() {
        return $this->_aData['count'];
    }
    public function getSize() {
        return $this->_aData['size'];
    }

  
    
    public function setCity($data) {
        $this->_aData['company_city']=$data;
    }
    
	public function setSize($data) {
        $this->_aData['size']=$data;
    }
}
?>