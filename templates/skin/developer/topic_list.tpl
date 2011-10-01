{if count($aTopics)>0}
 {if $noSidebar} <div  class="new-topic" ><div class="line-rezar"></div><div class="new-topic-text">Новое в блогах</div></div>{/if}
	{foreach from=$aTopics item=oTopic}   
		{include file='topic.tpl'}	
	{/foreach}	
		
    {include file='paging.tpl' aPaging="$aPaging"}			
{else}
	{$aLang.blog_no_topic}
{/if}