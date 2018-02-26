<?php
/**
 * SEO Audit crawl results dispatching template
 *
 * @package wpmu-dev-seo
 */

$report = empty( $report ) ? null : $report;

if ( null == $report ) {
	return;
}

$active_issues = $report->get_issues_count();
$ignored_issues = $report->get_ignored_issues_count();
$open_type = empty( $open_type ) ? null : $open_type;
$default_issue_types = array( '3xx', '4xx', '5xx', 'inaccessible', 'sitemap' );
?>
<div class="wds-crawl-results-report wds-report"
	 data-active-issues="<?php echo esc_attr( $active_issues ); ?>"
	 data-ignored-issues="<?php echo esc_attr( $ignored_issues ); ?>">

	<?php
	if ( $report->has_state_messages() ) {
		foreach ( $report->get_state_messages() as $state_message ) {
			$this->_render('notice', array(
				'message' => $state_message,
				'class'   => 'wds-notice-error',
			));
		}
	}
	?>

	<?php
		$this->_render('sitemap/sitemap-crawl-stats', array(
			'active_issues' => $active_issues,
			'report'        => $report,
		));
	?>

	<p><?php esc_html_e( 'Here are potential issues SmartCrawl has picked up. We recommend fixing them up to ensure you aren’t penalized by search engines - you can however ignore any of these warnings.', 'wds' ); ?></p>

<?php if ( ! Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_SITE )->is_member() ) { ?>
	<div class="wds-obfuscate-section"></div>
<?php } ?>

	<div class="wds-accordion">
		<?php
			$issue_types = array_unique( array_replace_recursive( $default_issue_types, $report->get_issue_types() ) );

		foreach ( $issue_types as $type ) {
			$this->_render('sitemap/sitemap-crawl-issues-' . $type, array(
				'type'   => $type,
				'report' => $report,
				'open'   => $open_type == $type,
			));
		}
		?>
	</div>
</div>