{if isset($oBlog) & !isset($sSelectedCategory)}
{assign var="sSelectedCategory" value=$oBlog->getCategory()}
{/if}


<div class="block categorize">
	<div class="tl"><div class="tr"></div></div>
	<div class="cl"><div class="cr">
	<div class="block-content">
	{if isset($smarty.get.cat)}
	<p> <h1  style="padding: 0 0 0 0; float:none; clear: none; margin-bottom: 0;">{$aLang.categorize_block_filter}</h1>
	<a href='{router page=$tgt}' style="position:relative; float:none; padding: 0 0 0 0;">{$aLang.categorize_block_filter_kill_all}</a>
	</p>
	<ul>
	<!--BLOG CATEGORY-->
	{if isset($aFilter.category)}
	<strong>{$aLang.categorize_block_blog_category}:</strong>
	{foreach from=$aFilter.category item=filteritem}
	{assign var=val value=$filteritem.value}
		<a href='{router page=$tgt}?{$filteritem.kill}' title='{$aLang.categorize_block_filter_kill}'>{$aLang.categorize_blog_categories.$val}</a>
	{/foreach}
	<br>
	{/if}
	<!--END OF FILTER-->
	{/if}
		<h1>{$aLang.categorize_block_blog_category}</h1>
				<ul class="categorize_content">
					{foreach from=$aCategories item=aGoodsType}
						{assign var="name" value=$aGoodsType.Item}
						{if !$hideNull or $aCategoryCount.$name!=0 }
						<li {if $sSelectedCategory==$name}class="even"{/if}>
						<a href="{router page=$tgt}?cat[]={$name}" class="stream-category" style="padding: 0 0 0 {$aGoodsType.Level*20}pt">{$aLang.categorize_blog_categories.$name}</a>
						{if !isset($aFilter.category)||!in_array($name,$aSelectedCategories)}
						<span><a href="{router page=$tgt}?{$aGet.get}&cat[]={$name}">+</a></span>
						{else}
						<span><a href="{router page=$tgt}?{$aGet.get}&cat[]={$name}"></a></span>
						{/if}
						</li>
						{/if}
					{/foreach}							
				</ul>
			</div>
		</div>
	</div>
	<div class="bl">
		<div class="br">
		</div>
	</div>
</div>

