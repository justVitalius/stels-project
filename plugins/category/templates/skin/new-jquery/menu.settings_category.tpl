<li {if $sMenuItemSelect=='category'}class="active"{/if}>
	<a href="{router page='settings'}category/">{$aLang.cat_title}</a>
  {if $sMenuItemSelect=='category'}
  <ul class="sub-menu" >
      {if $aType}
      {foreach from=$aType item=oType name=cat}
			<li {if $sMenuSubItemSelect==$oType->getPrefix()}class="active"{/if}><div><a href="{router page='settings'}category/{$oType->getPrefix()}/">{$oType->getTitle()}</a></div></li>
      {/foreach}
      {/if}
  </ul>
  {/if}
</li>
