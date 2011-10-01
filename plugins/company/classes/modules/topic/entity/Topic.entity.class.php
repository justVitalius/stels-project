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

class PluginCompany_ModuleTopic_EntityTopic extends PluginCompany_Inherit_ModuleTopic_EntityTopic {      
    public function getUrl() { 
    	if ($this->getBlog()->getType()=='personal') {
    		return Router::GetPath('blog').$this->getId().'.html';
    	} else if ($this->getBlog()->getType()=='company') {
    		return Router::GetPath('company').$this->getBlog()->getUrl().'/blog/'.$this->getId().'.html'; //вырезаем company_
    	} else {
    		return Router::GetPath('blog').$this->getBlog()->getUrl().'/'.$this->getId().'.html';
    	}
    }
    
	public function setBlogType($data) {
        $this->_aData['blog_type']=$data;
    }
	public function setBlogUrl($data) {
        $this->_aData['blog_url']=$data;
    }
}
?>