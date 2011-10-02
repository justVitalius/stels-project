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

class Mapper_BlogEx extends Mapper {		
	public function GetBlogs() {
		$sql = "SELECT 
			b.blog_id			 
			FROM 
				".Config::Get('db.table.blog')." as b				
			WHERE 				
				b.blog_type NOT IN ('personal')				
				";	//, 'company'	
		$aBlogs=array();
		if ($aRows=$this->oDb->select($sql)) {
			foreach ($aRows as $aBlog) {
				$aBlogs[]=$aBlog['blog_id'];
			}
		}
		return $aBlogs;
	}
		
	public function GetBlogsRating(&$iCount,$iCurrPage,$iPerPage) {		
		$sql = "SELECT 
					b.blog_id													
				FROM 
					".Config::Get('db.table.blog')." as b 									 
				WHERE 									
					b.blog_type NOT IN ('personal', 'company')								
				ORDER by b.blog_rating desc
				LIMIT ?d, ?d 	";		
		$aReturn=array();
		if ($aRows=$this->oDb->selectPage($iCount,$sql,($iCurrPage-1)*$iPerPage, $iPerPage)) {
			foreach ($aRows as $aRow) {
				$aReturn[]=$aRow['blog_id'];
			}
		}
		return $aReturn;
	}
	
	public function GetBlogsRatingJoin($sUserId,$iLimit) {		
		$sql = "SELECT 
					b.*													
				FROM 
					".Config::Get('db.table.blog_user')." as bu,
					".Config::Get('db.table.blog')." as b	
				WHERE 	
					bu.user_id = ?d
					AND
					bu.blog_id = b.blog_id
					AND				
					b.blog_type NOT IN ('personal', 'company')							
				ORDER by b.blog_rating desc
				LIMIT 0, ?d 
				;	
					";		
		$aReturn=array();
		if ($aRows=$this->oDb->select($sql,$sUserId,$iLimit)) {
			foreach ($aRows as $aRow) {
				$aReturn[]=Engine::GetEntity('Blog',$aRow);
			}
		}
		return $aReturn;
	}
	
	public function GetBlogsRatingSelf($sUserId,$iLimit) {		
		$sql = "SELECT 
					b.*													
				FROM 					
					".Config::Get('db.table.blog')." as b	
				WHERE 						
					b.user_owner_id = ?d
					AND				
					b.blog_type NOT IN ('personal', 'company')													
				ORDER by b.blog_rating desc
				LIMIT 0, ?d 
			;";		
		$aReturn=array();
		if ($aRows=$this->oDb->select($sql,$sUserId,$iLimit)) {
			foreach ($aRows as $aRow) {
				$aReturn[]=Engine::GetEntity('Blog',$aRow);
			}
		}
		return $aReturn;
	}
	
}
?>