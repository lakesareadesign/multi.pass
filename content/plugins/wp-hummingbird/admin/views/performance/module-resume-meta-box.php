<div class="row">
	<div class="col-half">

		<div class="content">

			<div class="wphb-hero hide-to-desktop">
				<img class="wphb-image" src="<?php echo wphb_plugin_url() . 'admin/assets/image/hummingbird-tinny.png'; ?>" alt="<?php _e('Hummingbird', 'wphb'); ?>">
			</div>

			<div class="current-score">
				<div class="wphb-performance-report-current-score">
					<div class="wphb-score wphb-score-have-label inside">
						<div class="tooltip-box">
							<div class="wphb-score-result wphb-score-result-grade-<?php echo $last_report->score_class ?>" tooltip="<?php echo $last_report->score; ?>/100">
								<div class="wphb-score-type wphb-score-type-circle large">
									<svg class="wphb-score-graph wphb-score-graph-svg" xmlns="http://www.w3.org/2000/svg" width="80" height="80">
										<circle class="wphb-score-graph-circle" r="35" cx="40" cy="40" fill="transparent" stroke-dasharray="0" stroke-dashoffset="0"></circle>
										<circle class="wphb-score-graph-circle wphb-score-graph-result" r="35" cx="40" cy="40" fill="transparent" stroke-dasharray="219.8" stroke-dashoffset="0"></circle>
									</svg>
								</div><!-- end wphb-score-type -->
								<div class="wphb-score-result-label"><?php echo $last_report->score; ?></div>
							</div><!-- end wphb-score-result -->
						</div><!-- end tooltip-box -->
					</div><!-- end wphb-score -->
				</div><!-- end wphb-performance-report-current-score -->

				<p><?php _e( 'Current Score', 'wphb' ); ?></p>

				<?php $next_test_on = WP_Hummingbird_Module_Performance::can_run_test(); ?>
				<?php if ( true === $next_test_on ): ?>
					<a href="<?php echo esc_url( $run_url ); ?>" class="button button-app button-content-cta" id="dash-performance-resume-run-new-test"><?php _e( 'Run New Test', 'wphb' ); ?></a>
				<?php else: ?>
					<a href="<?php echo esc_url( wphb_get_admin_menu_url( 'performance' ) ); ?>" id="dash-performance-resume-view-test" class="button button-app button-content-cta"><?php _e( 'View Test', 'wphb' ); ?></a>
				<?php endif; ?>
			</div>

		</div>

	</div>
	<div class="col-half">

		<div class="results">

			<ul class="dev-list dev-list-stats small standalone">
				<?php $data_time = strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', $last_report->time ) ) ); ?>
				<li class="dev-list-stats-item">
					<div>
						<span class="list-label list-label-stats"><?php _e( 'Last Report', 'wphb' ); ?></span>
						<span class="list-detail list-detail-stats list-detail-stats-heading small"><?php echo date_i18n( get_option( 'date_format' ), $data_time ); ?> <span class="list-detail-stats-heading-extra-info"><?php printf( _x( 'at %s', 'Time of the last performance report', 'wphb' ), date_i18n( get_option( 'time_format' ), $data_time ) ); ?></span></span>
					</div>
				</li><!-- end dev-list-stats-item -->

				<?php if ( $last_score ): ?>
					<li class="dev-list-stats-item">
						<div>
							<span class="list-label list-label-stats"><?php _e( 'Previous Score', 'wphb' ); ?></span>
							<span class="list-detail list-detail-stats list-detail-stats-heading small"><?php echo $last_score; ?>/100</span>
						</div>
					</li><!-- end dev-list-stats-item -->
					<li class="dev-list-stats-item">
						<div>
							<span class="list-label list-label-stats"><?php _e( 'Improvement', 'wphb' ); ?></span>
							<span class="list-detail list-detail-stats list-detail-stats-heading small"><span class="wphb-label wphb-label-notice wphb-label-notice-inline wphb-label-notice-<?php echo $improve_class; ?>"><?php echo $improvement; ?></span></span>
						</div>
					</li><!-- end dev-list-stats-item -->
				<?php else : ?>
					<li class="dev-list-stats-item">
						<div>
							<span class="list-label list-label-stats"><?php _e( 'Previous Score', 'wphb' ); ?></span>
							<span class="list-detail list-detail-stats list-detail-stats-heading small">N/A</span>
						</div>
					</li><!-- end dev-list-stats-item -->
					<li class="dev-list-stats-item">
						<div>
							<span class="list-label list-label-stats"><?php _e( 'Improvement', 'wphb' ); ?></span>
							<span class="list-detail list-detail-stats list-detail-stats-heading small"><span class="wphb-label wphb-label-notice wphb-label-notice-inline wphb-label-notice-warning">0</span></span>
						</div>
					</li><!-- end dev-list-stats-item -->
				<?php endif; ?>



			</ul>

		</div>

	</div>
</div>