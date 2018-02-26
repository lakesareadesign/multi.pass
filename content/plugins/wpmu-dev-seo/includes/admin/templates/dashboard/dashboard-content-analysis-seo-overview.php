<?php
/**
 * SEO analyis dashboard widget template
 *
 * @package wpmu-dev-seo
 */

	$analysis_model = new Smartcrawl_Model_Analysis();
	$overview = $analysis_model->get_overall_seo_analysis();

if ( ! $overview ) {
	return;
}

	$total = smartcrawl_get_array_value( $overview, 'total' );
	$passed = smartcrawl_get_array_value( $overview, 'passed' );
	$type_breakdown = smartcrawl_get_array_value( $overview, 'post-types' );

if ( is_null( $total ) || is_null( $passed ) || is_null( $type_breakdown ) ) {
	return;
}

	$percentage = ! empty( $total )
		? intval( ceil( ($passed / $total) * 100 ) )
		: 0
	;

if ( 0 === $passed && 0 === $total ) {
	$class = 'wds-check-invalid';
	$indicator = esc_html__( 'No data yet', 'wds' );
} elseif ( $percentage > 60 ) {
	$class = 'wds-check-success';
	$indicator = esc_html__( 'Good', 'wds' );
} else {
	$class = 'wds-check-warning';
	$indicator = esc_html__( 'Poor', 'wds' );
}
?>
<div class="wds-accordion">
	<div class="wds-accordion-section wds-check-item <?php echo esc_attr( $class ); ?>">

		<div class="wds-accordion-handle">
			<div class="wds-accordion-handle-part"><?php esc_html_e( 'Overall SEO Analysis', 'wds' ); ?></div>
			<div class="wds-accordion-handle-part">
				<span class="wds-check-item-indicator"><?php echo $indicator; ?></span>
			</div>
		</div>

		<div class="wds-accordion-content">
			<p class="wds-small-text">
				<?php esc_html_e( "Here's a breakdown of where you can make improvements.", 'wds' ); ?>
			</p>

			<table class="wds-list-table">
				<tr>
					<th><?php esc_html_e( 'Post Type', 'wds' ); ?></th>
					<th><?php esc_html_e( 'Poor', 'wds' ); ?></th>
					<th><?php esc_html_e( 'Good', 'wds' ); ?></th>
				</tr>
				<?php foreach ( $type_breakdown as $post_type => $type_overview ) :  ?>
					<?php
					$total_for_type = intval( smartcrawl_get_array_value( $type_overview, 'total' ) );
					$passed_for_type = intval( smartcrawl_get_array_value( $type_overview, 'passed' ) );
					$failed_for_type = $total_for_type - $passed_for_type;

					$fail_url = esc_url( admin_url( "edit.php?post_type={$post_type}&wds_analysis_threshold=99" ) );
					$success_url = esc_url( admin_url( "edit.php?post_type={$post_type}&wds_analysis_threshold=100" ) );
					?>
					<tr>
						<td><?php echo esc_html( $post_type ); ?></td>
						<td>
							<?php $failed_for_type > 0 ? printf( '<span class="wds-issues wds-issues-warning"><a href="%s">%s</a></span>', $fail_url, $failed_for_type ) : print(0); ?>
						</td>
						<td>
							<?php $passed_for_type > 0 ? printf( '<span class="wds-issues wds-issues-success-bg"><a href="%s">%s</a></span>', $success_url, $passed_for_type ) : print(0); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>