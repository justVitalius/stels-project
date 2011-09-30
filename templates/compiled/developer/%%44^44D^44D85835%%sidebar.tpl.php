<?php /* Smarty version 2.6.19, created on 2011-09-26 17:11:49
         compiled from actions/ActionPeople/sidebar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'block', 'actions/ActionPeople/sidebar.tpl', 19, false),)), $this); ?>
<div class="block">
	<h2><?php echo $this->_tpl_vars['aLang']['user_stats']; ?>
</h2>
	
	<ul>
		<li><?php echo $this->_tpl_vars['aLang']['user_stats_all']; ?>
: <strong><?php echo $this->_tpl_vars['aStat']['count_all']; ?>
</strong></li>
		<li><?php echo $this->_tpl_vars['aLang']['user_stats_active']; ?>
: <strong><?php echo $this->_tpl_vars['aStat']['count_active']; ?>
</strong></li>
		<li><?php echo $this->_tpl_vars['aLang']['user_stats_noactive']; ?>
: <strong><?php echo $this->_tpl_vars['aStat']['count_inactive']; ?>
</strong></li>
	</ul>
	
	<br />
	
	<ul>
		<li><?php echo $this->_tpl_vars['aLang']['user_stats_sex_man']; ?>
: <strong><?php echo $this->_tpl_vars['aStat']['count_sex_man']; ?>
</strong></li>
		<li><?php echo $this->_tpl_vars['aLang']['user_stats_sex_woman']; ?>
: <strong><?php echo $this->_tpl_vars['aStat']['count_sex_woman']; ?>
</strong></li>
		<li><?php echo $this->_tpl_vars['aLang']['user_stats_sex_other']; ?>
: <strong><?php echo $this->_tpl_vars['aStat']['count_sex_other']; ?>
</strong></li>
	</ul>
</div>

<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'block', 'block' => 'tagsCountry')), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'block', 'block' => 'tagsCity')), $this); ?>