
{assign var="pageUsers" value=true}
{include file='header.tpl' menu="profile"}
{assign var="oSession" value=$oUserProfile->getSession()}
{assign var="oVote" value=$oUserProfile->getVote()}


<div id="user-profile">

	{*<p class="strength">
		{$aLang.user_skill}: <strong class="total" id="user_skill_{$oUserProfile->getId()}">{$oUserProfile->getSkill()}</strong>
	</p> 

	
	<div class="voting {if $oUserProfile->getRating()>=0}positive{else}negative{/if} {if !$oUserCurrent || $oUserProfile->getId()==$oUserCurrent->getId()}guest{/if} {if $oVote} voted {if $oVote->getDirection()>0}plus{elseif $oVote->getDirection()<0}minus{/if}{/if}">
		<a href="#" class="plus" onclick="lsVote.vote({$oUserProfile->getId()},this,1,'user'); return false;"></a>
		<div class="total" title="{$aLang.user_vote_count}: {$oUserProfile->getCountVote()}">{if $oUserProfile->getRating()>0}+{/if}{$oUserProfile->getRating()}</div>
		<a href="#" class="minus" onclick="lsVote.vote({$oUserProfile->getId()},this,-1,'user'); return false;"></a>
	</div>

	*}

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
		<li class='user-info active'><a>информация</a></li>
		<li class='user-topics'><a {if $iCountTopicUser}href="{router page='my'}{$oUserProfile->getLogin()}/"{/if}>посты ({$sNumberTopicsByUser})</a></li>
		<li class='user-comments'><a {if $iCountCommentUser}href="{router page='my'}{$oUserProfile->getLogin()}/comment/"{/if}>комментарии ({$sNumberCommentsByUser})</a></li>
	</ul>
	<div class="clear"></div>
</div>

