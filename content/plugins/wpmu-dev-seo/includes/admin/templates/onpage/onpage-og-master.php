<?php
	$toggle_option_key = "og-active-" . esc_attr($for_type);
	$social_options = WDS_Settings::get_component_options(WDS_Settings::COMP_SOCIAL);
	$og_enabled = wds_get_array_value($social_options, 'og-enable');
	$value = !empty($_view['options'][ $toggle_option_key ]) ? $_view['options'][ $toggle_option_key ] : false;
?>
<fieldset class="wds-table-fields-group wds-separator-top wds-toggleable <?php echo $value ? '' : 'inactive'; ?>">
	<div class="wds-table-fields">
		<div class="label">
			<label for="<?php echo $toggle_option_key; ?>" class="wds-label">
				<?php esc_html_e('Options', 'wds'); ?>
			</label>
		</div>
		<div class="fields">
			<?php if(!$og_enabled): ?>
				<div class="wds-notice wds-notice-info">
					<p>
						<?php
							printf(
								esc_html__("OpenGraph is globally disabled. You can enable it %s.", 'wds'),
								sprintf(
									'<a href="%s">%s</a>',
									Wds_Settings_Admin::admin_url(WDS_Settings::TAB_SOCIAL),
									esc_html__("here", 'wds')
								)
							);
						?>
					</p>
				</div>
			<?php else: ?>
				<div class="wds-toggle-table">
					<span class="toggle wds-toggle">
						<input class="toggle-checkbox" value='1' <?php checked($value, true); ?> id='<?php echo $toggle_option_key; ?>' name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo $toggle_option_key; ?>]' type='checkbox' autocomplete="off"/>
						<label class="toggle-label" for="<?php echo $toggle_option_key; ?>"></label>
					</span>

					<div class="wds-toggle-description">
						<label class="wds-label" for="<?php echo $toggle_option_key; ?>">
							<?php _e('Enable OpenGraph', 'wds'); ?>
						</label>
						<p class="wds-label-description">
							<?php _e('OpenGraph support enhances how your content appears when shared on social networks such as Facebook.', 'wds'); ?>
						</p>

						<div class="wds-table-fields-group wds-toggleable-inside-box">
							<?php
							$this->_render('onpage/onpage-og-title', array(
								'for_type' => $for_type,
							));
							$this->_render('onpage/onpage-og-description', array(
								'for_type' => $for_type,
							));
							$this->_render('onpage/onpage-og-images', array(
								'for_type' => $for_type,
							));
							?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</fieldset>