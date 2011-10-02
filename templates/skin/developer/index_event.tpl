{ foreach from=$aEvents item=oEvent }

	{assign var="oEventBlog" value=$oEvent->getBlog() }
	

    
   <div class="event"> 
   <p class="title-event"><a href="/blog/events/">Ближайшее событие</a></p>  
   <a href="/blog/events/{ $oEvent->getId() }.html"><img class="preview" src="{if $oEvent->getTopicPreview()}{$oEvent->getTopicPreviewPath(590,360)}{/if}" /></a>
   <div class="blog-name-ugol"><div class="blog-name"><a href="/blog/events/{ $oEvent->getId() }.html" >{ $oEvent->getTitle() }</a></div></div> 
   </div> 
 
{ /foreach }

  <div class="clear"></div>

