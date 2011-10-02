<div class="block blogs">
				<div class="tl"><div class="tr"></div></div>
				<div class="cl"><div class="cr">
	<h2>{$aLang.adunits_block_title}</h2>

	<div class="block-content">

  {foreach from=$aAdunits item=oAdunits name="cmt"}

                {$oAdunits->getAdunitsCode()}

	{/foreach}

  </div>
				</div></div>
				<div class="bl"><div class="br"></div></div>
			</div>
