<?php /* Smarty version 2.6.19, created on 2011-10-01 13:15:16
         compiled from footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hook', 'footer.tpl', 1, false),array('function', 'cfg', 'footer.tpl', 13, false),array('function', 'router', 'footer.tpl', 14, false),)), $this); ?>
		<?php echo smarty_function_hook(array('run' => 'content_end'), $this);?>

		</div><!-- /content -->

	</div><!-- /wrapper -->
	<div id="wrapper-foot">&nbsp;</div>
</div><!-- /container -->
<div id="footer-img" class="footer-img" ></div>
	<div id="footer">
	  
	  <div class="container">
  	    <div id="footer-nav">
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
        </div>
        <div id="logo_studio">
          <a href="http://www.avatech.in/">Дизайн струдия Avatech</a>
        </div>
		</div>
	</div>



<?php echo smarty_function_hook(array('run' => 'body_end'), $this);?>


</body>
</html>