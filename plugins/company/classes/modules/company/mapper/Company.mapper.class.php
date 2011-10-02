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

class PluginCompany_ModuleCompany_MapperCompany extends Mapper {	
	protected $oUserCurrent=null;
	
	public function SetUserCurrent($oUserCurrent) {
		$this->oUserCurrent=$oUserCurrent;
	}
	
	/* КОМПАНИИ */
	
	public function AddCompany(PluginCompany_ModuleCompany_EntityCompany $oCompany) {
		$sql = "INSERT INTO ".Config::Get('db.table.company')." 
			(user_owner_id,
			company_url,
			company_name,
			company_description,
			company_tags,
			company_country,
			company_city,		
			company_date_add,
			company_vacancies,
			company_prefs,
			blog_id
			)
			VALUES(?d,  ?,	?,	?,	?,	?, ?, ?, ?, ?, ?d)
		";			
		if ($iId=$this->oDb->query($sql,$oCompany->getOwnerId(),$oCompany->getUrl(),$oCompany->getName(),$oCompany->getDescription(),$oCompany->getTags(),$oCompany->getCountry(),$oCompany->getCity(),$oCompany->getDateAdd(),'','',$oCompany->getBlogId())) {
			return $iId;
		}		
		return false;
	}
	
	public function UpdateCompany(PluginCompany_ModuleCompany_EntityCompany $oCompany) {		
		$sql = "UPDATE ".Config::Get('db.table.company')." 
			SET 
				company_name= ?,
				company_name_legal= ?,
				company_description= ?,
				company_site= ?,
				company_email= ?,
				company_phone= ?,
				company_fax= ?,
				company_boss= ?,
				company_date_basis= ?,
				company_date_edit= ?,	
				company_tags= ?,
				company_country= ?,
				company_city= ?,
				company_address= ?,
				company_count_workers= ?,
				company_rating= ?f,
				company_count_vote = ?d,
				company_logo=	?d,
				company_logo_type=	?,
				company_vacancies=	?,
				company_active=	?d
			WHERE
				company_id = ?d
		";			
		if ($this->oDb->query($sql,$oCompany->getName(),$oCompany->getLegalName(),$oCompany->getDescription(),$oCompany->getSite(),$oCompany->getEmail(),$oCompany->getPhone(),$oCompany->getFax(),$oCompany->getBoss(),$oCompany->getDateBasis(),$oCompany->getDateEdit(),
		$oCompany->getTags(),$oCompany->getCountry(),$oCompany->getCity(),$oCompany->getAddress(),$oCompany->getCountWorkers(),$oCompany->getRating(),$oCompany->getCountVote(),$oCompany->getLogo(),$oCompany->getLogoType(),$oCompany->getVacancies(),$oCompany->getActive(),$oCompany->getId())) {
			return true;
		}		
		return false;
	}
	
	
	public function GetCompanyByName($sName) {
		$sWhere = $this->MakeActivateFilter();
		$sql = "SELECT * FROM ".Config::Get('db.table.company')." as c WHERE c.company_name = ? ".$sWhere;
		if ($aRow=$this->oDb->selectRow($sql,$sName)) {
			return Engine::GetEntity('PluginCompany_Company_Company', $aRow);// new PluginCompany_ModuleCompany_EntityCompany($aRow); 
		}
		return null;
	}
	
	public function GetCompanyByUrl($sUrl) {
		$iCurrentUserId=-1;
		if (is_object($this->oUserCurrent)) {
			$iCurrentUserId=$this->oUserCurrent->getId();
		}
		$sWhere = $this->MakeActivateFilter();
		$sql = "SELECT 
			c.*,
			IF(cv.company_id IS NULL,0,1) as user_is_vote,
			cv.vote_delta as user_vote_delta	 
			FROM 
				".Config::Get('db.table.company')." as c
				LEFT JOIN (
						SELECT
							company_id,
							vote_delta												
						FROM ".Config::Get('db.table.company_vote')." 
						WHERE user_voter_id = ?d
					) AS cv ON cv.company_id = c.company_id		
			WHERE 
				LOWER(c.company_url) = ?
				".$sWhere;
		
		if ($aRow=$this->oDb->selectRow($sql,$iCurrentUserId,$sUrl)) {
			return Engine::GetEntity('PluginCompany_Company_Company', $aRow);//new PluginCompany_ModuleCompany_EntityCompany($aRow);
		}
		return null;
	}
	
