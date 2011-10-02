<option {if $_aRequest.category_id == $oCategory->getId()}selected{/if} value="{$oCategory->getId()}" style="padding-right: {$level}px;">{if $level}{section name=foo start=0 loop=$level step=1}-{/section}{/if} {$oCategory->getTitle()|escape:'html'}</option>
{if $oCategory->getSubCategory()}
    {assign var="oCategorySub" value=$oCategory->getSubCategory()}
    {foreach from=$oCategorySub item=oCategory name=cat}	
	{include file="$sTemplatePathPlugin/option.tpl" level=$level+1}
    {/foreach}
{/if}
