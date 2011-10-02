{include file='header.tpl' menu="company_edit" showWhiteBack=true}


{literal}
<script language="javascript" type="text/javascript">
document.addEvent('domready', function() {	
	var inputTags = $('company_tags');
 
	new Autocompleter.Request.HTML($('company_tags'), DIR_WEB_ROOT+'/plugins/company/include/ajax/tagCompanyAutocompleter.php?security_ls_key='+LIVESTREET_SECURITY_KEY, {
		'indicatorClass': 'autocompleter-loading', // class added to the input during request
		'minLength': 2, // We need at least 1 character
		'selectMode': 'pick', // Instant completion
		'multiple': true // Tag support, by default comma separated
	}); 
	
	var inputCity = $('company_city');
 
	new Autocompleter.Request.HTML(inputCity, DIR_WEB_ROOT+'/include/ajax/cityAutocompleter.php?security_ls_key='+LIVESTREET_SECURITY_KEY, {
		'indicatorClass': 'autocompleter-loading', // class added to the input during request
		'minLength': 2, // We need at least 1 character
		'selectMode': 'pick', // Instant completion
		'multiple': false // Tag support, by default comma separated
	});
	
	
	var inputCountry = $('company_country');
 
	new Autocompleter.Request.HTML(inputCountry, DIR_WEB_ROOT+'/include/ajax/countryAutocompleter.php?security_ls_key='+LIVESTREET_SECURITY_KEY, {
		'indicatorClass': 'autocompleter-loading', // class added to the input during request
		'minLength': 2, // We need at least 1 character
		'selectMode': 'pick', // Instant completion
		'multiple': false // Tag support, by default comma separated
	});
});
</script>
<script language="javascript" type="text/javascript">
function counter(limitField, limitCount, limitNum) {
        limitCount.value = limitNum - limitField.value.length;
}

function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
</script>
{/literal}
{if $oConfig->GetValue('view.tinymce')}
<script type="text/javascript" src="{cfg name='path.root.engine_lib'}/external/tiny_mce/tiny_mce.js"></script>
{literal}
<script type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_buttons1 : "lshselect,bold,italic,underline,strikethrough,|,bullist,numlist,|,undo,redo,|,lslink,unlink,lsvideo,lsimage,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	theme_advanced_resize_horizontal : 0,
	theme_advanced_resizing_use_cookie : 0,
	theme_advanced_path : false,
	object_resizing : true,
	force_br_newlines : true,
    forced_root_block : '', // Needed for 3.x
    force_p_newlines : false,    
    plugins : "lslink,lsimage,lsvideo,safari,inlinepopups,media,lshselect",
    convert_urls : false,
    extended_valid_elements : "embed[src|type|allowscriptaccess|allowfullscreen|width|height]"     
});
</script>
{/literal}
{/if}

{include file='window_load_img.tpl' sToLoad='company_vacancies'}

<h1>{$aLang.company_edit_header}: <a href="{$oCompanyEdit->getUrlFull()}/"  class="blog_headline_group">{$oCompanyEdit->getName()}</a></h1>

