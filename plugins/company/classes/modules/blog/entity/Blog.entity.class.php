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
class PluginCompany_ModuleBlog_EntityBlog extends PluginCompany_Inherit_ModuleBlog_EntityBlog {    
	public function getUrl() {
		if ($this->getType()=='company') {
        	return substr_replace($this->_aData['blog_url'],"", 0, 8);//вырезаем company_
		} else {
			return $this->_aData['blog_url'];
		}		
    }
	
    public function getUrlFull() {
        if ($this->getType()=='personal') {
    		return Router::GetPath('my').$this->getOwner()->getLogin().'/';
    	} else if ($this->getType()=='company') {
    		return Router::GetPath('company').$this->getUrl().'/blog/'; 
    	} else {
    		return Router::GetPath('blog').$this->getUrl().'/';
    	}
    }
           
 
}
?>