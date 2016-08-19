<?php
$deactivate_url = add_query_arg( array(
	'type' => 'cf-deactivate',
	'run' => 'true'
));
$deactivate_url = wp_nonce_url( $deactivate_url, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-cloudflare';
?>
<h3>CloudFlare</h3>
<div class="buttons hidden">
	<a href="<?php echo esc_url( $deactivate_url ); ?>" class="button button-small button-grey"><?php _e( 'Deactivate', 'wphb' ); ?></a>
</div>