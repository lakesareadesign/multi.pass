<a href="<?php echo esc_url( $viewreport_link ); ?>" class="button button-grey button-with-cta"><?php _e( 'View Report', 'wphb' ); ?></a>
<?php if ( true === WP_Hummingbird_Module_Performance::can_run_test() ): ?>
	<a href="<?php echo esc_url( $scan_link ); ?>" class="button button-app"><?php _e( 'Scan', 'wphb' ); ?></a>
<?php endif; ?>