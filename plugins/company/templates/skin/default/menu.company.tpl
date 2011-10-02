<ul class="menu">
			<li {if $sMenuItemSelect=='index'}class="active"{/if}>
				<a href="{router page='company'}{$oCompany->getUrl()}/">{$aLang.company_menu_profile}</a>
			</li>
			
			<li {if $sMenuItemSelect=='blog'}class="active"{/if}>
				<a href="{router page='company'}{$oCompany->getUrl()}/blog/">{$aLang.company_menu_blog}</a>
			</li>
			
			<li {if $sMenuItemSelect=='vacancies'}class="active"{/if}>
				<a href="{router page='company'}{$oCompany->getUrl()}/vacancies/">{$aLang.company_menu_vacancies}</a>
			</li>
			
			<li {if $sMenuItemSelect=='feedbacks'}class="active"{/if}>
				<a href="{router page='company'}{$oCompany->getUrl()}/feedbacks/">{$aLang.company_menu_feedbacks}</a>({$oCompany->getCountFeedback()})
			</li>				
		</ul>
