<?php
$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
$last_checked = (boolean) $service->get_last_checked_timestamp();
$in_progress = $service->in_progress();
$last_checked_timestamp = $service->get_last_checked( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) );
$checkup_url = Smartcrawl_Settings_Dashboard::checkup_url();
$options = $_view['options'];
$option_name = Smartcrawl_Settings::TAB_SETTINGS . '_options';
$sitemap_enabled = smartcrawl_get_array_value( $options, 'sitemap' );
$results = $last_checked ? $service->result() : array();
$counts = smartcrawl_get_array_value( $results, 'counts' );
$score = smartcrawl_get_array_value( $results, 'score' );
$checkup_enabled = smartcrawl_get_array_value( $options, 'checkup' );
$dependents = array( Smartcrawl_Settings_Dashboard::BOX_SITEMAP, Smartcrawl_Settings_Dashboard::BOX_SEO_CHECKUP );
$dependents_attr = implode( ';', $dependents );

$issue_count = 0;
if ( null === $score || false === $score ) {
	$score_class = 'wds-score-invalid';
} else {
	$issue_count = intval( smartcrawl_get_array_value( $counts, 'warning' ) ) + intval( smartcrawl_get_array_value( $counts, 'critical' ) );
	$score_class = $issue_count > 0 ? 'wds-score-warning' : 'wds-score-success';
}
?>

<section id="<?php echo esc_attr( Smartcrawl_Settings_Dashboard::BOX_TOP_STATS ); ?>"
         class="wds-seo-checkup-stats wds-report-stats wds-dash-stats dev-box"
         data-issue-count="<?php echo intval( $issue_count ); ?>"
         data-dependent="<?php echo esc_attr( $dependents_attr ); ?>">

	<div class="wds-report-score">
		<?php if ( ! $checkup_enabled ): ?>
            <div class="wds-last-checkup-never">
                <span class="wds-strong-text"><?php esc_html_e( 'Welcome!', 'wds' ); ?></span>
                <p class="wds-small-text">
					<?php esc_html_e( 'Activate SEO checkup to see what needs improving!', 'wds' ); ?>
                </p>
                <button type="button"
                        data-option-id="<?php echo esc_attr( $option_name ); ?>"
                        data-flag="<?php echo esc_attr( 'checkup' ); ?>"
                        class="wds-activate-component button button-small wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request">
					<?php esc_html_e( 'Activate', 'wds' ); ?>
                </button>
            </div>
		<?php elseif ( $in_progress ) : ?>
            <div class="wds-last-checkup-never">
                <span class="wds-strong-text"><?php esc_html_e( 'Welcome!', 'wds' ); ?></span>
                <p class="wds-small-text">
					<?php esc_html_e( 'Please wait while we finish the checkup ...', 'wds' ); ?>
                </p>
                <div class="wds-box-refresh-required"></div>
            </div>
		<?php elseif ( ! $last_checked ) : ?>
			<div class="wds-last-checkup-never">
				<span class="wds-strong-text"><?php esc_html_e( 'Welcome!', 'wds' ); ?></span>
				<p class="wds-small-text">
					<?php esc_html_e( 'Run your first SEO checkup to see what needs improving!', 'wds' ); ?>
				</p>
				<a href="<?php echo esc_attr( $checkup_url ); ?>"
				   class="button button-small">

					<?php esc_html_e( 'Run checkup', 'wds' ); ?>
				</a>
			</div>
		<?php else : ?>
			<div class="wds-score <?php echo esc_attr( $score_class ); ?>">
				<?php echo esc_html( intval( $score ) ); ?><span
                        class="wds-total"><?php esc_html_e( '/100', 'wds' ); ?></span>
			</div>
			<div class="wds-small-text"><?php esc_html_e( 'Current SEO Score', 'wds' ); ?></div>
		<?php endif; ?>
	</div>

	<div>
		<div class="wds-stacked-stats">
			<div>
				<div class="wds-stat-name"><?php esc_html_e( 'Last checkup:', 'wds' ); ?></div>
				<div class="wds-stat-value">
					<?php echo $in_progress ? esc_html__( 'In Progress', 'wds' ) : esc_html( $last_checked_timestamp ); ?>
				</div>
			</div>

			<div>
				<div class="wds-stat-name"><?php esc_html_e( 'Sitemap:', 'wds' ); ?></div>
				<div class="wds-stat-value">
					<?php if ( $sitemap_enabled ) : ?>

						<?php
						$this->_render( 'url-crawl-master', array(
							'ready_template'    => 'dashboard/dashboard-url-crawl-stats',
							'progress_template' => 'dashboard/dashboard-url-crawl-in-progress-small',
							'no_data_template'  => 'dashboard/dashboard-url-crawl-no-data-small',
						) );
						?>

					<?php else : ?>

						<button type="button"
						        data-option-id="<?php echo esc_attr( $option_name ); ?>"
						        data-flag="<?php echo 'sitemap'; ?>"
						        class="wds-activate-component button button-small wds-button-with-loader wds-button-with-left-loader wds-disabled-during-request">

							<?php esc_html_e( 'Activate Sitemap', 'wds' ); ?>
						</button>

					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>


</section>