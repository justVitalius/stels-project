{if $oCategory}
  <li>{if $oCategory->getParentId()}&nbsp;&rarr;&nbsp;{/if}<a href="{$oCategory->getCategoryUrl()}">{$oCategory->getTitle()}</a></li>
  {if $oCategory->getparent()}
    {include file="$sTemplateCategoryPath/category.bc_toggle.tpl" oCategory=$oCategory->getParent()}
  {/if}
{/if}
