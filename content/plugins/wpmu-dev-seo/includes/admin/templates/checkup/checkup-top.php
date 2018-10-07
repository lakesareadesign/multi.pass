<?php
$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
if ( $service->in_progress() ) {
	return;
}

$results = $service->result();
$counts = smartcrawl_get_array_value( $results, 'counts' );
$score = smartcrawl_get_array_value( $results, 'score' );

if ( null === $counts || null === $score || false === $score ) {
	return;
}

$issue_count = intval( smartcrawl_get_array_value( $counts, 'warning' ) ) + intval( smartcrawl_get_array_value( $counts, 'critical' ) );	     	 	 	  		 		
$score_class = $issue_count > 0 ? 'wds-score-warning' : 'wds-score-success';
$opts = Smartcrawl_Settings::get_component_options( Smartcrawl_Settings::COMP_CHECKUP );
$reporting_enabled = ! empty( $opts['checkup-cron-enable'] );
?>
<div class="wds-seo-checkup-stats wds-report-stats" data-issue-count="<?php echo esc_attr( $issue_count ); ?>">
	<div class="wds-report-score">
		<div class="wds-score <?php echo esc_attr( $score_class ); ?>">
			<?php echo esc_html( $score ); ?><span class="wds-total"><?php esc_html_e( '/100', 'wds' ); ?></span>
		</div>
		<div class="wds-small-text"><?php esc_html_e( 'Current SEO Score', 'wds' ); ?></div>
	</div>

	<div>
		<div class="wds-stacked-stats">
			<div>
				<div class="wds-stat-name"><?php esc_html_e( 'Last checked:', 'wds' ); ?></div>
				<div
					class="wds-stat-value"><?php echo esc_html( $service->get_last_checked( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) ); ?></div>
			</div>

			<div>
				<div class="wds-stat-name"><?php esc_html_e( 'SEO Issues', 'wds' ); ?></div>
				<div class="wds-stat-value">
				<span class="wds-issues <?php echo $issue_count > 0 ? esc_attr( 'wds-issues-warning' ) : ''; ?>">
					<span><?php echo esc_html( $issue_count ); ?></span>
				</span>
				</div>
			</div>

			<div>
				<div class="wds-stat-name"><?php esc_html_e( 'Scheduled reports', 'wds' ); ?></div>
				<div class="wds-stat-value" style="line-height: 1">
					<?php if ( $service->is_member() ) : ?>
						<?php if ( $reporting_enabled ) : ?>

							<?php
							$monday = strtotime( 'this Monday' );
							$midnight = strtotime( 'today' );
							$checkup_frequency = smartcrawl_get_array_value( $opts, 'checkup-frequency' );
							$checkup_dow = smartcrawl_get_array_value( $opts, 'checkup-dow' );
							$checkup_tod = smartcrawl_get_array_value( $opts, 'checkup-tod' );
							?>

							<span class="wds-checkup-frequency"><?php echo esc_html( $checkup_frequency ); ?></span>
							<br/>
							<span class="wds-checkup-frequency-details">
								<?php
								if ( 'daily' === $checkup_frequency ) {
									printf(
										esc_html__( 'at %s' ),
										esc_html( date_i18n( get_option( 'time_format' ), $midnight + ( $checkup_tod * HOUR_IN_SECONDS ) ) )
									);
								} else {
									printf(
										esc_html__( 'Every %1$s at %2$s' ),
										esc_html( date_i18n( 'l', $monday + ( $checkup_dow * DAY_IN_SECONDS ) ) ),
										esc_html( date_i18n( get_option( 'time_format' ), $midnight + ( $checkup_tod * HOUR_IN_SECONDS ) ) )
									);
								}
								?>
							</span>

						<?php else : ?>
							<button class="button button-small wds-enable-reporting">
								<?php esc_html_e( 'Enable', 'wds' ); ?>
							</button>
							<button class="button button-small wds-disable-reporting"
							        style="display: none;">
								<?php esc_html_e( 'Disable', 'wds' ); ?>
							</button>
						<?php endif; ?>
					<?php else : /* Not a member, this is a pro feature */ ?>
						<button class="wds-upgrade-button button-pro wds-has-tooltip"
						        data-content="<?php esc_attr_e( 'Get SmartCrawl Pro today Free', 'wds' ); ?>"
						        type="button">
							<?php esc_html_e( 'Pro feature', 'wds' ); ?>
						</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>