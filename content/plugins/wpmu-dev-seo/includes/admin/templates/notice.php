<?php
	$message = empty($message) ? '' : $message;
	$class = empty($class) ? 'wds-notice-warning' : $class;
?>
<div class="wds-notice <?php echo esc_attr($class); ?>">
	<p><?php echo $message; ?></p>
</div>