<p>
<label for="blog_category">{$aLang.categorize_blog_add_category}:</label>
					<select name="blog_category" id="blog_category" onChange="" style="width : 200px;">
						{foreach from=$aCategories item=oCategory}
						{assign var='name' value=$oCategory.Item}
						
						<option  {if !$bAllowParentCategory and $oCategory.haschildren>0 }disabled="disabled" {/if} value="{$name}" {if $_aRequest.blog_category==$name}selected{/if}>
							{section name='space' start=0 loop=$oCategory.Level}-{/section}
							{$aLang.categorize_blog_categories.$name}</option>
						{/foreach}
     				</select>
     				</p>