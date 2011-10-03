{foreach from=$aBanners item=oBanner}
        <a class="muddle-banner" style="font-size:15px;display:block;" href="{router page='banneroid'}redirect/{$oBanner->getBannerId()}/1/"><img src="{$sBannersPath}{$oBanner->getBannerImage()}" width="920" height="125"/></a>
{/foreach}
	