<li style="padding-left: {$level}px; {if $sEvent==$oCategory->getUrl()}font-weight: bold;{/if}">
    <a {if $sAdmin}href="#" onclick="ls.category.edit('{$oCategory->getId()}','{$oCategory->getParentId()}','{$oCategory->getTitle()}','{$oCategory->getUrl()}');return false;"{else}href="{$oCategory->getCategoryUrl()}"{/if}>
	{$oCategory->getTitle()|escape:'html'}
	<sup>[ {$oCategory->getCountTarget()} ]</sup>

    </a>
{if $sAdmin} <a href="#" onclick="ls.category.del('{$oCategory->getId()}','{$sTypeCategory}');return false; " style="color: red;">&#215;</a>{/if}
</li>
{if $oCategory->getSubCategory()}
    {assign var="oCategorySub" value=$oCategory->getSubCategory()}
    {foreach from=$oCategorySub item=oCategory name=cat}
	{include file="$sTemplatePathPlugin/block.cat_row.tpl" level=$level+10}
    {/foreach}
{/if}
