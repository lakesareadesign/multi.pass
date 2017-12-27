<div id="container" class="wrap wrap-wds wds-page wds-dashboard">
	<section id="header">
		<h1><?php esc_html_e('Dashboard', 'wds'); ?></h1>
	</section>

	<div class="row">
		<?php $this->_render('dashboard/dashboard-top'); ?>
	</div>

	<div class="row">
		<div class="col-half col-half-dashboard col-half-dashboard-left">
			<?php $this->_render('dashboard/dashboard-widget-seo-checkup'); ?>
			<?php $this->_render('dashboard/dashboard-widget-content-analysis'); ?>
			<?php $this->_render('dashboard/dashboard-widget-social'); ?>
		</div>

		<div class="col-half col-half-dashboard col-half-dashboard-right">
			<?php $this->_render('dashboard/dashboard-widget-onpage'); ?>
			<?php $this->_render('dashboard/dashboard-widget-sitemap'); ?>
			<?php $this->_render('dashboard/dashboard-widget-advanced-tools'); ?>
		</div>
	</div>

	<?php $this->_render('upsell-modal'); ?>
</div>
<?php do_action('wds-dshboard-after_settings'); ?>