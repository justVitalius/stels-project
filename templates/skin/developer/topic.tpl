{assign var="oBlog" value=$oTopic->getBlog()}
{assign var="oUser" value=$oTopic->getUser()}
{assign var="oVote" value=$oTopic->getVote()} 


{if ($sAction=='blog') } { assign var="yesMyBlog" value=true  } {/if}
{if ($sEvent=='events') } { assign var="yesEvetns" value=true  } {/if}
<div class="topic {if $noSidebar} main {/if} { if $yesMyBlog} blog-ugol {/if}"> 

  {if ($sEvent=='events')} <div class="date-topic"><p class="date-day-topic">{date_format date=$oTopic->getDateAdd() format="d.m"}</p><p class="day-topic">{date_format date=$oTopic->getDateAdd() format="l"}</p></div>{/if}
 {if ($sEvent=='events')}<div class="title-topic"> {/if}
   {if $noSidebar}<div class="post-img"> <img class="preview" src="{if $oTopic->getTopicPreview()}{$oTopic->getTopicPreviewPath(280,280)}{/if}">
   <div class="blog-name-ugol "><div class="blog-name"><a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a></div></div> </div>
   {/if}
   {if !$noSidebar} {if !$yesEvetns}<div class="blog-name-ugol {if ($yesMyBlog and !($yesEvetns))} blog-ugol {/if}"><div class="blog-name"><a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a></div></div>{/if}{/if}
  	<h2 class="title {if (yesMyBlog and !($yesEvetns))} {if !$noSidebar} blog-ugol {/if} {/if}">
  	{if !($noSidebar or ($sEvent=='events') or yesMyBlog ) }	<a href="{$oBlog->getUrlFull()}" class="title-blog">{$oBlog->getTitle()|escape:'html'}</a>
  		<span class='lightning'></span> 
  	{/if}
  		{if $oTopic->getPublish()==0}	
  			<img src="{cfg name='path.static.skin'}/images/draft.png" title="{$aLang.topic_unpublish}" alt="{$aLang.topic_unpublish}" />
  		{/if}
  		{if $oTopic->getType() == 'link'}<img src="{cfg name='path.static.skin'}/images/topic_link.png" title="{$aLang.topic_link}" alt="{$aLang.topic_link}" />{/if}
  		<a href="{if $oTopic->getType()=='link'}{router page='link'}go/{$oTopic->getId()}/{else}{$oTopic->getUrl()}{/if}" class="title-topic">{$oTopic->getTitle()|escape:'html'}</a>
  	</h2>
  	{ if !($yesMyBlog or  ($sEvent=='events') or ($sAction=='blog'))} {* определяем что за страница если страница не профиль то выводим статусы здесь *}
  	<ul class="user-info">
      <li class="username lamp {if $oUserCurrent}{if $oUserCurrent->getId()==$oTopic->getUserId()}active{/if}{/if}"><a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></li> 
      <li class="date">{date_format date=$oTopic->getDateAdd()}</li>
    </ul>
    {/if}
  	<ul class="actions">									
  		{if $oUserCurrent and ($oUserCurrent->getId()==$oTopic->getUserId() or $oUserCurrent->isAdministrator() or $oBlog->getUserIsAdministrator() or $oBlog->getUserIsModerator() or $oBlog->getOwnerId()==$oUserCurrent->getId())}
  			<li><a href="{cfg name='path.root.web'}/{$oTopic->getType()}/edit/{$oTopic->getId()}/" title="{$aLang.topic_edit}" class="edit">{$aLang.topic_edit}</a></li>
  		{/if}
  		{if $oUserCurrent and ($oUserCurrent->isAdministrator() or $oBlog->getUserIsAdministrator() or $oBlog->getOwnerId()==$oUserCurrent->getId())}
  			<li><a href="{router page='topic'}delete/{$oTopic->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" title="{$aLang.topic_delete}" onclick="return confirm('{$aLang.topic_delete_confirm}');" class="delete">{$aLang.topic_delete}</a></li>
  		{/if}
  	</ul>
 {if ($sEvent=='events')} </div>{/if}

