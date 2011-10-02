<?php
/*---------------------------------------------------------------------------
* @Plugin Name: Ad units
* @Plugin Id: adunits
* @Plugin URI:
* @Description: Advertise on users
* @Version: 1.0.0
* @Author: Nikolay Bishovec (netlanc)
* @Author URI: http://netlanc.net
* @LiveStreet Version: 0.4.2
* @File Name: HookAdunits.class.php
* @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*----------------------------------------------------------------------------
*/
class PluginAdunits_HookAdunits extends Hook {

    public function RegisterHook() {

        $this->AddHook('init_action', 'InitAction', __CLASS__);

        $this->AddHook('template_body_begin', 'HeaderAdunits', __CLASS__);
        $this->AddHook('template_body_end', 'FooterAdunits', __CLASS__);
        $this->AddHook('template_content_begin', 'ContentBeginAdunits', __CLASS__);
        $this->AddHook('template_content_end', 'ContentEndAdunits', __CLASS__);

        if (($oUserCurrent=$this->User_GetUserCurrent() and $oUserCurrent->isAdministrator()) or (Config::Get('config.adunits.permit.user') == 'all')) {
          $this->AddHook('template_menu_settings', 'MenuSettingsTpl', __CLASS__);
        }
    }

    public function InitAction() {
    	if (Router::GetAction()=='settings' and Router::GetActionEvent()=='adunits') {
    		Router::Action('adunits_settings','settings');
    	}
    }

    public function ContentBeginAdunits(){
      if ($sUserId = $this->PluginAdunits_Adunits_InitActionAdunits()){
        if ($oAdunits = $this->PluginAdunits_Adunits_GetAdunitsByFilter($sUserId)){
          if (empty($oAdunits['cbb'])) $oAdunits = $this->PluginAdunits_Adunits_GetAdunitsByFilter(1);
          if(!empty($oAdunits['cbb'])){
            $oViewer = $this->Viewer_GetLocalViewer();
            $aRandKey = array_rand($oAdunits['cbb'],1);
            $aRandAdunits['0'] = $oAdunits['cbb'][$aRandKey];

            $oViewer->Assign('aAdunits',$oAdunits['cbb']);
            return $oViewer->fetch(Plugin::GetTemplatePath('adunits').'adunits_content_begin.tpl');
          }
        }
      }
    }

    public function ContentEndAdunits(){
      if ($sUserId = $this->PluginAdunits_Adunits_InitActionAdunits()){
        if ($oAdunits = $this->PluginAdunits_Adunits_GetAdunitsByFilter($sUserId)){
          if (empty($oAdunits['cbe'])) $oAdunits = $this->PluginAdunits_Adunits_GetAdunitsByFilter(1);
          if(!empty($oAdunits['cbe'])){
            $oViewer = $this->Viewer_GetLocalViewer();
            $aRandKey = array_rand($oAdunits['cbe'],1);
            $aRandAdunits['0'] = $oAdunits['cbe'][$aRandKey];

            $oViewer->Assign('aAdunits',$oAdunits['cbe']);
            return $oViewer->fetch(Plugin::GetTemplatePath('adunits').'adunits_content_end.tpl');
          }
        }
      }
    }

    public function HeaderAdunits(){
      if ($sUserId = $this->PluginAdunits_Adunits_InitActionAdunits()){
        if ($oAdunits = $this->PluginAdunits_Adunits_GetAdunitsByFilter($sUserId)){
          if (empty($oAdunits['h'])) $oAdunits = $this->PluginAdunits_Adunits_GetAdunitsByFilter(1);
          if(!empty($oAdunits['h'])){
            $oViewer = $this->Viewer_GetLocalViewer();
            $aRandKey = array_rand($oAdunits['h'],1);
            $aRandAdunits['0'] = $oAdunits['h'][$aRandKey];

            $oViewer->Assign('aAdunits',$oAdunits['h']);
            return $oViewer->fetch(Plugin::GetTemplatePath('adunits').'adunits_header.tpl');
          }
        }
      }
    }

    public function FooterAdunits(){
      if ($sUserId = $this->PluginAdunits_Adunits_InitActionAdunits()){
        if ($oAdunits = $this->PluginAdunits_Adunits_GetAdunitsByFilter($sUserId)){
          if (empty($oAdunits['f'])) $oAdunits = $this->PluginAdunits_Adunits_GetAdunitsByFilter(1);
          if(!empty($oAdunits['f'])){
            $oViewer = $this->Viewer_GetLocalViewer();
            $aRandKey = array_rand($oAdunits['f'],1);
            $aRandAdunits['0'] = $oAdunits['f'][$aRandKey];

            $oViewer->Assign('aAdunits',$oAdunits['f']);
            return $oViewer->fetch(Plugin::GetTemplatePath('adunits').'adunits_footer.tpl');
          }
        }
      }
    }

    public function MenuSettingsTpl() {
    	return $this->Viewer_Fetch(Plugin::GetTemplatePath('adunits').'menu.setting.item.tpl');
    }
}
?>
