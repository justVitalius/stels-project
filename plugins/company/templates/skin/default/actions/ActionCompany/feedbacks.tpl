{if $oUserCurrent}
	{include file='header.tpl' menu='company' showUpdateButton=true}
{else}
	{include file='header.tpl' menu='company'}
{/if}

{include file="../plugins/company/templates/skin/default/header.company.tpl"}
						
			{include 
				file='../plugins/company/templates/skin/default/feedback_tree.tpl' 	
				iTargetId=$oCompany->getId()
				sTargetType='company'
				iCountComment=$oCompany->getCountFeedback()
				sDateReadLast=$oCompany->getDateRead()
				bAllowNewComment=0
				sNoticeNotAllow=$aLang.topic_comment_notallow
				sNoticeCommentAdd=$aLang.topic_comment_add
			}	
	
{include file='footer.tpl'}
