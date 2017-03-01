<div id="container" class="wrap wrap-wds wds-page wds-sitemap-settings">

	<section id="header">
		<?php $this->_render('settings-message-top'); ?>
		<h1><?php esc_html_e( 'Sitemaps' , 'wds' ); ?></h1>
	</section><!-- end header -->

<?php
	$wds_options = WDS_Settings::get_options();
	if ( ! wds_is_allowed_tab( $_view['slug'] ) ) {
		printf( __( "Your network admin prevented access to '%s', please move onto next step.", 'wds' ), __( 'Sitemaps' , 'wds' ) );
	} else if ( 'settings' === $_view['name'] || ( ! empty( $wds_options[ $_view['name'] ] ) ) ) {

?>
	<div class="row sub-header">
		<div class="wds-block-section">
			<p class="wds-page-desc"><?php esc_html_e( 'Here we will help you create a site map which are used to help search engines find all of the information on your site.' , 'wds' ); ?></p>
		</div>
	</div><!-- end sub-header -->

	<form action='<?php echo $_view['action_url']; ?>' method='post' class="wds-form">
		<?php settings_fields( $_view['option_name'] ); ?>

		<input type="hidden" name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($_view['slug']); ?>-setup]' value="1">

		<div class="row">

			<div class="col-half col-half-sitemaps col-half-sitemaps-left">

				<section class="box-sitemaps-xml-sitemap-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'XML Sitemap', 'wds' ); ?></h3>
					</div>
					<div class="box-content">
						<p><?php esc_html_e( 'Path to the XML Sitemap', 'wds' ); ?></p>
						<div class="wds-block-content wds-block-content-grey">
							<pre><?php echo wds_get_sitemap_path(); ?></pre>
						</div>
						<p><?php esc_html_e( 'URL to the XML Sitemap', 'wds' ); ?>: <a target="_blank" href="<?php echo esc_attr(wds_get_sitemap_url()); ?>"><?php echo esc_html(wds_get_sitemap_url()); ?></a></p>
					</div>
				</section><!-- end box-sitemaps-xml-sitemap-settings -->

				<section class="box-sitemaps-search-engines-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Search Engines', 'wds' ); ?></h3>
					</div>
					<div class="box-content">

						<p class="group wds-group wds-group-field">
							<label for="verification-google" class="wds-label"><?php esc_html_e( 'Google site verification code' , 'wds' ); ?></label>
							<input id='verification-google' name='<?php echo esc_attr($_view['option_name']); ?>[verification-google]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['verification-google']); ?>'>
							<span class="wds-field-legend"><?php echo $google_msg; ?></span>
						</p>

						<p class="group wds-group wds-group-field">
							<label for="verification-bing" class="wds-label"><?php esc_html_e( 'Bing site verification code' , 'wds' ); ?></label>
							<input id='verification-bing' name='<?php echo esc_attr($_view['option_name']); ?>[verification-bing]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['verification-bing']); ?>'>
							<span class="wds-field-legend"><?php echo $bing_msg; ?></span>
						</p>

						<fieldset class="wds-fieldset">
							<!-- <legend class='screen-reader-text'> -->
							<legend class="wds-fieldset-legend"><?php esc_html_e( 'Add verification code to', 'wds' ); ?></legend>
							<div class="wds-fieldset-fields-group">
							<?php
								foreach( $verification_pages as $item => $label ) {
									$checked = ( $_view['options']['verification-pages'] == $item ) ? "checked='checked' " : '';
									?>
										<p class="group">
											<input class="wds-radio wds-radio-with-label" value='<?php echo esc_attr($item); ?>' <?php echo $checked; ?> id='<?php echo esc_attr($_view['option_name']); ?>-verification-pages-<?php echo esc_attr($item); ?>' name='<?php echo esc_attr($_view['option_name']); ?>[verification-pages]' type='radio'>
											<label for="<?php echo esc_attr($_view['option_name']); ?>-verification-pages-<?php echo esc_attr($item); ?>" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><?php echo esc_html($label); ?></label>
										</p>
									<?php
								}
							?>
							</div><!-- end wds-fieldset-fields -->
						</fieldset><!-- end wds-fieldset -->

						<fieldset class="wds-fieldset">
							<!-- <legend class='screen-reader-text'> -->
							<legend class="wds-fieldset-legend"><?php esc_html_e( 'Automatically notify search engines when my sitemap updates', 'wds' ); ?></legend>
							<div class="wds-fieldset-fields-group">
							<?php
								foreach( $engines as $item => $label ) {
									$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
									?>
										<p class="group">
											<input class="wds-checkbox wds-checkbox-with-label" value='yes' <?php echo $checked; ?> id='<?php echo esc_attr($_view['option_name']); ?>-engines-<?php echo esc_attr($item); ?>' name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]' type='checkbox'>
											<label for="<?php echo esc_attr($_view['option_name']); ?>-engines-<?php echo esc_attr($item); ?>" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><?php echo esc_html($label); ?></label>
										</p>
									<?php
								}
							?>
							</div><!-- end wds-fieldset-fields -->
						</fieldset><!-- end wds-fieldset -->

					</div>
				</section><!-- end box-sitemaps-search-engines-settings -->

			</div><!-- col-half-sitemaps-left -->

			<div class="col-half col-half-sitemaps col-half-sitemaps-right">

				<section class="box-sitemaps-excludes-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Excludes', 'wds' ); ?></h3>
					</div>
					<div class="box-content">

						<fieldset class="wds-fieldset">
							<!-- <legend class='screen-reader-text'> -->
							<legend class="wds-fieldset-legend"><?php esc_html_e( 'Exclude Post Types', 'wds' ); ?></legend>
							<div class="wds-fieldset-fields-group">
								<div class="select-container wds-multiselect">
									<select multiple name="<?php echo esc_attr($_view['option_name']); ?>[exclude_post_types][]">
									<?php foreach ($post_types as $item => $label) { ?>
										<option
											value="<?php echo esc_attr($item); ?>"
											<?php selected(true, !empty($_view['options'][$item])); ?>
										><?php echo esc_html($label); ?></option>
									<?php } ?>
									</select>
								</div>
							</div><!-- end wds-fieldset-fields -->
						</fieldset><!-- end wds-fieldset -->

						<fieldset class="wds-fieldset">
							<!-- <legend class='screen-reader-text'> -->
							<legend class="wds-fieldset-legend"><?php esc_html_e( 'Exclude Taxonomies', 'wds' ); ?></legend>
							<div class="wds-fieldset-fields-group">
								<div class="select-container wds-multiselect">
									<select multiple name="<?php echo esc_attr($_view['option_name']); ?>[exclude_taxonomies][]">
									<?php foreach ($taxonomies as $item => $label) { ?>
										<option
											value="<?php echo esc_attr($item); ?>"
											<?php selected(true, !empty($_view['options'][$item])); ?>
										><?php echo esc_html($label); ?></option>
									<?php } ?>
									</select>
								</div>
							</div><!-- end wds-fieldset-fields -->
						</fieldset><!-- end wds-fieldset -->

					</div>
				</section><!-- end box-sitemaps-excludes-settings -->

				<section class="box-sitemaps-options-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Options', 'wds' ); ?></h3>
					</div>
					<div class="box-content">

						<?php
							foreach( $checkbox_options as $item => $label ) {
								$checked = ( ! empty( $_view['options']['sitemap-images'] ) ) ? "checked='checked' " : '';
								?>
								<p class="group">
									<span class="toggle">
										<input type="checkbox" class="toggle-checkbox" value='<?php echo esc_attr($item); ?>' name="<?php echo esc_attr($_view['option_name']); ?>[sitemap-images]" id="<?php echo esc_attr($_view['option_name']); ?>-sitemap-images-<?php echo esc_attr($item); ?>" <?php echo $checked; ?>>
										<label class="toggle-label" for="<?php echo esc_attr($_view['option_name']); ?>-sitemap-images-<?php echo esc_attr($item); ?>"></label>
									</span>
									<label class="wds-label wds-label-inline wds-label-inline-right" for="<?php echo esc_attr($_view['option_name']); ?>-sitemap-images-<?php echo esc_attr($item); ?>">
										<?php esc_html_e( 'Include image items with the sitemap' , 'wds' ); ?>
										<span class="wds-label-description"><?php esc_html_e( 'Enabling this option will considerably increase plugin memory consumption.' , 'wds' ); ?></span>
									</label>
								</p>
								<?php
							}
						?>

						<?php
							foreach( $checkbox_options as $item => $label ) {
								$checked = ( ! empty( $_view['options']['sitemap-stylesheet'] ) ) ? "checked='checked' " : '';
								?>
								<p class="group">
									<span class="toggle">
										<input type="checkbox" class="toggle-checkbox" value='<?php echo esc_attr($item); ?>' name="<?php echo esc_attr($_view['option_name']); ?>[sitemap-stylesheet]" id="<?php echo esc_attr($_view['option_name']); ?>-sitemap-stylesheet-<?php echo esc_attr($item); ?>" <?php echo $checked; ?>>
										<label class="toggle-label" for="<?php echo esc_attr($_view['option_name']); ?>-sitemap-stylesheet-<?php echo esc_attr($item); ?>"></label>
									</span>
									<label class="wds-label wds-label-inline wds-label-inline-right" for="<?php echo esc_attr($_view['option_name']); ?>-sitemap-stylesheet-<?php echo esc_attr($item); ?>">
										<?php esc_html_e( 'Include stylesheet with the generated sitemap' , 'wds' ); ?>
										<span class="wds-label-description"><?php esc_html_e( 'Stylesheet does not affect your sitemap functionality in any way.' , 'wds' ); ?></span>
									</label>
								</p>
								<?php
							}
						?>

						<?php
							foreach( $checkbox_options as $item => $label ) {
								$checked = ( ! empty( $_view['options']['sitemap-dashboard-widget'] ) ) ? "checked='checked' " : '';
								?>
								<p class="group">
									<span class="toggle">
										<input type="checkbox" class="toggle-checkbox" value='<?php echo esc_attr($item); ?>' name="<?php echo esc_attr($_view['option_name']); ?>[sitemap-dashboard-widget]" id="<?php echo esc_attr($_view['option_name']); ?>-sitemap-dashboard-widget-<?php echo esc_attr($item); ?>" <?php echo $checked; ?>>
										<label class="toggle-label" for="<?php echo esc_attr($_view['option_name']); ?>-sitemap-dashboard-widget-<?php echo esc_attr($item); ?>"></label>
									</span>
									<label class="wds-label wds-label-inline wds-label-inline-right" for="<?php echo esc_attr($_view['option_name']); ?>-sitemap-dashboard-widget-<?php echo esc_attr($item); ?>">
										<?php esc_html_e( 'Show dashboard widget' , 'wds' ); ?>
										<span class="wds-label-description"><?php esc_html_e( 'Enabling this option will add an Admin Dashboard widget that displays your sitemap information.' , 'wds' ); ?></span>
									</label>
								</p>
								<?php
							}
						?>

						<?php
							foreach( $checkbox_options as $item => $label ) {
								$checked = ( ! empty( $_view['options']['sitemap-disable-automatic-regeneration'] ) ) ? "checked='checked' " : '';
								?>
								<p class="group">
									<span class="toggle">
										<input type="checkbox" class="toggle-checkbox" value='<?php echo esc_attr($item); ?>' name="<?php echo esc_attr($_view['option_name']); ?>[sitemap-disable-automatic-regeneration]" id="<?php echo esc_attr($_view['option_name']); ?>-sitemap-disable-automatic-regeneration-<?php echo esc_attr($item); ?>" <?php echo $checked; ?>>
										<label class="toggle-label" for="<?php echo esc_attr($_view['option_name']); ?>-sitemap-disable-automatic-regeneration-<?php echo esc_attr($item); ?>"></label>
									</span>
									<label class="wds-label wds-label-inline wds-label-inline-right" for="<?php echo esc_attr($_view['option_name']); ?>-sitemap-disable-automatic-regeneration-<?php echo esc_attr($item); ?>">
										<?php esc_html_e( 'Disable automatic sitemap updates' , 'wds' ); ?>
										<span class="wds-label-description"><?php esc_html_e( 'Enable this option if you wish to update your sitemaps manually (by using the Dashboard widget or visiting this page) only.' , 'wds' ); ?></span>
									</label>
								</p>
								<?php
							}
						?>

					</div>
				</section><!-- end box-sitemaps-options-settings -->

			<?php
				if (!empty($wds_buddypress)) {
					$this->_render('sitemap-buddypress-settings', $wds_buddypress);
				}
			?>

			</div><!-- col-half-sitemaps-right -->

		</div><!-- end row -->

		<div class="block-section-footer buttons">
			<input name='submit' type='submit' class='button button-cta-alt' value='<?php echo esc_attr( __( 'Save Settings' , 'wds') ); ?>'>
		</div>

	</form>

	<?php // echo $additional; ?>

<?php

	} else {
		printf( __( "You've chosen not to set up '%s', please move onto next step.", 'wds' ), __( 'Sitemaps' , 'wds' ) );
	}

?>

</div><!-- end wds-sitemap-settings -->