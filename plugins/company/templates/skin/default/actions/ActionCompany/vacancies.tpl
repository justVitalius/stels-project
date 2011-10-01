{include file='header.tpl' menu='company'}
{include file="../plugins/company/templates/skin/default/header.company.tpl"}

<div class="topic">
<h2>{$aLang.company_vacancies_title}</h2><br/>
	{if $aVacancies}
		{include file='../plugins/job/templates/skin/default/vacancy_list.tpl' aVacancies=$aVacancies}
	{else}	
		{if $oCompany->getVacancies()}
			{$oCompany->getVacancies()|nl2br}
		{else}
			{$aLang.company_vacancies_empty}
		{/if}	
	{/if}
</div>
{include file='footer.tpl'}
