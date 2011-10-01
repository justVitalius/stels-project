<?php

/*-------------------------------------------------------
*
*   LsMods Developer Team
*   Author: Yuriy Sergeev aka randomtoy
*   Visit us: http://lsmods.ru
---------------------------------------------------------
*/

class PluginPreview_ModulePreview extends Module {

    protected $oMapperPreview;

    public function  Init() {
        $this->oMapperPreview=Engine::GetMapper(__CLASS__);
    }

    public function UploadTopicAvatar($aFile,$oTopic) {
                
                $bNoCrop = true;
		if(!is_array($aFile) || !isset($aFile['tmp_name'])) {
			return false;
	}

		$sFileTmp=Config::Get('sys.cache.dir').func_generator();
		if (!move_uploaded_file($aFile['tmp_name'],$sFileTmp)) {
			return false;
		}

		$sPath=$this->Image_GetIdDir($oTopic->getUserId());
		$aParams=$this->Image_BuildParams('avatar');

		$oImage=new LiveImage($sFileTmp);
		/**
		 * Если объект изображения не создан,
		 * возвращаем ошибку
		 */
		if($sError=$oImage->get_last_error()) {
			// Вывод сообщения об ошибки, произошедшей при создании объекта изображения
			 $this->Message_AddError($sError,$this->Lang_Get('error'));
			@unlink($sFileTmp);
			return false;
		}
		/**
		 * Срезаем квадрат
		 */
                
                $iPrefix=func_generator(6);
                
                 
		if ($sFileAvatar=$this->Image_Resize($sFileTmp,$sPath,"preview_topic_".$iPrefix,Config::Get('view.img_max_width'),Config::Get('view.img_max_height'),null,null,true,$aParams,$oImage)) {
			$aSize=Config::Get('plugin.preview.preview_size');
                        foreach ($aSize as $iSize) {
                             if(Config::Get('plugin.preview.preview_no_crop')===false){
                                    $iWidth  = $oImage->get_image_params('width');
                                    $iHeight = $oImage->get_image_params('height');
                                    $x=$iWidth/$iSize[0];
                                    $y=$iHeight/$iSize[1];
                                    $iNewCrop = min($x,$y);
                                    $oImage->crop($iSize[0]*$iNewCrop, $iSize[1]*$iNewCrop,($iWidth-$iSize[0]*$iNewCrop)/2,($iHeight-$iSize[1]*$iNewCrop)/2);

                                }
                            
                           $this->Image_Resize($sFileTmp,$sPath,"preview_topic_".$iPrefix."_{$iSize[0]}x{$iSize[1]}",Config::Get('view.img_max_width'),Config::Get('view.img_max_height'),$iSize[0],$iSize[1],true,$aParams,$oImage);

			}
        
			@unlink($sFileTmp);
                        @unlink($sFileAvatar);
			/**
			 * Если все нормально, возвращаем расширение загруженного аватара
			 */
			return $this->Image_GetWebPath($sFileAvatar);
		}
		@unlink($sFileTmp);
                @unlink($sFileAvatar);
		/**
		 * В случае ошибки, возвращаем false
		 */
		return false;
	}

        public function UploadTopicAvatarUrl($sUrl, $oTopic) {
		/**
		 * Проверяем, является ли файл изображением
		 */
		if(!@getimagesize($sUrl)) {
			return ModuleImage::UPLOAD_IMAGE_ERROR_TYPE;
		}
		/**
		 * Открываем файловый поток и считываем файл поблочно,
		 * контролируя максимальный размер изображения
		 */
		$oFile=fopen($sUrl,'r');
		if(!$oFile) {
			return ModuleImage::UPLOAD_IMAGE_ERROR_READ;
		}

		$iMaxSizeKb=500;
		$iSizeKb=0;
		$sContent='';
		while (!feof($oFile) and $iSizeKb<$iMaxSizeKb) {
			$sContent.=fread($oFile ,1024*1);
			$iSizeKb++;
		}

		/**
		 * Если конец файла не достигнут,
		 * значит файл имеет недопустимый размер
		 */
		if(!feof($oFile)) {
			return ModuleImage::UPLOAD_IMAGE_ERROR_SIZE;
		}
		fclose($oFile);

		/**
		 * Создаем tmp-файл, для временного хранения изображения
		 */
		$sFileTmp=Config::Get('sys.cache.dir').func_generator();

		$fp=fopen($sFileTmp,'w');
		fwrite($fp,$sContent);
		fclose($fp);

              //  $oImage=new LiveImage($sFileTmp);
		$sPath=$this->Image_GetIdDir($oTopic->getUserId());
		$aParams=$this->Image_BuildParams('avatar');
                $oImage=new LiveImage($sFileTmp);
		$iPrefix=func_generator(6);
		/**
		 * Передаем изображение на обработку
		 */
		if ($sFileAvatar=$this->Image_Resize($sFileTmp,$sPath,"preview_topic_".$iPrefix,Config::Get('view.img_max_width'),Config::Get('view.img_max_height'),null,null,true,$aParams,$oImage) ){
			$aSize=Config::Get('plugin.preview.preview_size');
                        foreach ($aSize as $iSize) {
                          
                            if(Config::Get('plugin.preview.preview_no_crop')===false){
                                    $iWidth  = $oImage->get_image_params('width');
                                    $iHeight = $oImage->get_image_params('height');
                                    $x=$iWidth/$iSize[0];
                                    $y=$iHeight/$iSize[1];
                                    $iNewCrop = min($x,$y);
                                    $oImage->crop($iSize[0]*$iNewCrop, $iSize[1]*$iNewCrop,($iWidth-$iSize[0]*$iNewCrop)/2,($iHeight-$iSize[1]*$iNewCrop)/2);

                                }
                           $this->Image_Resize($sFileTmp,$sPath,"preview_topic_".$iPrefix."_{$iSize[0]}x{$iSize[1]}",Config::Get('view.img_max_width'),Config::Get('view.img_max_height'),$iSize[0],$iSize[1],true,$aParams,$oImage);

			}

			@unlink($sFileTmp);
                        @unlink($sFileAvatar);
			/**
			 * Если все нормально, возвращаем расширение загруженного аватара
			 */
			return $this->Image_GetWebPath($sFileAvatar);
                }

		@unlink($sFileTmp);
                @unlink($sFileAvatar);
		return ModuleImage::UPLOAD_IMAGE_ERROR;
	}

        public function AddTopicPreview(ModuleTopic_EntityTopic $oTopic) {

            return $this->oMapperPreview->AddTopicPreview($oTopic);
        }
}
?>
