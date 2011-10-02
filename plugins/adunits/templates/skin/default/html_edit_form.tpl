{$oAdunits->getAdunitsCode()}<br />
        <form action="" method="post" enctype="multipart/form-data" name="adunits_form_{$oAdunits->getAdunitsId()}" id="adunits_form_{$oAdunits->getAdunitsId()}" onsubmit="return false">

          <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
          <input type="hidden" name="adunits_id" value="{$oAdunits->getAdunitsId()}" />
          <p>
            <label for="adunits_code">{$aLang.adunits_menu_settings_code_title}</label><br />
            <textarea name="adunits_code" style="height: 50px;">{$oAdunits->getAdunitsCode()}</textarea>
          </p>

          <p>
            <label for="adunits_setting_viev_1">{$aLang.adunits_menu_settings_viev}</label><br />
            <select name="adunits_setting_viev_1">
              <option value="h"{if $oAdunits->getAdunitsSetting() == 'h'} selected{/if}>{$aLang.adunits_menu_settings_viev_h}</option>
              <option value="f"{if $oAdunits->getAdunitsSetting() == 'f'} selected{/if}>{$aLang.adunits_menu_settings_viev_f}</option>
              <option value="cbb"{if $oAdunits->getAdunitsSetting() == 'cbb'} selected{/if}>{$aLang.adunits_menu_settings_viev_cbb}</option>
              <option value="cbe"{if $oAdunits->getAdunitsSetting() == 'cbe'} selected{/if}>{$aLang.adunits_menu_settings_viev_cbe}</option>
              <option value="bl"{if $oAdunits->getAdunitsSetting() == 'cbe'} selected{/if}>{$aLang.adunits_menu_settings_viev_bl}</option>
              <option value="b"{if $oAdunits->getAdunitsSetting() == 'b'} selected{/if}>{$aLang.adunits_menu_settings_viev_b}</option>
              <option value="c"{if $oAdunits->getAdunitsSetting() == 'c'} selected{/if}>{$aLang.adunits_menu_settings_viev_c}</option>
              <option value="t"{if $oAdunits->getAdunitsSetting() == 't'} selected{/if}>{$aLang.adunits_menu_settings_viev_t}</option>
            </select>
          </p>
          <input type="submit" name="submit_adunits_save" value="{$aLang.adunits_submit_save}" onclick="saveAdunitsId(document.getElementById('adunits_form_{$oAdunits->getAdunitsId()}'),'{$oAdunits->getAdunitsId()}');" /> <br />
			    <a href="#" onclick="shdr({$oAdunits->getAdunitsId()}); return false;" style="color: red;">{$aLang.adunits_fohm_hide}</a>
        </form>
        <br /><br />
