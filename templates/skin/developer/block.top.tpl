<div class="block top">
	<h3>TOP 15</h3>
	<ul>
	{foreach from=$aTopics item='oTopic' name='top'}
		{assign var="oUser" value=$oTopic->getUser()}
		<li>
			<a href="{$oUser->getUserWebPath()}" class="who">{$oUser->getLogin()}</a>&nbsp;&rarr;&nbsp;<a href="{$oTopic->getUrl()}" class="topic">{$oTopic->getTitle()|escape:'html'}</a>
		</li>
	{/foreach}
	</ul>
</div>
