<div class="row">
	<div class="wphb-notice wphb-notice-error wphb-notice-box">
		<span class="wphb-icon wphb-icon-left"><i class="wdv-icon wdv-icon-fw wdv-icon-warning-sign"></i></span>
		<p><?php echo $error; ?></p>
		<a href="<?php echo esc_url( $retry_url ); ?>" class="button button-light button-notice button-notice-error"><?php _e( 'Try again', 'wphb' ); ?></a>
		<a target="_blank" href="<?php echo esc_url( $support_url ); ?>" class="button button-light button-notice button-notice-error"><?php _e( 'Support', 'wphb' ); ?></a>
	</div>
</div>