<?php
/*---------------------------------------------------------------------------
 * @Plugin Name: aceAdminPanel
 * @Plugin Id: aceadminpanel
 * @Plugin URI: 
 * @Description: Advanced Administrator's Panel for LiveStreet/ACE
 * @Version: 1.4.194
 * @Author: Vadim Shemarov (aka aVadim)
 * @Author URI: 
 * @LiveStreet Version: 0.4.2
 * @File Name: Topic.mapper.class.php
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *----------------------------------------------------------------------------
 */

class PluginAceadminpanel_ModuleTopic_MapperTopic extends PluginAceadminpanel_Inherit_ModuleTopic_MapperTopic
{

    public function DeleteTopic($sTopicId)
    {
        $sql =
            "
            DELETE FROM " . Config::Get('db.table.topic') . "
            WHERE
                topic_id = ?d
            ";
        if ($this->oDb->query($sql, $sTopicId)) {
            $sql =
                "
                DELETE FROM " . Config::Get('db.table.topic_content') . "
                WHERE
                    topic_id = ?d
                ";
            $this->oDb->query($sql, $sTopicId);
                return true;
            return true;
        }
        return false;
    }

    public function ClearStreamByComment($aCommentsId)
    {
        if (!is_array($aCommentsId)) $aCommentsId = array($aCommentsId);
        $sql = "
            DELETE FROM " . Config::Get('db.table.topic_content') . "
            WHERE event_type LIKE '%_comment' AND target_id IN (?a)
        ";
    }

}

// EOF