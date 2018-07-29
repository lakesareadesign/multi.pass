<?php
// Required
$type = empty( $type ) ? '' : $type;
/**
 * @var $report Smartcrawl_SeoReport
 */
$report = empty( $report ) ? null : $report;
// Optional
$title = empty( $title ) ? '' : $title;
$description = empty( $description ) ? '' : $description;
$header_items = empty( $header_items ) ? array() : $header_items;
$controls_template = empty( $controls_template ) ? 'sitemap/sitemap-crawl-issues-generic-controls' : $controls_template;
$issue_template = empty( $issue_template ) ? 'sitemap/sitemap-crawl-issue-generic' : $issue_template;
$success_class = empty( $success_class ) ? 'wds-check-success' : $success_class;
$warning_class = empty( $warning_class ) ? 'wds-check-warning' : $warning_class;
$open = empty( $open ) ? false : $open;

if ( ! $report || ! $type ) {
	return;
}
$all_issues = $report->get_issues_by_type( $type, true );
$ignored_issues = array();
$active_issues = array();

foreach ( $all_issues as $issue_id ) {
	if ( $report->is_ignored_issue( $issue_id ) ) {
		$ignored_issues[] = $issue_id;
	} else {
		$active_issues[] = $issue_id;
	}
}

$issue_count = count( $active_issues );
$class = $issue_count > 0 ? $warning_class : $success_class;
?>
<div
	class="wds-issues-type-<?php echo esc_attr( $type ); ?> wds-accordion-section <?php echo esc_attr( $class ); ?> <?php echo $open ? 'open' : ''; ?> <?php echo $all_issues ? '' : 'disabled'; ?>"
	data-type="<?php echo esc_attr( $type ); ?>">

	<div class="wds-accordion-handle">
		<?php printf( esc_html( $title ), $issue_count > 0 ? intval( $issue_count ) : esc_html__( 'No', 'wds' ) ); ?>
	</div>
	<?php if ( $all_issues ) : ?>
		<div class="wds-accordion-content">
			<div class="wds-small-text"><strong><?php esc_html_e( 'Overview', 'wds' ); ?></strong></div>
			<p>
				<?php echo esc_html( $description ); ?>
			</p>
			<?php if ( $active_issues ) : ?>
				<table class="wds-list-table wds-crawl-issues-table">
					<thead>
					<tr>
						<?php foreach ( $header_items as $header_item ) : ?>
							<?php echo wp_kses_post( $header_item ); ?>
						<?php endforeach; ?>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ( $active_issues as $active_issue_id ) {
						$this->_render( $issue_template, array(
							'type'     => $type,
							'report'   => $report,
							'issue_id' => $active_issue_id,
						) );
					}

					$this->_render( $controls_template );
					?>
					</tbody>
				</table>
			<?php endif; ?>

			<?php if ( $ignored_issues ) : ?>
				<table class="wds-list-table wds-ignored-items-table">
					<thead>
					<tr>
						<th colspan="2"><?php esc_html_e( 'Ignored', 'wds' ); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ( $ignored_issues as $ignored_issue_id ) {
						$this->_render( 'sitemap/sitemap-crawl-issue-ignored', array(
							'type'     => $type,
							'report'   => $report,
							'issue_id' => $ignored_issue_id,
						) );
					}
					?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>