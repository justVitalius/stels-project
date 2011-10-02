<?php /* Smarty version 2.6.19, created on 2011-10-02 14:17:58
         compiled from block.ads.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'block.ads.tpl', 2, false),)), $this); ?>
<div class="block advertisement">
	<a href='<?php echo $this->_tpl_vars['sBannerLink']; ?>
'><img src='<?php echo smarty_function_cfg(array('name' => "path.root.web"), $this);?>
/<?php echo $this->_tpl_vars['sBannerImage']; ?>
' alt='<?php echo $this->_tpl_vars['sBannerLink']; ?>
' /></a>
</div>