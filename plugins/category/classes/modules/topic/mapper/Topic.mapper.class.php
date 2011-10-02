<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (v.0.4.2 and 0.5)
 *   Plugin Category (v.0.1.1)
 *   Copyright © 2011 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
  ---------------------------------------------------------
 */

class PluginCategory_ModuleTopic_MapperTopic extends Mapper
{

    public function GetArrayTopicsByCetegory($iPage, $iPerPage, $aArrayId, $sShowType)
    {
	$aReturn = array();
	$aReturn['collection'] = null;
	$aReturn['count'] = 0;
	if (!is_array($aArrayId) or count($aArrayId) == 0) {
	    return $aReturn;
	}

	$sql = "SELECT
          count(*) as count
				FROM
					" . Config::Get('plugin.category.table.category_relation') . "
				WHERE
					category_id IN(?a) AND target_type = ?";
	$iCount = 0;
	if ($aRow = $this->oDb->selectRow($sql, $aArrayId, $sShowType)) {
	    $iCount = $aRow['count'];
	}

	$sql = "SELECT
					t.topic_id,
          cr.target_id, cr.category_id
				FROM 
					" . Config::Get('db.table.topic') . " as t
					JOIN  " . Config::Get('plugin.category.table.category_relation') . " AS cr ON cr.target_id=t.topic_id
				WHERE
					cr.category_id IN(?a) AND cr.target_type = ?
				ORDER BY t.topic_date_add DESC LIMIT ?d, ?d";
	$aTopics = array();
	if ($aRows = $this->oDb->select($sql, $aArrayId, $sShowType, ($iPage - 1) * $iPerPage, $iPerPage)) {
	    foreach ($aRows as $aRow) {
		$aTopics[] = $aRow['topic_id'];
	    }
	}
	$aReturn['collection'] = $aTopics;
	$aReturn['count'] = $iCount;
	return $aReturn;
    }

}

?>