<div id="user-information">
	{if $aBlogUsers}
	<div class="subscription">
		<div>подписка:</div>
		<div class="subscr">
		{foreach from=$aBlogUsers item=oBlogUser name=blog_user}
		{assign var="oBlog" value=$oBlogUser->getBlog()}
			<a href="{router page='blog'}{$oBlog->getUrl()}/">{$oBlog->getTitle()|escape:'html'}</a>{if !$smarty.foreach.blog_user.last}, {/if}
		{/foreach}
		</div>
	</div>
	{/if}
	
	<div class="clear"></div>
	
	{if $aUsersFriend}
	<div class="friends">
		<div>друзья:</div>
		<div class="frien">
		{foreach from=$aUsersFriend item=oUser}        						
			<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>
		{/foreach}
		</div>
	</div>
	{/if}
	

	{ if  $oUserCurrent and ($oUserCurrent->isAdministrator()) } 
	 {if $oUserProfile->getProfileSex()!='other' || $oUserProfile->getProfileBirthday() || ($oUserProfile->getProfileCountry() || $oUserProfile->getProfileRegion() || $oUserProfile->getProfileCity()) || $oUserProfile->getProfileAbout() || $oUserProfile->getProfileSite()}
					<h1 class="title">{$aLang.profile_privat}</h1>
					<table>		
						{if $oUserProfile->getProfileSex()!='other'}
						<tr>
							<td class="var">{$aLang.profile_sex}:</td>
							<td>
								{if $oUserProfile->getProfileSex()=='man'}

									{$aLang.profile_sex_man}
								{else}
									{$aLang.profile_sex_woman}
								{/if}

							</td>
						</tr>
						{/if}
							
						{if $oUserProfile->getProfileBirthday()}
						<tr>
							<td class="var">{$aLang.profile_birthday}:</td>
							<td>{date_format date=$oUserProfile->getProfileBirthday() format="j F Y"}</td>
						</tr>
						{/if}
						
						{if ($oUserProfile->getProfileCountry()|| $oUserProfile->getProfileRegion() || $oUserProfile->getProfileCity())}
						<tr>
							<td class="var">{$aLang.profile_place}:</td>
							<td>

							{if $oUserProfile->getProfileCountry()}
								<a href="{router page='people'}country/{$oUserProfile->getProfileCountry()|escape:'html'}/">{$oUserProfile->getProfileCountry()|escape:'html'}</a>{if $oUserProfile->getProfileCity()},{/if}
							{/if}						
							{if $oUserProfile->getProfileCity()}
								<a href="{router page='people'}city/{$oUserProfile->getProfileCity()|escape:'html'}/">{$oUserProfile->getProfileCity()|escape:'html'}</a>
							{/if}

							</td>
						</tr>
						{/if}
											
						{if $oUserProfile->getProfileAbout()}					
						<tr>
							<td class="var">{$aLang.profile_about}:</td>
							<td>{$oUserProfile->getProfileAbout()|escape:'html'}</td>
						</tr>	
						{/if}
						
						{if $oUserProfile->getProfileSite()}
						<tr>
							<td class="var">{$aLang.profile_site}:</td>
							<td>

							<noindex>
							<a href="{$oUserProfile->getProfileSite(true)|escape:'html'}" rel="nofollow">
							{if $oUserProfile->getProfileSiteName()}
								{$oUserProfile->getProfileSiteName()|escape:'html'}
							{else}
								{$oUserProfile->getProfileSite()|escape:'html'}
							{/if}
							</a>
							</noindex>

							</td>
						</tr>
						{/if}
					</table>

							

					<br />	
					{/if}
					<br />
					<h1 class="title">{$aLang.profile_activity}</h1>

					<table>
						{if $aUsersFriend}
						<tr>
							<td class="var">{$aLang.profile_friends}:</td>
							<td class="friends">
								{foreach from=$aUsersFriend item=oUser}        						
	        						<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>&nbsp; 
	        					{/foreach}
							</td>
						</tr>
						{/if}
						
						{if $oConfig->GetValue('general.reg.invite') and $oUserInviteFrom}
						<tr>
							<td class="var">{$aLang.profile_invite_from}:</td>
							<td class="friends">							       						
	        					<a href="{$oUserInviteFrom->getUserWebPath()}">{$oUserInviteFrom->getLogin()}</a>&nbsp;         					
							</td>
						</tr>
						{/if}
						
						{if $oConfig->GetValue('general.reg.invite') and $aUsersInvite}
						<tr>
							<td class="var">{$aLang.profile_invite_to}:</td>
							<td class="friends">
								{foreach from=$aUsersInvite item=oUserInvite}        						
	        						<a href="{$oUserInvite->getUserWebPath()}">{$oUserInvite->getLogin()}</a>&nbsp; 
	        					{/foreach}
							</td>
						</tr>
						{/if}
						
						{if $aBlogsOwner}
						<tr>
							<td class="var">{$aLang.profile_blogs_self}:</td>
							<td>							
								{foreach from=$aBlogsOwner item=oBlog name=blog_owner}
									<a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a>{if !$smarty.foreach.blog_owner.last}, {/if}								      		
	        					{/foreach}
							</td>
						</tr>
						{/if}
						
						{if $aBlogAdministrators}
						<tr>
							<td class="var">{$aLang.profile_blogs_administration}:</td>
							<td>

								{foreach from=$aBlogAdministrators item=oBlogUser name=blog_user}
									{assign var="oBlog" value=$oBlogUser->getBlog()}
									<a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a>{if !$smarty.foreach.blog_user.last}, {/if}
								{/foreach}

							</td>
						</tr>
						{/if}
						
						{if $aBlogModerators}
						<tr>
							<td class="var">{$aLang.profile_blogs_moderation}:</td>
							<td>

								{foreach from=$aBlogModerators item=oBlogUser name=blog_user}
									{assign var="oBlog" value=$oBlogUser->getBlog()}
									<a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a>{if !$smarty.foreach.blog_user.last}, {/if}
								{/foreach}
							</td>
						</tr>
						{/if}
						
						{if $aBlogUsers}
						<tr>
							<td class="var">{$aLang.profile_blogs_join}:</td>
							<td>

								{foreach from=$aBlogUsers item=oBlogUser name=blog_user}
									{assign var="oBlog" value=$oBlogUser->getBlog()}
									<a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a>{if !$smarty.foreach.blog_user.last}, {/if}
								{/foreach}

							</td>
						</tr>
						{/if}
						
						{if $aCompanyEmployee}
						<tr>
							<td class="var">{$aLang.company_is_work}:</td>
							<td>
								{foreach from=$aCompanyEmployee item=oCompanyEmploye name=company_user}
									<a href="{router page='company'}{$oCompanyEmploye->getCompanyUrl()}/">{$oCompanyEmploye->getCompanyName()|escape:'html'}</a>{if !$smarty.foreach.company_user.last}, {/if}
								{/foreach}
							</td>
						</tr>
						{/if}
						
						{if $aCompanyAdmirer}
						<tr>
							<td class="var">{$aLang.company_is_like}:</td>
							<td>
								{foreach from=$aCompanyAdmirer item=oCompanyAdmirer name=company_user}
									<a href="{router page='company'}{$oCompanyAdmirer->getCompanyUrl()}/">{$oCompanyAdmirer->getCompanyName()|escape:'html'}</a>{if !$smarty.foreach.company_user.last}, {/if}
								{/foreach}
							</td>
						</tr>
						{/if}
	
						<tr>
							<td class="var">{$aLang.profile_date_registration}:</td>
							<td>{date_format date=$oUserProfile->getDateRegister()}</td>
						</tr>	
						{if $oSession}				
						<tr>
							<td class="var">{$aLang.profile_date_last}:</td>
							<td>{date_format date=$oSession->getDateLast()}</td>
						</tr>						
					</table>
	      {/if}
	
	{ /if}


	<div class="clear"></div>	
</div>

{include file='footer.tpl'}