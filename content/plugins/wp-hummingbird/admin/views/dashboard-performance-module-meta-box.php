<table class="list-table hover-effect dashboard-performance-report-table">

	<thead>
		<tr class="wphb-performance-report-item-heading">
			<th class="wphb-performance-report-heading wphb-performance-report-heading-recommendation"><?php _e( 'Recommendation', 'wphb' ); ?></th>
			<th class="wphb-performance-report-heading wphb-performance-report-heading-score"><?php _e( 'Score /100', 'wphb' ); ?></th>
		</tr><!-- end wphb-performance-report-item-heading -->
	</thead>

	<tbody>

		<?php foreach ( $report->rule_result as $rule => $rule_result ): ?>
			<tr class="wphb-performance-report-item" data-performance-url="<?php echo esc_url( wphb_get_admin_menu_url( 'performance' ) ); ?>#rule-<?php echo $rule; ?>">
				<td class="wphb-performance-report-item-recommendation">
					<span class="list-label-link">
						<?php echo $rule_result->label; ?>
					</span>
				</td><!-- end wphb-performance-report-item-recommendation -->
				<td class="wphb-performance-report-item-score">
					<div class="wphb-score wphb-score-have-label">
						<div class="tooltip-box">
							<div class="wphb-score-result wphb-score-result-grade-<?php echo $rule_result->impact_score_class; ?>" tooltip="<?php echo $rule_result->impact_score; ?>/100">
								<div class="wphb-score-type wphb-score-type-circle">
									<svg class="wphb-score-graph wphb-score-graph-svg" xmlns="http://www.w3.org/2000/svg" width="30" height="30">
										<circle class="wphb-score-graph-circle" r="12.5" cx="15" cy="15" fill="transparent" stroke-dasharray="0" stroke-dashoffset="0"></circle>
										<circle class="wphb-score-graph-circle wphb-score-graph-result" r="12.5" cx="15" cy="15" fill="transparent" stroke-dasharray="80" stroke-dashoffset="0"></circle>
									</svg>
								</div><!-- end wphb-score-type -->
								<div class="wphb-score-result-label"><?php echo $rule_result->impact_score; ?></div>
							</div><!-- end wphb-score-result -->
						</div><!-- end tooltip-box -->
					</div><!-- end wphb-score -->
				</td><!-- end wphb-performance-report-item-score -->
			</tr>
		<?php endforeach; ?>


	</tbody>
</table>