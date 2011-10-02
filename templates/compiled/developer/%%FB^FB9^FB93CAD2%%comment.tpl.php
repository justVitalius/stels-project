<?php /* Smarty version 2.6.19, created on 2011-10-02 17:00:16
         compiled from comment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'date_format', 'comment.tpl', 12, false),)), $this); ?>
<?php $this->assign('oUser', $this->_tpl_vars['oComment']->getUser()); ?>
<?php $this->assign('oVote', $this->_tpl_vars['oComment']->getVote()); ?>

<div class="comment-inner">
<?php if (! $this->_tpl_vars['oComment']->getDelete() || $this->_tpl_vars['bOneComment'] || ( $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oUserCurrent']->isAdministrator() )): ?>
	<a name="comment<?php echo $this->_tpl_vars['oComment']->getId(); ?>
" ></a>
	

	<ul class="info <?php if ($this->_tpl_vars['oComment']->getDelete() && $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oUserCurrent']->isAdministrator()): ?>del<?php elseif ($this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oComment']->getUserId() == $this->_tpl_vars['oUserCurrent']->getId()): ?>self<?php elseif ($this->_tpl_vars['sDateReadLast'] <= $this->_tpl_vars['oComment']->getDate()): ?>new<?php endif; ?>">
		<li class="avatar"><a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><img src="<?php echo $this->_tpl_vars['oUser']->getProfileAvatarPath(24); ?>
" alt="avatar" /></a></li>
		<li class="username"><a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a></li>
		<li class="date"><?php echo smarty_function_date_format(array('date' => $this->_tpl_vars['oComment']->getDate()), $this);?>
</li>
		<li><a href="#comment<?php echo $this->_tpl_vars['oComment']->getId(); ?>
">#</a></li>	
		<?php if ($this->_tpl_vars['oComment']->getPid()): ?>
			<li class="goto-comment-parent"><a href="#comment<?php echo $this->_tpl_vars['oComment']->getPid(); ?>
" onclick="return lsCmtTree.goToParentComment($(this));" title="<?php echo $this->_tpl_vars['aLang']['comment_goto_parent']; ?>
">↑</a></li>
		<?php endif; ?>
		<li class="goto-comment-child hidden"><a href="#" onclick="return lsCmtTree.goToChildComment(this);" title="<?php echo $this->_tpl_vars['aLang']['comment_goto_child']; ?>
">↓</a></li>
		<?php if ($this->_tpl_vars['oUserCurrent'] && ! $this->_tpl_vars['bNoCommentFavourites']): ?>
			<li><a href="#" onclick="lsFavourite.toggle(<?php echo $this->_tpl_vars['oComment']->getId(); ?>
,this,'comment'); return false;" class="favorite <?php if ($this->_tpl_vars['oComment']->getIsFavourite()): ?>active<?php endif; ?>"></a></li>
		<?php endif; ?>
		<?php if (! $this->_tpl_vars['oComment']->getDelete() && $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oUserCurrent']->isAdministrator()): ?>
			<li><a href="#" class="delete" onclick="lsCmtTree.toggleComment(this,<?php echo $this->_tpl_vars['oComment']->getId(); ?>
); return false;"><?php echo $this->_tpl_vars['aLang']['comment_delete']; ?>
</a></li>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['oComment']->getDelete() && $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oUserCurrent']->isAdministrator()): ?>   										
			<li><a href="#" class="repair" onclick="lsCmtTree.toggleComment(this,<?php echo $this->_tpl_vars['oComment']->getId(); ?>
); return false;"><?php echo $this->_tpl_vars['aLang']['comment_repair']; ?>
</a></li>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['oComment']->getTargetType() != 'talk'): ?>						
			<li class="voting <?php if ($this->_tpl_vars['oComment']->getRating() > 0): ?>positive<?php elseif ($this->_tpl_vars['oComment']->getRating() < 0): ?>negative<?php endif; ?> <?php if (! $this->_tpl_vars['oUserCurrent'] || $this->_tpl_vars['oComment']->getUserId() == $this->_tpl_vars['oUserCurrent']->getId() || strtotime ( $this->_tpl_vars['oComment']->getDate() ) < time()-$this->_tpl_vars['oConfig']->GetValue('acl.vote.comment.limit_time')): ?>guest<?php endif; ?>   <?php if ($this->_tpl_vars['oVote']): ?> voted <?php if ($this->_tpl_vars['oVote']->getDirection() > 0): ?>plus<?php else: ?>minus<?php endif; ?><?php endif; ?>  ">
				<a href="#" class="plus" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oComment']->getId(); ?>
,this,1,'comment'); return false;"></a>
				<span class="total"><?php if ($this->_tpl_vars['oComment']->getRating() > 0): ?>+<?php endif; ?><?php echo $this->_tpl_vars['oComment']->getRating(); ?>
</span>
				<a href="#" class="minus" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oComment']->getId(); ?>
,this,-1,'comment'); return false;"></a>
			</li>
		<?php endif; ?>
	</ul>
	
	
	<div id="comment_content_id_<?php echo $this->_tpl_vars['oComment']->getId(); ?>
" class="content">
		<?php if (! $this->_tpl_vars['bOneComment'] && $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oComment']->getUserId() != $this->_tpl_vars['oUserCurrent']->getId() && $this->_tpl_vars['sDateReadLast'] <= $this->_tpl_vars['oComment']->getDate()): ?>
			<?php echo '
			<script language="JavaScript" type="text/javascript">
				window.addEvent(\'domready\', function() {
				'; ?>

					lsCmtTree.addCommentScroll(<?php echo $this->_tpl_vars['oComment']->getId(); ?>
);
				<?php echo '
				});					
			</script>
			'; ?>

		<?php endif; ?>							
		
		<?php if ($this->_tpl_vars['oComment']->isBad()): ?>
			<span class="bad"><?php echo $this->_tpl_vars['oComment']->getText(); ?>
</span>
		<?php else: ?>	
			<?php echo $this->_tpl_vars['oComment']->getText(); ?>

		<?php endif; ?>
		
		<br />
		<?php if ($this->_tpl_vars['oUserCurrent'] && ! $this->_tpl_vars['oComment']->getDelete() && ! $this->_tpl_vars['bAllowNewComment']): ?>
			<a href="javascript:lsCmtTree.toggleCommentForm(<?php echo $this->_tpl_vars['oComment']->getId(); ?>
);" class="reply-link"><?php echo $this->_tpl_vars['aLang']['comment_answer']; ?>
</a>
		<?php endif; ?>
		<a href="#" title="<?php echo $this->_tpl_vars['aLang']['comment_collapse']; ?>
/<?php echo $this->_tpl_vars['aLang']['comment_expand']; ?>
" class="folding" <?php if ($this->_tpl_vars['bOneComment']): ?>style="display: none;"<?php endif; ?>><?php echo $this->_tpl_vars['aLang']['comment_fold']; ?>
</a>
	</div>
<?php else: ?>				
	<div class="deleted"><?php echo $this->_tpl_vars['aLang']['comment_was_delete']; ?>
</div>
<?php endif; ?>
</div>


<?php if ($this->_tpl_vars['oUserCurrent']): ?>
	<div class="comment" id="comment_preview_<?php echo $this->_tpl_vars['oComment']->getId(); ?>
" style="display: none;"><div class="comment-inner"><div class="content"></div></div></div>					
	<div class="reply" id="reply_<?php echo $this->_tpl_vars['oComment']->getId(); ?>
" style="display: none;"></div>	
<?php endif; ?>	


<div class="comment-children" id="comment-children-<?php echo $this->_tpl_vars['oComment']->getId(); ?>
">
<?php if ($this->_tpl_vars['bOneComment']): ?></div><?php endif; ?>