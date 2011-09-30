<div class="block news">
	<h3>Новости</h3>
	<ul>
	{foreach from=$aTopics item='oTopic' name='news'}
		<li>
			{$smarty.foreach.news.iteration}.&nbsp;<a href="{$oTopic->getUrl()}">{$oTopic->getTitle()|escape:'html'}</a>
		</li>
	{/foreach}
	</ul>
	{assign var="oBlog" value=$oTopic->getBlog()}
	<a href="{$oBlog->getUrlFull()}" class="all-news">Все новости</a>
</div>
