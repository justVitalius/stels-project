<ul id="live">
	{foreach from=$aComments item=oComment name="cmt"}
		{assign var="oUser" value=$oComment->getUser()}
		{assign var="oTopic" value=$oComment->getTarget()}
		{assign var="oBlog" value=$oTopic->getBlog()}
		
		<li class="air-comment">
			<a href="{$oUser->getUserWebPath()}" class="who">{$oUser->getLogin()}</a>&nbsp;&rarr;&nbsp;<a href="{$oTopic->getUrl()}#comment{$oComment->getId()}" class="topic">{$oTopic->getTitle()|escape:'html'}</a>&nbsp;{$oTopic->getCountComment()}
		</li>
	{/foreach}
</ul>

<div class="bottom">
	<a href="{router page='comments'}" class="all-live">{$aLang.block_stream_comments_all}</a>
</div>