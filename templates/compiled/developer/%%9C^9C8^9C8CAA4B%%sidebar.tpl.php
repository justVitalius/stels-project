<?php /* Smarty version 2.6.19, created on 2011-10-03 00:48:12
         compiled from sidebar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'sidebar.tpl', 7, false),array('function', 'hook', 'sidebar.tpl', 18, false),array('insert', 'block', 'sidebar.tpl', 51, false),)), $this); ?>
<div id="sidebar">
	<!-- Profile block -->
	<div class="block">
		<ul class="profile">
			<?php if ($this->_tpl_vars['oUserCurrent']): ?>
			<li><a href="<?php echo $this->_tpl_vars['oUserCurrent']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUserCurrent']->getLogin(); ?>
</a></li>
			<li><a href="<?php echo smarty_function_router(array('page' => 'topic'), $this);?>
add/">написать</a></li>

			<li><a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
add/">создать блог</a></li>

			<?php if ($this->_tpl_vars['iUserCurrentCountTalkNew']): ?>
			<li><a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
" title="<?php echo $this->_tpl_vars['aLang']['user_privat_messages_new']; ?>
">личные сообщения (<?php echo $this->_tpl_vars['iUserCurrentCountTalkNew']; ?>
)</a></li>
			<?php else: ?>
			<li><a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
">личные сообщения (<?php echo $this->_tpl_vars['iUserCurrentCountTalkNew']; ?>
)</a></li>
			<?php endif; ?>
			<li><a href="<?php echo smarty_function_router(array('page' => 'settings'), $this);?>
profile/">настройки</a></li>
			<li><a href="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
exit/?security_ls_key=<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
">выход</a></li>
			<?php echo smarty_function_hook(array('run' => 'userbar_item'), $this);?>

			<?php else: ?>
			<li><a href="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
" onclick="showLoginForm(); return false">вход</a></li>
			<li><a href="<?php echo smarty_function_router(array('page' => 'registration'), $this);?>
">регистрация</a></li>
			<?php endif; ?>
		</ul>
	</div>
	


	
	
			
	<!-- Other blocks -->
	<?php if (isset ( $this->_tpl_vars['aBlocks']['right'] )): ?>
		<?php $_from = $this->_tpl_vars['aBlocks']['right']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aBlock']):
?>
			<?php if ($this->_tpl_vars['aBlock']['type'] == 'block'): ?>
				<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'block', 'block' => ($this->_tpl_vars['aBlock']['name']), 'params' => ($this->_tpl_vars['aBlock']['params']))), $this); ?>

			<?php endif; ?>
			<?php if ($this->_tpl_vars['aBlock']['type'] == 'template'): ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['aBlock']['name']), 'smarty_include_vars' => array('params' => ($this->_tpl_vars['aBlock']['params']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
</div>