<?php /* Smarty version 2.6.19, created on 2011-09-30 15:35:36
         compiled from actions/ActionTalk/inbox.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionTalk/inbox.tpl', 5, false),array('function', 'date_format', 'actions/ActionTalk/inbox.tpl', 46, false),array('modifier', 'escape', 'actions/ActionTalk/inbox.tpl', 37, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('noShowSystemMessage' => false)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'menu.talk.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<form action="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
" method="post" id="form_talks_list">
	<input type="hidden" name="security_ls_key" value="<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" />

	<table class="table">
		<thead>
			<tr>
				<td width="20"><input type="checkbox" name="" onclick="checkAllTalk(this);"></td>
				<td width="150"><?php echo $this->_tpl_vars['aLang']['talk_inbox_target']; ?>
</td>
				<td width="20"></td>
				<td><?php echo $this->_tpl_vars['aLang']['talk_inbox_title']; ?>
</td>
				<td width="170" align="center"><?php echo $this->_tpl_vars['aLang']['talk_inbox_date']; ?>
</td>
			</tr>
		</thead>

		<tbody>
		<?php $_from = $this->_tpl_vars['aTalks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oTalk']):
?>
			<?php $this->assign('oTalkUserAuthor', $this->_tpl_vars['oTalk']->getTalkUser()); ?>
			<tr>
				<td><input type="checkbox" name="talk_del[<?php echo $this->_tpl_vars['oTalk']->getId(); ?>
]" class="form_talks_checkbox" /></td>
				<td>
					<?php $_from = $this->_tpl_vars['oTalk']->getTalkUsers(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['users'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['users']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oTalkUser']):
        $this->_foreach['users']['iteration']++;
?>
						<?php if ($this->_tpl_vars['oTalkUser']->getUserId() != $this->_tpl_vars['oUserCurrent']->getId()): ?>
						<?php $this->assign('oUser', $this->_tpl_vars['oTalkUser']->getUser()); ?>
							<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
" class="user <?php if ($this->_tpl_vars['oTalkUser']->getUserActive() != $this->_tpl_vars['TALK_USER_ACTIVE']): ?>inactive<?php endif; ?>"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</td>
				<td align="center">
					<a href="#" onclick="lsFavourite.toggle(<?php echo $this->_tpl_vars['oTalk']->getId(); ?>
,this,'talk'); return false;" class="favorite <?php if ($this->_tpl_vars['oTalk']->getIsFavourite()): ?>active<?php endif; ?>"></a>
				</td>
				<td>
					<?php if ($this->_tpl_vars['oTalkUserAuthor']->getCommentCountNew() || ! $this->_tpl_vars['oTalkUserAuthor']->getDateLast()): ?>
						<a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
read/<?php echo $this->_tpl_vars['oTalk']->getId(); ?>
/"><strong><?php echo ((is_array($_tmp=$this->_tpl_vars['oTalk']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</strong></a>
					<?php else: ?>
						<a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
read/<?php echo $this->_tpl_vars['oTalk']->getId(); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['oTalk']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
					<?php endif; ?>
					&nbsp;
					<?php if ($this->_tpl_vars['oTalk']->getCountComment()): ?>
						<?php echo $this->_tpl_vars['oTalk']->getCountComment(); ?>
 <?php if ($this->_tpl_vars['oTalkUserAuthor']->getCommentCountNew()): ?>+<?php echo $this->_tpl_vars['oTalkUserAuthor']->getCommentCountNew(); ?>
<?php endif; ?>
					<?php endif; ?>
				</td>
				<td align="center"><?php echo smarty_function_date_format(array('date' => $this->_tpl_vars['oTalk']->getDate()), $this);?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
		</tbody>
	</table>

	<input type="submit" name="submit_talk_del" value="<?php echo $this->_tpl_vars['aLang']['talk_inbox_delete']; ?>
" onclick="return ($$('.form_talks_checkbox:checked').length==0)?false:confirm('<?php echo $this->_tpl_vars['aLang']['talk_inbox_delete_confirm']; ?>
');" />
</form>

			
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