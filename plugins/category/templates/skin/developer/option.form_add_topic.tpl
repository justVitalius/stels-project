<p><label for="topic_title">{$aLang.cat_parent}:</label><br />
      <select name="category_id" class="w100p" id="option-category">
<option value="0">{$aLang.cat_select}</option>
        {if $aCategory}
        {foreach from=$aCategory item=oCategory name=cat}
        {include file="$sTemplatePathPlugin/option.tpl" level=0}
        {/foreach}
        {/if}
      </select>
      </p>
