<?php /* Smarty version 2.6.19, created on 2011-10-01 14:26:31
         compiled from actions/ActionProfile/whois.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'actions/ActionProfile/whois.tpl', 22, false),array('modifier', 'date_format', 'actions/ActionProfile/whois.tpl', 28, false),array('function', 'router', 'actions/ActionProfile/whois.tpl', 62, false),array('function', 'date_format', 'actions/ActionProfile/whois.tpl', 114, false),)), $this); ?>
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
		<li class='user-info active'><a>информация</a></li>
		<li class='user-topics'><a <?php if ($this->_tpl_vars['iCountTopicUser']): ?>href="<?php echo smarty_function_router(array('page' => 'my'), $this);?>
<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
/"<?php endif; ?>>посты (<?php echo $this->_tpl_vars['sNumberTopicsByUser']; ?>
)</a></li>
		<li class='user-comments'><a <?php if ($this->_tpl_vars['iCountCommentUser']): ?>href="<?php echo smarty_function_router(array('page' => 'my'), $this);?>
<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
/comment/"<?php endif; ?>>комментарии (<?php echo $this->_tpl_vars['sNumberCommentsByUser']; ?>
)</a></li>
	</ul>
	<div class="clear"></div>
</div>

<div id="user-information">
	<?php if ($this->_tpl_vars['aBlogUsers']): ?>
	<div class="subscription">
		<div>подписка:</div>
		<div class="subscr">
		<?php $_from = $this->_tpl_vars['aBlogUsers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['blog_user'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['blog_user']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oBlogUser']):
        $this->_foreach['blog_user']['iteration']++;
?>
		<?php $this->assign('oBlog', $this->_tpl_vars['oBlogUser']->getBlog()); ?>
			<a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
<?php echo $this->_tpl_vars['oBlog']->getUrl(); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><?php if (! ($this->_foreach['blog_user']['iteration'] == $this->_foreach['blog_user']['total'])): ?>, <?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="clear"></div>
	
	<?php if ($this->_tpl_vars['aUsersFriend']): ?>
	<div class="friends">
		<div>друзья:</div>
		<div class="frien">
		<?php $_from = $this->_tpl_vars['aUsersFriend']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oUser']):
?>        						
			<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a>
		<?php endforeach; endif; unset($_from); ?>
		</div>
	</div>
	<?php endif; ?>
	
	
	<?php if ($this->_tpl_vars['oUserProfile']->getProfileSex() != 'other' || $this->_tpl_vars['oUserProfile']->getProfileBirthday() || ( $this->_tpl_vars['oUserProfile']->getProfileCountry() || $this->_tpl_vars['oUserProfile']->getProfileRegion() || $this->_tpl_vars['oUserProfile']->getProfileCity() ) || $this->_tpl_vars['oUserProfile']->getProfileAbout() || $this->_tpl_vars['oUserProfile']->getProfileSite()): ?>
					<h1 class="title"><?php echo $this->_tpl_vars['aLang']['profile_privat']; ?>
</h1>
					<table>		
						<?php if ($this->_tpl_vars['oUserProfile']->getProfileSex() != 'other'): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_sex']; ?>
:</td>
							<td>
								<?php if ($this->_tpl_vars['oUserProfile']->getProfileSex() == 'man'): ?>
									<?php echo $this->_tpl_vars['aLang']['profile_sex_man']; ?>

								<?php else: ?>
									<?php echo $this->_tpl_vars['aLang']['profile_sex_woman']; ?>

								<?php endif; ?>
							</td>
						</tr>
						<?php endif; ?>
							
						<?php if ($this->_tpl_vars['oUserProfile']->getProfileBirthday()): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_birthday']; ?>
:</td>
							<td><?php echo smarty_function_date_format(array('date' => $this->_tpl_vars['oUserProfile']->getProfileBirthday(),'format' => 'j F Y'), $this);?>
</td>
						</tr>
						<?php endif; ?>
						
						<?php if (( $this->_tpl_vars['oUserProfile']->getProfileCountry() || $this->_tpl_vars['oUserProfile']->getProfileRegion() || $this->_tpl_vars['oUserProfile']->getProfileCity() )): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_place']; ?>
:</td>
							<td>
							<?php if ($this->_tpl_vars['oUserProfile']->getProfileCountry()): ?>
								<a href="<?php echo smarty_function_router(array('page' => 'people'), $this);?>
country/<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserProfile']->getProfileCountry())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['oUserProfile']->getProfileCountry())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><?php if ($this->_tpl_vars['oUserProfile']->getProfileCity()): ?>,<?php endif; ?>
							<?php endif; ?>						
							<?php if ($this->_tpl_vars['oUserProfile']->getProfileCity()): ?>
								<a href="<?php echo smarty_function_router(array('page' => 'people'), $this);?>
city/<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserProfile']->getProfileCity())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['oUserProfile']->getProfileCity())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
							<?php endif; ?>
							</td>
						</tr>
						<?php endif; ?>
											
						<?php if ($this->_tpl_vars['oUserProfile']->getProfileAbout()): ?>					
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_about']; ?>
:</td>
							<td><?php echo ((is_array($_tmp=$this->_tpl_vars['oUserProfile']->getProfileAbout())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</td>
						</tr>	
						<?php endif; ?>
						
						<?php if ($this->_tpl_vars['oUserProfile']->getProfileSite()): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_site']; ?>
:</td>
							<td>
							<noindex>
							<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserProfile']->getProfileSite(true))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" rel="nofollow">
							<?php if ($this->_tpl_vars['oUserProfile']->getProfileSiteName()): ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserProfile']->getProfileSiteName())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

							<?php else: ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserProfile']->getProfileSite())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

							<?php endif; ?>
							</a>
							</noindex>
							</td>
						</tr>
						<?php endif; ?>
					</table>
					<br />	
					<?php endif; ?>
					<br />
					<h1 class="title"><?php echo $this->_tpl_vars['aLang']['profile_activity']; ?>
</h1>
					<table>
						<?php if ($this->_tpl_vars['aUsersFriend']): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_friends']; ?>
:</td>
							<td class="friends">
								<?php $_from = $this->_tpl_vars['aUsersFriend']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oUser']):
?>        						
	        						<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a>&nbsp; 
	        					<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<?php endif; ?>
						
						<?php if ($this->_tpl_vars['oConfig']->GetValue('general.reg.invite') && $this->_tpl_vars['oUserInviteFrom']): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_invite_from']; ?>
:</td>
							<td class="friends">							       						
	        					<a href="<?php echo $this->_tpl_vars['oUserInviteFrom']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUserInviteFrom']->getLogin(); ?>
</a>&nbsp;         					
							</td>
						</tr>
						<?php endif; ?>
						
						<?php if ($this->_tpl_vars['oConfig']->GetValue('general.reg.invite') && $this->_tpl_vars['aUsersInvite']): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_invite_to']; ?>
:</td>
							<td class="friends">
								<?php $_from = $this->_tpl_vars['aUsersInvite']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oUserInvite']):
?>        						
	        						<a href="<?php echo $this->_tpl_vars['oUserInvite']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUserInvite']->getLogin(); ?>
</a>&nbsp; 
	        					<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<?php endif; ?>
						
						<?php if ($this->_tpl_vars['aBlogsOwner']): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_blogs_self']; ?>
:</td>
							<td>							
								<?php $_from = $this->_tpl_vars['aBlogsOwner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['blog_owner'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['blog_owner']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oBlog']):
        $this->_foreach['blog_owner']['iteration']++;
?>
									<a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><?php if (! ($this->_foreach['blog_owner']['iteration'] == $this->_foreach['blog_owner']['total'])): ?>, <?php endif; ?>								      		
	        					<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<?php endif; ?>
						
						<?php if ($this->_tpl_vars['aBlogAdministrators']): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_blogs_administration']; ?>
:</td>
							<td>
								<?php $_from = $this->_tpl_vars['aBlogAdministrators']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['blog_user'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['blog_user']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oBlogUser']):
        $this->_foreach['blog_user']['iteration']++;
?>
									<?php $this->assign('oBlog', $this->_tpl_vars['oBlogUser']->getBlog()); ?>
									<a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><?php if (! ($this->_foreach['blog_user']['iteration'] == $this->_foreach['blog_user']['total'])): ?>, <?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<?php endif; ?>
						
						<?php if ($this->_tpl_vars['aBlogModerators']): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_blogs_moderation']; ?>
:</td>
							<td>
								<?php $_from = $this->_tpl_vars['aBlogModerators']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['blog_user'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['blog_user']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oBlogUser']):
        $this->_foreach['blog_user']['iteration']++;
?>
									<?php $this->assign('oBlog', $this->_tpl_vars['oBlogUser']->getBlog()); ?>
									<a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><?php if (! ($this->_foreach['blog_user']['iteration'] == $this->_foreach['blog_user']['total'])): ?>, <?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<?php endif; ?>
						
						<?php if ($this->_tpl_vars['aBlogUsers']): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_blogs_join']; ?>
:</td>
							<td>
								<?php $_from = $this->_tpl_vars['aBlogUsers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['blog_user'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['blog_user']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oBlogUser']):
        $this->_foreach['blog_user']['iteration']++;
?>
									<?php $this->assign('oBlog', $this->_tpl_vars['oBlogUser']->getBlog()); ?>
									<a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><?php if (! ($this->_foreach['blog_user']['iteration'] == $this->_foreach['blog_user']['total'])): ?>, <?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<?php endif; ?>
						
						<?php if ($this->_tpl_vars['aCompanyEmployee']): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['company_is_work']; ?>
:</td>
							<td>
								<?php $_from = $this->_tpl_vars['aCompanyEmployee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['company_user'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['company_user']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oCompanyEmploye']):
        $this->_foreach['company_user']['iteration']++;
?>
									<a href="<?php echo smarty_function_router(array('page' => 'company'), $this);?>
<?php echo $this->_tpl_vars['oCompanyEmploye']->getCompanyUrl(); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['oCompanyEmploye']->getCompanyName())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><?php if (! ($this->_foreach['company_user']['iteration'] == $this->_foreach['company_user']['total'])): ?>, <?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<?php endif; ?>
						
						<?php if ($this->_tpl_vars['aCompanyAdmirer']): ?>
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['company_is_like']; ?>
:</td>
							<td>
								<?php $_from = $this->_tpl_vars['aCompanyAdmirer']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['company_user'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['company_user']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oCompanyAdmirer']):
        $this->_foreach['company_user']['iteration']++;
?>
									<a href="<?php echo smarty_function_router(array('page' => 'company'), $this);?>
<?php echo $this->_tpl_vars['oCompanyAdmirer']->getCompanyUrl(); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['oCompanyAdmirer']->getCompanyName())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><?php if (! ($this->_foreach['company_user']['iteration'] == $this->_foreach['company_user']['total'])): ?>, <?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<?php endif; ?>
	
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_date_registration']; ?>
:</td>
							<td><?php echo smarty_function_date_format(array('date' => $this->_tpl_vars['oUserProfile']->getDateRegister()), $this);?>
</td>
						</tr>	
						<?php if ($this->_tpl_vars['oSession']): ?>				
						<tr>
							<td class="var"><?php echo $this->_tpl_vars['aLang']['profile_date_last']; ?>
:</td>
							<td><?php echo smarty_function_date_format(array('date' => $this->_tpl_vars['oSession']->getDateLast()), $this);?>
</td>
						</tr>						
					</table>
	      <?php endif; ?>
	
	
	<div class="clear"></div>	
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>