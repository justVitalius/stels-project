<ul class="category_topic">
{if $oCategory}
  <li>{if $oCategory->getParentId()}&nbsp;&rarr;&nbsp;{/if}<a href="{$oCategory->getCategoryUrl()}">{$oCategory->getTitle()}</a></li>
  {if $oCategory->getparent()}
    {include file="$sTemplateCategoryPath/category.bc_toggle.tpl" oCategory=$oCategory->getparent()}
  {/if}
{else}
<li>&nbsp;нет&nbsp;</li>
{/if}
<li>категория&nbsp;:&nbsp;</li>
</ul>
<div style="clear:both;"></div>
