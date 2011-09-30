<?php /* Smarty version 2.6.19, created on 2011-09-08 20:55:48
         compiled from actions/ActionAdmin/plugins.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionAdmin/plugins.tpl', 4, false),array('modifier', 'escape', 'actions/ActionAdmin/plugins.tpl', 22, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<form action="<?php echo smarty_function_router(array('page' => 'admin'), $this);?>
plugins/" method="post" id="form_plugins_list">
	<input type="hidden" name="security_ls_key" value="<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" /> 
	<table class="table">
		<thead>
			<tr>
				<td width="20"><input type="checkbox" name="" onclick="checkAllPlugins(this);" /></td>
				<td><?php echo $this->_tpl_vars['aLang']['plugins_plugin_name']; ?>
</td>
				<td><?php echo $this->_tpl_vars['aLang']['plugins_plugin_version']; ?>
</td>
				<td><?php echo $this->_tpl_vars['aLang']['plugins_plugin_author']; ?>
</td>														
				<td><?php echo $this->_tpl_vars['aLang']['plugins_plugin_action']; ?>
</td>
			</tr>
		</thead>
		
		<tbody>
			<?php $_from = $this->_tpl_vars['aPlugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aPlugin']):
?>
				<tr>
					<td><input type="checkbox" name="plugin_del[<?php echo $this->_tpl_vars['aPlugin']['code']; ?>
]" class="form_plugins_checkbox" /></td>
					<td>
						<h3><?php echo ((is_array($_tmp=$this->_tpl_vars['aPlugin']['property']->name->data)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</h3>
						<?php echo ((is_array($_tmp=$this->_tpl_vars['aPlugin']['property']->description->data)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
<br />
						<?php echo $this->_tpl_vars['aPlugin']['property']->homepage; ?>

					</td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['aPlugin']['property']->version)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['aPlugin']['property']->author->data)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</td>													
					<td>
						<?php if ($this->_tpl_vars['aPlugin']['is_active']): ?>
							<a href="<?php echo smarty_function_router(array('page' => 'admin'), $this);?>
plugins/?plugin=<?php echo $this->_tpl_vars['aPlugin']['code']; ?>
&action=deactivate"><?php echo $this->_tpl_vars['aLang']['plugins_plugin_deactivate']; ?>
</a>
						<?php else: ?>
							<a href="<?php echo smarty_function_router(array('page' => 'admin'), $this);?>
plugins/?plugin=<?php echo $this->_tpl_vars['aPlugin']['code']; ?>
&action=activate"><?php echo $this->_tpl_vars['aLang']['plugins_plugin_activate']; ?>
</a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
		</tbody>
	</table>
	<input type="submit" name="submit_plugins_del" value="<?php echo $this->_tpl_vars['aLang']['plugins_submit_delete']; ?>
" onclick="return ($$('.form_plugins_checkbox:checked').length==0)?false:confirm('<?php echo $this->_tpl_vars['aLang']['plugins_delete_confirm']; ?>
');" />				
</form>
				

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>