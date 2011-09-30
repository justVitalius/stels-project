<?php /* Smarty version 2.6.19, created on 2011-09-08 20:55:48
         compiled from system_message.tpl */ ?>
<?php if ($this->_tpl_vars['aMsgError']): ?>
	<ul class="system-message-error">
	<?php $_from = $this->_tpl_vars['aMsgError']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aMsg']):
?>
		<li>
			<?php if ($this->_tpl_vars['aMsg']['title'] != ''): ?>
				<strong><?php echo $this->_tpl_vars['aMsg']['title']; ?>
</strong>:
			<?php endif; ?>
			<?php echo $this->_tpl_vars['aMsg']['msg']; ?>

		</li>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
<?php endif; ?>


<?php if ($this->_tpl_vars['aMsgNotice']): ?>
	<ul class="system-message-notice">
	<?php $_from = $this->_tpl_vars['aMsgNotice']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aMsg']):
?>
		<li>
			<?php if ($this->_tpl_vars['aMsg']['title'] != ''): ?>
				<strong><?php echo $this->_tpl_vars['aMsg']['title']; ?>
</strong>:
			<?php endif; ?>
			<?php echo $this->_tpl_vars['aMsg']['msg']; ?>

		</li>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
<?php endif; ?>