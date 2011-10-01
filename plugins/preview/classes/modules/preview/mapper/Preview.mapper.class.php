<?php

/*-------------------------------------------------------
*
*   LsMods Developer Team
*   Author: Yuriy Sergeev aka randomtoy
*   Visit us: http://lsmods.ru
---------------------------------------------------------
*/

class PluginPreview_ModulePreview_MapperPreview extends Mapper {


    
    public function AddTopicPreview(ModuleTopic_EntityTopic $oTopic) {

        $sql = "UPDATE " .Config::Get('db.table.topic')."
            SET topic_preview = ?
            WHERE topic_id = ?d
            ";
        if ($this->oDb->query($sql,$oTopic->getTopicPreview(),$oTopic->getId())) {
            return true;
        }
        return false;

    }
}


?>
