<?php

/* ---------------------------------------------------------------------------
 * @Plugin Name: Banneroid
 * @Plugin Id: Banneroid
 * @Plugin URI:
 * @Description: Banner rotator for LS
 * @Author: stfalcon-studio
 * @Author URI: http://stfalcon.com
 * @LiveStreet Version: 0.4.2
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * ----------------------------------------------------------------------------
 */

/**
 * Banneroid Plugin Hook class for LiveStreet
 *
 * Sets Hook for menu template and adds link into it
 */
class PluginBanneroid_HookBanneroid extends Hook {

    /**
     * Register Hooks
     *
     * @return void
     */
    public function RegisterHook() {
        $this->AddHook('template_main_menu', 'InitAction', __CLASS__);
        $this->AddHook('engine_init_complete', 'AddBannerBlock', __CLASS__, 0);
        
        // vit's hook to middle bar banner
        $this->AddHook(Config::Get('plugin.banneroid.banner_middle_hook'), 'AddBannersInIndexMiddle', __CLASS__, 0);
        $this->AddHook(Config::Get('plugin.banneroid.banner_top_hook'), 'AddBannersInIndexTop', __CLASS__, 0);
        $this->AddHook(Config::Get('plugin.banneroid.banner_end_hook'), 'AddBannersInIndexEnd', __CLASS__, 0); 
        $this->AddHook(Config::Get('plugin.banneroid.banner_sidebar_hook'), 'AddBannerInSidebar', __CLASS__, 0);    
    }
    

    /**
     * Hook Handler
     * Add a link to menu
     *
     * @return mixed
     */
    public function InitAction($aVars) {
        $oUser = $this->User_GetUserCurrent();
        

        // If user is admin than show link
        if ($oUser && $oUser->isAdministrator()) {
            return $this->Viewer_Fetch(
                    Plugin::GetTemplatePath(__CLASS__) . 'menu.banneroid.tpl');
        }
    }

    /**
     * Hook Handler
     * Add banners block to side bar
     *
     * @return mixed
     */
    public function AddBannerBlock($aVars) {
        
        if (in_array(Router::GetAction(), Config::Get('plugin.banneroid.banner_skip_actions'))){
            return false;
        }
        $aBanners = $this->PluginBanneroid_Banner_GetSideBarBanners($_SERVER['REQUEST_URI']);
        /**
        if (count($aBanners)) { //Inser banner block
            $this->Viewer_AddBlock('right', 'banneroid',
                    array('plugin' => 'banneroid', 'aBanners' => $aBanners),
                    Config::Get('plugin.banneroid.banner_block_order'));
        }
        */
        return true;
    }

    /**
     * Hook Handler
     * Add banners to index end
     *
     * @return mixed
     */
    public function AddBannersInIndexEnd($aVars) {
        if (in_array(Router::GetAction(), Config::Get('plugin.banneroid.banner_skip_actions'))){
            return false;
        }
        $aBanners = $this->PluginBanneroid_Banner_GetIndexEndBanners($_SERVER['REQUEST_URI'], true);
        if (count($aBanners)) { //Inser banner block
            $this->Viewer_Assign("aBanners", $aBanners);
            $this->Viewer_Assign('sBannersPath', Config::Get("plugin.banneroid.images_dir"));
            return $this->Viewer_Fetch(
                    Plugin::GetTemplatePath(__CLASS__) . 'end.banneroid.tpl');
        }
    }
    
    /**
     * Hook Handler
     * Add banners to index middle 
     *
     * @return mixed
     */
    public function AddBannersInIndexMiddle($aVars) {
        if (in_array(Router::GetAction(), Config::Get('plugin.banneroid.banner_skip_actions'))){
            return false;
        }
        $aBanners = $this->PluginBanneroid_Banner_GetIndexMiddleBanners($_SERVER['REQUEST_URI']);
        if (count($aBanners)) { //Inser banner block
            $this->Viewer_Assign("aBanners", $aBanners);
            $this->Viewer_Assign('sBannersPath', Config::Get("plugin.banneroid.images_dir"));
            return $this->Viewer_Fetch(
                    Plugin::GetTemplatePath(__CLASS__) . 'middle.banneroid.tpl');
        }
        return true;
    }
    
    /**
     * Hook Handler
     * Add banners to index middle 
     *
     * @return mixed
     */
    public function AddBannerInSidebar($aVars) {
        $aBanners = $this->PluginBanneroid_Banner_vitGetSidebarBanner($_SERVER['REQUEST_URI']);
        if (count($aBanners)) { 
            $this->Viewer_Assign("aBanners", $aBanners);
            $this->Viewer_Assign('sBannersPath', Config::Get("plugin.banneroid.images_dir"));
            return $this->Viewer_Fetch(
                    Plugin::GetTemplatePath(__CLASS__) . 'sidebar.banneroid.tpl');
                    
        }
        return true;
    }

    
    /**
     * Hook Handler
     * Add banners to index top
     *
     * @return mixed
     */
    public function AddBannersInIndexTop($aVars) {
        if (in_array(Router::GetAction(), Config::Get('plugin.banneroid.banner_skip_actions'))){
            return false;
        }
        $aBanners = $this->PluginBanneroid_Banner_GetIndexTopBanners($_SERVER['REQUEST_URI']);
        if (count($aBanners)) { //Inser banner block
            $this->Viewer_Assign("aBanners", $aBanners);
            $this->Viewer_Assign('sBannersPath', Config::Get("plugin.banneroid.images_dir"));
            return $this->Viewer_Fetch(
                    Plugin::GetTemplatePath(__CLASS__) . 'top.banneroid.tpl');
        }
        return true;
    }

    
}