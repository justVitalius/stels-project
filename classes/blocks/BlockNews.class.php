<?php
/**
 * Блок новостей
 * Получает новости и выводит их в шаблон.
 *
 * @package LiveStreet for Stels
 * @author Sevastyan Rabdano
 **/
class BlockNews extends Block
{
	public function Exec() {
		$oBlog=$this->Blog_GetBlogByUrl('news');
		// 1-> Откуда
		// 2-> Какую страницу
		// 3-> Сколько постов
		// 4-> Каких постов
		$aResult=$this->Topic_GetTopicsByBlog($oBlog,1,10,'good');
		$aTopics=$aResult['collection'];
		$this->Viewer_Assign('aTopics',$aTopics);
	}
} // END class
?>
