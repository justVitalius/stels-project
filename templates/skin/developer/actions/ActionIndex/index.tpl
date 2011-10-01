
{assign var="noSidebar" value=true}
{include file='header.tpl' menu='blog'}


{* шаблон для ивента на главной *}
{if noSidebar }
    {include file='index_event.tpl'}
{/if}

{include file='topic_list.tpl'}
{include file='footer.tpl'}