	public function GetCompanyById($sId) {
		$sWhere = $this->MakeActivateFilter();
		$sql = "SELECT * FROM ".Config::Get('db.table.company')." as c WHERE c.company_id = ?d ".$sWhere;
		if ($aRow=$this->oDb->selectRow($sql,$sId)) {
			return Engine::GetEntity('PluginCompany_Company_Company', $aRow);//new PluginCompany_ModuleCompany_EntityCompany($aRow);
		}
		return null;
	}
	
	public function GetCompanyByFeedbackId($sId) {
		$sWhere = $this->MakeActivateFilter();
		$sql = "SELECT c.* 
				FROM ".Config::Get('db.table.company')." as c
				left join ".Config::Get('db.table.company_feedback')." as cf ON cf.company_id = c.company_id
				WHERE 
				cf.feedback_id = ?d ".$sWhere;
		if ($aRow=$this->oDb->selectRow($sql,$sId)) {
			return Engine::GetEntity('PluginCompany_Company_Company', $aRow);//new PluginCompany_ModuleCompany_EntityCompany($aRow);
		}
		return null;
	}
	
	public function GetCompaniesByTag($sTag,&$iCount,$iCurrPage,$iPerPage) {
		$sWhere = $this->MakeActivateFilter();
		$sql = "SELECT 
			c.* 
			FROM (				
					SELECT 		
						company_id										
					FROM 
						".Config::Get('db.table.company_tag')."								
					WHERE 
						company_tag_text = ? 	
                    ORDER BY company_id DESC	
                    LIMIT ?d, ?d				
				) as ct
				JOIN ".Config::Get('db.table.company')." AS c ON ct.company_id = c.company_id ".$sWhere;
		$aCompanies=array();
		if ($aRows=$this->oDb->select($sql,$sTag,($iCurrPage-1)*$iPerPage, $iPerPage)) {
			foreach ($aRows as $aCompany) {
				$aCompanies[]= Engine::GetEntity('PluginCompany_Company_Company', $aCompany);//new PluginCompany_ModuleCompany_EntityCompany($aCompany);
			}
			$iCount=$this->GetCountCompaniesByTag($sTag);
		}
		return $aCompanies;
	}
	
	public function GetCountCompaniesByTag($sTag) {
		$sql = "SELECT 		
					count(company_id) as count									
				FROM 
					".Config::Get('db.table.company_tag')."								
				WHERE 
					company_tag_text = ? ;	
					";				
		if ($aRow=$this->oDb->selectRow($sql,$sTag)) {
			return $aRow['count'];
		}
		return false;
	}
	
	public function GetCompaniesRatingByFilter(&$iCount,$iCurrPage,$iPerPage,$aFilter) {
		$sWhere = '1=1';
		$sWhere .= $this->MakeActivateFilter();
		if(isset($aFilter['city']))
			$sWhere .= ' AND c.city = '.$aFilter['city'];
		if(isset($aFilter['blog_id']))	
			$sWhere .= " AND c.blog_id IN ('".join("', '",$aFilter['blog_id'])."')";	
		$iCurrentUserId=-1;
		$sql = "SELECT *																			
				FROM 
					".Config::Get('db.table.company')."	as c	
				WHERE ".$sWhere."			 															
				ORDER by c.company_rating desc
				LIMIT ?d, ?d ";	
		$aReturn=array();
		if ($aRows=$this->oDb->selectPage($iCount,$sql,($iCurrPage-1)*$iPerPage, $iPerPage)) {
			foreach ($aRows as $aRow) {
				$aReturn[]= Engine::GetEntity('PluginCompany_Company_Company', $aRow);
			}
		} 
		return $aReturn;
	}
	
	
	public function GetCompaniesRating(&$iCount,$iCurrPage,$iPerPage) {
		$iCurrentUserId=-1;
		$sWhere = "1=1 ".$this->MakeActivateFilter();
		$sql = "SELECT *																			
				FROM 
					".Config::Get('db.table.company')." as c
				WHERE ".$sWhere."				 															
				ORDER by c.company_rating desc
				LIMIT ?d, ?d;	
				";	
		$aReturn=array();
		if ($aRows=$this->oDb->selectPage($iCount,$sql,($iCurrPage-1)*$iPerPage, $iPerPage)) {
			foreach ($aRows as $aRow) {
				$aReturn[]= Engine::GetEntity('PluginCompany_Company_Company', $aRow);//new PluginCompany_ModuleCompany_EntityCompany($aRow);;
			}
		} 
		return $aReturn;
	}
	
