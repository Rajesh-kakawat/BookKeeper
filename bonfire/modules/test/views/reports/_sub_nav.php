<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/test') ?>" id="list"><?php echo lang('test_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Test.Reports.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/reports/test/create') ?>" id="create_new"><?php echo lang('test_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>