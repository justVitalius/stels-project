<?php /* Smarty version 2.6.19, created on 2011-09-30 01:33:27
         compiled from actions/ActionSearch/results.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'actions/ActionSearch/results.tpl', 4, false),array('function', 'router', 'actions/ActionSearch/results.tpl', 9, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<h2><?php echo $this->_tpl_vars['aLang']['search_results']; ?>
: <?php echo ((is_array($_tmp=$this->_tpl_vars['aReq']['q'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</h2>

<ul class="switcher">
<?php $_from = $this->_tpl_vars['aRes']['aCounts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sTypes'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sTypes']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sType'] => $this->_tpl_vars['iCount']):
        $this->_foreach['sTypes']['iteration']++;
?>
	<li <?php if ($this->_tpl_vars['aReq']['sType'] == $this->_tpl_vars['sType']): ?>class="active"<?php endif; ?>>					
		<a href="<?php echo smarty_function_router(array('page' => 'search'), $this);?>
<?php echo $this->_tpl_vars['sType']; ?>
/?q=<?php echo ((is_array($_tmp=$this->_tpl_vars['aReq']['q'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">
			<?php echo $this->_tpl_vars['iCount']; ?>
 
			<?php if ($this->_tpl_vars['sType'] == 'topics'): ?>
				<?php echo $this->_tpl_vars['aLang']['search_results_count_topics']; ?>

			<?php elseif ($this->_tpl_vars['sType'] == 'comments'): ?>
				<?php echo $this->_tpl_vars['aLang']['search_results_count_comments']; ?>

			<?php endif; ?>
		</a>
	</li>				
<?php endforeach; endif; unset($_from); ?>
</ul>

<?php if ($this->_tpl_vars['bIsResults']): ?>
	<?php if ($this->_tpl_vars['aReq']['sType'] == 'topics'): ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'topic_list.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php elseif ($this->_tpl_vars['aReq']['sType'] == 'comments'): ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'comment_list.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
<?php else: ?>
	<?php echo $this->_tpl_vars['aLang']['search_results_empty']; ?>

<?php endif; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>