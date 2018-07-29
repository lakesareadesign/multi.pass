<div id="container" class="wrap wrap-wds wds-page wds-page-settings">

	<section id="header">
		<div class="actions">
			<a target="_blank" class="button button-small button-light actions-button"
			   href="https://premium.wpmudev.org/docs/wpmu-dev-plugins/smartcrawl/#chapter-6">
				<i class="wds-icon-academy"></i>
				<?php esc_html_e( 'View Documentation', 'wds' ); ?>
			</a>
		</div>

		<?php $this->_render( 'settings-message-top' ); ?>
		<h1><?php esc_html_e( 'SmartCrawl Settings', 'wds' ); ?></h1>
	</section><!-- end header -->
	<div class="vertical-tabs">
		<?php
		$this->_render( 'vertical-tab', array(
			'tab_id'        => 'tab_general_settings',
			'tab_name'      => __( 'General Settings', 'wds' ),
			'is_active'     => 'tab_general_settings' === $active_tab,
			'before_output' => $this->_load( '_forms/settings' ),
			'after_output'  => '</form>',
			'tab_sections'  => array(
				array(
					'section_template' => 'settings/settings-section-general',
					'section_args'     => array(
						'verification_pages'  => $verification_pages,
						'sitemap_option_name' => $sitemap_option_name,
						'slugs'               => $slugs,
						'wds_sitewide_mode'   => $wds_sitewide_mode,
						'blog_tabs'           => $blog_tabs,
						'plugin_modules'      => $plugin_modules,
					),
				),
			),
		) );
		?>

		<?php
		$this->_render( 'vertical-tab', array(
			'tab_id'        => 'tab_user_roles',
			'tab_name'      => __( 'User Roles', 'wds' ),
			'is_active'     => 'tab_user_roles' === $active_tab,
			'before_output' => $this->_load( '_forms/settings' ),
			'after_output'  => '</form>',
			'tab_sections'  => array(
				array(
					'section_template' => 'settings/settings-section-user-roles',
					'section_args'     => array(
						'seo_metabox_permission_level'        => $seo_metabox_permission_level,
						'seo_metabox_301_permission_level'    => $seo_metabox_301_permission_level,
						'urlmetrics_metabox_permission_level' => $urlmetrics_metabox_permission_level,
					),
				),
			),
		) );
		?>

		<?php
		$this->_render( 'vertical-tab', array(
			'tab_id'        => 'tab_import_export',
			'tab_name'      => __( 'Import / Export', 'wds' ),
			'is_active'     => 'tab_import_export' === $active_tab,
			'button_text'   => false,
			'before_output' => $this->_load( '_forms/import-export' ),
			'after_output'  => '</form>',
			'tab_sections'  => array(
				array(
					'section_template' => 'settings/settings-section-import-export',
				),
			),
		) );
		?>
	</div>
</div>