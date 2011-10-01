{include file='header.tpl' showWhiteBack=true menu='main'}

<DIV class="page people top-blogs">		
			<h1>{$aLang.company_companies_header}</h1> 
							{if $bCanAddCompany}
							<div>(<a href="{router page='company'}add/">{$aLang.company_menu_create}</a>)</div>
							{/if}
									

				  <table width="100%" border="0" cellpadding="5" cellspacing="1">
				   <tr>
				    <td width=""></td>
				    <td width="22%" align="center" class="company_page_tb_header">{$aLang.company_rating}</td>
				   </tr>
				   {foreach from=$aCompany item=oCompany}
				   <tr>
				    <td class="name">
					{if $oConfig->GetValue('module.company.use_activate')}
						{if !$oCompany->getActive()}<img src='{cfg name="path.static.skin"}/images/topic_unpublish.gif' alt='{$aLang.job_hide_b}'>{/if}
					{/if}
				    <a href="{$oCompany->getUrlFull()}/"><img src="{$oCompany->getLogoPath(24)}" alt="" /></a>
				    <a href="{$oCompany->getUrlFull()}/" class="title">{$oCompany->getName()|escape:'html'}</a></td>
				    <td class="rating"><strong>{$oCompany->getRating()}</strong></td>
				   </tr>				  
					{/foreach}
				  </table>	<br>
				
				
</DIV>

{include file='paging.tpl' aPaging=`$aPaging`}
{include file='footer.tpl'}