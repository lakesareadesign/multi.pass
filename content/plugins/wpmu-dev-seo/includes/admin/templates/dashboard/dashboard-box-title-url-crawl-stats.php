<?php
$report = empty( $report ) ? null : $report;

if ( is_null( $report ) ) {
	return;
}

$active_issues = $report->get_issues_count();
?>

<?php if ( $active_issues > 0 ) : ?>
	<span class="wds-issues wds-issues-warning wds-has-tooltip"
		  data-content="<?php printf( esc_attr__( 'You have %s sitemap issues', 'wds' ), intval( $active_issues ) ); ?>">

		<?php echo intval( $active_issues ); ?>
	</span>
<?php endif; ?>