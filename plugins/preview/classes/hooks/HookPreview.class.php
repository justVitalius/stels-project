<?php

/*-------------------------------------------------------
*
*   LsMods Developer Team
*   Author: Yuriy Sergeev aka randomtoy
*   Visit us: http://lsmods.ru
---------------------------------------------------------
*/

class PluginPreview_HookPreview extends Hook {

    //регистрируем хуки
    public function  RegisterHook() {
        $this->AddHook('check_topic_fields','CheckTopicFieldsPreview', __CLASS__);
        $this->AddHook('check_question_fields','CheckTopicFieldsPreview', __CLASS__);
        $this->AddHook('check_link_fields','CheckTopicFieldsPreview', __CLASS__);
        $this->AddHook('template_form_add_topic_topic_end', 'AddFormTemplateTopic', __CLASS__);
        $this->AddHook('topic_add_before', 'GenerateTopicPreview', __CLASS__);
        $this->AddHook('topic_add_after', 'AddTopicPreview', __CLASS__);
        $this->AddHook('topic_edit_show','ShowTopicPreview', __CLASS__);
        $this->AddHook('topic_edit_before', 'TopicEditPreviewBefore', __CLASS__);
        $this->AddHook('topic_edit_after', 'AddTopicPreview', __CLASS__);
        $this->AddHook('template_form_add_topic_question_end', 'AddFormTemplateTopic', __CLASS__);
        $this->AddHook('template_form_add_topic_link_end', 'AddFormTemplateTopic', __CLASS__);
        $this->AddHook('topic_delete_before','DeleteTopicPreview',__CLASS__);
        
    }

    // Добавляем хук на темплейт добавления топика
    public function AddFormTemplateTopic() {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath('preview').'actions/ActionTopic/inject_add.tpl');
    }

    public function GenerateTopicPreview($aVars) {
        $oTopic=Engine::GetEntity('Topic');
        $oTopic=$aVars['oTopic'];
        
        $oTopic->setTopicPreview(NULL);
        /**
	* Загрузка аватара, делаем ресайзы
	*/
       

        
            if ($sPath=$this->PluginPreview_Preview_UploadTopicAvatar($_FILES['topic_preview_file'],$oTopic)) {
                $oTopic->setTopicPreview($sPath);
            } elseif (getRequest('topic_preview_link')){
                $oTopic->setTopicPreview($this->PluginPreview_Preview_UploadTopicAvatarUrl(getRequest('topic_preview_link'),$oTopic));
            } elseif(preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', getRequest('topic_text'),$matches)){
                $oTopic->setTopicPreview($this->PluginPreview_Preview_UploadTopicAvatarUrl($matches[1],$oTopic));
            }else{
                $this->Message_AddError($this->Lang_get('preview_create_preview_error'),$this->Lang_Get('error'));
                return FALSE;
            }
    }

    public function AddTopicPreview($aVars) {
        $oTopic=Engine::GetEntity('Topic');
        $oTopic=$aVars['oTopic'];
        return $this->PluginPreview_Preview_AddTopicPreview($oTopic);
    }

    public function ShowTopicPreview($aVars) {
        $oTopic=Engine::GetEntity('Topic');
        $oTopic=$aVars['oTopic'];
        $_REQUEST['topic_preview_data']=$oTopic->getTopicPreview();
        $this->Viewer_Assign('oTopic',$oTopic);
    }

    public function CheckTopicFieldsPreview($aVars) {
        /*
         * Проверяем на отсутствие превью
         *
         */
        if (isset($_FILES['topic_preview_file']) and is_uploaded_file($_FILES['topic_preview_file']['tmp_name'])) {

        } else {
            if (!getRequest('topic_preview_data')){
                if(!getRequest('topic_review_link')){
                    if(!preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', getRequest('topic_text'))){
                        if(Config::Get('plugin.preview.topic_allways_use_preview')==true) {
                            $this->Message_AddError($this->Lang_get('preview_topic_allways_use_preview'),$this->Lang_Get('error'));
                            $aVars['bOk']=false;
                        }
                    }
                }
            }
        }
   }

    public function TopicEditPreviewBefore($aVars){
        //$oTopic=Engine::GetEntity('Topic');
        $oTopic=$aVars['oTopic'];
        if(!$oTopic->getTopicPreview() or (isset($_FILES['topic_preview_file']) and is_uploaded_file($_FILES['topic_preview_file']['tmp_name'])) or getRequest('topic_preview_link')) {
            if($oTopic->getTopicPreview()){
                $aSize=array_merge(Config::Get('plugin.preview.preview_size'),array(48));
                foreach ($aSize as $iSize) {
                    @unlink($this->Image_GetServerPath(str_replace('.',"_{$iSize[0]}x{$iSize[1]}.",$oTopic->getTopicPreview())));
                }
            }
            $this->GenerateTopicPreview(array('oTopic'=>$oTopic));
        }
    }

    public function DeleteTopicPreview($aVars) {

        $oTopic=$aVars['oTopic'];
        if($oTopic->getTopicPreview()){
            $aSize=array_merge(Config::Get('plugin.preview.preview_size'));
            foreach ($aSize as $iSize) {
                @unlink($this->Image_GetServerPath(str_replace('.',"_{$iSize[0]}x{$iSize[1]}.",$oTopic->getTopicPreview())));
            }

        }
    }
}

?>