	public function GetCompaniesByCity(&$iCount,$iCurrPage,$iPerPage,$sCity) {
		$iCurrentUserId=-1;
		$sWhere = $this->MakeActivateFilter();
		$sql = "SELECT *																			
				FROM 
					".Config::Get('db.table.company')." as c
				WHERE 
					c.company_city = ? ".$sWhere."				 															
				ORDER by c.company_rating desc
				LIMIT ?d, ?d 
				;	
					";	
		$aReturn=array();
		if ($aRows=$this->oDb->selectPage($iCount,$sql,$sCity,($iCurrPage-1)*$iPerPage, $iPerPage)) {
			foreach ($aRows as $aRow) {
				$aReturn[]= Engine::GetEntity('PluginCompany_Company_Company', $aRow); //new PluginCompany_ModuleCompany_EntityCompany($aRow);;
			}
		} 
		return $aReturn;
	}
	
	/* СВЯЗЬ ПОЛЬЗОВАТЕЛЕЙ С КОМПАНИЕЙ */
	
	public function UpdateCompanyOwner(ModuleBlog_EntityBlog $oBlog) {		
		$sql = "UPDATE ".Config::Get('db.table.company')." 
			SET 
				user_owner_id = ?d			
			WHERE
				blog_id = ?d 
		";		
		if ($this->oDb->query($sql,$oBlog->getOwnerId(),$oBlog->getId())) {
			return true;
		}		
		return false;
	}
	
	public function UpdateCompanyBlogOwner(ModuleBlog_EntityBlog $oBlog) {		
		$sql = "UPDATE ".Config::Get('db.table.blog')." 
			SET 
				user_owner_id = ?d			
			WHERE
				blog_id = ?d 
		";		
		if ($this->oDb->query($sql,$oBlog->getOwnerId(),$oBlog->getId())) {
			return true;
		}		
		return false;
	}
	
	/* ГОЛОСОВАНИЯ */
	
	public function AddCompanyVote(PluginCompany_ModuleCompany_EntityCompanyVote $oCompanyVote) {
		$sql = "INSERT INTO ".Config::Get('db.table.company_vote')." 
			(company_id,
			user_voter_id,
			vote_delta		
			)
			VALUES(?d,  ?d,	?f)
		";			
		if ($this->oDb->query($sql,$oCompanyVote->getCompanyId(),$oCompanyVote->getVoterId(),$oCompanyVote->getDelta())===0) 
		{
			return true;
		}		
		return false;
	}
	
	public function GetCompanyVote($sCompanyId,$sUserId) {
		$sql = "SELECT * FROM ".Config::Get('db.table.company_vote')." WHERE company_id = ?d and user_voter_id = ?d ";
		if ($aRow=$this->oDb->selectRow($sql,$sCompanyId,$sUserId)) {
			return Engine::GetEntity('PluginCompany_Company_CompanyVote', $aRow);//new PluginCompany_ModuleCompany_EntityCompanyVote($aRow);
		}
		return null;
	}
	
	
	/* ОТЗЫВЫ */
	
