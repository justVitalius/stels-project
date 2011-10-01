<div id="sidebar">
	<!-- Profile block -->
	<div class="block">
		<ul class="profile">
			{if $oUserCurrent}
			<li><a href="{$oUserCurrent->getUserWebPath()}">{$oUserCurrent->getLogin()}</a></li>
			<li><a href="{router page='topic'}add/">написать</a></li>
			{if $iUserCurrentCountTalkNew}
			<li><a href="{router page='talk'}" title="{$aLang.user_privat_messages_new}">личные сообщения ({$iUserCurrentCountTalkNew})</a></li>
			{else}
			<li><a href="{router page='talk'}">личные сообщения ({$iUserCurrentCountTalkNew})</a></li>
			{/if}
			<li><a href="{router page='settings'}profile/">настройки</a></li>
			<li><a href="{router page='login'}exit/?security_ls_key={$LIVESTREET_SECURITY_KEY}">выход</a></li>
			{hook run='userbar_item'}
			{else}
			<li><a href="{router page='login'}" onclick="showLoginForm(); return false">вход</a></li>
			<li><a href="{router page='registration'}">регистрация</a></li>
			{/if}
		</ul>
	</div>
	
	<!-- Searchform block -->
	<div class="block searchform">
		<form id="search-form" action="{router page='search'}topics/" method="GET">
			<input id="search-area" type="text" onblur="if (!value) value=defaultValue" onclick="if (value==defaultValue) value=''" value="поиск..." name="q" />
		</form>
	</div>
	
	
	{*include file=header_nav.tpl*}
	{*<div id="nav">
		<ul class="menu">
			<li><a href="{cfg name='path.root.web'}/blog/news/">Новости</a></li>
			<li><a href="#">Тематические</a></li>
			<li><a href="#">От компании</a></li>
		</ul>
	</div>*}
	
	<!-- Other blocks -->
	{if isset($aBlocks.right)}
		{foreach from=$aBlocks.right item=aBlock}
			{if $aBlock.type=='block'}
				{insert name="block" block=`$aBlock.name` params=`$aBlock.params`}
			{/if}
			{if $aBlock.type=='template'}
				{include file=`$aBlock.name` params=`$aBlock.params`}
			{/if}
		{/foreach}
	{/if}
</div>