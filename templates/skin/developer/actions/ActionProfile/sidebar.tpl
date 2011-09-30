{if $oUserCurrent && $oUserCurrent->getId()!=$oUserProfile->getId()}
	<div class="block friender">				
		<ul>
			{include file='actions/ActionProfile/friend_item.tpl' oUserFriend=$oUserProfile->getUserFriend()}
			<li><a href="{router page='talk'}add/?talk_users={$oUserProfile->getLogin()}">{$aLang.user_write_prvmsg}</a></li>						
		</ul>
	</div>
{/if}

{if $oUserProfile->getProfileFoto()}
<div class="block">
	<h3>Фото</h3>	
	<img src="{$oUserProfile->getProfileFoto()}" alt="photo" class="photo" />
</div>
{/if}