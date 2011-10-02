<?php /* Smarty version 2.6.19, created on 2011-09-09 19:42:18
         compiled from blog_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'blog_list.tpl', 16, false),array('modifier', 'escape', 'blog_list.tpl', 16, false),)), $this); ?>
<table id="blogs">
	<thead>
		<tr>
			<td class='td1'>Блог</td>
			<td class='td2'>&nbsp;</td>
			<td class='td3'>категория</td>
			<td class='td3'>индекс</td>
		</tr>
	</thead>
	<tbody>
	<?php $_from = $this->_tpl_vars['aBlogs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlog']):
?>
		<?php $this->assign('oUserOwner', $this->_tpl_vars['oBlog']->getOwner()); ?>
		<?php $this->assign('sBlogId', $this->_tpl_vars['oBlog']->getId()); ?>
		<tr>
			<td class='td1'>
				<a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
<?php echo $this->_tpl_vars['oBlog']->getUrl(); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
				<?php echo $this->_tpl_vars['oBlog']->getCountUser(); ?>
 читателей, <?php echo $this->_tpl_vars['aCountTopicsInBlogs'][$this->_tpl_vars['sBlogId']]; ?>
 постов
			</td>
			<td class='td2'>
			<?php if ($this->_tpl_vars['oUserCurrent']): ?>
				<?php if ($this->_tpl_vars['oUserCurrent']->getId() != $this->_tpl_vars['oBlog']->getOwnerId() && $this->_tpl_vars['oBlog']->getType() == 'open'): ?>
				<a href="#" onclick="ajaxJoinLeaveBlog(this,<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
); return false;">
					<?php if ($this->_tpl_vars['oBlog']->getUserIsJoin()): ?><?php echo $this->_tpl_vars['aLang']['clean_leave']; ?>
<?php else: ?><?php echo $this->_tpl_vars['aLang']['clean_join']; ?>
<?php endif; ?>
				</a>
				<?php endif; ?>
			<?php endif; ?>
			</td>
			<td class='td3'>
				<?php echo $this->_tpl_vars['sBlogCategory']; ?>

			</td>
			<td class='td4'>
				<?php echo $this->_tpl_vars['oBlog']->getRating(); ?>

			</td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
	</tbody>
</table>