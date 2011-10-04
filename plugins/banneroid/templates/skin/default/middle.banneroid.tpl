{foreach from=$aBanners item=oBanner}
        <a class="muddle-banner" style="font-size:15px;display:block;padding-bottom:15px; padding-left:15px; " href="{router page='banneroid'}redirect/{$oBanner->getBannerId()}/1/"><img src="{$sBannersPath}{$oBanner->getBannerImage()}" width="900" height="125"/></a>
{/foreach}
	