<ul id="live">
	{foreach from=$oTopics item=oTopic name="cmt"}
		{assign var="oUser" value=$oTopic->getUser()}							
		{assign var="oBlog" value=$oTopic->getBlog()}
		
		<li class="air-comment">
			<a href="{$oUser->getUserWebPath()}" class="who">{$oUser->getLogin()}</a>&nbsp;&rarr;&nbsp;<a href="{$oTopic->getUrl()}" class="topic">{$oTopic->getTitle()|escape:'html'}</a>&nbsp;{$oTopic->getCountComment()}
		</li>						
	{/foreach}				
</ul>

<div class="bottom">
	<a href="{router page='new'}" class="all-live">{$aLang.block_stream_topics_all}</a>
</div>
					