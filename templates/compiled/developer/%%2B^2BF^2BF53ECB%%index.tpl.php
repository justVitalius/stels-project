<?php /* Smarty version 2.6.19, created on 2011-10-02 13:23:41
         compiled from actions/ActionIndex/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hook', 'actions/ActionIndex/index.tpl', 13, false),)), $this); ?>

<?php $this->assign('noSidebar', true); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'blog')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<?php if (noSidebar): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'index_event.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'topic_list.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php echo smarty_function_hook(array('run' => 'index_show_top','topic' => $this->_tpl_vars['oTopic']), $this);?>

		<?php echo smarty_function_hook(array('run' => 'index_show_middle','topic' => $this->_tpl_vars['oTopic']), $this);?>

		<?php echo smarty_function_hook(array('run' => 'index_show_end','topic' => $this->_tpl_vars['oTopic']), $this);?>
	
		
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

