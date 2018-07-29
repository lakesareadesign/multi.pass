<?php
/**
 * Dashboard root template
 *
 * @package wpmu-dev-seo
 */
?>
<div id="container" class="wrap wrap-wds wds-page wds-dashboard">
	<section id="header">
		<div class="actions">
			<a target="_blank" class="button button-small button-light actions-button"
			   href="https://premium.wpmudev.org/docs/wpmu-dev-plugins/smartcrawl/#chapter-7">
				<i class="wds-icon-academy"></i>
				<?php esc_html_e( 'View Documentation', 'wds' ); ?>
			</a>
		</div>

		<h1><?php esc_html_e( 'Dashboard', 'wds' ); ?></h1>
	</section>

	<div class="row">
		<?php $this->_render( 'dashboard/dashboard-top' ); ?>
	</div>

	<div class="row">
		<div class="col-half col-half-dashboard col-half-dashboard-left">
			<?php
			if ( smartcrawl_can_show_dash_widget_for( Smartcrawl_Settings_Settings::TAB_CHECKUP ) ) {
				$this->_render( 'dashboard/dashboard-widget-seo-checkup' );
			}
			?>
			<?php $this->_render( 'dashboard/dashboard-widget-content-analysis' ); ?>
			<?php
			if ( smartcrawl_can_show_dash_widget_for( Smartcrawl_Settings_Settings::TAB_SOCIAL ) ) {
				$this->_render( 'dashboard/dashboard-widget-social' );
			}
			?>
		</div>

		<div class="col-half col-half-dashboard col-half-dashboard-right">
			<?php
			if ( smartcrawl_can_show_dash_widget_for( Smartcrawl_Settings_Settings::TAB_ONPAGE ) ) {
				$this->_render( 'dashboard/dashboard-widget-onpage' );
			}
			?>
			<?php
			if ( smartcrawl_can_show_dash_widget_for( Smartcrawl_Settings_Settings::TAB_SITEMAP ) ) {
				$this->_render( 'dashboard/dashboard-widget-sitemap' );
			}
			?>
			<?php
			if ( smartcrawl_can_show_dash_widget_for( Smartcrawl_Settings_Settings::TAB_AUTOLINKS ) ) {
				$this->_render( 'dashboard/dashboard-widget-advanced-tools' );
			}
			?>
		</div>
	</div>

	<?php $this->_render( 'upsell-modal' ); ?>
</div>
<?php do_action( 'wds-dshboard-after_settings' ); ?>