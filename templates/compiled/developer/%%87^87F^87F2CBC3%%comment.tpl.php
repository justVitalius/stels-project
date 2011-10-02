<?php /* Smarty version 2.6.19, created on 2011-10-02 16:21:21
         compiled from actions/ActionMy/comment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'actions/ActionMy/comment.tpl', 22, false),array('modifier', 'date_format', 'actions/ActionMy/comment.tpl', 28, false),array('function', 'router', 'actions/ActionMy/comment.tpl', 61, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'profile')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $this->assign('oSession', $this->_tpl_vars['oUserProfile']->getSession()); ?>
<?php $this->assign('oVote', $this->_tpl_vars['oUserProfile']->getVote()); ?>


<div id="user-profile">
	<p class="strength">
		<?php echo $this->_tpl_vars['aLang']['user_skill']; ?>
: <strong class="total" id="user_skill_<?php echo $this->_tpl_vars['oUserProfile']->getId(); ?>
"><?php echo $this->_tpl_vars['oUserProfile']->getSkill(); ?>
</strong>
	</p>
	
	<div class="voting <?php if ($this->_tpl_vars['oUserProfile']->getRating() >= 0): ?>positive<?php else: ?>negative<?php endif; ?> <?php if (! $this->_tpl_vars['oUserCurrent'] || $this->_tpl_vars['oUserProfile']->getId() == $this->_tpl_vars['oUserCurrent']->getId()): ?>guest<?php endif; ?> <?php if ($this->_tpl_vars['oVote']): ?> voted <?php if ($this->_tpl_vars['oVote']->getDirection() > 0): ?>plus<?php elseif ($this->_tpl_vars['oVote']->getDirection() < 0): ?>minus<?php endif; ?><?php endif; ?>">
		<a href="#" class="plus" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oUserProfile']->getId(); ?>
,this,1,'user'); return false;"></a>
		<div class="total" title="<?php echo $this->_tpl_vars['aLang']['user_vote_count']; ?>
: <?php echo $this->_tpl_vars['oUserProfile']->getCountVote(); ?>
"><?php if ($this->_tpl_vars['oUserProfile']->getRating() > 0): ?>+<?php endif; ?><?php echo $this->_tpl_vars['oUserProfile']->getRating(); ?>
</div>
		<a href="#" class="minus" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oUserProfile']->getId(); ?>
,this,-1,'user'); return false;"></a>
	</div>
	
	<img src="<?php echo $this->_tpl_vars['oUserProfile']->getProfileAvatarPath(145); ?>
" alt="<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
" class="avatar" />
	
	<h2 class="username">
		<?php if ($this->_tpl_vars['oUserProfile']->getProfileName()): ?>
			<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserProfile']->getProfileName())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

		<?php else: ?>
			<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>

		<?php endif; ?>
	</h2>
	
	<p class="regtime">зарегистрирован&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserProfile']->getDateRegister())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e.%m.%Yг. в %R") : smarty_modifier_date_format($_tmp, "%e.%m.%Yг. в %R")); ?>
</p>
	
	<?php $this->assign('sUserLogin', $this->_tpl_vars['oUserProfile']->getLogin()); ?>
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
	
	<?php if ($this->_tpl_vars['iCountTopicUser']): ?>
		<?php $this->assign('sNumberTopicsByUser', $this->_tpl_vars['iCountTopicUser']); ?>
	<?php else: ?>
		<?php $this->assign('sNumberTopicsByUser', 0); ?>
	<?php endif; ?>
	
	<?php if ($this->_tpl_vars['iCountCommentUser']): ?>
		<?php $this->assign('sNumberCommentsByUser', $this->_tpl_vars['iCountCommentUser']); ?>
	<?php else: ?>
		<?php $this->assign('sNumberCommentsByUser', 0); ?>
	<?php endif; ?>
	
	<ul class="profile-menu">
		<li class='user-info'><a href="<?php echo smarty_function_router(array('page' => 'profile'), $this);?>
<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
/">информация</a></li>
		<li class='user-topics'><a <?php if ($this->_tpl_vars['iCountTopicUser']): ?>href="<?php echo smarty_function_router(array('page' => 'my'), $this);?>
<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
/"<?php endif; ?>>посты (<?php echo $this->_tpl_vars['sNumberTopicsByUser']; ?>
)</a></li>
		<li class='user-comments active'><a>комментарии (<?php echo $this->_tpl_vars['sNumberCommentsByUser']; ?>
)</a></li>
	</ul>
	<div class="clear" style="padding-top: 20px;"></div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'comment_list.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>