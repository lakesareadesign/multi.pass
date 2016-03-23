<h3><?php echo esc_html( $title ); ?></h3>
<div class="extra">
	<div class="wphb-select-group">
		<label for="wphb-server-type" class="inline-label"><?php _e( 'Server Type:', 'wphb' ); ?></label>
		<?php wphb_get_servers_dropdown( array( 'selected' => $gzip_server_type ) ); ?>
	</div>
</div>