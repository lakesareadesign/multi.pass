<?php if ( $external_problem ): ?>
	<div class="wphb-gzip-error wphb-notice wphb-notice-error">
		<strong><?php _e( 'gzip is not working properly:', 'wphb' ); ?></strong>
		<ul>
			<li>- <?php _e( 'Your server may not have the "deflate" module enabled (mod_deflate for Apache, ngx_http_gzip_module for NGINX)', 'wphb' ); ?></li>
			<li>- <?php _e( 'Another plugin may be interfering with the configuration', 'wphb' ); ?></li>
		</ul>
		<p><?php printf( __( 'If re-checking and restarting does not resolve, please check with your host or <a href="%s" target="_blank">open a support ticket with us</a>.', 'wphb' ), wphb_support_link() ); ?></p>
	</div>
<?php endif; ?>

<ul class="dev-list">
	<li class="list-header">
		<div>
			<span class="list-label"><?php _e( 'Compression Type', 'wphb' ); ?></span>
			<span class="list-label tr"><?php _e( 'Status', 'wphb' ); ?></span>
		</div>
	</li>

	<?php foreach ( $status as  $type => $result ): ?>
		<?php if ( $result == 1 ) {
			$resultStatus = __( 'Enabled', 'wphb' );
			$resultStatusColor = 'green';
		} else {
			$resultStatus = __( 'Disabled', 'wphb' );
			$resultStatusColor = 'red';
		} ?>
		<li>
			<div>
				<span class="list-label"><?php echo $type; ?></span>
				<span class="list-detail">
					<span class="wphb-button-label wphb-button-label-small wphb-button-label-<?php echo $resultStatusColor; ?>" tooltip="<?php echo sprintf( __( 'Gzip compression is %s for %s', 'wphb' ), $resultStatus, $type ); ?>">
						<?php echo $resultStatus; ?>
					</span>
				</span>
			</div>
		</li>
	<?php endforeach; ?>

</ul>