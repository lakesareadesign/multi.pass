<?php
	$key = empty($key) ? '' : $key;
	$message = empty($message) ? '' : $message;
	$dismissible = isset($dismissible) ? $dismissible : true;

	if ($key === '' || $message === '') {
		return;
	}

	$dismissed_messages = get_user_meta(get_current_user_id(), 'wds_dismissed_messages', true);
	$is_message_dismissed = wds_get_array_value($dismissed_messages, $key) === true;
?>
<?php if (!$is_message_dismissed): ?>
	<div class="wds-mascot-message <?php echo esc_attr($key); ?>">
		<div class="wds-mascot"></div>
		<div class="wds-mascot-bubble-container">
			<div class="wds-mascot-bubble">
				<?php if ($dismissible): ?>
					<span class="wds-mascot-bubble-dismiss"><i class="wds-icon-close"></i></span>
				<?php endif; ?>
				<p class="wds-small-text"><?php echo $message; ?></p>
			</div>
		</div>
	</div>
<?php endif; ?>