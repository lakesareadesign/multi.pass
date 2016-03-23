<?php if ( $error ): ?>
	<div class="wphb-table-wrapper complex">
		<div class="row">
			<div class="wphb-notice wphb-notice-error wphb-notice-box">
				<span class="close"></span>
				<span class="wphb-icon wphb-icon-left"><i class="wdv-icon wdv-icon-fw wdv-icon-warning-sign"></i></span>
				<p><?php echo $error; ?></p>
				<a href="<?php echo esc_url( $retry_url ); ?>" class="button button-light button-notice button-notice-error"><?php _e( 'Try again', 'wpb' ); ?></a>
				<a target="_blank" href="<?php echo esc_url( wphb_support_link() ); ?>" class="button button-light button-notice button-notice-error"><?php _e( 'Support', 'wpb' ); ?></a>
			</div>
		</div>
	</div>
<?php else: ?>

	<div class="wphb-table-wrapper complex">
		<table class="list-table hover-effect wphb-table performance-report-table">

			<thead>
				<tr class="wphb-performance-report-item-heading">
					<th class="wphb-performance-report-heading wphb-performance-report-heading-recommendation"><?php _e( 'Recommendation', 'wphb' ); ?></th>
					<th class="wphb-performance-report-heading wphb-performance-report-heading-score"><?php _e( 'Score /100', 'wphb' ); ?></th>
					<th class="wphb-performance-report-heading wphb-performance-report-heading-type"><?php _e( 'Type', 'wphb' ); ?></th>
					<th class="wphb-performance-report-heading wphb-performance-report-heading-cta"></th>
				</tr><!-- end wphb-performance-report-item-heading -->
			</thead>

			<tbody>
				<?php foreach ( $last_test->rule_result as $rule => $rule_result ): ?>
					<?php $has_url_blocks = ! empty( $rule_result->urlblocks ) && is_array( $rule_result->urlblocks ) && ! empty( $rule_result->urlblocks[0] ); ?>
					<tr class="wphb-performance-report-item" id="rule-<?php echo esc_attr( $rule ); ?>">
						<td class="wphb-performance-report-item-recommendation">
							<a href="#"><?php echo $rule_result->label; ?></a>
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
						<td class="wphb-performance-report-item-type">
							<?php echo $rule_result->type; ?>
						</td><!-- end wphb-performance-report-item-type -->

						<td class="wphb-performance-report-item-cta">
							<?php if ( ! empty( $rule_result->summary ) || ! empty ( $rule_result->tip ) ): ?>
								<?php if ( $rule_result->impact_score != 100 ): ?>
									<button class="button button-blue button-small additional-content-opener"><?php _e( 'Improve Score', 'wphb' ); ?></button>
								<?php else: ?>
									<button class="button button-grey button-small additional-content-opener"><?php _e( 'View', 'wphb' ); ?></button>
								<?php endif; ?>
								<span class="additional-content-opener trigger-additional-content"><i class="dev-icon dev-icon-caret_down"></i></span>
							<?php endif; ?>
						</td><!-- end wphb-performance-report-item-cta -->

					</tr><!-- end wphb-performance-report-item -->

					<tr class="wphb-performance-report-item-additional-content">
						<td colspan="4">
							<div class="wphb-performance-report-item-additional-content-inner">

								<h2 class="wphb-performance-report-item-additional-content-heading"><?php echo $rule_result->label; ?></h2>

								<div class="row">
									<?php if ( ! empty( $rule_result->summary ) || ! empty( $rule_result->tip ) ): ?>
										<div class="col-half <?php echo ! $has_url_blocks ? 'col-center' : ''; ?>">
											<?php if ( ! empty( $rule_result->summary ) ): ?>
												<div class="dev-box dev-box-performance-report-additional-content dev-box-performance-report-additional-content-overview">
													<div class="box-content">
														<h4 class="wphb-performance-report-additional-title"><?php _e('Overview', 'wphb'); ?></h4>
														<p><?php echo $rule_result->summary; ?></p>
													</div>
												</div>
											<?php endif; ?>

											<?php if ( ! empty( $rule_result->tip ) ): ?>
												<div class="dev-box dev-box-performance-report-additional-content dev-box-performance-report-additional-content-how-to-fix">
													<div class="box-content">
														<h4 class="wphb-performance-report-additional-title"><?php _e('How to improve', 'wphb'); ?></h4>
														<?php echo $rule_result->tip; ?>
													</div>
												</div>
											<?php endif; ?>
										</div>
									<?php endif; ?>



									<?php if ( $has_url_blocks ): ?>
										<div class="col-half">
											<div class="dev-box dev-box-performance-report-additional-content dev-box-performance-report-additional-content-benchmarks">
												<div class="box-content">
													<h4 class="wphb-performance-report-additional-title"><?php _e('Benchmarks', 'wphb'); ?></h4>

													<?php foreach( $rule_result->urlblocks as $url_block ): ?>
														<?php if ( empty( $url_block ) )
															continue; ?>

														<p><?php echo $url_block->header; ?></p>

														<?php if ( ! empty( $url_block->urls ) && is_array( $url_block->urls ) ): ?>
															<?php foreach ( $url_block->urls as $url ): ?>
																<p><?php echo make_clickable( $url ); ?></p>
															<?php endforeach; ?>
														<?php endif; ?>
													<?php endforeach; ?>

												</div>
											</div>
										</div>
									<?php endif; ?>
								</div>

							</div><!-- end wphb-performance-report-item-additional-content-inner -->
						</td>
					</tr><!-- end wphb-performance-report-item-additional-content -->
				<?php endforeach; ?>

			</tbody>

		</table><!-- end list-table-performance-report -->
	</div>
<?php endif; ?>