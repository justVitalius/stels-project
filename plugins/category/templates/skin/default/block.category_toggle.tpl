{if $oUserCurrent and $oUserCurrent->isAdministrator()}{assign var="isAdm" value=1}{/if}
        <ul class="list">
        {if $aCategory}
        {foreach from=$aCategory item=oCategory name=cat}
          {include file="$sTemplatePathPlugin/block.cat_row.tpl" level=10}
        {/foreach}
        {/if}
        </ul>
