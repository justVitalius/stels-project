{*
<ul class="menu">
			<li {if $sMenuItemSelect=='companies'}class="active"{/if}>
				<a href="{router page='company'}">{$aLang.companies}</a>				
			</li>
			
			{if $aUserCompany}<li {if $sMenuItemSelect=='companies_my'}class="active"{/if}><div><a href="{router page='company'}my/">{$aLang.companies_my}</a>({$aUserCompany|@count})</div></li>{/if}	
		</ul>
*}