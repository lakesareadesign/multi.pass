<section class="box-sitemaps-options-settings dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( 'BuddyPress', 'wds' ); ?></h3>
	</div>
	<div class="box-content">

		<p><?php esc_html_e( 'BuddyPress sitemaps integration.', 'wds' ); ?></p>
		<?php
			foreach( $checkbox_options as $item => $label ) {
				$checked = ( ! empty( $_view['options']['sitemap-buddypress-groups'] ) ) ? "checked='checked' " : '';
				?>
				<p class="group">
					<span class="toggle">
						<input type="checkbox" class="toggle-checkbox" value='<?php echo esc_attr($item); ?>' name="<?php echo $_view['option_name']; ?>[sitemap-buddypress-groups]" id="<?php echo $_view['option_name']; ?>-sitemap-buddypress-groups-<?php echo esc_attr($item); ?>" <?php echo $checked; ?>>
						<label class="toggle-label" for="<?php echo $_view['option_name']; ?>-sitemap-buddypress-groups-<?php echo esc_attr($item); ?>"></label>
					</span>
					<label class="wds-label wds-label-inline wds-label-inline-right" for="<?php echo $_view['option_name']; ?>-sitemap-buddypress-groups-<?php echo esc_attr($item); ?>">
						<?php esc_html_e( 'Include BuddyPress groups in my sitemaps' , 'wds' ); ?>
						<span class="wds-label-description"><?php esc_html_e( 'Enabling this option will add all your BuddyPress groups to your sitemap.' , 'wds' ); ?></span>
					</label>
				</p>
				<?php
			}
		?>

		<?php if( ! empty( $exclude_groups ) ) { ?>

			<fieldset class="wds-fieldset wds-fieldset-standalone">
				<!-- <legend class='screen-reader-text'> -->
				<legend class="wds-fieldset-legend"><?php esc_html_e( 'Exclude these groups from my sitemap.', 'wds' ); ?></legend>
				<div class="wds-fieldset-fields-group">
					<div class="select-container wds-multiselect">
						<select multiple name="<?php echo esc_attr($_view['option_name']); ?>[exclude_bp_groups][]">
						<?php foreach ($exclude_groups as $item => $label) { ?>
							<option
								value="<?php echo esc_attr($item); ?>"
								<?php selected(true, !empty($_view['options']['sitemap-buddypress-' . $item])); ?>
							><?php echo esc_html($label); ?></option>
						<?php } ?>
						</select>
					</div>
				</div><!-- end wds-fieldset-fields -->
			</fieldset><!-- end wds-fieldset -->

		<?php } ?>

		<?php
			foreach( $checkbox_options as $item => $label ) {
				$checked = ( ! empty( $_view['options']['sitemap-buddypress-profiles'] ) ) ? "checked='checked' " : '';
				?>
				<p class="group">
					<span class="toggle">
						<input type="checkbox" class="toggle-checkbox" value='<?php echo esc_attr($item); ?>' name="<?php echo $_view['option_name']; ?>[sitemap-buddypress-profiles]" id="<?php echo $_view['option_name']; ?>-sitemap-buddypress-profiles-<?php echo esc_attr($item); ?>" <?php echo $checked; ?>>
						<label class="toggle-label" for="<?php echo $_view['option_name']; ?>-sitemap-buddypress-profiles-<?php echo esc_attr($item); ?>"></label>
					</span>
					<label class="wds-label wds-label-inline wds-label-inline-right" for="<?php echo $_view['option_name']; ?>-sitemap-buddypress-profiles-<?php echo esc_attr($item); ?>">
						<?php esc_html_e( 'Include BuddyPress profiles in my sitemaps.' , 'wds' ); ?>
						<span class="wds-label-description"><?php esc_html_e( 'Enabling this option will add all your BuddyPress profiles to your sitemap.' , 'wds' ); ?></span>
					</label>
				</p>
				<?php
			}
		?>

		<?php if( ! empty( $exclude_roles ) ) { ?>

			<fieldset class="wds-fieldset">
				<!-- <legend class='screen-reader-text'> -->
				<legend class="wds-fieldset-legend"><?php esc_html_e( 'Exclude profiles with these roles from my sitemap.', 'wds' ); ?></legend>
				<div class="wds-fieldset-fields-group">
					<div class="select-container wds-multiselect">
						<select multiple name="<?php echo esc_attr($_view['option_name']); ?>[exclude_bp_roles][]">
						<?php foreach ($exclude_roles as $item => $label) { ?>
							<option
								value="<?php echo esc_attr($item); ?>"
								<?php selected(true, !empty($_view['options']['sitemap-buddypress-roles-' . $item])); ?>
							><?php echo esc_html($label); ?></option>
						<?php } ?>
						</select>
					</div>
				</div><!-- end wds-fieldset-fields -->
			</fieldset><!-- end wds-fieldset -->

		<?php } ?>

	</div>
</section><!-- end box-sitemaps-options-settings -->