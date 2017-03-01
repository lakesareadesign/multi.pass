<?php
	$errors = !empty($_view['errors']) && is_array($_view['errors'])
		? $_view['errors']
		: array()
	;
	$type = !empty($errors)
		? 'warning'
		: 'success'
	;
?>
<?php if (!empty($_view['msg'])) { ?>
	<div class="wds-notice wds-notice-<?php echo esc_attr($type); ?>">
		<p><?php echo esc_html($_view['msg']); ?></p>
	</div>
<?php } ?>

<?php if (!empty($errors)) foreach ($errors as $error) { ?>
	<?php
		$msg = !empty($error['message']) ? $error['message'] : false;
		if (empty($msg)) continue;
	?>
	<div class="wds-notice wds-notice-error can-close">
		<span class="close"></span>
		<p><?php echo esc_html($msg); ?></p>
	</div>
<?php } ?>