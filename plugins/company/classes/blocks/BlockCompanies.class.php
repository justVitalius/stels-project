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

/**
 * Обработка блока компаний
 *
 */
class PluginCompany_BlockCompanies extends Block {
    
    public function Exec() {
        /**
		 * Получаем список блогов
		 */
		$aResult = $this->PluginCompany_Company_GetCompaniesRating(1,Config::Get('module.company.on_block')); 
		$aCompany=$aResult['collection'];	
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign("aCompany", $aCompany);

    }
}
?>