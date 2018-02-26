<?php
	$options = empty( $options ) ? $_view['options'] : $options;
?>

<div class="wds-table-fields wds-separator-top">
	<div class="label">
		<label class="wds-label" for="website_name"><?php esc_html_e( 'Website name', 'wds' ); ?></label>
	</div>
	<div class="fields">
		<input type="text" id="website_name" name="<?php echo esc_attr( $_view['option_name'] ); ?>[sitename]"
			   value="<?php echo esc_attr( $options['sitename'] ); ?>"/>
	</div>
</div>

<div class="wds-table-fields">
	<div class="label">
		<label class="wds-label" for="schema_type"><?php esc_html_e( 'Type', 'wds' ); ?></label>
	</div>
	<div class="fields">
		<div class="wds-conditional">
			<select id="schema_type"
					name="<?php echo esc_attr( $_view['option_name'] ); ?>[schema_type]"
					class="select-container" style="width: 100%">
				<option
					<?php selected( $options['schema_type'], Smartcrawl_Schema_Printer::PERSON ); ?>
					value="<?php echo esc_attr( Smartcrawl_Schema_Printer::PERSON ); ?>">
					<?php esc_html_e( 'Person', 'wds' ); ?>
				</option>

				<option
					<?php selected( $options['schema_type'], Smartcrawl_Schema_Printer::ORGANIZATION ); ?>
					value="<?php echo esc_attr( Smartcrawl_Schema_Printer::ORGANIZATION ); ?>">
					<?php esc_html_e( 'Organization', 'wds' ); ?>
				</option>
			</select>

			<div
				data-conditional-val="<?php echo esc_attr( Smartcrawl_Schema_Printer::PERSON ); ?>"
				class="wds-table-fields wds-table-fields-stacked wds-conditional-inside wds-conditional-inside-box">

				<div class="label">
					<label for="override_name" class="wds-label"><?php esc_html_e( 'Your name', 'wds' ); ?></label>
				</div>
				<div class="fields">
					<input id="override_name" type="text" name="<?php echo esc_attr( $_view['option_name'] ); ?>[override_name]"
						   value="<?php echo esc_attr( $options['override_name'] ); ?>"/>
				</div>
			</div>

			<div
				data-conditional-val="<?php echo esc_attr( Smartcrawl_Schema_Printer::ORGANIZATION ); ?>"
				class="wds-table-fields wds-table-fields-stacked wds-conditional-inside wds-conditional-inside-box">

				<div class="label">
					<label for="organization_name" class="wds-label"><?php esc_html_e( 'Organization Name', 'wds' ); ?></label>
				</div>
				<div class="fields">
					<input id="organization_name" type="text" name="<?php echo esc_attr( $_view['option_name'] ); ?>[organization_name]"
						   value="<?php echo esc_attr( $options['organization_name'] ); ?>"/>
				</div>

				<div class="label">
					<label for="organization_logo" class="wds-label"><?php esc_html_e( 'Organization Logo', 'wds' ); ?></label>
				</div>
				<div class="fields">
					<?php
						$this->_render('media-url-field', array(
							'item' => 'organization_logo',
						));
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$this->_render('toggle-group', array(
		'label'       => __( 'Schema markup', 'wds' ),
		'items'       => array(
			'disable-schema' => array(
				'label'       => __( 'Enable schema markup output', 'wds' ),
				'inverted'    => true,
				'description' => __( 'By default, the plugin will render appropriate schema markup to all your pages. You can disable this kind of output here.', 'wds' ),
			),
		),
		'separator'   => true,
	));
?>

<div class="wds-table-fields wds-separator-top">
	<div class="label">
		<label for="twitter_username" class="wds-label"><?php esc_html_e( 'Twitter Username', 'wds' ); ?></label>
	</div>
	<div class="fields wds-twitter-username">
		<input type="text" id="twitter_username" name="<?php echo esc_attr( $_view['option_name'] ); ?>[twitter_username]"
			   value="<?php echo esc_attr( $options['twitter_username'] ); ?>"
			   placeholder="<?php _e( 'username', 'wds' ); ?>"/>
	</div>

	<div class="label">
		<label for="fb-app-id" class="wds-label"><?php esc_html_e( 'Facebook App ID', 'wds' ); ?></label>
	</div>
	<div class="fields wds-fb-app-id">
		<input type="text" id="fb-app-id" name="<?php echo esc_attr( $_view['option_name'] ); ?>[fb-app-id]"
			   value="<?php echo esc_attr( $options['fb-app-id'] ); ?>"
			   placeholder="<?php _e( 'App ID', 'wds' ); ?>"/>
	</div>

	<div class="label">
		<label for="facebook_url" class="wds-label"><?php esc_html_e( 'Facebook Page Url', 'wds' ); ?></label>
	</div>
	<div class="fields">
		<input type="text" id="facebook_url" name="<?php echo esc_attr( $_view['option_name'] ); ?>[facebook_url]"
			   value="<?php echo esc_attr( $options['facebook_url'] ); ?>"
			   placeholder="<?php _e( 'https://facebook.com/pagename', 'wds' ); ?>"/>
	</div>

	<div class="label">
		<label for="instagram_url" class="wds-label"><?php esc_html_e( 'Instagram URL', 'wds' ); ?></label>
	</div>
	<div class="fields">
		<input type="text" id="instagram_url" name="<?php echo esc_attr( $_view['option_name'] ); ?>[instagram_url]"
			   value="<?php echo esc_attr( $options['instagram_url'] ); ?>"
			   placeholder="<?php _e( 'https://instagram.com/username', 'wds' ); ?>"/>
	</div>

	<div class="label">
		<label for="linkedin_url" class="wds-label"><?php esc_html_e( 'Linkedin URL', 'wds' ); ?></label>
	</div>
	<div class="fields">
		<input type="text" id="linkedin_url" name="<?php echo esc_attr( $_view['option_name'] ); ?>[linkedin_url]"
			   value="<?php echo esc_attr( $options['linkedin_url'] ); ?>"
			   placeholder="<?php _e( 'https://linkedin.com/username', 'wds' ); ?>"/>
	</div>

	<div class="label">
		<label for="pinterest_url" class="wds-label"><?php esc_html_e( 'Pinterest URL', 'wds' ); ?></label>
	</div>
	<div class="fields">
		<input type="text" id="pinterest_url" name="<?php echo esc_attr( $_view['option_name'] ); ?>[pinterest_url]"
			   value="<?php echo esc_attr( $options['pinterest_url'] ); ?>"
			   placeholder="<?php _e( 'https://pinterest.com/username', 'wds' ); ?>"/>
	</div>

	<div class="label">
		<label for="gplus_url" class="wds-label"><?php esc_html_e( 'Google+ URL', 'wds' ); ?></label>
	</div>
	<div class="fields">
		<input type="text" id="gplus_url" name="<?php echo esc_attr( $_view['option_name'] ); ?>[gplus_url]"
			   value="<?php echo esc_attr( $options['gplus_url'] ); ?>"
			   placeholder="<?php _e( 'https://plus.google.com/u/1/123456789123456789123', 'wds' ); ?>"/>
	</div>

	<div class="label">
		<label for="youtube_url" class="wds-label"><?php esc_html_e( 'Youtube URL', 'wds' ); ?></label>
	</div>
	<div class="fields">
		<input type="text" id="youtube_url" name="<?php echo esc_attr( $_view['option_name'] ); ?>[youtube_url]"
			   value="<?php echo esc_attr( $options['youtube_url'] ); ?>"
			   placeholder="<?php _e( 'https://www.youtube.com/user/username', 'wds' ); ?>"/>
	</div>
</div>