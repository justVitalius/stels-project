<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.08.2010
 * Time: 0:45:37
 * To change this template use File | Settings | File Templates.
 */

 class PluginPreview_ModulePreview_EntityTopic extends PluginPreview_Inherit_ModuleTopic_EntityTopic {


    public function getTopicPreview() {
        return $this->_aData['topic_preview'];
    }
    public function getTopicPreviewType() {
        return ($sPath=$this->getTopicPreviewPath()) ? pathinfo($sPath,PATHINFO_EXTENSION) : null;
    }

    public function getTopicPreviewPath($iSize1=0,$iSize2=0) {

        if ($sPath=$this->getTopicPreview()) {
		$sNewPath = preg_replace("/.([\w]{2,5})$/","_{$iSize1}x{$iSize2}.$1",$sPath);
		$sLocalPath = str_replace("".Config::Get('path.root.web')."","".Config::Get('path.root.server')."",$sNewPath);
		 if (is_file($sLocalPath)){
                    return $sNewPath;
                }
        } 

        return $sLocalPath;
    }
 }
 
?>
