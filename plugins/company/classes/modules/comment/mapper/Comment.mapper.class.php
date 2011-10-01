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

class Mapper_CommentEx extends Mapper {	

	public function UpdateFeeback(CommentEntity_Comment $oComment) {		
		$sql = "UPDATE ".Config::Get('db.table.comment')." 
			SET 
				comment_text= ?,
				comment_rating= ?f,
				comment_count_vote= ?d,
				comment_delete = ?d ,
				comment_publish = ?d ,
				comment_text_hash = ?
			WHERE
				comment_id = ?d
		";			
		if ($this->oDb->query($sql,$oComment->getText(),$oComment->getRating(),$oComment->getCountVote(),$oComment->getDelete(),$oComment->getPublish(),$oComment->getTextHash(),$oComment->getId())) {
			return true;
		}		
		return false;
	}
}
?>