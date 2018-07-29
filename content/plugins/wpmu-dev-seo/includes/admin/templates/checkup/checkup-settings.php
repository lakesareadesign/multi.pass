<?php
$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
$checkup_url = Smartcrawl_Checkup_Settings::checkup_url();
$last_checked = $service->get_last_checked( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) );
?>
<div id="container"
     class="wrap wrap-wds wds-page wds-checkup-settings <?php echo $service->is_member() ? 'wds-is-member' : 'wds-is-not-member'; ?>">

	<section id="header">
		<?php $this->_render( 'settings-message-top' ); ?>
		<div class="actions">
			<?php
			printf(
				esc_html__( 'Last checked: %s', 'wds' ),
				esc_html( $last_checked )
			);
			?>
			<a href="<?php echo esc_attr( $checkup_url ); ?>" class="button button-small">
				<?php esc_html_e( 'Run checkup', 'wds' ); ?>
			</a>
			<a target="_blank" class="button button-small button-light actions-button"
			   href="https://premium.wpmudev.org/docs/wpmu-dev-plugins/smartcrawl/#chapter-1">
				<i class="wds-icon-academy"></i>
				<?php esc_html_e( 'View Documentation', 'wds' ); ?>
			</a>
		</div>
		<h1><?php esc_html_e( 'SEO Checkup', 'wds' ); ?></h1>
	</section><!-- end header -->

	<div class="wds-seo-checkup-stats-container">
		<?php $this->_render( 'checkup/checkup-top' ); ?>
	</div>

	<form action='<?php echo esc_attr( $_view['action_url'] ); ?>' method='post' class="wds-form">
		<?php settings_fields( $_view['option_name'] ); ?>

		<input type="hidden"
		       name='<?php echo esc_attr( $_view['option_name'] ); ?>[<?php echo esc_attr( $_view['slug'] ); ?>-setup]'
		       value="1">

		<div class="vertical-tabs" id="checkup-settings-tabs">
			<?php
			$this->_render( 'report-vertical-tab', array(
				'tab_id'       => 'tab_checkup',
				'tab_name'     => __( 'Checkup', 'wds' ),
				'is_active'    => 'tab_checkup' === $active_tab,
				'tab_sections' => array(
					array(
						'section_template' => 'checkup/checkup-checkup',
					),
				),
			) );
			?>
			<?php
			$is_member = $service->is_member();
			$this->_render(
				$is_member ? 'vertical-tab' : 'report-vertical-tab',
				array(
					'tab_id'       => 'tab_settings',
					'tab_name'     => __( 'Reporting', 'wds' ),
					'is_active'    => 'tab_settings' === $active_tab,
					'title_button' => 'upgrade',
					'tab_sections' => array(
						array(
							'section_description' => esc_html__( 'Set up SmartCrawl to automatically run a comprehensive checkup daily, weekly or monthly and receive an email report.', 'wds' ),
							'section_template'    => 'checkup/checkup-reporting',
						),
					),
				)
			);
			?>

		</div>
	</form>

	<?php $this->_render( 'upsell-modal' ); ?>
</div>