	public function increaseCompanyCountFeedbacks($sCompanyId) {
		$sql = "UPDATE ".Config::Get('db.table.company')." 
			SET 
				company_count_feedback=company_count_feedback+1
			WHERE
				company_id = ?
		";			
		if ($this->oDb->query($sql,$sCompanyId)) {
			return true;
		}		
		return false;
	}
		
	public function UpdateFeedbackRead(PluginCompany_ModuleCompany_EntityCompanyFeedbackRead $oFeedbackRead) {		
		$sql = "UPDATE ".Config::Get('db.table.company_feedback_read')." 
			SET 
				feedback_count_last = ? ,
				feedback_id_last = ? ,
				date_read = ? 
			WHERE
				company_id = ? 
				AND				
				user_id = ? 
		";			
		return $this->oDb->query($sql,$oFeedbackRead->getFeedbackCountLast(),$oFeedbackRead->getFeedbackIdLast(),$oFeedbackRead->getDateRead(),$oFeedbackRead->getCompanyId(),$oFeedbackRead->getUserId());
	}	

	public function AddFeedbackRead(PluginCompany_ModuleCompany_EntityCompanyFeedbackRead $oFeedbackRead) {	
		$sql = "INSERT INTO ".Config::Get('db.table.company_feedback_read')." 
			SET 
				feedback_count_last = ? ,
				feedback_id_last = ? ,
				date_read = ? ,
				company_id = ? ,							
				user_id = ? 
		";			
		return $this->oDb->query($sql,$oFeedbackRead->getFeedbackCountLast(),$oFeedbackRead->getFeedbackIdLast(),$oFeedbackRead->getDateRead(),$oFeedbackRead->getCompanyId(),$oFeedbackRead->getUserId());
	}
				
	public function GetFeedbackRead($sCompanyId,$sUserId) {			
		$sql = "SELECT 
					*									
				FROM 
					".Config::Get('db.table.company_feedback_read')."					 
				WHERE 					
					company_id = ?d					
					AND			
					user_id = ?d					
				;	
					";		
		if ($aRow=$this->oDb->selectRow($sql,$sCompanyId,$sUserId)) {
			return Engine::GetEntity('PluginCompany_Company_CompanyFeedbackRead', $aRow);//new PluginCompany_ModuleCompany_EntityCompanyFeedbackRead($aRow);
		}
		return false;
	}
	
	/* ТЭГИ */
	
	public function AddCompanyTag(PluginCompany_ModuleCompany_EntityCompanyTag $oCompanyTag) {
		$sql = "INSERT INTO ".Config::Get('db.table.company_tag')." 
			(company_id,
			user_id,
			company_tag_text		
			)
			VALUES(?d,  ?d,	?)
		";			
		if ($iId=$this->oDb->query($sql,$oCompanyTag->getCompanyId(),$oCompanyTag->getUserId(),$oCompanyTag->getText())) 
		{
			return $iId;
		}		
		return false;
	}
	
	public function DeleteCompanyTagsByCompanyId($sCompanyId) {
		$sql = "DELETE FROM ".Config::Get('db.table.company_tag')." 
			WHERE
				company_id = ?d				
		";			
		if ($this->oDb->query($sql,$sCompanyId)) {
			return true;
		}		
		return false;
	}
	
	public function GetCompanyTags($iLimit) {
		$sql = "SELECT 
			tt.company_tag_text,
			count(tt.company_tag_text)	as count		 
			FROM 
				".Config::Get('db.table.company_tag')." as tt, 
				".Config::Get('db.table.company')." as t		
			WHERE
				t.company_id=tt.company_id		
			GROUP BY 
				tt.company_tag_text
			ORDER BY 
				count desc		
			LIMIT 0, ?d		
				";	
		$aReturn=array();
		$aReturnSort=array();
		if ($aRows=$this->oDb->select($sql,$iLimit)) {
			foreach ($aRows as $aRow) {				
				$aReturn[$aRow['company_tag_text']]=$aRow;
			}			
			ksort($aReturn);			
			foreach ($aReturn as $aRow) {
				$aReturnSort[]= Engine::GetEntity('PluginCompany_Company_CompanyTag', $aRow);//new PluginCompany_ModuleCompany_EntityCompanyTag($aRow);				
			}
		}
		return $aReturnSort;
	}
	
