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
	<div class="wds-notice-floating wds-notice wds-notice-<?php echo esc_attr($type); ?>">
		<p><?php echo esc_html($_view['msg']); ?></p>
	</div>
<?php } ?>

<?php if (!empty($errors)) foreach ($errors as $error) { ?>
	<?php
		$msg = !empty($error['message']) ? $error['message'] : false;
		if (empty($msg)) continue;
	?>
	<div class="wds-notice-floating wds-notice wds-notice-error can-close">
		<p><?php echo esc_html($msg); ?></p>
	</div>
<?php } ?>

<?php
/**
 * Import/Export error messages display
 */
?>
<?php $io_errors = WDS_Controller_IO::get()->get_errors(); ?>
<?php if (!empty($io_errors)) foreach ($io_errors as $io_type => $io_error) { ?>
	<div class="wds-notice-floating wds-notice wds-notice-error <?php esc_attr($io_type); ?>">
		<p><?php echo esc_html($io_error); ?></p>
	</div>
<?php } else if (!empty($_GET['import']) && 'success' === $_GET['import']) { ?>
	<div class="wds-notice-floating wds-notice wds-notice-success">
		<p><?php esc_html_e('Settings successfully imported', 'wds'); ?></p>
	</div>
<?php } ?>
