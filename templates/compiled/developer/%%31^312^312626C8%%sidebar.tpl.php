<?php /* Smarty version 2.6.19, created on 2011-10-02 14:17:58
         compiled from actions/ActionProfile/sidebar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionProfile/sidebar.tpl', 5, false),)), $this); ?>
<?php if ($this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oUserCurrent']->getId() != $this->_tpl_vars['oUserProfile']->getId()): ?>
	<div class="block friender">				
		<ul>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'actions/ActionProfile/friend_item.tpl', 'smarty_include_vars' => array('oUserFriend' => $this->_tpl_vars['oUserProfile']->getUserFriend())));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<li><a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
add/?talk_users=<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
"><?php echo $this->_tpl_vars['aLang']['user_write_prvmsg']; ?>
</a></li>						
		</ul>
	</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['oUserProfile']->getProfileFoto()): ?>
<div class="block">
	<h3>Фото</h3>	
	<img src="<?php echo $this->_tpl_vars['oUserProfile']->getProfileFoto(); ?>
" alt="photo" class="photo" />
</div>
<?php endif; ?>