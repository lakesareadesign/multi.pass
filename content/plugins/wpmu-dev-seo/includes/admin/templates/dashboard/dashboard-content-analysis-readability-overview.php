<?php
/**
 * Readability analysis dashboard widget template
 *
 * @package wpmu-dev-seo
 */

	$analysis_model = new Smartcrawl_Model_Analysis();
	$overview = $analysis_model->get_overall_readability_analysis();

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
} elseif ( $percentage > 79 ) {
	$class = 'wds-check-success';
	$indicator = esc_html__( 'Easy', 'wds' );
} elseif ( $percentage > 59 ) {
	$class = 'wds-check-warning';
	$indicator = esc_html__( 'Difficult', 'wds' );
} else {
	$class = 'wds-check-error';
	$indicator = esc_html__( 'Difficult', 'wds' );
}
?>
<div class="wds-accordion">
	<div class="wds-accordion-section wds-check-item <?php echo esc_attr( $class ); ?>">

		<div class="wds-accordion-handle">
			<div class="wds-accordion-handle-part"><?php esc_html_e( 'Overall Readability Analysis', 'wds' ); ?></div>
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
					<th><?php esc_html_e( 'Difficult', 'wds' ); ?></th>
					<th><?php esc_html_e( 'Okay', 'wds' ); ?></th>
					<th><?php esc_html_e( 'Easy', 'wds' ); ?></th>
				</tr>
				<?php foreach ( $type_breakdown as $post_type => $type_overview ) :  ?>
					<?php
					$difficult = intval( smartcrawl_get_array_value( $type_overview, 'error' ) );
					$okay = intval( smartcrawl_get_array_value( $type_overview, 'warning' ) );;
					$easy = intval( smartcrawl_get_array_value( $type_overview, 'success' ) );

					$edit_url = admin_url( 'edit.php?wds_readability_threshold=' );
					?>
					<tr>
						<td><?php echo esc_html( $post_type ); ?></td>
						<td>
							<?php $difficult > 0 ? printf( '<span class="wds-issues wds-issues-error"><a href="%s">%s</a></span>', esc_url( add_query_arg( 'post_type', $post_type, "{$edit_url}0" ) ), $difficult ) : print(0); ?>
						</td>
						<td>
							<?php $okay > 0 ? printf( '<span class="wds-issues wds-issues-warning"><a href="%s">%s</a></span>', esc_url( add_query_arg( 'post_type', $post_type, "{$edit_url}1" ) ), $okay ) : print(0); ?>
						</td>
						<td>
							<?php $easy > 0 ? printf( '<span class="wds-issues wds-issues-success-bg">%s</span>', $easy ) : print(0); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>