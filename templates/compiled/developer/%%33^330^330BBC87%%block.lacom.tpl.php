<?php /* Smarty version 2.6.19, created on 2011-09-09 14:53:27
         compiled from block.lacom.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'block.lacom.tpl', 13, false),array('modifier', 'truncate', 'block.lacom.tpl', 13, false),array('function', 'router', 'block.lacom.tpl', 18, false),)), $this); ?>
<div class="block lacom">
	<h3>Последние комментарии</h3>
	
	<div class="block-content">		
		<ul id="live">
			<?php $_from = $this->_tpl_vars['aComments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cmt'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cmt']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oComment']):
        $this->_foreach['cmt']['iteration']++;
?>
				<?php $this->assign('oUser', $this->_tpl_vars['oComment']->getUser()); ?>
				<?php $this->assign('oTopic', $this->_tpl_vars['oComment']->getTarget()); ?>
				<?php $this->assign('oBlog', $this->_tpl_vars['oTopic']->getBlog()); ?>
				<?php $this->assign('sFirstLine', $this->_tpl_vars['oComment']->getText()); ?>

				<li class="air-comment">
					<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
" class="who"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a>&nbsp;&rarr;&nbsp;<a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
#comment<?php echo $this->_tpl_vars['oComment']->getId(); ?>
" class="topic"><?php echo ((is_array($_tmp=$this->_tpl_vars['oTopic']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>&nbsp;&rarr;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['sFirstLine'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 42, '...') : smarty_modifier_truncate($_tmp, 42, '...')); ?>

				</li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>

		<a href="<?php echo smarty_function_router(array('page' => 'comments'), $this);?>
" class="all-comments">Все комментарии</a>
	</div>
</div>