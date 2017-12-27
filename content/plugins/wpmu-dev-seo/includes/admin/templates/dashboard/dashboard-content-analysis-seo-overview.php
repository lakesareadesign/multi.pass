<?php
	$analysis_model = new WDS_Model_Analysis();
	$overview = $analysis_model->get_overall_seo_analysis();

	if (!$overview) {
		return;
	}

	$total = wds_get_array_value($overview, 'total');
	$passed = wds_get_array_value($overview, 'passed');
	$type_breakdown = wds_get_array_value($overview, 'post-types');

	if (is_null($total) || is_null($passed) || is_null($type_breakdown)) {
		return;
	}

	$percentage = !empty($total)
		? intval(ceil(($passed / $total) * 100))
		: 0
	;

	if ($passed === 0 && $total === 0) {
		$class = 'wds-check-invalid';
		$indicator = esc_html__('No data yet', 'wds');
	} else if ($percentage > 60) {
		$class = 'wds-check-success';
		$indicator = esc_html__('Good', 'wds');
	} else {
		$class = 'wds-check-warning';
		$indicator = esc_html__('Poor', 'wds');
	}
?>
<div class="wds-accordion">
	<div class="wds-accordion-section wds-check-item <?php echo esc_attr($class); ?>">

		<div class="wds-accordion-handle">
			<div class="wds-accordion-handle-part"><?php esc_html_e('Overall SEO Analysis', 'wds'); ?></div>
			<div class="wds-accordion-handle-part">
				<span class="wds-check-item-indicator"><?php echo $indicator; ?></span>
			</div>
		</div>

		<div class="wds-accordion-content">
			<p class="wds-small-text">
				<?php esc_html_e("Here's a breakdown of where you can make improvements.", 'wds'); ?>
			</p>

			<table class="wds-list-table">
				<tr>
					<th><?php esc_html_e('Post Type', 'wds'); ?></th>
					<th><?php esc_html_e('Poor', 'wds'); ?></th>
					<th><?php esc_html_e('Good', 'wds'); ?></th>
				</tr>
				<?php foreach ($type_breakdown as $post_type => $type_overview): ?>
					<?php
					$total_for_type = intval(wds_get_array_value($type_overview, 'total'));
					$passed_for_type = intval(wds_get_array_value($type_overview, 'passed'));
					$failed_for_type = $total_for_type - $passed_for_type;
					?>
					<tr>
						<td><?php echo esc_html($post_type); ?></td>
						<td>
							<?php $failed_for_type > 0 ? printf('<span class="wds-issues wds-issues-warning">%s</span>', $failed_for_type) : esc_html_e('None', 'wds'); ?>
						</td>
						<td>
							<?php $passed_for_type > 0 ? printf('<span class="wds-issues wds-issues-success-bg">%s</span>', $passed_for_type) : esc_html_e('None', 'wds'); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>