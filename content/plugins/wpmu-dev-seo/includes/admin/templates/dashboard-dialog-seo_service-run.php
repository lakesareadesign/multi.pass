<?php
	$progress = isset($status) && !empty($status['percentage']) && is_numeric($status['percentage'])
		? (int)$status['percentage']
		: 0
	;
	if ($progress > 100) $progress = 100;
?>
<div class="box-content wds-seo_service-run">
	<div class="wds-block-test wds-block-test-standalone">
		<h4 class="wds-block-test-sub-title"><?php _e( 'SEO analysis in progress', 'wds' ); ?></h4>
		<div class="wds-progress">
			<div class="wds-progress-bar wds-progress-bar-with-percent wds-progress-bar-animated" role="progressbar" aria-valuenow="<?php echo (int)$progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo (int)$progress; ?>%;">
				<span class="wds-progress-bar-current-percent"><?php echo (int)$progress; ?>%</span>
			</div>
		</div><!-- end wds-progress -->
		<div class="wds-progress-state">
			<span class="wds-progress-state-text"><?php _e( 'Checking the site ...', 'wds' ); ?></span>
		</div><!-- end wds-progress-state -->
		<div class="wds-progress-note">
			<?php
				$admin_email = false;
				$dash_email = false;
				if (class_exists('WPMUDEV_Dashboard') && !empty(WPMUDEV_Dashboard::$site)) {
					if (is_callable(array(WPMUDEV_Dashboard::$site, 'get_option'))) {
						$dash_email = WPMUDEV_Dashboard::$site->get_option( 'auth_user' );
						if (false !== strpos($dash_email, '@')) $admin_email = $dash_email;
					}
				}
				$scan_msg =  __("A full scan can take quite a while, especially if you have a large site!<br>Feel free to close this page; we'll send an e-mail to %s once the results are in.", 'wds');
			?>
			<p>
				<?php if (!empty($dash_email) && !empty($admin_email)) { ?>
					<?php $admin_email = sprintf('<a href="mailto: %1$s">%1$s</a>', $admin_email); ?>
				<?php } else { ?>
					<?php $admin_email = __('your DEV account email', 'wds'); ?>
				<?php } ?>
				<?php
						printf(
							$scan_msg,
							$admin_email
						);
					?>
					<br>
					<?php esc_html_e('You can change that e-mail address if you want, on your DEV account page', 'wds'); ?>
					<a href="https://premium.wpmudev.org/hub/account" target="_blank"><?php esc_html_e('here', 'wds'); ?></a>
			</p>
		</div>
	</div><!-- end wds-block-test -->
</div>