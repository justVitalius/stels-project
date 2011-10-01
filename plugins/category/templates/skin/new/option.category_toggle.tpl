<option value="0">{$aLang.cat_select}</option>
{if $aCategory}
    {foreach from=$aCategory item=oCategory name=cat}        
	{include file="$sTemplatePathPlugin/option.tpl" level=0}
    {/foreach}
{/if}
