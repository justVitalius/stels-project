<?php

/*-------------------------------------------------------
*
*   LsMods Developer Team
*   Author: Yuriy Sergeev aka randomtoy
*   Visit us: http://lsmods.ru
---------------------------------------------------------
*/

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginPreview extends Plugin {

    protected $aInherits=array(
        'action'  =>array('ActionLink','ActionQuestion'),
        'entity'  =>array('ModuleTopic_EntityTopic'=>'PluginPreview_ModulePreview_EntityTopic'),

    );

    /*
   protected $aDelegates=array(
			'template'=>array(
				'topic_list.tpl'=>'_topic_list.tpl',
				'topic.tpl'=>'_topic.tpl'
			),


	);

    *
     *
     */

    public function Activate() {
         $prefix=Config::Get('db.table.prefix');

                $r = mysql_query("SELECT `topic_preview` FROM `{$prefix}topic` WHERE 1=1");

                if (!$r) {
                   $a=mysql_query("ALTER TABLE `{$prefix}topic` ADD `topic_preview` VARCHAR(250) NOT NULL");
                }
       /*  if(Config::Get('plugin.preview.convert')===true){
            $tp = mysql_query("SELECT `topic_avatar_type` FROM `{$prefix}topic` WHERE 1=1");
            if($tp) {
                $sQuery = "SELECT topic_id, topic_avatar_type FROM `{$prefix}topic` WHERE 1=1 AND topic_avatar_type IS NOT NULL ";
                $aConverts = $this->Database_GetConnect()->select($sQuery);
             
                foreach ($aConverts as $aConvert) {
                    $avatar = $aConvert['topic_avatar_type'];
                    $topic = $aConvert['topic_id'];
                    $sPath=''.Config::Get('path.root.web').''.Config::Get('path.uploads.images').'/topics/'.$topic.'.'.$avatar;
                    $z=mysql_query("UPDATE `{$prefix}topic` SET  topic_preview = '{$sPath}' WHERE topic_id = {$topic}");
                }
                $y = mysql_query("ALTER TABLE `{$prefix}topic` DROP `topic_avatar_type`");
                $this->Message_AddNoticeSingle('Аватары были успешно импортированы', $this->Lang_Get('attention'),true);
            }
         }
        *
        */
		return true;
    }



    public function Init() {
        $this->Viewer_Assign('sTemplateWebPathPlugin',Plugin::GetTemplateWebPath('preview'));
        $this->Viewer_AppendStyle(Plugin::GetTemplateWebPath('preview').'css/preview.css');
    }

}

?>
