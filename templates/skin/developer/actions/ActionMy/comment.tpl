{assign var="pageUsers" value=true}
{include file='header.tpl' menu="profile"}

{assign var="oSession" value=$oUserProfile->getSession()}
{assign var="oVote" value=$oUserProfile->getVote()}


<div id="user-profile">
	{* <p class="strength">
		{$aLang.user_skill}: <strong class="total" id="user_skill_{$oUserProfile->getId()}">{$oUserProfile->getSkill()}</strong>
	</p>
	
	<div class="voting {if $oUserProfile->getRating()>=0}positive{else}negative{/if} {if !$oUserCurrent || $oUserProfile->getId()==$oUserCurrent->getId()}guest{/if} {if $oVote} voted {if $oVote->getDirection()>0}plus{elseif $oVote->getDirection()<0}minus{/if}{/if}">
		<a href="#" class="plus" onclick="lsVote.vote({$oUserProfile->getId()},this,1,'user'); return false;"></a>
		<div class="total" title="{$aLang.user_vote_count}: {$oUserProfile->getCountVote()}">{if $oUserProfile->getRating()>0}+{/if}{$oUserProfile->getRating()}</div>
		<a href="#" class="minus" onclick="lsVote.vote({$oUserProfile->getId()},this,-1,'user'); return false;"></a> *}
	</div>
	
	<img src="{$oUserProfile->getProfileAvatarPath(145)}" alt="{$oUserProfile->getLogin()}" class="avatar" />
	
	<h2 class="username">
		{if $oUserProfile->getProfileName()}
			{$oUserProfile->getProfileName()|escape:'html'}
		{else}
			{$oUserProfile->getLogin()}
		{/if}
	</h2>
	
	<p class="regtime">зарегистрирован&nbsp;{$oUserProfile->getDateRegister()|date_format:"%e.%m.%Yг. в %R"}</p>
	
	{assign var="sUserLogin" value=$oUserProfile->getLogin()}
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
	
	{if $iCountTopicUser}
		{assign var='sNumberTopicsByUser' value=$iCountTopicUser}
	{else}
		{assign var='sNumberTopicsByUser' value=0}
	{/if}
	
	{if $iCountCommentUser}
		{assign var='sNumberCommentsByUser' value=$iCountCommentUser}
	{else}
		{assign var='sNumberCommentsByUser' value=0}
	{/if}
	
	<ul class="profile-menu">
		<li class='user-info'><a href="{router page='profile'}{$oUserProfile->getLogin()}/">информация</a></li>
		<li class='user-topics'><a {if $iCountTopicUser}href="{router page='my'}{$oUserProfile->getLogin()}/"{/if}>посты ({$sNumberTopicsByUser})</a></li>
		<li class='user-comments active'><a>комментарии ({$sNumberCommentsByUser})</a></li>
	</ul>
	<div class="clear" style="padding-top: 20px;"></div>
</div>

{include file='comment_list.tpl'}
{include file='footer.tpl'}