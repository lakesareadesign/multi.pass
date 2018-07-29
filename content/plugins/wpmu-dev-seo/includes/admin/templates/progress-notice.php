<?php
$admin_email = false;
$dash_email = false;
if ( class_exists( 'WPMUDEV_Dashboard' ) && ! empty( WPMUDEV_Dashboard::$site ) ) {
	if ( is_callable( array( WPMUDEV_Dashboard::$site, 'get_option' ) ) ) {
		$dash_email = WPMUDEV_Dashboard::$site->get_option( 'auth_user' );
		if ( false !== strpos( $dash_email, '@' ) ) {
			$admin_email = $dash_email;
		}
	}
}
$scan_msg = __( "A full scan can take quite a while, especially if you have a large site! Feel free to close this page; we'll send an e-mail to %s once the results are in.", 'wds' );
?>
<p class="wds-small-text">
	<?php if ( ! empty( $dash_email ) && ! empty( $admin_email ) ) { ?>
		<?php $admin_email = sprintf( '<a href="mailto: %1$s">%1$s</a>', $admin_email ); ?>
	<?php } else { ?>
		<?php $admin_email = __( 'your DEV account email', 'wds' ); ?>
	<?php } ?>
	<?php
	printf(
		esc_html( $scan_msg ),
		wp_kses_post( $admin_email )
	);
	?>
	<?php esc_html_e( 'You can change that e-mail address if you want, on your DEV account page', 'wds' ); ?>
	<a href="https://premium.wpmudev.org/hub/account" target="_blank"><?php esc_html_e( 'here', 'wds' ); ?></a>
</p>