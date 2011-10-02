<?php /* Smarty version 2.6.19, created on 2011-09-30 15:35:36
         compiled from menu.talk.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'menu.talk.tpl', 4, false),array('function', 'hook', 'menu.talk.tpl', 7, false),)), $this); ?>
<h2><?php echo $this->_tpl_vars['aLang']['talk_menu_inbox']; ?>
</h2>

<ul class="switcher">					
	<li <?php if ($this->_tpl_vars['sEvent'] == 'inbox'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['talk_menu_inbox_list']; ?>
</a></li>
	<li <?php if ($this->_tpl_vars['sEvent'] == 'add'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
add/"><?php echo $this->_tpl_vars['aLang']['talk_menu_inbox_create']; ?>
</a></li>
	<li <?php if ($this->_tpl_vars['sEvent'] == 'favourites'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
favourites/"><?php echo $this->_tpl_vars['aLang']['talk_menu_inbox_favourites']; ?>
<?php if ($this->_tpl_vars['iCountTalkFavourite']): ?> (<?php echo $this->_tpl_vars['iCountTalkFavourite']; ?>
)<?php endif; ?></a></li>
	<?php echo smarty_function_hook(array('run' => 'menu_talk_talk_item'), $this);?>
	
</ul>
<?php echo smarty_function_hook(array('run' => 'menu_talk'), $this);?>