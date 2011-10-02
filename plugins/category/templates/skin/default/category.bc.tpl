<link rel='stylesheet' type='text/css' href='{$sTemplateCategoryWebPathPlugin}/css/style.css' />
{if $oCategory}
  <ul class="category">
  <li>{if $oCategory->getParentId()}&nbsp;&rarr;&nbsp;{/if}<a href="{$oCategory->getCategoryUrl()}">{$oCategory->getTitle()}</a></li>
  {if $oCategory->getparent()}
    {include file="$sTemplateCategoryPath/category.bc_toggle.tpl" oCategory=$oCategory->getparent()}
  {/if}
  </ul>
  <div style="clear:both;"></div>
{/if}
