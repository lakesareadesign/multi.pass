<div id="container" class="wrap wrap-wds wds-page wds-page-autolinks">

	<section id="header">
		<?php $this->_render('settings-message-top'); ?>
		<h1><?php esc_html_e( 'Automatic Links' , 'wds' ); ?></h1>
	</section><!-- end header -->

<?php
	$wds_options = WDS_Settings::get_options();
	if ( ! wds_is_allowed_tab( $_view['slug'] ) ) {
		printf( __( "Your network admin prevented access to '%s', please move onto next step.", 'wds' ), __( 'Automatic Links' , 'wds' ) );
	} else if ( 'settings' === $_view['name'] || ( ! empty( $wds_options[ $_view['name'] ] ) ) ) {

?>

	<div class="row sub-header">
		<div class="wds-block-section">
			<p class="wds-page-desc"><?php esc_html_e( 'Sometimes you want to always link certain key words to a page on your blog or even a whole new site all together. This section lets you set those key words and links. ' , 'wds' ); ?></p>
		</div>
	</div><!-- end sub-header -->

	<form action='<?php echo esc_attr($_view['action_url']); ?>' method='post' class="wds-form">
		<?php settings_fields( $_view['option_name'] ); ?>

		<input type="hidden" name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($_view['slug']); ?>-setup]' value="1">

		<div class="row">

			<div class="col-half col-half-autolinks col-half-autolinks-left">

				<section class="box-autolinks-link-inserts-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Link Inserts', 'wds' ); ?></h3>
					</div>
					<div class="box-content">
						<fieldset class="wds-fieldset">
							<legend class="wds-fieldset-legend"><?php esc_html_e( 'Insert links in' , 'wds' ); ?></legend>
							<span class="wds-field-legend"><?php esc_html_e( 'Choose where to insert automatic links', 'wds' ); ?></span>
							<div class="wds-fieldset-fields">
								<div class="select-container wds-multiselect">
									<select multiple name="<?php echo esc_attr($_view['option_name']); ?>[insert_links_in][]">
									<?php foreach ($insert as $item => $label) { ?>
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
							<legend class="wds-fieldset-legend"><?php esc_html_e( 'Link to' , 'wds' ); ?></legend>
							<span class="wds-field-legend"><?php esc_html_e( 'Choose content you want to convert to links', 'wds' ); ?></span>
							<div class="wds-fieldset-fields">
								<div class="select-container wds-multiselect">
									<select multiple name="<?php echo esc_attr($_view['option_name']); ?>[insert_links_to][]">
									<?php foreach ($linkto as $item => $label) { ?>
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
				</section><!-- end box-autolinks-link-inserts-settings -->

				<section class="box-autolinks-excludes-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Excludes', 'wds' ); ?></h3>
					</div>
					<div class="box-content">
						<div class="group wds-group wds-group-field">
							<label for="ignore" class="wds-label"><?php esc_html_e( 'Exclude Keywords' , 'wds' ); ?></label>
							<input id='ignore' name='<?php echo esc_attr($_view['option_name']); ?>[ignore]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['ignore']); ?>'>
							<span class="wds-field-legend"><?php esc_html_e( 'Paste in the keywords you wish to exclude and separate them by commas' , 'wds' ); ?></span>
						</div>
						<div class="group wds-group wds-group-field">
							<div class="wds-replaceable">
								<label for="ignorepost" class="wds-label"><?php esc_html_e( 'Excude Posts, Pages & CPTs' , 'wds' ); ?></label>
								<input id='ignorepost' name='<?php echo esc_attr($_view['option_name']); ?>[ignorepost]' size='' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['ignorepost']); ?>'>
								<span class="wds-field-legend"><?php esc_html_e( 'Paste in the IDs, slugs or titles for the post/pages you wish to exclude and separate them by commas' , 'wds' ); ?></span>
							</div>
						</div>
					</div>
				</section><!-- end box-autolinks-excludes-settings -->

				<section class="box-autolinks-additional-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Additional Settings', 'wds' ); ?></h3>
					</div>
					<div class="box-content">

						<?php
							foreach( array( 'allow_empty_tax' => __( 'Allow autolinks to empty taxonomies', 'wds' ) ) as $item => $label ) {
								$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
								?>
								<div class="group wds-group">
									<span class="toggle">
										<input type="checkbox" class="toggle-checkbox" value='yes' name="<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]" id="<?php echo esc_attr($_view['option_name']); ?>-allow_empty_tax-<?php echo esc_attr($item); ?>" <?php echo $checked; ?>>
										<label class="toggle-label" for="<?php echo esc_attr($_view['option_name']); ?>-allow_empty_tax-<?php echo esc_attr($item); ?>"></label>
									</span>
									<label class="wds-label wds-label-inline wds-label-inline-right" for="<?php echo esc_attr($_view['option_name']); ?>-allow_empty_tax-<?php echo esc_attr($item); ?>"><?php echo esc_html($label); ?></label>
								</div>
								<?php
							}
						?>

						<?php
							foreach( array( 'excludeheading' => __( 'Prevent linking in heading tags', 'wds' ) ) as $item => $label ) {
								$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
								?>
								<div class="group wds-group">
									<span class="toggle">
										<input type="checkbox" class="toggle-checkbox" value='yes' name="<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]" id="<?php echo esc_attr($_view['option_name']); ?>-excludeheading-<?php echo esc_attr($item); ?>" <?php echo $checked; ?>>
										<label class="toggle-label" for="<?php echo esc_attr($_view['option_name']); ?>-excludeheading-<?php echo esc_attr($item); ?>"></label>
									</span>
									<label class="wds-label wds-label-inline wds-label-inline-right" for="<?php echo esc_attr($_view['option_name']); ?>-excludeheading-<?php echo esc_attr($item); ?>"><?php echo esc_html($label); ?></label>
								</div>
								<?php
							}
						?>

						<?php
							foreach( $reduce_load as $item => $label ) {
								$checked = ( ! empty( $_view['options'][$item] ) ) ? "checked='checked' " : '';
								?>
								<div class="group wds-group">
									<span class="toggle">
										<input type="checkbox" class="toggle-checkbox" value='yes' name="<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($item); ?>]" id="<?php echo esc_attr($_view['option_name']); ?>-reduceload-<?php echo esc_attr($item); ?>" <?php echo $checked; ?>>
										<label class="toggle-label" for="<?php echo esc_attr($_view['option_name']); ?>-reduceload-<?php echo esc_attr($item); ?>"></label>
									</span>
									<label class="wds-label wds-label-inline wds-label-inline-right" for="<?php echo esc_attr($_view['option_name']); ?>-reduceload-<?php echo esc_attr($item); ?>"><?php echo esc_html($label); ?></label>
								</div>
								<?php
							}
						?>
					</div>
				</section><!-- end box-autolinks-additional-settings -->

			</div><!-- end col-half-autolinks-left -->

			<div class="col-half col-half-autolinks col-half-autolinks-right">

				<section class="box-autolinks-custom-keywords-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Custom Keywords', 'wds' ); ?></h3>
					</div>
					<div class="box-content">
						<div class="wds-replaceable">
							<div>
								<span class="wds-code-label"><?php esc_html_e( 'Example:' ); ?></span>
								<code><?php _e( 'WPMU DEV, plugins, themes, http://premium.wpmudev.org/<br>WordPress News, http://wpmu.org/', 'wds' ); ?></code>
							</p>
							<div class="group wds-group wds-group-field">
								<label for="customkey" class="wds-label"><?php esc_html_e( 'Custom Keywords' , 'wds' ); ?></label>
								<textarea id='customkey' name='<?php echo esc_attr($_view['option_name']); ?>[customkey]' size='' class='wds-textarea'><?php
									echo esc_textarea($_view['options']['customkey']);
								?></textarea>
							</div>
						</div>
					</div>
				</section><!-- end box-autolinks-custom-keywords-settings -->

				<section class="box-autolinks-min-title-lenght-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Minimum Title Length', 'wds' ); ?></h3>
					</div>
					<div class="box-content">
						<div class="group wds-group wds-group-field has-field-label">
							<label class="wds-label" for="cpt_char_limit"><?php esc_html_e( 'Minimum post title length', 'wds' ); ?></label>
							<?php $limit = !empty($_view['options']['cpt_char_limit']) && is_numeric($_view['options']['cpt_char_limit']) ? (int)$_view['options']['cpt_char_limit'] : WDS_AUTOLINKS_DEFAULT_CHAR_LIMIT; ?>
							<input type="number" class="wds-field" name="<?php echo esc_attr($_view['option_name']); ?>[cpt_char_limit]" id="cpt_char_limit" value="<?php echo esc_attr($limit); ?>">
							<span class="wds-field-label"><?php esc_html_e( 'Characters', 'wds' ); ?></span>
							<span class="wds-field-legend"><?php esc_html_e( 'Shorter Post Titles will not be converted to links.' , 'wds' ); ?></span>
						</div>
						<div class="group wds-group wds-group-field has-field-label">
							<label for="tax_char_limit" class="wds-label"><?php esc_html_e( 'Minimum taxonomy title length', 'wds' ); ?></label>
							<?php $limit = !empty($_view['options']['tax_char_limit']) && is_numeric($_view['options']['tax_char_limit']) ? (int)$_view['options']['tax_char_limit'] : WDS_AUTOLINKS_DEFAULT_CHAR_LIMIT; ?>
							<input type="number" class="wds-field" name="<?php echo esc_attr($_view['option_name']); ?>[tax_char_limit]" id="tax_char_limit" value="<?php echo esc_attr($limit); ?>">
							<span class="wds-field-label"><?php esc_html_e( 'Characters', 'wds' ); ?></span>
							<span class="wds-field-legend"><?php esc_html_e( 'Shorter Taxonomy Titles will not be converted to links.' , 'wds' ); ?></span>
						</div>
					</div>
				</section><!-- end box-autolinks-min-title-lenght-settings -->

				<section class="box-autolinks-autolink-limits-settings dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Autolink Limits', 'wds' ); ?></h3>
					</div>
					<div class="box-content">
						<div class="group wds-group wds-group-field has-field-label">
							<label for="link_limit" class="wds-label"><?php esc_html_e( 'Maximum autolinks number limit', 'wds' ); ?></label>
							<?php $limit = !empty($_view['options']['link_limit']) && is_numeric($_view['options']['link_limit']) ? (int)$_view['options']['link_limit'] : 0; ?>
							<input type="number" class="wds-field" name="<?php echo esc_attr($_view['option_name']); ?>[link_limit]" id="link_limit" value="<?php echo esc_attr($limit); ?>">
							<span class="wds-field-legend"><?php esc_html_e( 'This is the maximum number of autolinks that will be added to your posts.' , 'wds' ); ?></span>
						</div>
						<div class="group wds-group wds-group-field has-field-label">
							<label for="single_link_limit" class="wds-label"><?php esc_html_e( 'Maximum single autolink occurrence', 'wds' ); ?></label>
							<?php $limit = !empty($_view['options']['single_link_limit']) && is_numeric($_view['options']['single_link_limit']) ? (int)$_view['options']['single_link_limit'] : 0; ?>
							<input type="number" class="wds-field" name="<?php echo esc_attr($_view['option_name']); ?>[single_link_limit]" id="single_link_limit" value="<?php echo esc_attr($limit); ?>">
							<span class="wds-field-legend"><?php esc_html_e( 'This is a number of single link replacement occurrences.' , 'wds' ); ?></span>
						</div>
					</div>
				</section><!-- end box-autolinks-autolink-limits-settings -->

			</div><!-- end col-half-autolinks-right -->

		</div><!-- end row -->

		<div class="block-section-footer buttons">
			<input name='submit' type='submit' class='button button-cta-alt' value='<?php echo esc_attr( __( 'Save Settings' , 'wds') ); ?>'>
		</div>

	</form>

	<?php // echo $additional; ?>

<?php

	} else {
		printf( __( "You've chosen not to set up '%s', please move onto next step.", 'wds' ), __( 'Automatic Links' , 'wds' ) );
	}

?>

</div><!-- end wds-page-autolinks -->