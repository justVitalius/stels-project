
{ assign var="Top" value=count($aTopics)  }
{if count($aTopics)>0}
 {if $noSidebar} <div  class="new-topic" ><div class="line-rezar"></div><div class="new-topic-text">Новое в блогах</div></div>{/if}
	 
	{foreach from=$aTopics item=oTopic name=fn}   
		{include file='topic.tpl'}	
		{if $smarty.foreach.fn.index==2}<div class="clear"></div>{/if}
{if $smarty.foreach.fn.index==5} {hook run='index_show_middle' topic=$oTopic}{/if}
{if $smarty.foreach.fn.index==8}{hook run='index_show_end' topic=$oTopic}  {/if}
	{/foreach}	
		
    {include file='paging.tpl' aPaging="$aPaging"}			
{else}

	<p style="padding-left:18px;">{$aLang.blog_no_topic}</p>


{/if}