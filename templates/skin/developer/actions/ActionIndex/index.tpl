
{assign var="noSidebar" value=true}
{include file='header.tpl' menu='blog'}


{* шаблон для ивента на главной *}
{if noSidebar }
    {include file='index_event.tpl'}
{/if}

{include file='topic_list.tpl'}
        {* это три строки для выводы 3х банеров *}
        {hook run='index_show_top' topic=$oTopic}
		{hook run='index_show_middle' topic=$oTopic}
		{hook run='index_show_end' topic=$oTopic}	
		
{include file='footer.tpl'}


