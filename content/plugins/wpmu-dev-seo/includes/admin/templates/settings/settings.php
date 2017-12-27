<div id="container" class="wrap wrap-wds wds-page wds-page-settings">

	<section id="header">
		<?php $this->_render('settings-message-top'); ?>
		<h1><?php esc_html_e( 'SmartCrawl Settings' , 'wds' ); ?></h1>
	</section><!-- end header -->

<?php
	$wds_options = WDS_Settings::get_options();
	if (!is_network_admin() && !wds_is_allowed_tab($_view['slug'])) {
		printf( __( "Your network admin prevented access to '%s', please move onto next step.", 'wds' ), __( 'Settings' , 'wds' ) );
	} else if ( 'settings' === $_view['name'] || ( ! empty( $wds_options[ $_view['name'] ] ) ) ) {
?>

<div class="vertical-tabs">
	<?php
		$this->_render('vertical-tab', array(
			'tab_id'          => 'tab_general_settings',
			'tab_name'        => __('General Settings', 'wds'),
			'is_active'       => $active_tab == 'tab_general_settings',
			'before_output' => $this->_load('_forms/settings'),
			'after_output'  => '</form>',
			'tab_sections'    => array(
				array(
					'section_template' => 'settings/settings-section-general',
					'section_args'     => array(
						'verification_pages'  => $verification_pages,
						'sitemap_option_name' => $sitemap_option_name,
						'slugs'               => $slugs,
						'wds_sitewide_mode'   => $wds_sitewide_mode,
						'blog_tabs'           => $blog_tabs,
					)
				)
			)
		));
	?>

	<?php
		$this->_render('vertical-tab', array(
			'tab_id'          => 'tab_user_roles',
			'tab_name'        => __('User Roles', 'wds'),
			'is_active'       => $active_tab == 'tab_user_roles',
			'before_output' => $this->_load('_forms/settings'),
			'after_output'  => '</form>',
			'tab_sections'    => array(
				array(
					'section_template' => 'settings/settings-section-user-roles',
					'section_args'     => array(
						'seo_metabox_permission_level'        => $seo_metabox_permission_level,
						'seo_metabox_301_permission_level'    => $seo_metabox_301_permission_level,
						'urlmetrics_metabox_permission_level' => $urlmetrics_metabox_permission_level,
					)
				)
			)
		));
	?>

	<?php
		$this->_render('vertical-tab', array(
			'tab_id'       => 'tab_import_export',
			'tab_name'     => __('Import / Export', 'wds'),
			'is_active'    => $active_tab == 'tab_import_export',
			'button_text'  => false,
			'before_output' => $this->_load('_forms/import-export'),
			'after_output'  => '</form>',
			'tab_sections' => array(
				array(
					'section_template' => 'settings/settings-section-import-export'
				)
			)
		));
	?>
</div>

<?php

	} else {
		printf( __( "You've chosen not to set up '%s', please move onto next step.", 'wds' ), __( 'Settings' , 'wds' ) );
	}

?>