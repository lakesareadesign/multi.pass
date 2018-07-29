<?php
$active_issues = empty( $active_issues ) ? 0 : $active_issues;
$report = empty( $report ) ? null : $report;

if ( ! $report ) {
	return;
}
?>

<div class="wds-url-crawler-stats wds-report-stats">
	<div class="wds-report-score">
		<span class="wds-score <?php echo $active_issues > 0 ? 'wds-score-warning' : 'wds-score-success'; ?>">
			<?php echo intval( $active_issues ); ?>
			<span class="wds-total"></span>
		</span>
		<span class="wds-small-text"><?php esc_html_e( 'Sitemap Issues', 'wds' ); ?></span>
	</div>

	<div>
		<div class="wds-stacked-stats">
			<div>
				<div class="wds-stat-name"><?php esc_html_e( 'Total URLs Discovered', 'wds' ); ?></div>
				<div class="wds-stat-value"><?php echo intval( $report->get_meta( 'total' ) ); ?></div>
			</div>
			<div>
				<div class="wds-stat-name"><?php esc_html_e( 'Invisible URLs', 'wds' ); ?></div>
				<div class="wds-stat-value"><?php echo intval( $report->get_issues_count( 'sitemap' ) ); ?></div>
			</div>
		</div>
	</div>
</div>