{ foreach from=$aEvents item=oEvent }

	{assign var="oEventBlog" value=$oEvent->getBlog() }
	
    title { $oEvent->getTitle() }
    img <img class="preview" src="{if $oEvent->getTopicPreview()}{$oEvent->getTopicPreviewPath(590,360)}{/if}" />
    
    <a href="/blog/events/{ $oEvent->getId() }.html">Link</a>	
     
{ /foreach }


