<?php /* Smarty version 2.6.19, created on 2011-09-30 18:08:19
         compiled from notify/russian/notify.comment_new.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'notify/russian/notify.comment_new.tpl', 1, false),array('function', 'cfg', 'notify/russian/notify.comment_new.tpl', 6, false),)), $this); ?>
Пользователь <a href="<?php echo $this->_tpl_vars['oUserComment']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUserComment']->getLogin(); ?>
</a> оставил новый комментарий к вашему топику <b>«<?php echo ((is_array($_tmp=$this->_tpl_vars['oTopic']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
»</b>, прочитать его можно перейдя по <a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
#comment<?php echo $this->_tpl_vars['oComment']->getId(); ?>
">этой ссылке</a><br>							
<?php if ($this->_tpl_vars['oConfig']->GetValue('sys.mail.include_comment')): ?>
	Текст сообщения: <i><?php echo $this->_tpl_vars['oComment']->getText(); ?>
</i>				
<?php endif; ?>				
<br><br>
С уважением, администрация сайта <a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
"><?php echo smarty_function_cfg(array('name' => 'view.name'), $this);?>
</a>