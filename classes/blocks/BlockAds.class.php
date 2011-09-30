<?php
/**
 * Блок рекламы
 * Передает в шаблон адрес картинки-баннера и ссылку.
 *
 * @package LiveStreet for Stels
 * @author Sevastyan Rabdano
 **/

class BlockAds extends Block {
	public function Exec() {
		$sBannerImage='uploads/ad/banner.png';
		$sBannerLink= file_get_contents('uploads/ad/link.txt');
		$this->Viewer_Assign('sBannerImage',$sBannerImage);
		$this->Viewer_Assign('sBannerLink',$sBannerLink);
	}
}
?>