	public function GetCompanyTagsByLike($sTag,$iLimit) {
		$sTag=mb_strtolower($sTag,"UTF-8");		
		$sql = "SELECT 
				company_tag_text					 
			FROM 
				".Config::Get('db.table.company_tag')."	
			WHERE
				company_tag_text LIKE ?			
			GROUP BY 
				company_tag_text					
			LIMIT 0, ?d		
				";	
		$aReturn=array();
		if ($aRows=$this->oDb->select($sql,$sTag.'%',$iLimit)) {
			foreach ($aRows as $aRow) {
				$aReturn[]= Engine::GetEntity('PluginCompany_Company_CompanyTag', $aRow);//new PluginCompany_ModuleCompany_EntityCompanyTag($aRow);
			}
		}
		return $aReturn;
	}
	
	/* СТРАНЫ И ГОРОДА*/
		
	public function SetCompanyCountry($sCompanyId,$sCountryId) {		
		$sql = "REPLACE ".Config::Get('db.table.company_country')." 
			SET 
				company_id = ? ,
				country_id = ? 		
		";			
		return $this->oDb->query($sql,$sCompanyId,$sCountryId);
	}
	
	public function SetCompanyCity($sCompanyId,$sCityId) {		
		$sql = "REPLACE ".Config::Get('db.table.company_city')." 
			SET 
				company_id = ? ,
				city_id = ? 
		";			
		return $this->oDb->query($sql,$sCompanyId,$sCityId);
	}
	
	
	public function GetCompanyCities($iLimit) {
		$sWhere = "1=1 ".$this->MakeActivateFilter();
		$sql = "SELECT 
			c.company_city,
			count(c.company_city) as count		 
			FROM  
				".Config::Get('db.table.company')." as c
			WHERE ".$sWhere."	
			GROUP BY
              c.company_city	
			ORDER BY 
				count desc		
			LIMIT 0, ?d		
				";	
		$aReturn=array();
		$aReturnSort=array();
		if ($aRows=$this->oDb->select($sql,$iLimit)) {
			foreach ($aRows as $aRow) {				
				$aReturn[$aRow['company_city']]=$aRow;
			}			
			ksort($aReturn);			
			foreach ($aReturn as $aRow) {
				$aReturnSort[]= Engine::GetEntity('PluginCompany_Company_CompanyCities', $aRow); //new PluginCompany_ModuleCompany_EntityCompanyCities($aRow);				
			}
		}
		return $aReturnSort;
	}
	
	public function DeleteCompany($sCompanyId) {
		$sql = "DELETE FROM ".Config::Get('db.table.company')." 
			WHERE
				company_id = ?d				
		";			
		if ($this->oDb->query($sql,$sCompanyId)) {
			return true;
		}		
		return false;
	}
	public function DeleteBlog($sBlogId) {
		$sql = "DELETE FROM ".Config::Get('db.table.blog')." 
			WHERE
				blog_id = ?d				
		";			
		if ($this->oDb->query($sql,$sBlogId)) {
			return true;
		}		
		return false;
	}
	
	public function GetCompaniesByBlogId($Blogid) {
		$sWhere = $this->MakeActivateFilter();
		if (!$Blogid){
			return array();
		}
		if (!is_array($Blogid))
			$Blogid = array($Blogid);		
		$sql = "SELECT *			
				FROM 
					".Config::Get('db.table.company')." as c
				WHERE 
					c.blog_id IN (?a) ".$sWhere;		
		$aCompanies=array();
		if ($aRows=$this->oDb->select($sql,$Blogid)) {
			foreach ($aRows as $oCompany) {
				$aCompanies[$oCompany['company_id']]= Engine::GetEntity('PluginCompany_Company_Company', $oCompany);
			}
		}
		return $aCompanies;
	}
	
