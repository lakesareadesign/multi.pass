<?php
	/**
	 * @var string $for_type
	 */
	$social_options = Smartcrawl_Settings::get_component_options(Smartcrawl_Settings::COMP_SOCIAL);
	$onpage_options = !empty($_view['options']) ? $_view['options'] : array();

	$og_enabled_field_id = 'og-active-' . esc_attr($for_type);
	$og_enabled_globally = smartcrawl_get_array_value($social_options, 'og-enable');
	$og_enabled_locally = !empty($onpage_options[$og_enabled_field_id]) ? $onpage_options[$og_enabled_field_id] : false;

	$twitter_enabled_field_id = 'twitter-active-' . esc_attr($for_type);
	$twitter_enabled_globally = smartcrawl_get_array_value($social_options, 'twitter-card-enable');
	$twitter_enabled_locally = !empty($onpage_options[$twitter_enabled_field_id]) ? $onpage_options[$twitter_enabled_field_id] : false;
?>
<fieldset class="wds-table-fields-group wds-separator-top">
    <div class="wds-table-fields">
        <div class="label">
            <label class="wds-label">
				<?php esc_html_e('Options', 'wds'); ?>
            </label>
        </div>
        <div class="fields">
            <div class="wds-toggleable <?php echo $og_enabled_locally ? '' : 'inactive'; ?>">
				<?php
					if (!$og_enabled_globally) {
						$this->_render('onpage/onpage-og-disabled');
					} else {
						$this->_render('onpage/onpage-og-settings', array(
							'for_type' => $for_type,
						));
					}
				?>
            </div>
            <p></p>

            <div class="wds-toggleable <?php echo $twitter_enabled_locally ? '' : 'inactive'; ?>">
				<?php
					if (!$twitter_enabled_globally) {
						$this->_render('onpage/onpage-twitter-disabled');
					} else {
						$this->_render('onpage/onpage-twitter-settings', array(
							'for_type' => $for_type,
						));
					}
				?>
            </div>
        </div>
    </div>
</fieldset>