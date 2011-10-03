{foreach from=$aBanners item=oBanner}
        <a class="top-banner" style="font-size:15px;display:block;" href="{router page='banneroid'}redirect/{$oBanner->getBannerId()}/1/"><img src="{$sBannersPath}{$oBanner->getBannerImage()}" width="330" height="380"/></a>
{/foreach}
