{include file='header.tpl' showWhiteBack=true menu='main'}
<script type="text/javascript" src="{cfg name='path.root.web'}/plugins/company/templates/skin/default/js/company.js"></script>
<DIV class="page people top-blogs">		
			<h1>{$aLang.company_companies_header}</h1> 
							{if $bCanAddCompany}
							<div>(<a href="{router page='company'}add/">{$aLang.company_menu_create}</a>)</div>
							{/if}
									

				  <table width="100%" border="0" cellpadding="5" cellspacing="1">
				   <tr>
				    <td width=""></td>
				    <td width="22%" align="center" class="company_page_tb_header">{$aLang.company_rating}</td>
				    <td></td>
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
				    <td>
				      <div class="join {if $oCompany->getUserIsJoin()}active{/if}">
             
             <a href="#" onclick="ajaxJoinLeaveCompany(this,{$oCompany->getBlogId()}); return false;">{if !$oCompany->getUserIsJoin()}подписаться{else}отписаться{/if}</a>
            
            </div>
            {if !$aCompanyUsers}
            <p>BBB</p>
            {foreach from=$aCompanyUsers item=oUser}
             <p> {$oUser->getId()}AAA</p>
            {/foreach}
            {/if}
				    </td>  
				   </tr>
				  
					{/foreach}
				  </table>	<br>
				
				
				
				
				
</DIV>

{include file='paging.tpl' aPaging=`$aPaging`}
{include file='footer.tpl'}