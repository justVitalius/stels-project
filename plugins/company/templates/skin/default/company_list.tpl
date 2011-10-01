<DIV class=blogposts>
	
{if count($aCompanies)>0}	
	{foreach from=$aCompanies item=oCompany}    
	<div class="topic">
 		<div class="title">
  			<h1 class="title">
  				<a href="{$oCompany->getUrlFull()}" class="blog_headline_group">{$oCompany->getName()|escape:'html'}</a>
  			</h1>
  			<div class="groups_topic_text">
				{$oCompany->getDescription()}
			</div>
			<br>	
      		<div style="clear: left;"></div>
			<ul class="tags">
				{$oCompany->getTagsLink()}					
			</ul>
   			<ul class="voting">
     			<li class="total"> 
     				<span class="padd_1">
     					<span style="padding-left: 4px; font-size: 11px; color: {if $oCompany->getRating()<0}#d00000{else}#008000{/if};" id="topic_rating_{$oCompany->getId()}" title="{if $oCompany->getCountVote()==0}{$aLang.topic_vote_no}{else}{$aLang.topic_vote_count}: {$oCompany->getCountVote()}{/if}">{$oCompany->getRating()}</span>
     				</span>
     			</li>
     			<li class="date">
     				<a href="#" title="{$aLang.topic_date}" onclick="return false;"><span>{date_format date=$oCompany->getDateAdd()}</span></a>
     			</li>         			   
          		<li class="comments-total">
          			{if $oCompany->getCountFeedback()>0}
          				<a href="{$oCompany->getUrlFull()}/feedbacks/#feedbacks" title="{$aLang.company_feedbacks_read_feedback}"><span class="red">{$oCompany->getCountFeedback()}</span></a>
          			{else}
          				<a href="{$oCompany->getUrlFull()}/feedbacks/#feedbacks" title="{$aLang.company_feedbacks_write_feedback}"><span class="red">{$aLang.company_feedbacks_write_feedback}</span></a>
          			{/if}
          		</li>
        	</ul>
 		</div>
	</div>
	{/foreach}	
	
    {include file='paging.tpl' aPaging=`$aPaging`}			
	
{else}
{$aLang.company_notfound_companies}
{/if}		
	
</DIV>