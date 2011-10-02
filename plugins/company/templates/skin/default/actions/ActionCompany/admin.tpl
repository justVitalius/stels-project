{include file='header.tpl' menu="company_edit" showWhiteBack=true}

{literal}
<script>
document.addEvent('domready', function() {	
	new Autocompleter.Request.HTML($('own_user'), {cfg name="path.root.web"}+'/include/ajax/userAutocompleter.php', {
		'indicatorClass': 'autocompleter-loading', // class added to the input during request
		'minLength': 1, // We need at least 1 character
		'selectMode': 'pick', // Instant completion
		'multiple': true // Tag support, by default comma separated
	});
});
</script>
{/literal}

<h1>{$aLang.company_users_header}: <a href="{$oCompanyEdit->getUrlFull()}/"  class="blog_headline_group">{$oCompanyEdit->getName()}</a></h1>

<div class="profile-user">

{if $aBlogUsers}
   
       <form action="" method="POST" id="thisform" enctype="multipart/form-data">
       <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
      	<table class="table-blog-users">
			<tr>
				<td width="200px"></td>
				<td align="center">{$aLang.company_users_admin}</td>				
				<td align="center">{$aLang.company_users_moderator}</td>
				<td align="center">{$aLang.company_users_employe}</td>
				<td align="center">{$aLang.company_users_admirer}</td>
			</tr>	
			{foreach from=$aBlogUsers item=oCompanyUser}
			{assign var="oUser" value=$oCompanyUser->getUser()}
			<tr>
				<td class="username"><a href="{router page='profile'}{$oUser->getLogin()}/">{$oUser->getLogin()}</a></td>
				{if $oCompanyUser->getUserId()==$oUserCurrent->getId()}
					<td colspan="4" align="center">{$aLang.company_users_isadmin}</td>
				{elseif $oCompanyUser->getUserOwnerId()==$oCompanyUser->getUserId()}
					<td colspan="4" align="center">{$aLang.company_users_isowner}</td>
				{else}
					<td><input type="radio" name="user_rank[{$oUser->getId()}]"  value="administrator" {if $oCompanyUser->getIsAdministrator()}checked{/if}/></td>
					<td><input type="radio" name="user_rank[{$oUser->getId()}]"  value="moderator" {if $oCompanyUser->getIsModerator()}checked{/if}/></td>
					<td><input type="radio" name="user_rank[{$oUser->getId()}]"  value="employee" {if $oCompanyUser->getUserRole()==$BLOG_USER_ROLE_USER}checked{/if}/></td>
					<td><input type="radio" name="user_rank[{$oUser->getId()}]"  value="reader" {if $oCompanyUser->getUserRole()==$BLOG_USER_ROLE_GUEST}checked{/if}/></td>	

				{/if}
			</tr>
			{/foreach}		
					
		</table><br />
    <p class="buttons">   
     <input type="submit" name="submit_company_admin" value="{$aLang.company_users_submit}">&nbsp;    
    </p>
    </form>
   {else}
    {$aLang.company_users_onlyone}
   {/if} 

	
	{if $oBlog->getOwnerId()==$oUserCurrent->getId() or $oUserCurrent->isAdministrator() }
    <form action="" method="POST" id="thisform" enctype="multipart/form-data">
       <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
  		<p><label for="own_user">{$aLang.company_users_replaceowner}:</label><input type="text" class="w100" id="own_user" name="own_user" value="{$_aRequest.own_user}"/><input type="submit" name="submit_company_own" value="{$aLang.company_users_replaceowner_submit}"></p>
	</form>	
	{/if} 
    <div class="form_note">{$aLang.company_users_note}</div>  
   

    
</div>




{include file='footer.tpl'}

