<?php /* Smarty version 2.6.19, created on 2011-10-02 14:15:31
         compiled from topic_list.tpl */ ?>
<?php if (count ( $this->_tpl_vars['aTopics'] ) > 0): ?>
 <?php if ($this->_tpl_vars['noSidebar']): ?> <div  class="new-topic" ><div class="line-rezar"></div><div class="new-topic-text">Новое в блогах</div></div><?php endif; ?>
	<?php $_from = $this->_tpl_vars['aTopics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oTopic']):
?>   
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'topic.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
	<?php endforeach; endif; unset($_from); ?>	
		
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'paging.tpl', 'smarty_include_vars' => array('aPaging' => ($this->_tpl_vars['aPaging']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>			
<?php else: ?>
	<?php echo $this->_tpl_vars['aLang']['blog_no_topic']; ?>

<?php endif; ?>