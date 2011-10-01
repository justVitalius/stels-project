{include file='header.tpl' menu='settings'}
<script type="text/javascript" src="{$sTemplateWebPathPlugin}/js/category.js"></script>

<h2>{$aLang.cat_title}</h2>

<div style="position:relative;">
    <div style="display: none;" id="window_edit_form_null">
	<div class="login-popup upload-image" id="window_edit_form">
	    <div class="content">
		<form method="POST" action="" enctype="multipart/form-data" id="form_edit" >
		    <input type="hidden" name="category_id" id="e_category_id" value="">
		    <h3>{$aLang.cat_edit_title}</h3>
		    <p><label for="category_parent">{$aLang.cat_parent}:</label><br />
			<select name="parent_id" id="edit-category" class="w100p">
			    {include file="$sTemplatePathPlugin/option.category_toggle.tpl"}
			</select>
		    </p>
		    <p><label for="category_title">{$aLang.cat_title}:</label><br /><input  type="text" name="category_title" id="e_category_title" value="" class="w100p"/></p>
		    <p><label for="category_url">{$aLang.cat_url}:</label><br /><input type="text" name="category_url" id="e_category_url" value="" class="w100p" /></p>
		    <input type="button" value="{$aLang.cat_save}" onclick="ls.category.upd('{$sType}');">
		    <input type="button" value="{$aLang.cat_cancel}" onclick="ls.category.hide();">
		</form>
	    </div>
	</div>
    </div>

    <form action="" method="post" enctype="multipart/form-data" name="form_category" id="form_category" onsubmit="return false">
	<input type="hidden" name="target_type" value="{$sType}" />
	<p>
	    <label for="category_parent">{$aLang.cat_parent}</label><br />
	    <select name="parent_id" class="input-200" id="option-category">
		{include file="$sTemplatePathPlugin/option.category_toggle.tpl"}
	    </select>
	</p>
	<p>
	    <label for="category_title">{$aLang.cat_creat_title}</label><br/>
	    <input type="text" name="category_title" value="" class="input-200" /><br/>
	    <span class="note">{$aLang.settings_cat_title_notice}</span>
	</p>
	<p>
	    <label for="category_url">{$aLang.cat_url}</label><br/>
	    <input type="text" name="category_url" value="" class="input-200" /><br/>
	    <span class="note">{$aLang.settings_cat_url_notice}</span>
	</p>
	<input type="button" name="category_save" value="{$aLang.cat_send_form}" onclick="ls.category.save('{$sType}');">
    </form>
</div>

{include file='footer.tpl'}
