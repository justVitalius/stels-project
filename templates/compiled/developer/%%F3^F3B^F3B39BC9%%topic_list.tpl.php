<?php /* Smarty version 2.6.19, created on 2011-10-03 09:59:55
         compiled from topic_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hook', 'topic_list.tpl', 9, false),)), $this); ?>

<?php $this->assign('Top', "count(".($this->_tpl_vars['aTopics']).")"); ?>
<?php if (count ( $this->_tpl_vars['aTopics'] ) > 0): ?>
 <?php if ($this->_tpl_vars['noSidebar']): ?> <div  class="new-topic" ><div class="line-rezar"></div><div class="new-topic-text">Новое в блогах</div></div><?php endif; ?>
	 
	<?php $_from = $this->_tpl_vars['aTopics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fn'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fn']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oTopic']):
        $this->_foreach['fn']['iteration']++;
?>   
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'topic.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
		<?php if (($this->_foreach['fn']['iteration']-1) == 2): ?><div class="clear"></div><?php endif; ?>
<?php if (($this->_foreach['fn']['iteration']-1) == 5): ?> <?php echo smarty_function_hook(array('run' => 'index_show_middle','topic' => $this->_tpl_vars['oTopic']), $this);?>
<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>	
		
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'paging.tpl', 'smarty_include_vars' => array('aPaging' => ($this->_tpl_vars['aPaging']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>			
<?php else: ?>

	<p style="padding-left:18px;"><?php echo $this->_tpl_vars['aLang']['blog_no_topic']; ?>
</p>


<?php endif; ?>