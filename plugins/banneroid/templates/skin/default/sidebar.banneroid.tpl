{foreach from=$aBanners item=oBanner}
        <a class="sidebar-banner" style="font-size:15px;display:block;" href="{router page='banneroid'}redirect/{$oBanner->getBannerId()}/1/"><img src="{$sBannersPath}{$oBanner->getBannerImage()}" width="210" height="315"/></a>
{/foreach}
