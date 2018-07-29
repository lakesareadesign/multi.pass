<?php
$report = empty( $report ) ? null : $report;

if ( is_null( $report ) ) {
	return;
}

$active_issues = $report->get_issues_count();
$missing_urls = $report->get_issues_count( 'sitemap' );
?>

<?php if ( $active_issues > 0 ) : ?>
	<div class="wds-box-crawl-stats">
		<span class="wds-issues wds-issues-warning wds-has-tooltip"
		      data-content="<?php printf( esc_attr__( 'You have %s sitemap issues', 'wds' ), intval( $active_issues ) ); ?>">

			<?php echo intval( $active_issues ); ?><?php esc_html_e( ' issues', 'wds' ); ?>
		</span>
		<span
			class="wds-issues wds-issues-invalid"><?php echo intval( $missing_urls ); ?><?php esc_html_e( ' missing URLs', 'wds' ); ?></span>
	</div>
<?php else : ?>
	<span class="wds-box-stat-value wds-box-stat-value-success"><?php esc_html_e( 'No issues', 'wds' ); ?></span>
<?php endif; ?>