<div class="backoffice">
	<form action="" method="POST" id="thisform" enctype="multipart/form-data">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 
		<label for="company_name">{$aLang.company_add_name}:</label>
		<input type="text" id="company_name" name="company_name" value="{$oCompanyEdit->getName()|escape:'html'}" class="w100p" /><br />
		<span class="form_note">{$aLang.company_add_name_note}</span><br />
		<span class="form_note_red"></span>
		<p>
		<label for="company_name_legal">{$aLang.company_edit_legalname}:</label>
		<input type="text" id="company_name_legal" name="company_name_legal" value="{$oCompanyEdit->getLegalName()|escape:'html'}" class="w100p" /><br />
		<span class="form_note">{$aLang.company_edit_legalname_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		<p>
		<label for="company_url">{$aLang.company_add_url}:</label>
		<input type="text" id="company_url" name="company_url" value="{$oCompanyEdit->getUrl()|escape:'html'}" class="w100p" {if $oCompanyEdit->getId()}disabled{/if} /><br />
		<span class="form_note">{$aLang.company_add_url_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		<p>
		<textarea name="company_description" id="company_description" rows="5" 
				onfocus ="counter(this.form.company_description,this.form.countdown,255);" 
				onKeyPress="counter(this.form.company_description,this.form.countdown,255);"
				onKeyDown="limitText(this.form.company_description,this.form.countdown,255);" 
				onKeyUp="limitText(this.form.company_description,this.form.countdown,255);">{$oCompanyEdit->getDescription()|escape:'html'}</textarea>
		<span class="form_note">{$aLang.company_add_description_note}</span><br />
		<span class="form_note">Осталось <input readonly type="text" name="countdown" size="3" value="255"> символов</span><br />		
		<span class="form_note_red"></span>
		</p>
		<p>
		<label for="company_tags">{$aLang.company_add_tags}:</label>
		<input type="text" id="company_tags" name="company_tags" value="{$oCompanyEdit->getTags()|escape:'html'}" class="w100p" /><br />
		<span class="form_note"{$aLang.company_add_tags_note}</span>
		</p>
		<p>
		<span class="form">{$aLang.company_add_place}: </span><br />
		<span class="form">{$aLang.company_add_place_country}: </span><br /><input  style="width: 60%;" type="text"	id="company_country" name="company_country" value="{$oCompanyEdit->getCountry()|escape:'html'}" /><br />
		<span class="form">{$aLang.company_add_place_city}:  </span><br /><input  style="width: 60%;" type="text"	id="company_city" name="company_city" value="{$oCompanyEdit->getCity()|escape:'html'}" /><br />
		<label for="company_address">{$aLang.company_edit_address}:</label>
		<input type="text" id="company_address" name="company_address" value="{$oCompanyEdit->getAddress()|escape:'html'}" class="w100p" /><br />
		<span class="form_note">{$aLang.company_add_place_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		<p>
		<label for="company_site">{$aLang.company_edit_site}:</label>
		<input type="text" id="company_site" name="company_site" value="{$oCompanyEdit->getSite()|escape:'html'}" class="w100p" /><br />
		<span class="form_note">{$aLang.company_edit_site_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		<p>
		<label for="company_email">{$aLang.company_edit_email}:</label>
		<input type="text" id="company_email" name="company_email" value="{$oCompanyEdit->getEmail()|escape:'html'}" class="w100p" /><br />
		<span class="form_note">{$aLang.company_edit_email_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		<p>
		<label for="company_phone">{$aLang.company_edit_phone}:</label>
		<input type="text" id="company_phone" name="company_phone" value="{$oCompanyEdit->getPhone()|escape:'html'}" class="w100p" /><br />
		<span class="form_note">{$aLang.company_edit_phone_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		<p>
		<label for="company_fax">{$aLang.company_edit_fax}:</label>
		<input type="text" id="company_fax" name="company_fax" value="{$oCompanyEdit->getFax()|escape:'html'}" class="w100p" /><br />
		<span class="form_note">{$aLang.company_edit_fax_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		<p>
		<label for="company_boss">{$aLang.company_edit_boss}:</label>
		<input type="text" id="company_boss" name="company_boss" value="{$oCompanyEdit->getBoss()|escape:'html'}" class="w100p" /><br />
		<span class="form_note">{$aLang.company_edit_boss_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		<p>
		<span class="form">{$aLang.company_edit_datebasis}: </span><br />
		<select name="company_basis_day" class="w70">
			<option value="">{$aLang.date_day}</option>
			{section name=date_day start=1 loop=32 step=1}    		
    		<option value="{$smarty.section.date_day.index}" {if $smarty.section.date_day.index==$oCompanyEdit->getDateBasis()|date_format:"%d"}selected{/if}>{$smarty.section.date_day.index}</option>
			{/section}
		</select>
		<select name="company_basis_month" class="w100">
			<option value="">{$aLang.date_month}</option>		
			{section name=date_month start=1 loop=13 step=1}
			<option value="{$smarty.section.date_month.index}" {if $smarty.section.date_month.index==$oCompanyEdit->getDateBasis()|date_format:"%m"}selected{/if}>{$aLang.month_array[$smarty.section.date_month.index][0]}</option>
			{/section}
		</select>
		
		<select name="company_basis_year" class="w70">
			<option value="">{$aLang.date_year}</option>
			{section name=date_year start=1910 loop=2011 step=1}    		
    			<option value="{$smarty.section.date_year.index}" {if $smarty.section.date_year.index==$oCompanyEdit->getDateBasis()|date_format:"%Y"}selected{/if}>{$smarty.section.date_year.index}</option>
			{/section}
		</select><br />
		<span class="form_note">{$aLang.company_edit_datebasis_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		<p>
		<label for="company_count_workers">{$aLang.company_edit_countworkers}:</label><br />
		<select name="company_count_workers" class="w100">
		<option value="0">неизвестно</option>		
		<option value="100" {if 100==$oCompanyEdit->getCountWorkers()}selected{/if}>1-100</option>
		<option value="500" {if 500==$oCompanyEdit->getCountWorkers()}selected{/if}>100-500</option>
		<option value="1000" {if 1000==$oCompanyEdit->getCountWorkers()}selected{/if}>500-1000</option>
		<option value="5000" {if 5000==$oCompanyEdit->getCountWorkers()}selected{/if}>1000-5000</option>
		<option value="9999" {if 9999==$oCompanyEdit->getCountWorkers()}selected{/if}>более 5000</option>		
		</select><br />
		<span class="form_note">{$aLang.company_edit_countworkers_note}</span><br />
		<span class="form_note_red"></span>
		</p>

		{if !$oConfig->GetValue('module.company.use_jobs')}
		<p>{if !$oConfig->GetValue('view.tinymce')}<div class="note"><a href="#" onclick="return false;">{$aLang.topic_create_text_notice}</a></div>{/if}
		<label for="company_vacancies">{$aLang.company_edit_vacancy}:</label>
		{if !$oConfig->GetValue('view.tinymce')}
            			<div class="panel_form" style="background: #eaecea; ">       	 
	 						<a href="#" onclick="lsPanel.putTagAround('company_vacancies','b'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/bold_ru.gif" width="20" height="20" title="{$aLang.panel_b}"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('company_vacancies','i'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/italic_ru.gif" width="20" height="20" title="{$aLang.panel_i}"></a>	 			
	 						<a href="#" onclick="lsPanel.putTagAround('company_vacancies','u'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/underline_ru.gif" width="20" height="20" title="{$aLang.panel_u}"></a>	 			
	 						<a href="#" onclick="lsPanel.putTagAround('company_vacancies','s'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/strikethrough.gif" width="20" height="20" title="{$aLang.panel_s}"></a>	 			
	 						&nbsp;
	 						<a href="#" onclick="lsPanel.putTagUrl('company_vacancies','Введите ссылку'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/link.gif" width="20" height="20"  title="{$aLang.panel_url}"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('company_vacancies','code'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/code.gif" width="30" height="20" title="{$aLang.panel_code}"></a>
	 						<a href="#" onclick="showImgUploadForm(); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/img.gif" width="20" height="20" title="{$aLang.panel_image}"></a> 				
	 					</div>
	 				{/if}
		
		
		<textarea class="w100p" name="company_vacancies" id="company_vacancies" rows="10">{$oCompanyEdit->getVacancies()|escape:'html'}</textarea><br />
		<span class="form_note">{$aLang.company_edit_vacancy_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		{/if}
		{if $oCompanyEdit->getLogo()}
		<img src="{$oCompanyEdit->getLogoPath(48)}" border="0">
		<img src="{$oCompanyEdit->getLogoPath(24)}" border="0">
		<input type="checkbox" id="logo_delete" name="logo_delete" value="on"> &mdash; <label for="logo_delete"><span class="form">{$aLang.company_edit_logo_delete}</span></label><br /><br>
		{/if}
     	<span class="form">{$aLang.company_edit_logo}:</span><br /> <input type="file" name="logo" ><br /><br />
		<p class="l-bot"><input type="submit" name="submit_edit_company" tabindex="6" value="{$aLang.company_edit_submit}" /></p>
	</form>
</div>
{include file='footer.tpl'}
