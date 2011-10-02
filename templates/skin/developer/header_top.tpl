


<div id="header">
	{if !$oUserCurrent}
		<div class="login-form">
			<a href="#" class="close" onclick="hideLoginForm(); return false;"></a>

			<form action="{router page='login'}" method="POST">
				<h3>{$aLang.user_authorization}</h3>

				{hook run='form_login_popup_begin'}

				<p><label>{$aLang.user_login}:<br />
				<input type="text" class="input-text" name="login" id="login-input"/></label></p>

				<p><label>{$aLang.user_password}:<br />
				<input type="password" name="password" class="input-text" /></label></p>

				<p><label><input type="checkbox" name="remember" class="checkbox" checked />{$aLang.user_login_remember}</label></p>

				{hook run='form_login_popup_end'}

				<input type="submit" name="submit_login" value="{$aLang.user_login_submit}" /><br /><br />

				<a href="{router page='login'}reminder/">{$aLang.user_password_reminder}</a><br />
				<a href="{router page='registration'}">{$aLang.user_registration}</a>
			</form>
		</div>
	{/if}
	<div id="registrtionIn" align="center">

	   <a href="#" class="img {if !$oUserCurrent} current {/if}">Войти/Регистрация</a>

	   <div class="clear"></div>
	   {if $oUserCurrent}
	      <a href="{$oUserCurrent->getUserWebPath()}">{$oUserCurrent->getLogin()}</a>
	      <span> / </span>
	      <a href="{router page='login'}exit/?security_ls_key={$LIVESTREET_SECURITY_KEY}">выход</a>
	    {else}
	    <a href="{router page='login'}" onclick="showLoginForm(); return false">вход</a><span> / </span>
      <a href="{router page='registration'}">регистрация</a>
      {/if}

	</div>
	<div id="topnav">
		<!-- {$sAction}!!!{$sEvent} -->
		<ul class="pages">
			<li {if $sAction=='index'}class="active"{/if}><a href="{cfg name='path.root.web'}" style="margin-left:5px">Главная</a></li>

			<li {if $sAction=='blogs'}class="active"{/if}><a href="{router page='blogs'}">Блоги</a></li>
			<li {if $sEvent=='qa'}class="active"{/if}><a href="{cfg name='path.root.web'}/blog/qa/">Q&A</a></li>
			<li {if $sAction=='people'}class="active"{/if}><a href="{router page='people'}">Пользователи</a></li>
			{*
			 убрали до лучших времен. Потому что сам плагин компании вставляет свой пункт меню 
			 <li {if $sMenuItemSelect=='companies'}class="active"{/if}><a href="{router page='company'}">Компании</a></li>
			*}
			<li {if $sEvent=='events'}class="active"{/if}><a href="{cfg name='path.root.web'}/blog/events/">События</a></li>
			<li {if $sEvent=='competitions'}class="active"{/if}><a href="{cfg name='path.root.web'}/blog/competitions/"  style="margin-right:5px">Конкурсы</a></li>
			{hook run='main_menu'}
		</ul>
		<div id="topnav-foot">&nbsp;</div>
		<!-- Searchform block -->
    <div class="block searchform header">
      <form id="search-form" action="{router page='search'}topics/" method="GET">
        <input id="search-area" type="text" onblur="if (!value) value=defaultValue" onclick="if (value==defaultValue) value=''" value="поиск..." name="q" />
      </form>
    </div>
	</div>
	<h1><a href="{cfg name='path.root.web'}">ЭНЕРГОБЛОГ</a></h1>
</div>

