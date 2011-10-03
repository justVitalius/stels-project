{ foreach from=$aEvents item=oEvent }

	{assign var="oEventBlog" value=$oEvent->getBlog() }
	

    
   <div class="event"> 
   <p class="title-event"><a href="/blog/events/">Ближайшее событие</a></p>  

   <a href="/blog/events/{ $oEvent->getId() }.html"><img class="preview" src="{if $oEvent->getTopicPreview()}{$oEvent->getTopicPreviewPath(590,360)}{else}/templates/skin/developer/images/defaults/meeting_590x360.jpg{/if}" /></a>

   <div class="blog-name-ugol"><div class="blog-name"><a href="/blog/events/{ $oEvent->getId() }.html" >{ $oEvent->getTitle() }</a></div></div> 
   </div> 
 
{ /foreach }
{hook run='index_show_top' topic=$oTopic}
  <div class="clear"></div>

