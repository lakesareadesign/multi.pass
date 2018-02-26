<?php
	$message = empty( $message ) ? '' : $message;
	$class = empty( $class ) ? 'wds-notice-warning' : $class;
	$key = empty( $key ) ? '' : $key;

if ( ! $key ) {
	return;
}

	$dismissed_messages = get_user_meta( get_current_user_id(), 'wds_dismissed_messages', true );
	$is_message_dismissed = smartcrawl_get_array_value( $dismissed_messages, $key ) === true;
?>
<?php if ( ! $is_message_dismissed ) :  ?>
	<div class="wds-notice <?php echo esc_attr( $class ); ?>">
		<p>
			<?php echo wp_kses( $message, 'post' ); ?>
			<a href="#" class="wds-notice-dismiss"><?php esc_html_e( 'Dismiss', 'wds' ) ?></a>
		</p>
	</div>
<?php endif; ?>