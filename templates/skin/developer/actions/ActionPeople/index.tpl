{assign var="pageUsers" value=true}
{include file='header.tpl' menu='people'}

<div id="people">
{foreach from=$aUsersRating item=oUser}
	<div class="user-entry">
		
		<a href="{router page='profile'}{$oUser->getLogin()}/"><img src="{$oUser->getProfileAvatarPath(110)}" alt="{$oUser->getLogin()}" class="avatar" />
		
		<h2 class="username">
			{if $oUser->getProfileName()}
				{$oUser->getProfileName()|escape:'html'}
			{else}
				{$oUser->getLogin()}
			{/if}
		</h2></a>
		
		<p class="regtime">зарегистрирован&nbsp;{$oUser->getDateRegister()|date_format:"%e.%m.%Yг. в %R"}</p>
		
		{assign var="sUserLogin" value=$oUser->getLogin()}
		{if $aTopicsByUsers.$sUserLogin}
		<div class="last">
			<p class="last-label">последние посты:</p>
			<div class="last-entries">
			
			{assign var="aTopicsByUser" value=$aTopicsByUsers[$sUserLogin]}
			
			{foreach from=$aTopicsByUser item=oTopic}			
				{assign var="oBlog" value=$oTopic->getBlog()}
				<div class="last-entry">
					<a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a>&nbsp;/&nbsp;<a href="{$DIR_WEB_ROOT}/blog/{if $oBlog->getUrl()}{$oBlog->getUrl()}/{/if}{$oTopic->getId()}.html" class="topic">{$oTopic->getTitle()}</a>
				</div>
			{/foreach}
			</div>
		</div>
		{/if}
		
	</div>
	<div class="clear"></div>
{/foreach}
</div>

{include file='paging.tpl' aPaging="$aPaging"}
{include file='footer.tpl'}