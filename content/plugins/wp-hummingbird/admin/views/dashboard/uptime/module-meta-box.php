<ul class="dev-list dev-list-stats">

    <div class="content">
        <div class="wphb-notice wphb-notice-success">
            <p><?php _e( 'Your website is currently up and humming.', 'wphb' ); ?></p>
        </div>
    </div>

	<li class="dev-list-stats-item">
		<div>
			<span class="list-label list-label-stats"><?php _e( 'Availability', 'wphb' ); ?></span>
			<span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $uptime_stats->availability; ?></span>
		</div>
	</li><!-- end dev-list-stats-item -->

	<li class="dev-list-stats-item">
		<div>
			<span class="list-label list-label-stats"><?php _e( 'Downtime', 'wphb' ); ?></span>
			<span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $uptime_stats->period_downtime; ?></span>
		</div>
	</li><!-- end dev-list-stats-item -->

	<li class="dev-list-stats-item">
		<div>
			<span class="list-label list-label-stats"><?php _e( 'Average Response Time', 'wphb' ); ?></span>
			<span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $uptime_stats->response_time ? $uptime_stats->response_time : "Calculating..."; ?></span>
		</div>
	</li><!-- end dev-list-stats-item -->

	<li class="dev-list-stats-item">
		<div>
			<span class="list-label list-label-stats"><?php _e( 'Last Down', 'wphb' ); ?></span>
			<?php
				$gmt_date = date( 'Y-m-d H:i:s', $uptime_stats->up_since );
				$site_date = get_date_from_gmt( $gmt_date, get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) );
			?>
			<span class="list-detail list-detail-stats"><?php echo $site_date; ?></span>
		</div>
	</li><!-- end dev-list-stats-item -->

	<div class="buttons">
		<a href="<?php echo esc_url( wphb_get_admin_menu_url( 'uptime' ) ); ?>" class="button button-ghost" name="submit"><?php esc_attr_e( 'View stats', 'wphb' ); ?></a>
        <span class="status-text alignright"><?php _e( 'Downtime notifications are enabled', 'wphb' ); ?></span>
	</div>
</ul>