	public function GetCompaniesByArrayId($aArrayId) {
		if (!is_array($aArrayId) or count($aArrayId)==0) {
			return array();
		}
				
		$sql = "SELECT 
					c.*						 
				FROM 
					".Config::Get('db.table.company')." as c	
				WHERE 
					c.company_id IN(?a) 								
				ORDER BY FIELD(c.company_id,?a) ";
		$aCompanies=array();
		if ($aRows=$this->oDb->select($sql,$aArrayId,$aArrayId)) {
			foreach ($aRows as $oCompany) {
				$aCompanies[]=Engine::GetEntity('PluginCompany_Company_Company', $oCompany);
			}
		}		
		return $aCompanies;
	}
	/**
	 * Конвертирует данные таблицы компаний
	 * @return unknown_type
	 */
	public function Convert(){
		$sPrefix = Config::Get('db.table.prefix');
		$aErrors = array();
		/**
		 * Переводим в одну таблицу комментарии
		 */
		$sCommentIdMaxQuery = "SELECT MAX( comment_id ) AS max_id FROM {$sPrefix}comment";
		/**
		 * Получаем максимальный идентификатор комментариев к топикам
		 */
		if(!$aResults = mysql_query($sCommentIdMaxQuery) ){
			$aErrors[] = $this->Lang('error_table_select',array('table'=>'comments'));
		} else {
			$aRow=mysql_fetch_row($aResults);
			$iMaxId = $aRow[0]+1;

			$sTalkCommentSelect = "SELECT * FROM {$sPrefix}company_feedback";
			if(!$aResults = mysql_query($sTalkCommentSelect)){ 
				$aErrors[] = $this->Lang('error_table_select', array('table'=>'company_feedback'));
			} else {
				$iAutoIncrement = $iMaxId;
				while($aRow = mysql_fetch_array($aResults, MYSQL_ASSOC)) {
					$aRow['feedback_id']+=$iMaxId;
					/**
					 * Выбираем максимальный айдишник
					 */
					$iAutoIncrement = ($aRow['feedback_id']>$iAutoIncrement) 
						? $aRow['feedback_id']
						: $iAutoIncrement;
						
					$aRow['feedback_pid']= is_int($aRow['feedback_pid']) ? $aRow['feedback_id']+$iMaxId : "NULL"; 
					$sQuery = "INSERT INTO `{$sPrefix}comment` 
								SET
									comment_id = '{$aRow['feedback_id']}',
									comment_pid = {$aRow['feedback_pid']}, 
									target_id = '{$aRow['company_id']}',
									target_type = 'company',
									target_parent_id = '0',
									user_id = '{$aRow['user_id']}',
									comment_text = '".mysql_real_escape_string($aRow['feedback_text'])."',
									comment_text_hash = '".md5($aRow['feedback_text'])."',
									comment_date = '{$aRow['feedback_date']}',
									comment_user_ip = '{$aRow['feedback_user_ip']}',
									comment_rating = '".(($aRow['feedback_bad'] == 1)? -100: 0)."', 
									comment_count_vote = '0',
									comment_delete = '{$aRow['feedback_delete']}',
									comment_publish = '1' ";
					if(!mysql_query($sQuery)) $aErrors[] = mysql_error();
				}
				$iAutoIncrement++;
				/**
				 * Устанавливаем в таблице новое значение авто инкремента
				 */
				@mysql_query("ALTER {$sPrefix}comment AUTO_INCREMENT={$iAutoIncrement}");
				mysql_free_result($aResults);
			}
		}
		/**
		 * Обновляем количество отзывов
		 */
		$sFeedbackSql = "SELECT feedback_id FROM {$sPrefix}company_feedback";
		if($aResults = mysql_query($sFeedbackSql)){
			while($aRow = mysql_fetch_assoc($aResults)) {
				$sFeedbackCountSql = "SELECT count(comment_id) as c FROM {$sPrefix}comment WHERE `target_id`={$aRow['feedback_id']} AND `target_type`='company'";
				if($aResultsCount = mysql_query($sFeedbackCountSql) and $aRowCount = mysql_fetch_assoc($aResultsCount)){
					mysql_query("UPDATE {$sPrefix}company SET company_count_feedback = {$aRowCount['c']} WHERE feedback_id = {$aRow['feedback_id']} ");
				}
			}
		}
		
		// Обновляем роли
		$sTable=$sPrefix.'company_user';
		mysql_query("UPDATE {$sTable} SET company_user_role = 0 WHERE company_user_role = 1 ");  //поклонник
		mysql_query("UPDATE {$sTable} SET company_user_role = 1 WHERE company_user_role = 2 ");  //сотрудник
		mysql_query("UPDATE {$sTable} SET company_user_role = 2 WHERE company_user_role = 99 "); //модератор
		mysql_query("UPDATE {$sTable} SET company_user_role = 4 WHERE company_user_role = 100 ");//администратор
		
		$sCompanyRoleSql = "SELECT c.company_id, c.blog_id, cu.company_user_role, cu.user_id FROM {$sPrefix}company_user as cu LEFT JOIN {$sPrefix}company as c on c.company_id=cu.company_id WHERE c.user_owner_id <> cu.user_id";
		if(!$aResults = mysql_query($sCompanyRoleSql)){ 
			$aErrors[] = $this->Lang('error_table_select', array('table'=>'company_user'));
		} else {
			while($aRow = mysql_fetch_array($aResults, MYSQL_ASSOC)) {
				$sQuery = "INSERT INTO `{$sPrefix}blog_user` 
							SET
								blog_id = '{$aRow['blog_id']}',
								user_id = '{$aRow['user_id']}',
								user_role = '{$aRow['company_user_role']}'
							";
				if(!mysql_query($sQuery)) $aErrors[] = mysql_error();
			}
			mysql_free_result($aResults);
		}
		
		if(count($aErrors)==0) {
			return array('result'=>true,'errors'=>null);
		}
		return array('result'=>false,'errors'=>$aErrors);	
	}
	
