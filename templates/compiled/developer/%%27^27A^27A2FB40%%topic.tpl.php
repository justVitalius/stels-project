<?php /* Smarty version 2.6.19, created on 2011-10-01 12:36:33
         compiled from topic.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'topic.tpl', 8, false),array('function', 'cfg', 'topic.tpl', 11, false),array('function', 'router', 'topic.tpl', 14, false),array('function', 'date_format', 'topic.tpl', 94, false),array('function', 'hook', 'topic.tpl', 99, false),)), $this); ?>
<?php $this->assign('oBlog', $this->_tpl_vars['oTopic']->getBlog()); ?>
<?php $this->assign('oUser', $this->_tpl_vars['oTopic']->getUser()); ?>
<?php $this->assign('oVote', $this->_tpl_vars['oTopic']->getVote()); ?> 


<div class="topic">
	<h2 class="title">
		<a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
" class="title-blog"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
		<span class='lightning'></span>
		<?php if ($this->_tpl_vars['oTopic']->getPublish() == 0): ?>	
			<img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/draft.png" title="<?php echo $this->_tpl_vars['aLang']['topic_unpublish']; ?>
" alt="<?php echo $this->_tpl_vars['aLang']['topic_unpublish']; ?>
" />
		<?php endif; ?>
		<?php if ($this->_tpl_vars['oTopic']->getType() == 'link'): ?><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/topic_link.png" title="<?php echo $this->_tpl_vars['aLang']['topic_link']; ?>
" alt="<?php echo $this->_tpl_vars['aLang']['topic_link']; ?>
" /><?php endif; ?>
		<a href="<?php if ($this->_tpl_vars['oTopic']->getType() == 'link'): ?><?php echo smarty_function_router(array('page' => 'link'), $this);?>
go/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/<?php else: ?><?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
<?php endif; ?>" class="title-topic"><?php echo ((is_array($_tmp=$this->_tpl_vars['oTopic']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
	</h2>
	
	
	
	<ul class="actions">									
		<?php if ($this->_tpl_vars['oUserCurrent'] && ( $this->_tpl_vars['oUserCurrent']->getId() == $this->_tpl_vars['oTopic']->getUserId() || $this->_tpl_vars['oUserCurrent']->isAdministrator() || $this->_tpl_vars['oBlog']->getUserIsAdministrator() || $this->_tpl_vars['oBlog']->getUserIsModerator() || $this->_tpl_vars['oBlog']->getOwnerId() == $this->_tpl_vars['oUserCurrent']->getId() )): ?>
			<li><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
/<?php echo $this->_tpl_vars['oTopic']->getType(); ?>
/edit/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/" title="<?php echo $this->_tpl_vars['aLang']['topic_edit']; ?>
" class="edit"><?php echo $this->_tpl_vars['aLang']['topic_edit']; ?>
</a></li>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['oUserCurrent'] && ( $this->_tpl_vars['oUserCurrent']->isAdministrator() || $this->_tpl_vars['oBlog']->getUserIsAdministrator() || $this->_tpl_vars['oBlog']->getOwnerId() == $this->_tpl_vars['oUserCurrent']->getId() )): ?>
			<li><a href="<?php echo smarty_function_router(array('page' => 'topic'), $this);?>
delete/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/?security_ls_key=<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" title="<?php echo $this->_tpl_vars['aLang']['topic_delete']; ?>
" onclick="return confirm('<?php echo $this->_tpl_vars['aLang']['topic_delete_confirm']; ?>
');" class="delete"><?php echo $this->_tpl_vars['aLang']['topic_delete']; ?>
</a></li>
		<?php endif; ?>
	</ul>



	<div class="content">
	  <img class="preview" src="<?php if ($this->_tpl_vars['oTopic']->getTopicPreview()): ?><?php echo $this->_tpl_vars['oTopic']->getTopicPreviewPath(280,280); ?>
<?php endif; ?>">
	  <img class="preview" src="<?php if ($this->_tpl_vars['oTopic']->getTopicPreview()): ?><?php echo $this->_tpl_vars['oTopic']->getTopicPreviewPath(590,360); ?>
<?php endif; ?>">
	  
		<?php if ($this->_tpl_vars['oTopic']->getType() == 'question'): ?>
			<div id="topic_question_area_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
" class="poll">
				<?php if (! $this->_tpl_vars['oTopic']->getUserQuestionIsVote()): ?>
					<ul class="poll-vote">
						<?php $_from = $this->_tpl_vars['oTopic']->getQuestionAnswers(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['aAnswer']):
?>
							<li><label><input type="radio" id="topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_<?php echo $this->_tpl_vars['key']; ?>
" name="topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
" value="<?php echo $this->_tpl_vars['key']; ?>
" onchange="$('topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_value').setProperty('value',this.value);" /> <?php echo ((is_array($_tmp=$this->_tpl_vars['aAnswer']['text'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</label></li>
						<?php endforeach; endif; unset($_from); ?>
					</ul>

					<input type="submit" value="<?php echo $this->_tpl_vars['aLang']['topic_question_vote']; ?>
" onclick="ajaxQuestionVote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,$('topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_value').getProperty('value'));" />
					<input type="submit" value="<?php echo $this->_tpl_vars['aLang']['topic_question_abstain']; ?>
" onclick="ajaxQuestionVote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,-1)" />
					<input type="hidden" id="topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_value" value="-1" />
				<?php else: ?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'topic_question.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if (! $this->_tpl_vars['tSingle']): ?>
			<?php echo $this->_tpl_vars['oTopic']->getTextShort(); ?>

			<?php if ($this->_tpl_vars['oTopic']->getTextShort() != $this->_tpl_vars['oTopic']->getText()): ?>
				<a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
" title="<?php echo $this->_tpl_vars['aLang']['topic_read_more']; ?>
" class="readmore">
				<?php if ($this->_tpl_vars['oTopic']->getCutText()): ?>
					<?php echo $this->_tpl_vars['oTopic']->getCutText(); ?>

				<?php else: ?>
					читать дальше...
				<?php endif; ?>      			
				</a>
			<?php endif; ?>
		<?php else: ?>
			<?php echo $this->_tpl_vars['oTopic']->getText(); ?>

		<?php endif; ?>
	</div>	



	<ul class="tags">
		<?php $_from = $this->_tpl_vars['oTopic']->getTagsArray(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tags_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tags_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sTag']):
        $this->_foreach['tags_list']['iteration']++;
?>
			<li><a href="<?php echo smarty_function_router(array('page' => 'tag'), $this);?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['sTag'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['sTag'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><?php if (! ($this->_foreach['tags_list']['iteration'] == $this->_foreach['tags_list']['total'])): ?>, <?php endif; ?></li>
		<?php endforeach; endif; unset($_from); ?>								
	</ul>



	<ul class="info">
		<li class="voting <?php if ($this->_tpl_vars['oVote'] || ( $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oTopic']->getUserId() == $this->_tpl_vars['oUserCurrent']->getId() ) || strtotime ( $this->_tpl_vars['oTopic']->getDateAdd() ) < time()-$this->_tpl_vars['oConfig']->GetValue('acl.vote.topic.limit_time')): ?><?php if ($this->_tpl_vars['oTopic']->getRating() > 0): ?>positive<?php elseif ($this->_tpl_vars['oTopic']->getRating() < 0): ?>negative<?php endif; ?><?php endif; ?> <?php if (! $this->_tpl_vars['oUserCurrent'] || $this->_tpl_vars['oTopic']->getUserId() == $this->_tpl_vars['oUserCurrent']->getId() || strtotime ( $this->_tpl_vars['oTopic']->getDateAdd() ) < time()-$this->_tpl_vars['oConfig']->GetValue('acl.vote.topic.limit_time')): ?>guest<?php endif; ?><?php if ($this->_tpl_vars['oVote']): ?> voted <?php if ($this->_tpl_vars['oVote']->getDirection() > 0): ?>plus<?php elseif ($this->_tpl_vars['oVote']->getDirection() < 0): ?>minus<?php endif; ?><?php endif; ?>">
			<a href="#" class="plus" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,1,'topic'); return false;"></a>
			<span class="total" title="<?php echo $this->_tpl_vars['aLang']['topic_vote_count']; ?>
: <?php echo $this->_tpl_vars['oTopic']->getCountVote(); ?>
"><?php if ($this->_tpl_vars['oVote'] || ( $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oTopic']->getUserId() == $this->_tpl_vars['oUserCurrent']->getId() ) || strtotime ( $this->_tpl_vars['oTopic']->getDateAdd() ) < time()-$this->_tpl_vars['oConfig']->GetValue('acl.vote.topic.limit_time')): ?> <?php if ($this->_tpl_vars['oTopic']->getRating() > 0): ?>+<?php endif; ?><?php echo $this->_tpl_vars['oTopic']->getRating(); ?>
 <?php else: ?> <a href="#" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,0,'topic'); return false;">&mdash;</a> <?php endif; ?></span>
			<a href="#" class="minus" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,-1,'topic'); return false;"></a>
		</li>
		<?php if (! $this->_tpl_vars['tSingle']): ?>
			<li class="comments-link">
				<?php if ($this->_tpl_vars['oTopic']->getCountComment() > 0): ?>
					<a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
#comments" title="<?php echo $this->_tpl_vars['aLang']['topic_comment_read']; ?>
"><?php echo $this->_tpl_vars['oTopic']->getCountComment(); ?>
 <span><?php if ($this->_tpl_vars['oTopic']->getCountCommentNew()): ?>+<?php echo $this->_tpl_vars['oTopic']->getCountCommentNew(); ?>
<?php endif; ?></span></a>
				<?php else: ?>
					<a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
#comments" title="<?php echo $this->_tpl_vars['aLang']['topic_comment_add']; ?>
">0</a>
				<?php endif; ?>
			</li>
		<?php endif; ?>
		<li class="username"><a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a></li>	
		<li class="date"><?php echo smarty_function_date_format(array('date' => $this->_tpl_vars['oTopic']->getDateAdd()), $this);?>
</li>
		<!-- <li><a href="#" onclick="lsFavourite.toggle(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,'topic'); return false;" class="favorite <?php if ($this->_tpl_vars['oUserCurrent']): ?><?php if ($this->_tpl_vars['oTopic']->getIsFavourite()): ?>active<?php endif; ?><?php else: ?>fav-guest<?php endif; ?>"></a></li> -->
		<?php if ($this->_tpl_vars['oTopic']->getType() == 'link'): ?>
			<li><a href="<?php echo smarty_function_router(array('page' => 'link'), $this);?>
go/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/" title="<?php echo $this->_tpl_vars['aLang']['topic_link_count_jump']; ?>
: <?php echo $this->_tpl_vars['oTopic']->getLinkCountJump(); ?>
"><?php echo $this->_tpl_vars['oTopic']->getLinkUrl(true); ?>
</a></li>
		<?php endif; ?>
		<?php echo smarty_function_hook(array('run' => 'topic_show_info','topic' => $this->_tpl_vars['oTopic']), $this);?>

	</ul>
	<?php if ($this->_tpl_vars['tSingle']): ?>
		<?php echo smarty_function_hook(array('run' => 'topic_show_end','topic' => $this->_tpl_vars['oTopic']), $this);?>

	<?php endif; ?>
</div>