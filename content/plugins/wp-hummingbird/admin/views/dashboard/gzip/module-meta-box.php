<ul class="dev-list dev-list-stats">

	<div class="content">
		<p><?php _e( 'Gzip compresses your webpages and style sheets before sending them over to the browser.', 'wphb' ); ?></p>
	</div>

	<?php foreach ( $status as  $type => $result ): ?>
		<?php if ( $result == 1 ) {
			$resultStatus = __( 'Enabled', 'wphb' );
			$resultStatusColor = 'green';
		} else {
			$resultStatus = __( 'Disabled', 'wphb' );
			$resultStatusColor = 'yellow';
		}

		switch ( $type ) {
            case 'HTML':
                $icon = __( 'html', 'wphb' );
                break;
			case 'JavaScript':
			    $icon = __( 'js', 'wphb' );
				break;
			case 'CSS':
			    $icon = __( 'css', 'wphb' );
				break;
        } ?>
        <li class="dev-list-stats-item">
			<div>
                <span class="list-label list-label-stats list-label-stats-filename">
                    <span class="wphb-filename-extension wphb-filename-extension-<?php echo $icon; ?>"><?php echo $icon; ?></span>
	                <p><?php echo $type; ?></p>
                </span>
				<span class="list-detail">
					<div class="tooltip-box">
						<span class="wphb-button-label wphb-button-label-<?php echo $resultStatusColor; ?> tooltip-l" tooltip="<?php echo sprintf( __( 'Gzip compression is %s for %s', 'wphb' ), $resultStatus, $type ); ?>">
							<?php echo $resultStatus; ?>
						</span>
					</div>
				</span>
			</div>
        </li><!-- end dev-list-stats-item -->
	<?php endforeach; ?>
</ul>

<div class="buttons">
    <a href="<?php echo esc_url( $gzip_url ); ?>" class="button button-ghost" name="submit"><?php esc_attr_e( 'Configure', 'wphb' ); ?></a>
</div>