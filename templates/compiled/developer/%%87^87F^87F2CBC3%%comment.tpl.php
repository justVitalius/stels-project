<<<<<<< HEAD
<?php /* Smarty version 2.6.19, created on 2011-10-03 14:19:05
         compiled from actions/ActionMy/comment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'actions/ActionMy/comment.tpl', 23, false),array('modifier', 'date_format', 'actions/ActionMy/comment.tpl', 29, false),array('function', 'router', 'actions/ActionMy/comment.tpl', 62, false),)), $this); ?>
<?php $this->assign('pageUsers', true); ?>
=======
<?php /* Smarty version 2.6.19, created on 2011-10-03 13:20:54
         compiled from actions/ActionMy/comment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'actions/ActionMy/comment.tpl', 28, false),array('modifier', 'date_format', 'actions/ActionMy/comment.tpl', 34, false),array('function', 'router', 'actions/ActionMy/comment.tpl', 67, false),)), $this); ?>

<?php $this->assign('pageUsers', true); ?>

>>>>>>> c6093c2daf53f648849efc14f29389962674ee5c
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'profile')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
<<<<<<< HEAD
 ?>

<?php $this->assign('oSession', $this->_tpl_vars['oUserProfile']->getSession()); ?>
<?php $this->assign('oVote', $this->_tpl_vars['oUserProfile']->getVote()); ?>


<div id="user-profile">
    
  <img src="<?php echo $this->_tpl_vars['oUserProfile']->getProfileAvatarPath(145); ?>
=======
 ?>

<?php $this->assign('oSession', $this->_tpl_vars['oUserProfile']->getSession()); ?>
<?php $this->assign('oVote', $this->_tpl_vars['oUserProfile']->getVote()); ?>


<div id="user-profile">

	
	</div>
	
	<img src="<?php echo $this->_tpl_vars['oUserProfile']->getProfileAvatarPath(145); ?>
>>>>>>> c6093c2daf53f648849efc14f29389962674ee5c
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