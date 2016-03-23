<div class="wphb-notice wphb-notice-<?php echo $class; ?>">
	<p><?php echo $message; ?></p>
	<?php if ( $dismissable ): ?>
		<a href="#" data-nonce="<?php echo esc_attr( $nonce ); ?>" data-id="<?php echo esc_attr( $id ); ?>" class="wphb-dismiss"><?php _e( 'Dismiss', 'wphb' ); ?></a>
	<?php endif; ?>
</div>