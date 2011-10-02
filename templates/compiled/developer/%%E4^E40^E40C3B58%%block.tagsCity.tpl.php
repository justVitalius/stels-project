<?php /* Smarty version 2.6.19, created on 2011-10-02 16:52:56
         compiled from block.tagsCity.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'block.tagsCity.tpl', 6, false),array('modifier', 'escape', 'block.tagsCity.tpl', 6, false),)), $this); ?>
<?php if ($this->_tpl_vars['aCityList'] && count ( $this->_tpl_vars['aCityList'] ) > 0): ?>
	<div class="block">				
		<h2><?php echo $this->_tpl_vars['aLang']['block_city_tags']; ?>
</h2>					
		<ul class="cloud">
			<?php $_from = $this->_tpl_vars['aCityList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aCity']):
?>
				<li><a class="w<?php echo $this->_tpl_vars['aCity']['size']; ?>
" rel="tag" href="<?php echo smarty_function_router(array('page' => 'people'), $this);?>
city/<?php echo ((is_array($_tmp=$this->_tpl_vars['aCity']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
/" ><?php echo ((is_array($_tmp=$this->_tpl_vars['aCity']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a></li>	
			<?php endforeach; endif; unset($_from); ?>					
		</ul>									
	</div>
<?php endif; ?>