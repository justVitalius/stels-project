<li {if $sAction=='company'}class="active"{/if}>
<a href="{router page='company'}user/{$oUserProfile->getLogin()}/feedbacks/">{$aLang.company_profile_menu_companies} </a>
{if $sAction=='company'}
	<ul class="sub-menu" >
		<li {if $aParams[1]=='feedbacks'}class="active"{/if}><div><a href="{router page='company'}user/{$oUserProfile->getLogin()}/feedbacks/">{$aLang.company_pub_feedback}</a>{if $iCountFeedbackUser}({$iCountFeedbackUser}){/if}</div></li>
	</ul>
{/if}
</li>