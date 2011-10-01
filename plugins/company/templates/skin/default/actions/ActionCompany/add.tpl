{include file='header.tpl' menu='topic_action' showWhiteBack=true}

{literal}
<script>
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



<div class="backoffice">
<h1>{$aLang.company_add_header}</h1>
	<form action="" method="POST" id="thisform" enctype="multipart/form-data">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 
		<label for="company_name">{$aLang.company_add_name}:</label>
		<input type="text" id="company_name" name="company_name" value="{$_aRequest.company_name}" style="width: 100%;" /><br />
		<span class="form_note">{$aLang.company_add_name_note}</span><br />
		<span class="form_note_red"></span>
		{if !$oConfig->GetValue('module.company.use_convert_url')}
		<p>
		<label for="company_url">{$aLang.company_add_url}:</label>
		<input type="text" id="company_add_url" name="company_url" value="{$_aRequest.company_url}" style="width: 100%;" {if $_aRequest.company_id}disabled{/if} /><br />
		<span class="form_note">{$aLang.company_add_url_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		{/if}
		<p>
		<textarea name="company_description" id="company_description" rows="5" 
				onKeyPress="counter(this.form.company_description,this.form.countdown,255);"
				onKeyDown="limitText(this.form.company_description,this.form.countdown,255);" 
				onKeyUp="limitText(this.form.company_description,this.form.countdown,255);">{$_aRequest.company_description}</textarea>
		<span class="form_note">{$aLang.company_add_description_note}</span><br />
		<span class="form_note">Осталось <input readonly type="text" name="countdown" size="3" value="255"> символов</span><br />
		<span class="form_note">{$aLang.company_add_description_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		<p>
		<label for="company_tags">{$aLang.company_add_tags}:</label>
		<input type="text" id="company_tags" name="company_tags" value="{$_aRequest.company_tags}" style="width: 100%;" /><br />
		<span class="form_note">{$aLang.company_add_tags_note}</span>
		</p>
		<p>
		<span class="form">{$aLang.company_add_place}: </span><br />
		<span class="form">{$aLang.company_add_place_country}: </span><br /><input  style="width: 60%;" type="text"	id="company_country" name="company_country" value="{$_aRequest.company_country}" /><br />
		<span class="form">{$aLang.company_add_place_city}:  </span><br /><input  style="width: 60%;" type="text"	id="company_city" name="company_city" value="{$_aRequest.company_city}" /><br />	
		<span class="form_note">{$aLang.company_add_place_note}</span><br />
		<span class="form_note_red"></span>
		</p>
		<p class="l-bot"><input type="submit" name="submit_add_company" tabindex="6" value="{$aLang.company_add_submit}" /></p>
	</form>
</div>
{include file='footer.tpl'}
