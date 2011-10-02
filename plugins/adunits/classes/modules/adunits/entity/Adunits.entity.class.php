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
* @File Name: Adunits.entity.class.php
* @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*----------------------------------------------------------------------------
*/

class PluginAdunits_ModuleAdunits_EntityAdunits extends Entity{

    public function getAdunitsId()            {return $this->_aData['adunits_id'];}
    public function getAdunitsUserId()        {return $this->_aData['user_id'];}
    public function getAdunitsCode()          {return $this->_aData['adunits_code'];}
    public function getAdunitsSetting()       {return $this->_aData['adunits_setting'];}
    public function getAdunitsSettingMore()   {return $this->_aData['adunits_setting_more'];}
    public function getAdunitsDateAdd()       {return $this->_aData['adunits_date_add'];}
    public function getAdunitsDateEdit()      {return $this->_aData['adunits_date_edit'];}
    /*
    public function getAdunitsSettingType()   {return $this->_aData['adunits_setting_type'];}
    public function getAdunitsSettingViev1()  {return $this->_aData['adunits_setting_viev_1'];}
    public function getAdunitsSettingViev2()  {return $this->_aData['adunits_setting_viev_2'];}
    public function getAdunitsSettingViev3()  {return $this->_aData['adunits_setting_viev_3'];}
    */

    public function setAdunitsId($data)           {$this->_aData['adunits_id']=$data;}
    public function setAdunitsUserId($data)       {$this->_aData['user_id']=$data;}
    public function setAdunitsCode($data)         {$this->_aData['adunits_code']=$data;}
    public function setAdunitsSetting($data)      {$this->_aData['adunits_setting']=$data;}
    public function setAdunitsSettingMore($data)  {$this->_aData['adunits_setting_more']=$data;}
    public function setAdunitsDateAdd($data)      {$this->_aData['adunits_date_add']=$data;}
    public function setAdunitsDateEdit($data)     {$this->_aData['adunits_date_edit']=$data;}
    /*
    public function setAdunitsSettingType($data)  {$this->_aData['adunits_setting_type']=$data;}
    public function setAdunitsSettingViev1($data) {$this->_aData['adunits_setting_viev_1']=$data;}
    public function setAdunitsSettingViev2($data) {$this->_aData['adunits_setting_viev_2']=$data;}
    public function setAdunitsSettingViev3($data) {$this->_aData['adunits_setting_viev_3']=$data;}
    */
}
?>
