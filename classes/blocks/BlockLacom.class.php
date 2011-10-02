<?php
/**
 * Блок последних комментариев
 * Получает последние комментарии и выводит их в шаблон.
 *
 * @package LiveStreet for Stels
 * @author Sevastyan Rabdano
 **/
class BlockLacom extends Block
{
	public function Exec() {
		if ($aComments=$this->Comment_GetCommentsOnline('topic',Config::Get('block.stream.row'))) {
			$this->Viewer_Assign('aComments',$aComments);
		}
	}
} // END class
?>
