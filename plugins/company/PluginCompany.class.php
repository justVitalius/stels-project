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
*	Plugin "Company"
*	Author: Grebenkin Anton 
*	Contact e-mail: 4freework@gmail.com
*
---------------------------------------------------------
*/
if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginCompany extends Plugin {
	protected $aInherits=array(
		/*'action' => array('ActionBlog', 'ActionPersonalBlog', 'ActionTop'), */
		'module' => array('ModuleBlog'=>'PluginCompany_ModuleBlog','ModuleComment'=>'PluginCompany_ModuleComment'),
		'entity' => array('ModuleTopic_EntityTopic'=>'_ModuleTopic_EntityTopic', 'ModuleBlog_EntityBlog'=>'_ModuleBlog_EntityBlog'),
		// entity 'ModuleTopic_EntityTopic'=>'_ModuleTopic_EntityTopic'
		// module 'ModuleTopic'=>'PluginCompany_ModuleTopic'
    );
    
	protected $aDelegates=array(
        'template'=>array(
        				//'actions/ActionProfile/whois.tpl'=>'../../../plugins/company/templates/skin/default/actions/ActionProfile/whois.tpl', //by vit 
						'block.stream.tpl'=>'../../../plugins/company/templates/skin/default/block.stream.tpl',
						'block.stream_comment.tpl'=>'../../../plugins/company/templates/skin/default/block.stream_comment.tpl',
						'menu.blog.tpl'=>'../../../plugins/company/templates/skin/default/menu.blog.tpl',
						),			
	);
	/**
	 * Активация плагина Компании.
	 * Создание таблицы в базе данных при ее отсутствии.
	 */
	public function Activate() {
		$this->ExportSQL(dirname(__FILE__).'/sql.sql');
		return true;
	}
	
	/**
	 * Инициализация плагина Компании
	 */
	public function Init() {
	}
}
?>