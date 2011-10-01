{include file='header.tpl' menu='company' showWhiteBack=true}
{include file="../plugins/company/templates/skin/default/header.company.tpl"}
{assign var="oUserOwner" value=$oCompany->getOwner()}
<div class='topic'>
<div class="profile-user">



	<table>	  
	{if $oCompany->getLegalName()}
	<tr>
		<td class="var">{$aLang.company_info_legalname}:</td>
		<td>{$oCompany->getLegalName()|escape:'html'}</td>
	</tr>	
	{/if}
	
	{if $oCompany->getDescription()}
	<tr>
		<td class="var">{$aLang.company_info_description}:</td>
		<td>{$oCompany->getDescription()|nl2br}</td>
	</tr>	
	{/if}
	{if $oCompany->getTags()}
	<tr>
		<td class="var">{$aLang.company_info_tags}:</td>
		<td>{$oCompany->getTagsLink()}</td>
	</tr>	
	{/if}
	{if $oCompany->getSite()}
	<tr>
		<td class="var">{$aLang.company_info_site}:</td>
		<td><noindex> <a href="{$oCompany->getSite(true)|escape:'html'}" target="_blank">{$oCompany->getSite()}</a></noindex> </td>
	</tr>
	{/if}
	{if $oCompany->getEmail()}
	<tr>
		<td class="var">{$aLang.company_info_email}:</td>
		<td>{if $oUserCurrent}{$oCompany->getEmail()|escape:'html'}{else}{$aLang.company_email_hide}{/if}</td>
	</tr>
	{/if}
	{if $oCompany->getPhone()}
	<tr>
		<td class="var">{$aLang.company_info_phone}:</td>
		<td>{$oCompany->getPhone()|escape:'html'}</td>
	</tr>
	{/if}
	{if $oCompany->getFax()}
	<tr>
		<td class="var">{$aLang.company_info_fax}:</td>
		<td>{$oCompany->getFax()|escape:'html'}</td>
	</tr>
	{/if}
	{if ($oCompany->getCountry()|| $oCompany->getCity() || $oCompany->getAddress())}
	<tr>
		<td class="var">
			{$aLang.company_info_place}:
		</td>
		<td>
			{if $oCompany->getCountry()}
				{$oCompany->getCountry()|escape:'html'}
			{/if}
			{if $oCompany->getCity()}
				, {$oCompany->getCity()|escape:'html'}
			{/if}
			{if $oCompany->getAddress()}
				, {$oCompany->getAddress()|escape:'html'}
			{/if}			
		</td>
	</tr>
	{/if}
	{if $oCompany->getBoss()}
	<tr>
		<td class="var">{$aLang.company_info_boss}:</td>
		<td>{$oCompany->getBoss()|escape:'html'}</td>
	</tr>
	{/if}
	{if $oCompany->getDateBasis()}
	<tr>
		<td class="var">{$aLang.company_info_datebasis}:</td>
		<td>{date_format date=$oCompany->getDateBasis() format="j F Y"}</td>
	</tr>
	{/if}
	{if $oCompany->getCountWorkers()!=0}
	<tr>
		<td class="var">{$aLang.company_info_countworkers}:</td>
		<td>
			{if 0==$oCompany->getCountWorkers()}неизвестен{/if}
			{if 100==$oCompany->getCountWorkers()}1-100{/if}
			{if 500==$oCompany->getCountWorkers()}100-500{/if}
			{if 1000==$oCompany->getCountWorkers()}500-1000{/if}
			{if 5000==$oCompany->getCountWorkers()}1000-5000{/if}
			{if 9999==$oCompany->getCountWorkers()}более 5000{/if}
		</td>
	</tr>
	
{/if}</table>
</div>
</div>
<div class="profile-blog">
<div class="about">
<div class="tl"><div class="tr"></div></div>
<div class="content">

  <div class="admins">
  <h3>{$aLang.company_info_admins} ({$iCountCompanyAdministrators})</h3>	
  <ul class="admin-list">				
	<li>
		<dl>
			<dt>
				<a href="{$oUserOwner->getUserWebPath()}"><img src="{$oUserOwner->getProfileAvatarPath(48)}" alt=""  title="{$oUserOwner->getLogin()}"/></a>
			</dt>
			<dd>
				<a href="{$oUserOwner->getUserWebPath()}">{$oUserOwner->getLogin()}</a>
			</dd>
		</dl>
	</li>
	{if $aCompanyAdministrators}			
	{foreach from=$aCompanyAdministrators item=oBlogUser}
	{assign var="oUser" value=$oBlogUser->getUser()}  									
	<li>
		<dl>
			<dt>
				<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(48)}" alt=""  title="{$oUser->getLogin()}"/></a>
			</dt>
			<dd>
				<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>
			</dd>
		</dl>
	</li>
	{/foreach}	
	{/if}						
  </ul>
   </div>
  
  <div class="moderators">
	<h3>{$aLang.company_info_moderators}({$iCountCompanyModerators})</h3>
	{if $aCompanyModerators}
	<ul class="admin-list">							
		{foreach from=$aCompanyModerators item=oBlogUser}  
		{assign var="oUser" value=$oBlogUser->getUser()}									
		<li>
			<dl>
				<dt>
					<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(48)}" alt="" title="{$oUser->getLogin()}" /></a>
				</dt>
				<dd>
					<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>
				</dd>
			</dl>
		</li>
		{/foreach}							
	</ul>
	{else}
		{$aLang.company_info_moderators_empty}
	{/if}
	</div>
 
  <br style='clear:both'/>
	<h3>{$aLang.company_info_employes} ({$iCountCompanyEmployees})</h3>
	{if $aCompanyEmployees}
	<ul class="admin-list">							
		{foreach from=$aCompanyEmployees item=oBlogUser}  
		{assign var="oUser" value=$oBlogUser->getUser()}									
		<li>
			<dl>
				<dt>
					<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(48)}" alt="" title="{$oUser->getLogin()}" /></a>
				</dt>
				<dd>
					<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>
				</dd>
			</dl>
		</li>
		{/foreach}							
	</ul>
	{else}
		{$aLang.company_info_employes_empty}
	{/if}

	<h3>{$aLang.company_info_admirers} ({$iCountCompanyUsers})</h3>
  
  {if $aCompanyUsers}
	<ul class="reader-list">
		{foreach from=$aCompanyUsers item=oBlogUser}
		{assign var="oUser" value=$oBlogUser->getUser()}
			<li><a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></li>
		{/foreach}
	</ul>
	{else}
		{$aLang.company_info_admirers_empty}
	{/if}

</div> 	
<div class="bl"><div class="br"></div></div>
</div>

</div>
{include file='footer.tpl'}

