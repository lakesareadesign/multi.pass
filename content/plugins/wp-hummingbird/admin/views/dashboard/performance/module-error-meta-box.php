<div class="row">
	<div class="wphb-notice wphb-notice-error wphb-notice-box can-close">
		<p><?php echo $error; ?></p>
		<a href="<?php echo esc_url( $retry_url ); ?>" class="button button-grey"><?php _e( 'Try again', 'wphb' ); ?></a>
		<a target="_blank" href="<?php echo esc_url( $support_url ); ?>" class="button button-grey"><?php _e( 'Support', 'wphb' ); ?></a>
	</div>
</div>