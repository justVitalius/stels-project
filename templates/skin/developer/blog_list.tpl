
<table id="blogs">
	<thead>
		<tr>
			<td class='td1'>Блог</td>
			<td class='td2'>&nbsp;</td>
			<td class='td3'>категория</td>
			<td class='td3'>индекс</td>
		</tr>
	</thead>
	<tbody>
	{foreach from=$aBlogs item=oBlog}
		{assign var="oUserOwner" value=$oBlog->getOwner()}
		{assign var="sBlogId" value=$oBlog->getId()}
		<tr>
			<td class='td1'>
				<a href="{router page='blog'}{$oBlog->getUrl()}/">{$oBlog->getTitle()|escape:'html'}</a>
				{$oBlog->getCountUser()} читателей, {$aCountTopicsInBlogs.$sBlogId} постов
			</td>
			<td class='td2'>
			{if $oUserCurrent}
				{if $oUserCurrent->getId()!=$oBlog->getOwnerId() and $oBlog->getType()=='open'}
				<a href="#" onclick="ajaxJoinLeaveBlog(this,{$oBlog->getId()}); return false;">
					{if $oBlog->getUserIsJoin()}{$aLang.clean_leave}{else}{$aLang.clean_join}{/if}
				</a>
				{/if}
			{/if}
			</td>
			<td class='td3'>
				{$sBlogCategory}
			</td>
			<td class='td4'>
				{$oBlog->getRating()}
			</td>
		</tr>
	{/foreach}
	</tbody>
</table>