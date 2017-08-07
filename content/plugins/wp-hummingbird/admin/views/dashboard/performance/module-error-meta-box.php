<?php
/**
 * Performance error meta box on dashboard page.
 *
 * @package Hummingbird
 *
 * @var string $error        Error text.
 * @var string $retry_url    URL to retry.
 * @var string $support_url  URL to support.
 */

?>
<div class="row">
	<div class="wphb-notice wphb-notice-error wphb-notice-box can-close">
		<p><?php echo $error; ?></p>
		<a href="<?php echo esc_url( $retry_url ); ?>" class="button button-grey">
			<?php esc_html_e( 'Try again', 'wphb' ); ?>
		</a>
		<a target="_blank" href="<?php echo esc_url( $support_url ); ?>" class="button button-grey">
			<?php esc_html_e( 'Support', 'wphb' ); ?>
		</a>
	</div>
</div>