	public function RepairUrl(){
		$sql = "SELECT 
					c.company_url, c.blog_id						 
				FROM 
					".Config::Get('db.table.company')." as c	
				WHERE 

				(1=1)";
		if ($aRows=$this->oDb->select($sql)) {
			foreach ($aRows as $oRow) {
				$sQuery = "UPDATE ".Config::Get('db.table.blog')." 
								SET
									blog_url = 'company_{$oRow['company_url']}'
								WHERE 
									blog_id = {$oRow['blog_id']} and blog_type = 'company' ";
				$this->oDb->query($sQuery);
			}
		}	
		return true;	
	}
	
	public function MakeActivateFilter() {
		$iCurrentUserId=-1;
		if (is_object($this->oUserCurrent)) {
			$iCurrentUserId=$this->oUserCurrent->getId();
		}
		if (Config::Get('module.company.use_activate')) {
			if ($this->oUserCurrent and !$this->oUserCurrent->isAdministrator()){
				return " AND (c.company_active = 1 OR c.user_owner_id = ".$iCurrentUserId.')';
			}
		} 
		return "";
	}
	
	public function GetCompanyInactiveBlogs() {
		$sql = "SELECT c.blog_id										
				FROM ".Config::Get('db.table.company')." as c					
				WHERE c.company_active = 0;
			   ";
		$aReturn=array();
		if ($aRows=$this->oDb->select($sql)) {
			foreach ($aRows as $aRow) {
				$aReturn[]=$aRow['blog_id'];
			}
		}
		return $aReturn;
	}
	
	public function GetCompanyActiveBlogs($oUser) {
		$sWhere = "1=1 ";
		if (!$oUser->isAdministrator()){
			$sWhere .= " AND c.company_active = 1";
		}
		$sql = "SELECT c.blog_id										
				FROM ".Config::Get('db.table.company')." as c					
				WHERE ".$sWhere;
		$aReturn=array();
		if ($aRows=$this->oDb->select($sql)) {
			foreach ($aRows as $aRow) {
				$aReturn[]=$aRow['blog_id'];
			}
		}
		return $aReturn;
	}
}
?>