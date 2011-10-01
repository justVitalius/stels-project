<?php /* Smarty version 2.6.19, created on 2011-10-01 11:18:03
         compiled from header_top.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'header_top.tpl', 9, false),array('function', 'hook', 'header_top.tpl', 12, false),array('function', 'cfg', 'header_top.tpl', 45, false),)), $this); ?>



<div id="header">
	<?php if (! $this->_tpl_vars['oUserCurrent']): ?>
		<div class="login-form">
			<a href="#" class="close" onclick="hideLoginForm(); return false;"></a>

			<form action="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
" method="POST">
				<h3><?php echo $this->_tpl_vars['aLang']['user_authorization']; ?>
</h3>

				<?php echo smarty_function_hook(array('run' => 'form_login_popup_begin'), $this);?>


				<p><label><?php echo $this->_tpl_vars['aLang']['user_login']; ?>
:<br />
				<input type="text" class="input-text" name="login" id="login-input"/></label></p>

				<p><label><?php echo $this->_tpl_vars['aLang']['user_password']; ?>
:<br />
				<input type="password" name="password" class="input-text" /></label></p>

				<p><label><input type="checkbox" name="remember" class="checkbox" checked /><?php echo $this->_tpl_vars['aLang']['user_login_remember']; ?>
</label></p>

				<?php echo smarty_function_hook(array('run' => 'form_login_popup_end'), $this);?>


				<input type="submit" name="submit_login" value="<?php echo $this->_tpl_vars['aLang']['user_login_submit']; ?>
" /><br /><br />

				<a href="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
reminder/"><?php echo $this->_tpl_vars['aLang']['user_password_reminder']; ?>
</a><br />
				<a href="<?php echo smarty_function_router(array('page' => 'registration'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['user_registration']; ?>
</a>
			</form>
		</div>
	<?php endif; ?>
	<div id="registrtionIn">
	   <a href="#" class="img">Войоти/Регистрация</a>
	   <div class="clear"></div>
	   <?php if ($this->_tpl_vars['oUserCurrent']): ?>
	      <a href="<?php echo $this->_tpl_vars['oUserCurrent']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUserCurrent']->getLogin(); ?>
</a>
	    <?php else: ?>
	    <a href="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
" onclick="showLoginForm(); return false">вход</a><span> / </span>
      <a href="<?php echo smarty_function_router(array('page' => 'registration'), $this);?>
">регистрация</a>
      <?php endif; ?>

	</div>
	<div id="topnav">
		<!-- <?php echo $this->_tpl_vars['sAction']; ?>
!!!<?php echo $this->_tpl_vars['sEvent']; ?>
 -->
		<ul class="pages">
			<li <?php if ($this->_tpl_vars['sAction'] == 'index'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
" style="margin-left:5px">Главная</a></li>
			<li <?php if ($this->_tpl_vars['sAction'] == 'blogs' && $this->_tpl_vars['sEvent'] == 'good'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_router(array('page' => 'blogs'), $this);?>
">Блоги</a></li>
			<li <?php if ($this->_tpl_vars['sEvent'] == 'qa'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
/blog/qa/">Q&A</a></li>
			<li <?php if ($this->_tpl_vars['sAction'] == 'people'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_router(array('page' => 'people'), $this);?>
">Пользователи</a></li>
			<li <?php if ($this->_tpl_vars['sAction'] == 'companies'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
/#">Компании</a></li>
			<li <?php if ($this->_tpl_vars['sEvent'] == 'events'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
/blog/events/">События</a></li>
			<li <?php if ($this->_tpl_vars['sEvent'] == 'competitions'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
/blog/competitions/"  style="margin-right:5px">Конкурсы</a></li>
			<?php echo smarty_function_hook(array('run' => 'main_menu'), $this);?>

		</ul>
		<div id="topnav-foot">&nbsp;</div>
		<!-- Searchform block -->
    <div class="block searchform header">
      <form id="search-form" action="<?php echo smarty_function_router(array('page' => 'search'), $this);?>
topics/" method="GET">
        <input id="search-area" type="text" onblur="if (!value) value=defaultValue" onclick="if (value==defaultValue) value=''" value="поиск..." name="q" />
      </form>
    </div>
	</div>
	<h1><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
">ЭНЕРГОБЛОГ</a></h1>
</div>