{foreach from=$aBanners item=oBanner}
        <a style="font-size:15px;display:block; float:left;" href="{router page='banneroid'}redirect/{$oBanner->getBannerId()}/1/"><img src="{$sBannersPath}{$oBanner->getBannerImage()}" width="280" height="550"/></a>
{/foreach}
	