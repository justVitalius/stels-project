<?php
/**
 * Блок вопросов и ответов
 * Получает вопросы и ответы и выводит их в шаблон.
 *
 * @package LiveStreet for Stels
 * @author Sevastyan Rabdano
 **/
class BlockQa extends Block
{
	public function Exec() {
		$oBlog=$this->Blog_GetBlogByUrl('qa');
		// 1-> Откуда
		// 2-> Какую страницу
		// 3-> Сколько постов
		// 4-> Каких постов
		$aResult=$this->Topic_GetTopicsByBlog($oBlog,1,5,'good');
		$aTopics=$aResult['collection'];
		$this->Viewer_Assign('aTopics',$aTopics);
	}
} // END class
?>
