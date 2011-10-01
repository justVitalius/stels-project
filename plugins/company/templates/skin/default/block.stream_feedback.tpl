				
					
					<ul class="stream-content">
						{foreach from=$aComments item=oComment name="cmt"}
							{assign var="oUser" value=$oComment->getUser()}
							{assign var="oCompany" value=$oComment->getTarget()}
							
							<li {if $smarty.foreach.cmt.iteration % 2 == 1}class="even"{/if}>
								<a href="{$oUser->getUserWebPath()}" class="stream-author">{$oUser->getLogin()}</a>&nbsp;&#8594;
								<span class="stream-comment-icon"></span><a href="{$oCompany->getUrlFull()}/feedbacks/#comment{$oComment->getId()}" class="stream-comment">{$oCompany->getCompanyName()|escape:'html'}</a>
								<span> {$oCompany->getCompanyCountFeedback()}</span>
							</li>
						{/foreach}
					</ul>

					<div class="right"><a href="{router page='comments'}">{$aLang.block_stream_comments_all}</a> | <a href="{router page='rss'}allcomments/">RSS</a></div>