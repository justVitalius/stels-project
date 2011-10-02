<div class="block lacom">
	<h3>Последние комментарии</h3>
	
	<div class="block-content">		
		<ul id="live">
			{foreach from=$aComments item=oComment name="cmt"}
				{assign var="oUser" value=$oComment->getUser()}
				{assign var="oTopic" value=$oComment->getTarget()}
				{assign var="oBlog" value=$oTopic->getBlog()}
				{assign var="sFirstLine" value=$oComment->getText()}

				<li class="air-comment">
					<a href="{$oUser->getUserWebPath()}" class="who">{$oUser->getLogin()}</a>&nbsp;&rarr;&nbsp;<a href="{$oTopic->getUrl()}#comment{$oComment->getId()}" class="topic">{$oTopic->getTitle()|escape:'html'}</a>&nbsp;&rarr;&nbsp;{$sFirstLine|truncate:42:'...'}
				</li>
			{/foreach}
		</ul>

		<a href="{router page='comments'}" class="all-comments">Все комментарии</a>
	</div>
</div>