{if ($sEvent=='events')}<div class="clear"></div>{/if}
	<div class="content {if ($sEvent=='events')} content-plus{/if}">
	 {*<img class="preview" src="{if $oTopic->getTopicPreview()}{$oTopic->getTopicPreviewPath(280,280)}{/if}">
	  <img class="preview" src="{if $oTopic->getTopicPreview()}{$oTopic->getTopicPreviewPath(590,360)}{/if}"> *}

	  
		{if $oTopic->getType()=='question'}
			<div id="topic_question_area_{$oTopic->getId()}" class="poll">
				{if !$oTopic->getUserQuestionIsVote()}
					<ul class="poll-vote">
						{foreach from=$oTopic->getQuestionAnswers() key=key item=aAnswer}
							<li><label><input type="radio" id="topic_answer_{$oTopic->getId()}_{$key}" name="topic_answer_{$oTopic->getId()}" value="{$key}" onchange="$('topic_answer_{$oTopic->getId()}_value').setProperty('value',this.value);" /> {$aAnswer.text|escape:'html'}</label></li>
						{/foreach}
					</ul>

					<input type="submit" value="{$aLang.topic_question_vote}" onclick="ajaxQuestionVote({$oTopic->getId()},$('topic_answer_{$oTopic->getId()}_value').getProperty('value'));" />
					<input type="submit" value="{$aLang.topic_question_abstain}" onclick="ajaxQuestionVote({$oTopic->getId()},-1)" />
					<input type="hidden" id="topic_answer_{$oTopic->getId()}_value" value="-1" />
				{else}
					{include file='topic_question.tpl'}
				{/if}
			</div>
		{/if}

		{if !$tSingle}
			{$oTopic->getTextShort()}
			{if $oTopic->getTextShort()!=$oTopic->getText()}
				<a href="{$oTopic->getUrl()}" title="{$aLang.topic_read_more}" class="readmore">
				{if $oTopic->getCutText()}
					{$oTopic->getCutText()}
				{else}
					читать дальше...
				{/if}      			
				</a>
			{/if}
		{else}
			{$oTopic->getText()}
		{/if}
	</div>	



	<ul class="tags">
		{foreach from=$oTopic->getTagsArray() item=sTag name=tags_list}
			<li><a href="{router page='tag'}{$sTag|escape:'html'}/">{$sTag|escape:'html'}</a>{if !$smarty.foreach.tags_list.last}, {/if}</li>
		{/foreach}								
	</ul>



	<ul class="info" style="{ if $yesMyBlog or ($sEvent=='events') } float:left; {/if}">
	 
		<li class="voting {if $oVote || ($oUserCurrent && $oTopic->getUserId()==$oUserCurrent->getId()) || strtotime($oTopic->getDateAdd())<$smarty.now-$oConfig->GetValue('acl.vote.topic.limit_time')}{if $oTopic->getRating()>0}positive{elseif $oTopic->getRating()<0}negative{/if}{/if} {if !$oUserCurrent || $oTopic->getUserId()==$oUserCurrent->getId() || strtotime($oTopic->getDateAdd())<$smarty.now-$oConfig->GetValue('acl.vote.topic.limit_time')}guest{/if}{if $oVote} voted {if $oVote->getDirection()>0}plus{elseif $oVote->getDirection()<0}minus{/if}{/if}">
			<span class="total"><span class="t-value" title="{$aLang.topic_vote_count}: {$oTopic->getCountVote()}">{if $oVote || ($oUserCurrent && $oTopic->getUserId()==$oUserCurrent->getId()) || strtotime($oTopic->getDateAdd())<$smarty.now-$oConfig->GetValue('acl.vote.topic.limit_time')} {if $oTopic->getRating()>0}+{/if}{$oTopic->getRating()} {else} <a href="#" onclick="lsVote.vote({$oTopic->getId()},this,0,'topic'); return false;">&mdash;</a> {/if}</span></span>

			<a href="#" class="plus" onclick="lsVote.vote({$oTopic->getId()},this,1,'topic'); return false;"></a>
			<a href="#" class="minus" onclick="lsVote.vote({$oTopic->getId()},this,-1,'topic'); return false;"></a>
		</li>
		{if !$tSingle}
			<li class="comments-link">
				{if $oTopic->getCountComment()>0}
					<a href="{$oTopic->getUrl()}#comments" title="{$aLang.topic_comment_read}"><span>{$oTopic->getCountComment()}</span></a>
				{else}
					<a href="{$oTopic->getUrl()}#comments" title="{$aLang.topic_comment_add}"><span>0</span></a>
				{/if}
			</li>
		{/if}
		
		{if $oTopic->getType()=='link'}
			<li><a href="{router page='link'}go/{$oTopic->getId()}/" title="{$aLang.topic_link_count_jump}: {$oTopic->getLinkCountJump()}">{$oTopic->getLinkUrl(true)}</a></li>
		{/if}
		{hook run='topic_show_info' topic=$oTopic}
	</ul>

	{ if $yesMyBlog or ($sEvent=='events')  } {* определяем что за страница если страница не профиль то выводим статусы здесь *}
  <ul class="user-info profile">
    <li class="username lamp {if $oUserCurrent}{if $oUserCurrent->getId()==$oTopic->getUserId()}active{/if}{/if}"><a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></li> 
   {if !($sEvent=='events')} <li class="date">{date_format date=$oTopic->getDateAdd()}</li>{/if}
  </ul>
  {/if}
	{if $tSingle}
		{*{hook run='topic_show_end' topic=$oTopic} *}

	{/if}
</div>