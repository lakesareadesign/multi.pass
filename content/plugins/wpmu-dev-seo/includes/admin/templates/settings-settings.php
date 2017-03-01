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

	<div class="row sub-header">
		<div class="wds-block-section">
			<p class="wds-page-desc"><?php esc_html_e( 'Here you can add your SEO Moz API details & configure additional plugin settings.' , 'wds' ); ?></p>
		</div>
	</div><!-- end sub-header -->

	<form action='<?php echo esc_attr($_view['action_url']); ?>' method='post' class="wds-form">
		<?php settings_fields( $_view['option_name'] ); ?>

		<input type="hidden" name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($_view['slug']); ?>-setup]' value="1">

		<div class="row">

			<div class="col-half col-half-settings col-half-settings-left">

				<section class="box-settings-seo-moz-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'SEO Moz Account', 'wds' ); ?></h3>
					</div>
					<div class="box-content">
						<p><?php _e( '<a href="http://moz.com/products/api" target="_blank">Sign-up for a free account</a> to gain access to reports that will tell you how your site stacks up against the competition with all of the important SEO measurement tools - ranking, links, and much more.' , 'wds' ); ?></p>

						<label class="wds-label" for="access-id'"><?php esc_html_e( 'Access ID', 'wds' ); ?></label>
						<input type="text" id='access-id' name='<?php echo esc_attr($_view['option_name']); ?>[access-id]' size='' value='<?php echo esc_attr($_view['options']['access-id']); ?>'>

						<label class="wds-label" for="secret-key'"><?php esc_html_e( 'Secret Key', 'wds' ); ?></label>
						<input type="text" id='secret-key' name='<?php echo esc_attr($_view['option_name']); ?>[secret-key]' size='' value='<?php echo esc_attr($_view['options']['secret-key']); ?>'>
					</div>
				</section><!-- end box-settings-seo-moz-settings -->

				<section class="box-settings-redirections-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Default Redirection type', 'wds' ); ?></h3>
					</div>
					<div class="box-content">

						<fieldset class="wds-fieldset">
							<!-- <legend class='screen-reader-text'> -->
							<?php
								if (empty($_view['options']['redirections-code'])) {
									$rmodel = new WDS_Model_Redirection;
									$_view['options']['redirections-code'] = $rmodel->get_default_redirection_status_type();
								}
							?>
							<div class="wds-fieldset-fields-group">
								<p class="group">
									<input class="wds-radio wds-radio-with-label" value='301' <?php checked($_view['options']['redirections-code'], 301); ?> id='wds-redirections-options-301' name='<?php echo esc_attr($_view['option_name']); ?>[redirections-code]' type='radio'>
									<label for="wds-redirections-options-301" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><?php echo esc_html_e('Permanent (301)', 'wds'); ?></label>
								</p>
								<p class="group">
									<input class="wds-radio wds-radio-with-label" value='302' <?php checked($_view['options']['redirections-code'], 302); ?> id='wds-redirections-options-302' name='<?php echo esc_attr($_view['option_name']); ?>[redirections-code]' type='radio'>
									<label for="wds-redirections-options-302" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><?php echo esc_html_e('Temporary (302)', 'wds'); ?></label>
								</p>
							</div><!-- end wds-fieldset-fields -->
						</fieldset><!-- end wds-fieldset -->

					</div>
				</section>

			<?php if (!is_multisite() || is_network_admin()) { ?>
				<section class="box-settings-activate-plugin dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Activate plugin section', 'wds' ); ?></h3>
					</div>
					<div class="box-content">
						<p><?php _e( 'Use this option if you would like to quickly disable one of the SmartCrawl sections. eg:<br> You want to quickly switch off Automatic Links. Usually you would want to have all enabled.', 'wds' ); ?></p>
						<?php
							foreach( $active_components as $item => $label ) {
								$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
								?>
								<p class="group">
									<span class="toggle">
										<input type="checkbox" class="toggle-checkbox" value="yes" name="<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]" id="<?php echo $_view['option_name']; ?>-active-components-<?php echo esc_attr($item); ?>" <?php echo $checked; ?>>
										<label class="toggle-label" for="<?php echo esc_attr($_view['option_name']); ?>-active-components-<?php echo esc_attr($item); ?>"></label>
									</span>
									<label class="wds-label wds-label-inline wds-label-inline-right" for="<?php echo $_view['option_name']; ?>-active-components-<?php echo esc_attr($item); ?>"><?php echo esc_html($label); ?></label>
								</p>
								<?php
							}
						?>
					</div>
				</section><!-- end box-settings-activate-plugin -->
			<?php } ?>

			</div><!-- end col-half-settings-left -->

			<div class="col-half col-half-settings col-half-settings-right">

				<section class="box-settings-show-metaboxes-users dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Show metaboxes to users', 'wds' ); ?></h3>
					</div>
					<div class="box-content">

						<fieldset class="wds-fieldset">
							<legend class="wds-fieldset-legend"><?php esc_html_e( 'Show SEO metabox to role' , 'wds' ); ?></legend>
							<div class="wds-fieldset-fields-group">
								<div class="select-container wds-multiselect">
									<select multiple name="<?php echo esc_attr($_view['option_name']); ?>[seo_metabox_permission_level][]">
									<?php foreach ($seo_metabox_permission_level as $item => $label) { ?>
										<?php
											$selected = !empty($_view['options']['seo_metabox_permission_level']) && is_array($_view['options']['seo_metabox_permission_level'])
												? (in_array($item, $_view['options']['seo_metabox_permission_level']) ? " selected='selected'" : '') // New
												: ($_view['options']['seo_metabox_permission_level'] === $item ? " selected='selected'" : '') // Legacy
											;
										?>
										<option
											<?php echo $selected; ?>
											value="<?php echo esc_attr($item); ?>"
										>
												<?php echo esc_html($label); ?>
										</option>
									<?php } ?>
									</select>
								</div>
							</div><!-- end wds-fieldset-fields -->
						</fieldset><!-- end wds-fieldset -->

						<fieldset class="wds-fieldset">
							<legend class="wds-fieldset-legend"><?php esc_html_e( 'Within SEO metabox, show 301 redirection to role' , 'wds' ); ?></legend>
							<div class="wds-fieldset-fields-group">
								<div class="select-container wds-multiselect">
									<select multiple name="<?php echo esc_attr($_view['option_name']); ?>[seo_metabox_301_permission_level][]">
									<?php foreach ($seo_metabox_301_permission_level as $item => $label) { ?>
										<?php
											$selected = !empty($_view['options']['seo_metabox_301_permission_level']) && is_array($_view['options']['seo_metabox_301_permission_level'])
												? (in_array($item, $_view['options']['seo_metabox_301_permission_level']) ? " selected='selected'" : '') // New
												: ($_view['options']['seo_metabox_301_permission_level'] === $item ? " selected='selected'" : '') // Legacy
											;
										?>
										<option
											<?php echo $selected; ?>
											value="<?php echo esc_attr($item); ?>"
										>
												<?php echo esc_html($label); ?>
										</option>
									<?php } ?>
									</select>
								</div>
							</div><!-- end wds-fieldset-fields -->
						</fieldset><!-- end wds-fieldset -->

						<fieldset class="wds-fieldset">
							<legend class="wds-fieldset-legend"><?php esc_html_e( 'Show Moz metabox to roles' , 'wds' ); ?></legend>
							<div class="wds-fieldset-fields-group">
								<div class="select-container wds-multiselect">
									<select multiple name="<?php echo esc_attr($_view['option_name']); ?>[urlmetrics_metabox_permission_level][]">
									<?php foreach ($urlmetrics_metabox_permission_level as $item => $label) { ?>
										<?php
											$selected = !empty($_view['options']['urlmetrics_metabox_permission_level']) && is_array($_view['options']['urlmetrics_metabox_permission_level'])
												? (in_array($item, $_view['options']['urlmetrics_metabox_permission_level']) ? " selected='selected'" : '') // New
												: ($_view['options']['urlmetrics_metabox_permission_level'] === $item ? " selected='selected'" : '') // Legacy
											;
										?>
										<option
											<?php echo $selected; ?>
											value="<?php echo esc_attr($item); ?>"
										>
												<?php echo esc_html($label); ?>
										</option>
									<?php } ?>
									</select>
								</div>
							</div><!-- end wds-fieldset-fields -->
						</fieldset><!-- end wds-fieldset -->

					</div>
				</section><!-- end box-settings-show-metaboxes-users -->

				<?php
					if ( is_multisite() && is_network_admin() ) {
				?>
					<section class="box-settings-site-owner-permissions dev-box">
						<div class="box-title">
							<h3><?php esc_html_e( 'Site Owner Permissions', 'wds' ); ?></h3>
						</div>
						<div class="box-content">
							<p><?php esc_html_e( 'Use this section to chose what sections of this plugin will be accessible to Site Admins on your Network.' , 'wds' ); ?></p>
							<?php
								foreach( $slugs as $item => $label ) {
									$checked = ( ! empty( $blog_tabs[$item] ) ) ? "checked='checked' " : '';
									?>
									<p class="group">
										<span class="toggle">
											<input type="checkbox" class="toggle-checkbox" value="yes" name="<?php echo esc_attr($_view['option_name']); ?>[wds_blog_tabs][<?php echo esc_attr($item); ?>]" id="wds_blog_tabs-<?php echo esc_attr($item); ?>" <?php echo $checked; ?>>
											<label class="toggle-label" for="wds_blog_tabs-<?php echo esc_attr($item); ?>"></label>
										</span>
										<label class="wds-label wds-label-inline wds-label wds-label-inline-right" for="wds_blog_tabs-<?php echo esc_attr($item); ?>"><?php echo esc_html($label); ?></label>
									</p>
									<?php
								}
							?>
						</div>
					</section><!-- end box-settings-site-owner-permissions -->

				<?php
					}
				?>

			</div><!-- end col-half-settings-right -->

		</div><!-- end row -->

		<div class="block-section-footer buttons">
			<input name='submit' type='submit' class='button button-cta-alt' value='<?php echo esc_attr( __( 'Save Settings' , 'wds') ); ?>'>
		</div>

	</form>

	<?php // echo $additional; ?>

<?php

	} else {
		printf( __( "You've chosen not to set up '%s', please move onto next step.", 'wds' ), __( 'Settings' , 'wds' ) );
	}

?>

</div><!-- end wds-page-settings -->