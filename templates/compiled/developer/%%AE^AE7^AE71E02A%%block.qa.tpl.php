<?php /* Smarty version 2.6.19, created on 2011-10-02 16:27:42
         compiled from block.qa.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'block.qa.tpl', 7, false),)), $this); ?>
<div class="block qa">
	<h3>Вопросы и ответы</h3>
	<ul>
	<?php $_from = $this->_tpl_vars['aTopics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['qa'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['qa']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oTopic']):
        $this->_foreach['qa']['iteration']++;
?>
		<?php $this->assign('oUser', $this->_tpl_vars['oTopic']->getUser()); ?>
		<li>
			<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
" class="who"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a>&nbsp;&rarr;&nbsp;<a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
" class="topic"><?php echo ((is_array($_tmp=$this->_tpl_vars['oTopic']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>&nbsp;<?php echo $this->_tpl_vars['oTopic']->getCountComment(); ?>

		</li>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
	<?php $this->assign('oBlog', $this->_tpl_vars['oTopic']->getBlog()); ?>
	<a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
" class="all-questions">Все вопросы</a>
</div>