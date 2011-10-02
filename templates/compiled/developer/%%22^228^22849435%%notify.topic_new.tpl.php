<?php /* Smarty version 2.6.19, created on 2011-10-02 19:17:47
         compiled from notify/russian/notify.topic_new.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'notify/russian/notify.topic_new.tpl', 1, false),array('function', 'router', 'notify/russian/notify.topic_new.tpl', 1, false),array('function', 'cfg', 'notify/russian/notify.topic_new.tpl', 4, false),)), $this); ?>
Пользователь <a href="<?php echo $this->_tpl_vars['oUserTopic']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUserTopic']->getLogin(); ?>
</a> опубликовал в блоге <b>«<?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
»</b> новый топик -  <a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
.html"><?php echo ((is_array($_tmp=$this->_tpl_vars['oTopic']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><br>						
														
<br><br>
С уважением, администрация сайта <a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
"><?php echo smarty_function_cfg(array('name' => 'view.name'), $this);?>
</a>