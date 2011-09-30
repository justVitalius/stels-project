<?php /* Smarty version 2.6.19, created on 2011-09-09 14:53:27
         compiled from block.news.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'block.news.tpl', 6, false),)), $this); ?>
<div class="block news">
	<h3>Новости</h3>
	<ul>
	<?php $_from = $this->_tpl_vars['aTopics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['news'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['news']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oTopic']):
        $this->_foreach['news']['iteration']++;
?>
		<li>
			<?php echo $this->_foreach['news']['iteration']; ?>
.&nbsp;<a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['oTopic']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
		</li>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
	<?php $this->assign('oBlog', $this->_tpl_vars['oTopic']->getBlog()); ?>
	<a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
" class="all-news">Все новости</a>
</div>