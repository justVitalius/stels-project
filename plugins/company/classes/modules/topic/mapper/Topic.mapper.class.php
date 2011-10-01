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

class Mapper_TopicEx extends Mapper {	
	public function GetOpenTopicTags($iLimit) {
		$sql = "
			SELECT 
				tt.topic_tag_text,
				count(tt.topic_tag_text)	as count		 
			FROM 
				".Config::Get('db.table.topic_tag')." as tt,
				".Config::Get('db.table.blog')." as b
			WHERE 
				tt.blog_id = b.blog_id
				AND
				b.blog_type IN ('open','personal','company')
			GROUP BY 
				tt.topic_tag_text
			ORDER BY 
				count desc		
			LIMIT 0, ?d
				";	
		$aReturn=array();
		$aReturnSort=array();
		if ($aRows=$this->oDb->select($sql,$iLimit)) {
			foreach ($aRows as $aRow) {				
				$aReturn[mb_strtolower($aRow['topic_tag_text'],'UTF-8')]=$aRow;
			}
			ksort($aReturn);
			foreach ($aReturn as $aRow) {
				$aReturnSort[]=Engine::GetEntity('Topic_TopicTag',$aRow);				
			}
		}
		return $aReturnSort;
	}
}
?>