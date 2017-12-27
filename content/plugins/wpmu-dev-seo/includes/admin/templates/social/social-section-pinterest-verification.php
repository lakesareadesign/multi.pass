<?php
	$options = empty($options) ? $_view['options'] : $options;
?>

<div class="wds-table-fields">
	<?php if (isset($options['pinterest-verification-status'])): ?>
		<?php if ($options['pinterest-verification-status'] === 'fail'): ?>
			<div class="wds-notice wds-notice-error">
				<p><?php esc_html_e('Verification failed', 'wds'); ?></p>
			</div>
		<?php elseif($options['pinterest-verification-status'] === ''): ?>
			<div class="wds-notice wds-notice-success">
				<p><?php esc_html_e('Your domain verification tag has been added to the <head> of your website.', 'wds'); ?></p>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<div class="label">
		<label for="pinterest-verify" class="wds-label"><?php esc_html_e('Pinterest Meta Tag', 'wds'); ?></label>
		<p class="wds-label-description"><?php _e('This setting will add the meta tag to verify your website with Pinterest.', 'wds'); ?></p>
	</div>

	<div class="fields">
		<textarea
			id="pinterest-verify"
			name="<?php echo esc_attr($_view['option_name']); ?>[pinterest-verify]"
			placeholder="<?php _e('Enter your Pinterest meta tag here', 'wds'); ?>"><?php echo esc_textarea($options['pinterest-verify']); ?></textarea>
		<div class="wds-field-legend">
			<?php if(empty($options['pinterest-verify'])): ?>
				<?php _e('Instructions:', 'wds'); ?>
				<ul>
					<li><?php _e('1. Go to your Account Settings area.', 'wds'); ?></li>
					<li><?php _e('2. Scroll to the Website field, add your website and click Confirm website.', 'wds'); ?></li>
					<li><?php _e('3. Copy the meta tag', 'wds'); ?></li>
				</ul>
			<?php else: ?>
				<?php _e('To remove verification simply remove this meta tag.', 'wds'); ?>
			<?php endif; ?>
		</div>
	</div>
</div>