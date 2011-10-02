<p>
<label for="topic_preview" class="topic_preview-bigsize">{$aLang.preview_topic_preview}:</label><br />
{if !$oTopic}<span class="form_note">{$aLang.preview_topic_notice}</span><br />{/if}
{if $oTopic}
    {if $oTopic->getTopicPreview()}
        {foreach from=$oConfig->GetValue('plugin.preview.preview_size') item=iSize}
        <img src="{$oTopic->getTopicPreviewPath($iSize[0],$iSize[1])}">&#32;
        {/foreach}
        <input type="hidden" id="topic_preview_data" name="topic_preview_data" value="{$oTopic->getTopicPreview()}">
        <input type="checkbox" id="topic_preview_delete" name="topic_preview_delete" />&mdash; <label for="topic_preview_delete"><span class="form">{$aLang.settings_profile_avatar_delete}</span></label><br />
        <span class="form_note">{$aLang.preview_topic_notice_delete}</span>
    {/if}
{/if}
</p>

<label for="topic_preview_file">{$aLang.uploadimg_file}:</label><br />
<input type="file" name="topic_preview_file" id="topic_preview_file"><br />
<span class="form_note">{$aLang.preview_topic_notice_file}</span><br /><br />

<label for="topic_preview_link">{$aLang.uploadimg_url}:</label><br />
<input type="text"  class="w100p" name="topic_preview_link" id="topic_preview_link" value="" /><br />
<span class="form_note">{$aLang.preview_topic_notice_link}</span>
</p>
<br /><br />

