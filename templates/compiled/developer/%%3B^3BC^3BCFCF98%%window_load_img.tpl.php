<?php /* Smarty version 2.6.19, created on 2011-09-30 15:22:03
         compiled from window_load_img.tpl */ ?>
<div class="upload-form" id="window_load_img">
	<a href="#" class="close" onclick="hideImgUploadForm(); return false;"></a>
	<div class="content">
		<form method="POST" action="" enctype="multipart/form-data" id="form_upload_img">
			<h3><?php echo $this->_tpl_vars['aLang']['uploadimg']; ?>
</h3>

			<p><label><?php echo $this->_tpl_vars['aLang']['uploadimg_file']; ?>
:<br />
			<input type="file" name="img_file" value="" class="input-wide" /></label></p>

			<p><label><?php echo $this->_tpl_vars['aLang']['uploadimg_url']; ?>
:
			<input type="text" name="img_url" value="http://" class="input-wide" /></label></p>

			<p><label for="align"><?php echo $this->_tpl_vars['aLang']['uploadimg_align']; ?>
:</label>
			<select name="align" class="input-wide">
				<option value=""><?php echo $this->_tpl_vars['aLang']['uploadimg_align_no']; ?>
</option>
				<option value="left"><?php echo $this->_tpl_vars['aLang']['uploadimg_align_left']; ?>
</option>
				<option value="right"><?php echo $this->_tpl_vars['aLang']['uploadimg_align_right']; ?>
</option>
			</select></p>

			<p><label><?php echo $this->_tpl_vars['aLang']['uploadimg_title']; ?>
:<br />
			<input type="text" class="input-wide" name="title" value="" /></label></p>

			<input type="button" value="<?php echo $this->_tpl_vars['aLang']['uploadimg_submit']; ?>
" onclick="ajaxUploadImg(document.getElementById('form_upload_img'),'<?php echo $this->_tpl_vars['sToLoad']; ?>
');" />
			<input type="button" value="<?php echo $this->_tpl_vars['aLang']['uploadimg_cancel']; ?>
" onclick="hideImgUploadForm(); return false;" />
		</form>
	</div>
</div>