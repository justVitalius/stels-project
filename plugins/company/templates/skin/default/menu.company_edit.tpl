<ul class="menu">
			<li {if $sMenuItemSelect=='profile'}class="active"{/if}>
				<a href="{router page='company'}edit/{$oCompanyEdit->getId()}/">{$aLang.company_menu_profile}</a>
			</li>
			
			<li {if $sMenuItemSelect=='admin'}class="active"{/if}>
				<a href="{router page='company'}admin/{$oCompanyEdit->getId()}/">{$aLang.company_menu_users}</a>
			</li>				
		</ul>
