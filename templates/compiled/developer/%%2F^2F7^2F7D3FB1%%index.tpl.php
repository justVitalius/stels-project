<<<<<<< HEAD
<?php /* Smarty version 2.6.19, created on 2011-10-03 10:51:06
=======
<?php /* Smarty version 2.6.19, created on 2011-10-03 00:56:27
>>>>>>> 40aef76911846e9d556c188de14a7b730a4e81f0
         compiled from actions/ActionPeople/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionPeople/index.tpl', 7, false),array('modifier', 'escape', 'actions/ActionPeople/index.tpl', 11, false),array('modifier', 'date_format', 'actions/ActionPeople/index.tpl', 17, false),)), $this); ?>
<?php $this->assign('pageUsers', true); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'people')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="people">
<?php $_from = $this->_tpl_vars['aUsersRating']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oUser']):
?>
	<div class="user-entry">
		
		<a href="<?php echo smarty_function_router(array('page' => 'profile'), $this);?>
<?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
/"><img src="<?php echo $this->_tpl_vars['oUser']->getProfileAvatarPath(110); ?>
" alt="<?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
" class="avatar" />
		
		<h2 class="username">
			<?php if ($this->_tpl_vars['oUser']->getProfileName()): ?>
				<?php echo ((is_array($_tmp=$this->_tpl_vars['oUser']->getProfileName())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

			<?php else: ?>
				<?php echo $this->_tpl_vars['oUser']->getLogin(); ?>

			<?php endif; ?>
		</h2></a>
		
		<p class="regtime">зарегистрирован&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['oUser']->getDateRegister())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e.%m.%Yг. в %R") : smarty_modifier_date_format($_tmp, "%e.%m.%Yг. в %R")); ?>
</p>
		
		<?php $this->assign('sUserLogin', $this->_tpl_vars['oUser']->getLogin()); ?>
		<?php if ($this->_tpl_vars['aTopicsByUsers'][$this->_tpl_vars['sUserLogin']]): ?>
		<div class="last">
			<p class="last-label">последние посты:</p>
			<div class="last-entries">
			
			<?php $this->assign('aTopicsByUser', $this->_tpl_vars['aTopicsByUsers'][$this->_tpl_vars['sUserLogin']]); ?>
			
			<?php $_from = $this->_tpl_vars['aTopicsByUser']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oTopic']):
?>			
				<?php $this->assign('oBlog', $this->_tpl_vars['oTopic']->getBlog()); ?>
				<div class="last-entry">
					<a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>&nbsp;/&nbsp;<a href="<?php echo $this->_tpl_vars['DIR_WEB_ROOT']; ?>
/blog/<?php if ($this->_tpl_vars['oBlog']->getUrl()): ?><?php echo $this->_tpl_vars['oBlog']->getUrl(); ?>
/<?php endif; ?><?php echo $this->_tpl_vars['oTopic']->getId(); ?>
.html" class="topic"><?php echo $this->_tpl_vars['oTopic']->getTitle(); ?>
</a>
				</div>
			<?php endforeach; endif; unset($_from); ?>
			</div>
		</div>
		<?php endif; ?>
		
	</div>
	<div class="clear"></div>
<?php endforeach; endif; unset($_from); ?>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'paging.tpl', 'smarty_include_vars' => array('aPaging' => ($this->_tpl_vars['aPaging']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>