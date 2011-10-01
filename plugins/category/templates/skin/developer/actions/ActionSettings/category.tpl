{include file='header.tpl' menu='settings' showWhiteBack=true}
<script type="text/javascript" src="{$sTemplateWebPathPlugin}/js/category.js"></script>

<h1>{$aLang.cat_title}</h1>

<div style="position:relative;">
    <div style="display: none;">
	<div class="login-popup upload-image" id="window_edit_form">
	    <div class="login-popup-top"><a href="#" class="close-block" onclick="return false;"></a></div>
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
		    <input type="button" value="{$aLang.cat_save}" onclick="lsCategoryTree.Upd(document.getElementById('form_edit'),'{$sType}');">
		    <input type="button" value="{$aLang.cat_cancel}" onclick="lsCategoryTree.hideFormEdit();">
		</form>
	    </div>
	    <div class="login-popup-bottom"></div>
	</div>
    </div>

    <form action="" method="post" enctype="multipart/form-data" name="form_category" id="form_category" onsubmit="return false">
	<input type="hidden" name="target_type" value="{$sType}" />
	<p>
	    <label for="category_parent">{$aLang.cat_parent}</label><br />
	    <select name="parent_id" class="w100p" id="option-category">
		{include file="$sTemplatePathPlugin/option.category_toggle.tpl"}
	    </select>
	</p>
	<p>
	    <label for="category_title">{$aLang.cat_creat_title}</label>
	    <input type="text" name="category_title" value="" class="w100p" />
	    <span class="form_note">{$aLang.settings_cat_title_notice}</span>
	</p>
	<p>
	    <label for="category_url">{$aLang.cat_url}:</label>
	    <input type="text" name="category_url" value="" class="w100p" />
	    <span class="form_note">{$aLang.settings_cat_url_notice}</span>
	</p>
	<input type="button" name="category_save" value="{$aLang.cat_send_form}" onclick="lsCategoryTree.Add(document.getElementById('form_category'),'{$sType}');">
    </form>
</div>

{include file='footer.tpl'}
