<?php /* Smarty version 2.6.19, created on 2011-10-02 14:15:31
         compiled from paging.tpl */ ?>
<?php if ($this->_tpl_vars['aPaging'] && $this->_tpl_vars['aPaging']['iCountPage'] > 1): ?> 
	<div class="pagination">
		<ul>			
			<!-- <?php if ($this->_tpl_vars['aPaging']['iPrevPage']): ?>
							<li class='prev-page'><a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/page<?php echo $this->_tpl_vars['aPaging']['iPrevPage']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
">&nbsp;</a></li>
						<?php else: ?>
							<li class='prev-page'>&nbsp;</li>
						<?php endif; ?> -->
			
			
			<li class='first-page'><a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
">&nbsp;</a></li>
			
			<?php $_from = $this->_tpl_vars['aPaging']['aPagesLeft']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['before'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['before']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['iPage']):
        $this->_foreach['before']['iteration']++;
?>
				<li class='i-page <?php if (($this->_foreach['before']['iteration'] <= 1)): ?>first<?php endif; ?>'><a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/page<?php echo $this->_tpl_vars['iPage']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
"><?php echo $this->_tpl_vars['iPage']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
			
			<?php if (! $this->_tpl_vars['aPaging']['aPagesLeft']): ?>
			<li class="active-page first"><a><?php echo $this->_tpl_vars['aPaging']['iCurrentPage']; ?>
</a></li>
			<?php else: ?>
			<?php if (! $this->_tpl_vars['aPaging']['aPagesRight']): ?>
			<li class="active-page last"><a><?php echo $this->_tpl_vars['aPaging']['iCurrentPage']; ?>
</a></li>
			<?php else: ?>
			<li class="active-page i-page"><a><?php echo $this->_tpl_vars['aPaging']['iCurrentPage']; ?>
</a></li>
			<?php endif; ?>
			<?php endif; ?>
			
			<?php $_from = $this->_tpl_vars['aPaging']['aPagesRight']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['after'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['after']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['iPage']):
        $this->_foreach['after']['iteration']++;
?>
				<li class='i-page <?php if (($this->_foreach['after']['iteration'] == $this->_foreach['after']['total'])): ?>last<?php endif; ?>'><a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/page<?php echo $this->_tpl_vars['iPage']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
"><?php echo $this->_tpl_vars['iPage']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
			
			
			<li class='last-page'><a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/page<?php echo $this->_tpl_vars['aPaging']['iCountPage']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
">&nbsp;</a></li>

			<!-- <?php if ($this->_tpl_vars['aPaging']['iNextPage']): ?>
							<li class='next-page'><a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/page<?php echo $this->_tpl_vars['aPaging']['iNextPage']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
">&nbsp;</a></li>
						<?php else: ?>
							<li class='next-page'>&nbsp;</li>
						<?php endif; ?> -->
		</ul>
		<div class="clear"></div>
	</div>
<?php endif; ?>