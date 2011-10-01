<div class="block blogs">		
	<div class="tl"><div class="tr"></div></div>
	<div class="cl"><div class="cr">
		<h1>{$aLang.block_company}</h1>	
		<div class="block-content">	
		<ul class="list">
			{foreach from=$aCompany item=oCompany}
				<li><div class="total">{$oCompany->getRating()}</div><img src="{$oCompany->getLogoPath(24)}" alt="" width="16" style='vertical-align:middle' />&nbsp;<a href="{$oCompany->getUrlFull()}/" class="stream-author">{$oCompany->getName()|escape:'html'}</a></li>						
			{/foreach}
		</ul>	
		</div>	
		<div class="right"><a href="{router page='company'}">{$aLang.block_company_allcompanies}</a></div>
	</div></div>
	<div class="bl"><div class="br"></div></div>		
</div>

						