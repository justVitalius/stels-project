<div class="block qa">
	<h3>Вопросы и ответы</h3>
	<ul>
	  
	{foreach from=$aTopics item='oTopic' name='qa'}
		{assign var="oUser" value=$oTopic->getUser()}
		<li>
			<a href="{$oUser->getUserWebPath()}" class="who">{$oUser->getLogin()}</a>&nbsp;&rarr;&nbsp;<a href="{$oTopic->getUrl()}" class="topic">{$oTopic->getTitle()|escape:'html'}</a>&nbsp;{$oTopic->getCountComment()}
		</li>
	{/foreach}
	</ul>
	{assign var="oBlog" value=$oTopic->getBlog()}
	<a href="{$oBlog->getUrlFull()}" class="all-questions">Все вопросы</a>
</div>
