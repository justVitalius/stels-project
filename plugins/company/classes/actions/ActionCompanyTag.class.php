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

/**
 * Обрабатывает поиск по тегам
 *
 */
class PluginCompany_ActionCompanyTag extends ActionPlugin {	
	/**
	 * Инициализация
	 *
	 */
	public function Init() {		
		/**
		 * Определяем какие блоки выводить
		 */
		//$this->Viewer_AddBlocks('right',array('tags','stream','companytags','companies'));	
	}
	
	protected function RegisterEvent() {						
	}
		
	
	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */
	
	/**
	 * Отображение топиков
	 *
	 */
	protected function EventNotFound() {
		/**
		 * Получаем тег из УРЛа
		 */
		$sTag=urldecode($this->sCurrentEvent);
		/**
		 * Передан ли номер страницы
		 */
		if (preg_match("/^page(\d+)$/i",$this->getParam(0),$aMatch)) {			
			$iPage=$aMatch[1];
		} else {
			$iPage=1;
		}		
		/**
		 * Получаем список топиков
		 */
		$iCount=0;			
		$aResult=$this->PluginCompany_Company_GetCompaniesByTag($sTag,$iCount,$iPage,Config::Get('module.topic.per_page'));		
		$aCompanies=$aResult['collection'];	
		/**
		 * Формируем постраничность
		 */		
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),4,Config::Get('module.company.url').'tag/'.htmlspecialchars($sTag));
		/**
		 * Загружаем переменные в шаблон
		 */				
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('aCompanies',$aCompanies);
		$this->Viewer_Assign('sTag',$sTag);
		$this->Viewer_AddHtmlTitle('Поиск компаний по тегам');
		$this->Viewer_AddHtmlTitle($sTag);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('index');		
	}	
}
?>