<?php /* Smarty version 2.6.19, created on 2011-10-03 00:52:48
         compiled from actions/ActionBlog/blog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'actions/ActionBlog/blog.tpl', 21, false),array('modifier', 'nl2br', 'actions/ActionBlog/blog.tpl', 57, false),array('function', 'router', 'actions/ActionBlog/blog.tpl', 24, false),)), $this); ?>

<?php $this->assign('pageBlogs', true); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'blog')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->assign('oUserOwner', $this->_tpl_vars['oBlog']->getOwner()); ?>
<?php $this->assign('oVote', $this->_tpl_vars['oBlog']->getVote()); ?>


<?php if ($this->_tpl_vars['oUserCurrent'] && ( $this->_tpl_vars['oUserCurrent']->isAdministrator() )): ?>

<div class="blog">
  
	
	
	
	<h2><img src="<?php echo $this->_tpl_vars['oBlog']->getAvatarPath(24); ?>
" alt="avatar" class="avatar" /> <?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</h2>
	
	<ul class="actions">
		<li><a href="<?php echo smarty_function_router(array('page' => 'rss'), $this);?>
blog/<?php echo $this->_tpl_vars['oBlog']->getUrl(); ?>
/" class="rss">Rss</a></li>
		<?php if ($this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oUserCurrent']->getId() != $this->_tpl_vars['oBlog']->getOwnerId()): ?>
			<li><a href="#" onclick="ajaxJoinLeaveBlog(this,<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
); return false;"><?php if ($this->_tpl_vars['oBlog']->getUserIsJoin()): ?><?php echo $this->_tpl_vars['aLang']['clean_leave']; ?>
<?php else: ?><?php echo $this->_tpl_vars['aLang']['clean_join']; ?>
<?php endif; ?></a></li>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['oUserCurrent'] && ( $this->_tpl_vars['oUserCurrent']->getId() == $this->_tpl_vars['oBlog']->getOwnerId() || $this->_tpl_vars['oUserCurrent']->isAdministrator() || $this->_tpl_vars['oBlog']->getUserIsAdministrator() )): ?>
			<li>
				<a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
edit/<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
/" title="<?php echo $this->_tpl_vars['aLang']['blog_edit']; ?>
" class="edit"><?php echo $this->_tpl_vars['aLang']['blog_edit']; ?>
</a></li>
				<?php if ($this->_tpl_vars['oUserCurrent']->isAdministrator()): ?>
					<li><a href="#" title="<?php echo $this->_tpl_vars['aLang']['blog_delete']; ?>
" onclick="toggleBlogDeleteForm('blog_delete_form',this); return false;" class="delete"><?php echo $this->_tpl_vars['aLang']['blog_delete']; ?>
</a>

					<form id="blog_delete_form" class="hidden" action="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
delete/<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
/" method="POST">
						<input type="hidden" value="<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" name="security_ls_key" />
						<?php echo $this->_tpl_vars['aLang']['blog_admin_delete_move']; ?>
:<br />
						<select name="topic_move_to">
							<option value="-1"><?php echo $this->_tpl_vars['aLang']['blog_delete_clear']; ?>
</option>
							<?php if ($this->_tpl_vars['aBlogs']): ?>
								<option disabled="disabled">-------------</option>
								<?php $_from = $this->_tpl_vars['aBlogs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlogDelete']):
?>
									<option value="<?php echo $this->_tpl_vars['oBlogDelete']->getId(); ?>
"><?php echo $this->_tpl_vars['oBlogDelete']->getTitle(); ?>
</option>
								<?php endforeach; endif; unset($_from); ?>
							<?php endif; ?>
						</select>
						<input type="submit" value="<?php echo $this->_tpl_vars['aLang']['blog_delete']; ?>
" />
					</form>
				<?php else: ?>
					<a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
delete/<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
/?security_ls_key=<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" title="<?php echo $this->_tpl_vars['aLang']['blog_delete']; ?>
" onclick="return confirm('<?php echo $this->_tpl_vars['aLang']['blog_admin_delete_confirm']; ?>
');" ><?php echo $this->_tpl_vars['aLang']['blog_delete']; ?>
</a>
				<?php endif; ?>
			</li>
		<?php endif; ?>
	</ul>
	
	
	
	<p><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getDescription())) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</p>			
	
	<strong><?php echo $this->_tpl_vars['aLang']['blog_user_administrators']; ?>
 (<?php echo $this->_tpl_vars['iCountBlogAdministrators']; ?>
):</strong>							
	<a href="<?php echo $this->_tpl_vars['oUserOwner']->getUserWebPath(); ?>
" class="user"><?php echo $this->_tpl_vars['oUserOwner']->getLogin(); ?>
</a>
	<?php if ($this->_tpl_vars['aBlogAdministrators']): ?>			
		<?php $_from = $this->_tpl_vars['aBlogAdministrators']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlogUser']):
?>
			<?php $this->assign('oUser', $this->_tpl_vars['oBlogUser']->getUser()); ?>  									
			<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
" class="user"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a>
		<?php endforeach; endif; unset($_from); ?>	
	<?php endif; ?><br />		

	
	<strong><?php echo $this->_tpl_vars['aLang']['blog_user_moderators']; ?>
 (<?php echo $this->_tpl_vars['iCountBlogModerators']; ?>
):</strong>
	<?php if ($this->_tpl_vars['aBlogModerators']): ?>						
		<?php $_from = $this->_tpl_vars['aBlogModerators']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlogUser']):
?>  
		<?php $this->assign('oUser', $this->_tpl_vars['oBlogUser']->getUser()); ?>									
			<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
" class="user"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a>
		<?php endforeach; endif; unset($_from); ?>							
	<?php else: ?>
		<?php echo $this->_tpl_vars['aLang']['blog_user_moderators_empty']; ?>

	<?php endif; ?><br />
	
	
	<strong><?php echo $this->_tpl_vars['aLang']['blog_user_readers']; ?>
 (<?php echo $this->_tpl_vars['iCountBlogUsers']; ?>
):</strong>
	<?php if ($this->_tpl_vars['aBlogUsers']): ?>
		<?php $_from = $this->_tpl_vars['aBlogUsers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlogUser']):
?>
		<?php $this->assign('oUser', $this->_tpl_vars['oBlogUser']->getUser()); ?>
			<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
" class="user"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a>
		<?php endforeach; endif; unset($_from); ?>
	<?php else: ?>
		<?php echo $this->_tpl_vars['aLang']['blog_user_readers_empty']; ?>

	<?php endif; ?>		
</div>


<?php endif; ?>


<?php if ($this->_tpl_vars['bCloseBlog']): ?>
	<?php echo $this->_tpl_vars['aLang']['blog_close_show']; ?>

<?php else: ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'topic_list.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>