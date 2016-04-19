<?php if ( $error ): ?>
	<div class="row">
		<div class="wphb-notice wphb-notice-<?php echo $error_type; ?> wphb-notice-box can-close">
			<span class="close"></span>
			<span class="wphb-icon wphb-icon-left"><i class="wdv-icon wdv-icon-fw wdv-icon-warning-sign"></i></span>
			<p><?php echo $error; ?></p>
			<a href="<?php echo esc_url( $retry_url ); ?>" class="button button-notice button-notice-error"><?php _e( 'Try again', 'wphb' ); ?></a>
			<a target="_blank" href="<?php echo esc_url( $support_url ); ?>" class="button button-notice button-notice-error"><?php _e( 'Support', 'wphb' ); ?></a>
		</div>
	</div>
<?php else: ?>
	<div class="row row-space-large">
		<div class="col-half">

			<div class="wphb-block wphb-block-uptime-status">

				<div class="wphb-block-content wphb-block-content-grey wphb-block-content-grey-large wphb-block-content-center wphb-block-content-uptime-status">


					<img class="wphb-image-icon-content wphb-image-icon-content-top wphb-image-icon-content-center wphb-uptime-icon" src="<?php echo wphb_plugin_url() . 'admin/assets/image/websiteup.png'; ?>">

					<h4 class="wphb-heading-status wphb-heading-status-green"><?php _e('Your website is up', 'wphb'); ?></h4>

					<p><?php printf( __('Available for <strong>%s</strong>', 'wphb'), $uptime_stats->uptime ); ?></p>

					<button class="button button-cta button-content-cta" id="uptime-re-check-status"><?php _e('Re-check', 'wphb'); ?></button>

				</div><!-- end wphb-block-content-uptime-status -->

			</div><!-- end wphb-block-uptime-status -->

		</div>

		<div class="col-half">

			<div class="wphb-block wphb-block-uptime-data-range wphb-block-uptime-on-off-switch">

				<div class="wphb-block-content-group">

					<div class="wphb-block-content-group-inner">

						<div class="wphb-block-content-group-item">

							<div class="wphb-block-content wphb-block-content-grey wphb-block-content-uptime-data-range">

								<div class="wphb-select-group wphb-select-group-right">
									<span class="spinner left"></span>
									<select name="wphb-uptime-data-range" id="wphb-uptime-data-range">
										<?php foreach ( $data_ranges as $range => $label ): ?>
											<option
												value="<?php echo esc_attr( $range ); ?>"
												<?php selected( $data_range_selected, $range ); ?>
												data-url="<?php echo esc_url( add_query_arg( 'data-range', $range, wphb_get_admin_menu_url( 'uptime' ) ) ); ?>">
												<?php echo esc_html( $label ); ?>
											</option>
										<?php endforeach; ?>
									</select>
									<label for="wphb-uptime-data-range" class="inline-label"><?php _e( 'Data range:', 'wphb' ); ?></label>
								</div>

							</div><!-- end wphb-block-content-uptime-data-range -->

						</div>

						<div class="wphb-block-content-group-item">

							<div class="wphb-block-content wphb-block-content-grey wphb-block-content-uptime-on-off-switch">
								<div class="tooltip-box">
									<span class="toggle" tooltip="<?php _e( 'Disable Uptime', 'wphb' ); ?>">
										<input type="checkbox" id="wphb-disable-uptime" class="toggle-checkbox" name="wphb-disable-uptime" checked>
										<label for="wphb-disable-uptime" class="toggle-label"></label>
									</span>
								</div>
							</div><!-- end wphb-block-content-uptime-on-off-switch -->

						</div>

					</div>

				</div><!-- end wphb-block-uptime-data-range wphb-block-uptime-on-off-switc -->

			</div>

			<div class="wphb-block wphb-block-uptime-stats">

				<div class="wphb-block-content wphb-block-content-grey">

					<ul class="dev-list dev-list-stats dev-list-stats standalone">

						<li class="dev-list-stats-item">
							<div>
								<span class="list-label list-label-stats"><?php _e( 'Uptime', 'wphb' ); ?></span>
								<span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $uptime_stats->availability; ?></span>
							</div>
						</li><!-- end dev-list-stats-item -->

						<li class="dev-list-stats-item">
							<div>
								<span class="list-label list-label-stats"><?php _e( 'Outages', 'wphb' ); ?></span>
								<span class="list-detail list-detail-stats list-detail-stats-heading"><?php echo $uptime_stats->outages; ?></span>
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

				</div>

			</div><!-- end wphb-block-uptime-stats -->

		</div>
	</div>

	<div class="row row-space-large">
		<div class="wphb-block wphb-block-uptime-average-responsive-time">
			<div class="wphb-block-header">
				<h3 class="wphb-block-title"><?php _e( 'Average response time', 'wphb' ); ?></h3>
				<p class="wphb-block-description"><?php _e( 'This graph shows how fast visitors can access your site, a lower response time is better!', 'wphb' ); ?></p>
			</div>
			<div class="wphb-block-content">
				<input type="hidden" id="uptime-chart-json" value="<?php echo $uptime_stats->chart_json; ?>">
				<div class="uptime-chart" id="uptime-chart" style="height:300px">
					<span class="loader i-wpmu-dev-loader"></span>
				</div>
			</div>
		</div><!-- end wphb-block-uptime-average-responsive-time -->
	</div>

	<div class="row row-space-large">

		<div class="wphb-block wphb-block-uptime-downtime">

			<div class="wphb-block-header">
				<h3 class="wphb-block-title"><?php _e( 'Downtime', 'wphb' ); ?></h3>
				<p class="wphb-block-description"><?php _e( 'Here\'s a log of when your website was inaccessible for visitors.', 'wphb' ); ?></p>
			</div>
			<div class="wphb-block-content">
				<ul class="dev-list dev-list-stats dev-list-stats-standalone dev-list-stats-border">
					<?php if ( ! count( $uptime_stats->events ) ): ?>
						<p><strong><?php _e( 'No events in the chosen date range', 'wphb' ); ?></strong></p>
					<?php else: ?>
						<?php foreach ( $uptime_stats->events as $event ): ?>
							<li class="dev-list-stats-item">
								<div>
									<span class="list-label list-label-stats">
									<?php if ( ! empty( $event->down ) && ! empty( $event->up ) ): ?>
										<?php $down = strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', $event->down ) ) ); ?>
										<?php $up = strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', $event->up ) ) ); ?>
										<div class="wphb-pills-group">
											<span class="wphb-pills large red" tooltip="<?php echo esc_attr( $event->details ); ?>"><i class="dev-icon dev-icon-caret_down"></i> <?php echo date_i18n( 'M j, Y g:ia', $down ); ?></span>
											<span class="wphb-pills large green"><i class="dev-icon dev-icon-caret_up"></i> <?php echo date_i18n( 'M j, Y g:ia', $up ); ?></span>
										</div>
									<?php else : ?>
										<?php if ( ! empty( $event->down ) ): ?>
											<?php $down = strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', $event->down ) ) ); ?>
											<span class="wphb-pills large red" tooltip="<?php echo esc_attr( $event->details ); ?>"><i class="dev-icon dev-icon-caret_down"></i> <?php echo date_i18n( 'M j, Y g:ia', $down ); ?></span>
										<?php endif; ?>
										<?php if ( ! empty( $event->up ) ): ?>
											<?php $up = strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', $event->up ) ) ); ?>
											<span class="wphb-pills large green"><i class="dev-icon dev-icon-caret_up"></i> <?php echo date_i18n( 'M j, Y g:ia', $up ); ?></span>
										<?php endif; ?>
									<?php endif; ?>
									</span>
									<?php if ( $event->downtime ): ?>
										<span class="list-detail list-detail-stats list-detail-stats-heading" tooltip="<?php echo esc_attr( $event->details ); ?>"><?php echo $event->downtime; ?></span>
									<?php elseif ( ! $event->up && $uptime_stats->downtime ): ?>
										<span class="list-detail list-detail-stats list-detail-stats-heading" tooltip="<?php echo esc_attr( $event->details ); ?>"><?php echo $uptime_stats->downtime; ?></span>
									<?php endif; ?>
								</div>
							</li><!-- end dev-list-stats-item -->
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<!--div class="wphb-block-content wphb-block-content-center">
				<button class="button button-load-more">
					<?php _e( 'Load more', 'wphb' ); ?>
				</button>
			</div-->

		</div><!-- end wphb-block-uptime-downtime -->

	</div>

	<script>
		jQuery(document).ready( function() {
			WPHB_Admin.getModule( 'uptime' );
		});
	</script>
<?php endif; ?>
