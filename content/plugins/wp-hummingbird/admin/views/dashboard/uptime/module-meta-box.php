<ul class="dev-list dev-list-stats">

	<li class="dev-list-stats-item">
		<div>
			<span class="list-label list-label-stats"><?php _e( 'Uptime', 'wphb' ); ?></span>
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

</ul>