
{if $aPaging and $aPaging.iCountPage>1} 

	<div class="pagination">
		<ul>			
			<!-- {if $aPaging.iPrevPage}
							<li class='prev-page'><a href="{$aPaging.sBaseUrl}/page{$aPaging.iPrevPage}/{$aPaging.sGetParams}">&nbsp;</a></li>
						{else}
							<li class='prev-page'>&nbsp;</li>
						{/if} -->
			
			
			{*if $aPaging.iCurrentPage>1*}<li class='first-page'><a href="{$aPaging.sBaseUrl}/{$aPaging.sGetParams}">&nbsp;</a></li>{*/if*}

			
			{foreach from=$aPaging.aPagesLeft item=iPage name=before}
				<li class='i-page {if $smarty.foreach.before.first}first{/if}'><a href="{$aPaging.sBaseUrl}/page{$iPage}/{$aPaging.sGetParams}">{$iPage}</a></li>
			{/foreach}
			
			{if !$aPaging.aPagesLeft}
			<li class="active-page first"><a>{$aPaging.iCurrentPage}</a></li>
			{else}
			{if !$aPaging.aPagesRight}
			<li class="active-page last"><a>{$aPaging.iCurrentPage}</a></li>
			{else}
			<li class="active-page i-page"><a>{$aPaging.iCurrentPage}</a></li>
			{/if}
			{/if}
			
			{foreach from=$aPaging.aPagesRight item=iPage name=after}
				<li class='i-page {if $smarty.foreach.after.last}last{/if}'><a href="{$aPaging.sBaseUrl}/page{$iPage}/{$aPaging.sGetParams}">{$iPage}</a></li>
			{/foreach}
			
			
			{*if $aPaging.iCurrentPage<$aPaging.iCountPage*}<li class='last-page'><a href="{$aPaging.sBaseUrl}/page{$aPaging.iCountPage}/{$aPaging.sGetParams}">&nbsp;</a></li>{*/if*}


			<!-- {if $aPaging.iNextPage}
							<li class='next-page'><a href="{$aPaging.sBaseUrl}/page{$aPaging.iNextPage}/{$aPaging.sGetParams}">&nbsp;</a></li>
						{else}
							<li class='next-page'>&nbsp;</li>
						{/if} -->
		</ul>
		<div class="clear"></div>
	</div>
{/if}