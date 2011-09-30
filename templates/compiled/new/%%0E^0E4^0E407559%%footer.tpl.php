<?php /* Smarty version 2.6.19, created on 2011-08-21 23:04:59
         compiled from footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hook', 'footer.tpl', 1, false),array('function', 'router', 'footer.tpl', 14, false),array('function', 'cfg', 'footer.tpl', 16, false),)), $this); ?>
		<?php echo smarty_function_hook(array('run' => 'content_end'), $this);?>

		</div>
		<!-- /Content -->
		<?php if (! $this->_tpl_vars['bNoSidebar']): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'sidebar.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>
		
	</div>

	<!-- Footer -->
	<div id="footer">
		<div class="right">
			© Powered by <a href="http://livestreetcms.ru" title="Free social engine">«LiveStreet»</a><br />
			<a href="<?php echo smarty_function_router(array('page' => 'page'), $this);?>
about/"><?php echo $this->_tpl_vars['aLang']['page_about']; ?>
</a>
		</div>
		Design by — <a href="http://www.xeoart.com/">Студия XeoArt</a>&nbsp;<img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/xeoart.gif" border="0">
	</div>
	<!-- /Footer -->

</div>
<?php echo smarty_function_hook(array('run' => 'body_end'), $this);?>

</body>
</html>