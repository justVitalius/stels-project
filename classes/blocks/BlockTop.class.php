<?php
/**
 * Блок TOP 15 за неделю
 * Получает 15 топиков и выводит их в шаблон.
 *
 * @package LiveStreet for Stels
 * @author Sevastyan Rabdano
 **/
class BlockTop extends Block
{
	public function Exec() {
		$iTimeDelta=60*60*24*7;
		$sDate=date("Y-m-d H:00:00",time()-$iTimeDelta);
		if ($aTopics=$this->Topic_GetTopicsRatingByDate($sDate,15)) {
			$this->Viewer_Assign('aTopics',$aTopics);
		}
	}
} // END class
?>
