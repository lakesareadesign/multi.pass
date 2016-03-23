<ul class="dev-list">

	<li class="list-header">
		<div>
			<span class="list-label"><?php _e( 'Compression Type', 'wphb' ); ?></span>
			<span class="list-detail"><?php _e( 'Status', 'wphb' ); ?></span>
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
					<div class="tooltip-box">
						<span class="wphb-button-label wphb-button-label-small wphb-button-label-<?php echo $resultStatusColor; ?>" tooltip="<?php echo sprintf( __( 'Gzip compression is %s for %s', 'wphb' ), $resultStatus, $type ); ?>">
							<?php echo $resultStatus; ?>
						</span>
					</div>
				</span>
			</div>
		</li>
	<?php endforeach; ?>

</ul>