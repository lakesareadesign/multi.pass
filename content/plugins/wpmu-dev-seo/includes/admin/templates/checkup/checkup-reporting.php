<?php
	$cron = WDS_Controller_Cron::get();

	// This does the actual rescheduling
	$cron->set_up_schedule();
	$service = WDS_Service::get(WDS_Service::SERVICE_CHECKUP);

	$disabled = !$service->is_member() ? 'disabled' : '';
	$option_name = $_view['option_name'];
	$toggle_field_name = $option_name . '[checkup-cron-enable]';
	$checkup_cron_enabled = $_view['options']['checkup-cron-enable'];
?>

<?php if(!$service->is_member()): ?>
	<div class="wds-obfuscate-section"></div>
<?php endif; ?>

<div class="wds-table-fields wds-toggleable">
	<div class="label">
		<label class="wds-label"
			   for="<?php echo esc_attr($toggle_field_name); ?>">

			<?php esc_html_e('Schedule automatic checkups', 'wds'); ?>
		</label>
		<p class="wds-label-description">
			<?php esc_html_e('Configure SmartCrawl to automatically email you a comprehensive SEO report for this website.', 'wds'); ?>
		</p>
	</div>
	<div class="fields wds-toggleable <?php echo $checkup_cron_enabled ? '' : 'inactive'; ?>">
		<?php
			$this->_render('toggle-item', array(
				'field_name' => $toggle_field_name,
				'field_id'   => $toggle_field_name,
				'checked'    => checked($checkup_cron_enabled, true, false),
				'item_label' => esc_html__('Enable regular checkups', 'wds')
			));
		?>
		<div class="wds-toggleable-inside wds-toggleable-inside-box">
			<div class="wds-table-fields wds-table-fields-stacked">
				<div class="label">
					<label for="wds-checkup-frequency" class="wds-label"><?php esc_html_e('Frequency', 'wds'); ?></label>
				</div>
				<div class="fields">
					<select <?php echo $disabled; ?>
						style="width: 100%"
						class="select-container wds-conditional-parent"
						id="wds-checkup-frequency"
						name="<?php echo esc_attr($_view['option_name']); ?>[checkup-frequency]">

						<?php $checkup_freq = isset($_view['options']['checkup-frequency']) ? $_view['options']['checkup-frequency'] : false; ?>

						<?php foreach ($cron->get_frequencies() as $key => $label): ?>
							<option value="<?php echo esc_attr($key); ?>" <?php selected($key, $checkup_freq); ?>>
								<?php echo esc_html($label); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="wds-table-fields wds-table-fields-stacked wds-conditional-child"
				 data-parent="wds-checkup-frequency"
				 data-parent-val="weekly,monthly">

				<div class="label">
					<label for="wds-checkup-dow" class="wds-label"><?php esc_html_e('Day of the week', 'wds'); ?></label>
				</div>
				<div class="fields">
					<select <?php echo $disabled; ?>
						style="width: 100%"
						class="select-container"
						id="wds-checkup-dow"
						name="<?php echo esc_attr($_view['option_name']); ?>[checkup-dow]">

						<?php $monday = strtotime('this Monday'); ?>
						<?php $checkup_dow = isset($_view['options']['checkup-dow']) ? $_view['options']['checkup-dow'] : false; ?>
						<?php foreach (range(0, 6) as $dow): ?>
							<option value="<?php echo esc_attr($dow); ?>" <?php selected($dow, $checkup_dow); ?>>
								<?php echo esc_html(date_i18n('l', $monday + ($dow * DAY_IN_SECONDS))); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="wds-table-fields wds-table-fields-stacked">
				<div class="label">
					<label for="wds-checkup-tod" class="wds-label"><?php esc_html_e('Time of day', 'wds'); ?></label>
				</div>
				<div class="fields">

					<select <?php echo $disabled; ?>
						style="width: 100%"
						class="select-container"
						id="wds-checkup-tod"
						name="<?php echo esc_attr($_view['option_name']); ?>[checkup-tod]">

						<?php $midnight = strtotime('today'); ?>
						<?php $checkup_tod = isset($_view['options']['checkup-tod']) ? $_view['options']['checkup-tod'] : false; ?>
						<?php foreach (range(0, 23) as $tod): ?>
							<option value="<?php echo esc_attr($tod); ?>" <?php selected($tod, $checkup_tod); ?>>
								<?php echo esc_html(date_i18n(get_option('time_format'), $midnight + ($tod * HOUR_IN_SECONDS))); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="wds-table-fields wds-separator-top">
	<div class="label">
		<label class="wds-label"><?php esc_html_e('Email recipients', 'wds'); ?></label>
		<p class="wds-label-description">
			<?php esc_html_e('Choose which of your website’s users will receive the SEO report.', 'wds'); ?>
		</p>
	</div>
	<div class="fields">
		<?php
			$this->_render('user-search', array(
				'users'        => (isset($_view['options']['email-recipients']) ? $_view['options']['email-recipients'] : array()),
				'option_name'  => $option_name,
				'users_key'    => 'email-recipients',
				'new_user_key' => 'new-user'
			));
		?>
	</div>
</div>