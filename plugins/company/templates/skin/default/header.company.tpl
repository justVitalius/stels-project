<script type="text/javascript" src="{cfg name='path.root.web'}/plugins/company/templates/skin/default/js/vote.js"></script>
<script type="text/javascript" src="{cfg name='path.root.web'}/plugins/company/templates/skin/default/js/company.js"></script>
	<div class="profile-blog">
		<div class="voting {if $oCompany->getRating()>=0}positive{else}negative{/if} {if !$oUserCurrent || $oCompany->getOwnerId()==$oUserCurrent->getId()}guest{/if} {if $oCompany->getUserIsVote()} voted {if $oCompany->getUserVoteDelta()>0}plus{elseif $oCompany->getUserVoteDelta()<0}minus{/if}{/if}">
					<div class="clear">{$aLang.company_rating}</div>
					
					<a href="#" class="plus" onclick="lsVoteCompany.vote({$oCompany->getId()},this,1,'company'); return false;"></a>
					<div class="total">{if $oCompany->getRating()>0}+{/if}{$oCompany->getRating()}</div>
					<a href="#" class="minus" onclick="lsVoteCompany.vote({$oCompany->getId()},this,-1,'company'); return false;"></a>
					
					<div class="clear"></div>
					<div class="text">{$aLang.company_vote_count}:</div><div class="count">{$oCompany->getCountVote()}</div>
		</div>
		

		<img class="avatar" src="{$oCompany->getLogoPath(24)}" width="24" height="24" alt="" title="{$oCompany->getName()|escape:'html'}" border="0">
		<h1 class="title"><a href="{router page='company'}{$oCompany->getUrl()}/"><span>{$oCompany->getName()|escape:'html'}</span></a></h1> 
		<div class="topic">
		  <ul class="action">	
					<li class="rss"><a href="{$oCompany->getUrlFull()}/rss/"></a></li>	
					{if $oUserCurrent and $oUserCurrent->getId()!=$oCompany->getOwnerId()}
						<li class="join {if $oCompany->getUserIsJoin()}active{/if}">
							<a href="#" onclick="ajaxJoinLeaveCompany(this,{$oCompany->getBlogId()}); return false;"></a>
						</li>
					{/if}
					{if $oUserCurrent and ($oUserCurrent->getId()==$oCompany->getOwnerId() or $oUserCurrent->isAdministrator() or ($oCompany->getUserIsAdministrator()) )}
  						<li class="edit"><a href="{router page='company'}edit/{$oCompany->getId()}/" title="{$aLang.company_edit}">{$aLang.company_edit}</a></li>
  					{/if}
  					{if $oUserCurrent and $oUserCurrent->isAdministrator()}
  						<li class="delete"><a href="{router page='company'}delete/{$oCompany->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" title="{$aLang.company_delete}">{$aLang.company_delete}</a></li>
  						<li class="edit"><a href="{router page='company'}{if $oCompany->getActive()}deactivate{else}activate{/if}/{$oCompany->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}">{if $oCompany->getActive()}{$aLang.company_deactivate}{else}{$aLang.company_activate}{/if}</a></li>
  					{/if}
					{if $isEmployee}
  						<li class="edit"><a href="{router page='topic'}add/?blog_id={$oCompany->getBlogId()}" title="{$aLang.company_add_topic}">{$aLang.company_add_topic}</a></li>
  					{/if}
            </ul>
		</div>
		
		<!-- company menu -->
		<ul class="profile-menu">
        	<li class='user-info active'><a>информация</a></li>
        	<li class='user-topics'><a href="{router page='company'}{$oCompany->getUrl()}/blog">посты ({$sNumberTopicsByUser})</a></li>
        	<li class='user-comments'><a href="{router page='company'}{$oCompany->getUrl()}/feedbacks">мнения ({$sNumberCommentsByUser})</a></li>
        </ul>
        <div class="clear"></div>
        

	</div>
