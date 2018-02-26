<section class="box-dashboard-performance-info dev-box">
	<div class="box-content">
		<p class="uptime-message">
			<span class="dashicons dashicons-chart-line wds-dashicons wds-dashicons-box-title"></span>
			<?php if ( ! empty( $data['availability'] ) ) { ?>
				<span class="uptime">
					<span class="uptime-result"><?php echo esc_html( $data['availability'] ); ?></span>
					<span class="uptime-label"><?php esc_html_e( 'Uptime', 'wds' ); ?></span>
				</span>
			<?php } ?>
			<?php if ( ! class_exists( 'WP_Hummingbird' ) ) { ?>
				<span class="content">
					<?php printf( __( 'Install %s for more info.' , 'wds' ), sprintf( '<a href="https://premium.wpmudev.org/project/wp-hummingbird/">%s</a>', __( 'Hummingbird', 'wds' ) ) ); ?>
				</span>
			<?php } ?>
		</p>

		<?php
		if ( ! empty( $errors ) ) { foreach ( $errors as $error ) {
			?>
			<div class="wds-notice wds-notice-error">
				<p><?php echo esc_html( $error ); ?></p>
			</div>
			<?php
		}
		}
		?>

	</div>
</section><!-- end box-dashboard-performance-info -->