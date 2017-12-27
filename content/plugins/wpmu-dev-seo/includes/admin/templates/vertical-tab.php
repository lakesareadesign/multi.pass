<section class="tab">
	<?php
		// Required
		$tab_id = empty($tab_id) ? '' : $tab_id;
		$tab_name = empty($tab_name) ? '' : $tab_name;
		$is_active = empty($is_active) ? false : $is_active;
		$tab_sections = !empty($tab_sections) && is_array($tab_sections) ? $tab_sections : array();
		$option_name = empty($_view['option_name']) ? '' : $_view['option_name'];

		// Optional
		$button_text = isset($button_text) ? $button_text : __('Save Settings', 'wds');
		$before_output = isset($before_output) ? $before_output : null;
		$after_output = isset($after_output) ? $after_output : null;

		// Variables
		$is_singular = count($tab_sections) == 1;
		$wds_options = WDS_Settings::get_options();
		$first_section = true;
	?>
	<input
		type="radio"
		name="wds-admin-active-tab"
		id="<?php echo esc_attr($tab_id); ?>"
		value="<?php echo esc_attr($tab_id); ?>"
		<?php checked($is_active); ?> />

	<label for="<?php echo esc_attr($tab_id); ?>">
		<?php echo esc_html($tab_name); ?>
	</label>

	<div class="content wds-content-tabs <?php echo $tab_id; ?> <?php echo $is_singular ? '' : 'wds-accordion'; ?>">
		<h2 class="tab-title">
			<?php echo esc_html($tab_name); ?>
		</h2>

		<?php if ($before_output): ?>
			<?php echo($before_output); ?>
			<input
				type="hidden"
				name="wds-admin-active-tab"
				id="<?php echo esc_attr($tab_id); ?>"
				value="<?php echo esc_attr($tab_id); ?>"/>
		<?php endif; ?>

		<?php foreach($tab_sections as $section): ?>
			<?php
				$this->_render('vertical-tab-section', array_merge(
					$section,
					array(
						'show_accordion'         => !$is_singular,
						'accordion_section_open' => $first_section
					)
				));

				$first_section = false;
			?>
		<?php endforeach; ?>

		<?php if($button_text): ?>
			<div class="wds-seamless-footer">
				<input name='submit' type='submit' class='button' value='<?php echo esc_attr($button_text); ?>'/>
			</div>
		<?php endif; ?>

		<?php
			if ($after_output) {
				echo($after_output);
			}
		?>
	</div>
</section>