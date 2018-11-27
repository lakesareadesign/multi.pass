<?php
if ( ! Smartcrawl_Settings::get_setting( 'analysis-seo' ) ) {
	return false;
}

/**
 * @var $model \Smartcrawl_Model_Analysis
 */
$model = empty( $model ) ? null : $model;
$readability_data = empty( $readability_data ) ? array() : $readability_data;
$readability_ignored = empty( $readability_ignored ) ? false : $readability_ignored;
$readability_score = smartcrawl_get_array_value( $readability_data, 'score' );

if ( null === $model || null === $readability_score ) {
	return;
}

$readability_score = intval( ceil( $readability_score ) );
$readability_level = $model->get_readability_level();
$readability_levels_map = $model->get_readability_levels_map();
$readability_strategy = Smartcrawl_String::get_readability_strategy();

if ( $readability_ignored ) {
	$classes_array[] = 'disabled';
}

$total_possible_score = Smartcrawl_String::READABILITY_KINCAID === $readability_strategy ? '100' : '';
$readability_level_description = $model->get_readability_level_description( $readability_level );
$readability_state = $model->get_kincaid_readability_state( $readability_score, $readability_ignored );
$classes_array[] = sprintf(
	'wds-check-%s',
	$readability_state
);
$score_class = sprintf(
	'wds-score-%s',
	$readability_state
);
$classes = implode( ' ', $classes_array );
$refresh_analysis_disabled = 'auto-draft' === get_post_status() ? 'disabled' : '';
?>

<div class="wds-readability-report wds-report"
     data-readability-state="<?php echo esc_attr( $readability_state ); ?>">

	<div class="wds-readability-stats wds-report-stats">
		<div class="wds-report-score">
			<div class="wds-score <?php echo esc_attr( $score_class ); ?>">
                <span><?php echo esc_html( $readability_score ); ?></span><?php if ( $total_possible_score ) : ?><span
                        class="wds-total">/<?php echo esc_html( $total_possible_score ); ?></span><?php endif; ?>
			</div>
			<span class="wds-small-text"><?php esc_html_e( 'Readability score', 'wds' ); ?></span>
		</div>

		<div class="wds-readability-level-description wds-small-text">
			<?php echo wp_kses( $readability_level_description, array( 'strong' => array() ) ); ?>

			<br/>
			<button class="button button-small button-dark button-dark-o wds-refresh-analysis wds-analysis-readability wds-disabled-during-request"
				<?php echo esc_attr( $refresh_analysis_disabled ); ?> type="button">
				<span><?php esc_html_e( 'Refresh', 'wds' ); ?></span>
			</button>
		</div>
	</div>

	<div class="wds-analysis-working">
		<p>
			<?php esc_html_e( 'Analyzing content, please wait a few moments', 'wds' ); ?>
		</p>
	</div>

	<div class="wds-report-inner">
		<div class="wds-accordion">
			<div class="wds-check-item wds-accordion-section <?php echo esc_attr( $classes ); ?>">
				<div class="wds-accordion-handle">
					<div class="wds-accordion-handle-part">
						<?php esc_html_e( 'Flesch-Kincaid Test', 'wds' ); ?>
					</div>

					<?php if ( $readability_ignored ) : ?>
						<div class="wds-unignore-container wds-accordion-handle-part">
							<button type="button"
							        class="wds-unignore wds-button-with-loader wds-button-with-left-loader wds-disabled-during-request button button-small button-dark-o"
							        data-check_id="readability">
								<?php esc_html_e( 'Restore', 'wds' ); ?>
							</button>
						</div>
					<?php else : ?>
						<div class="wds-readability-level wds-accordion-handle-part">
							<span class="wds-check-item-indicator"><?php echo esc_html( $readability_level ); ?></span>
						</div>
					<?php endif; ?>
				</div>
				<div class="wds-accordion-content">
					<div class="wds-small-text"><strong><?php esc_html_e( 'Overview', 'wds' ); ?></strong></div>
					<p class="wds-small-text"><?php esc_html_e( 'The Flesch-Kincaid readability tests are readability tests designed to indicate how difficult a passage in English is to understand. Here are the benchmarks.', 'wds' ); ?></p>
					<table class="wds-list-table">
						<tbody>
						<tr>
							<th><?php esc_html_e( 'Score', 'wds' ); ?></th>
							<th><?php esc_html_e( 'Description', 'wds' ); ?></th>
						</tr>

						<?php foreach ( $readability_levels_map as $label => $level ) : ?>
							<tr>
								<?php
								if ( ! is_array( $level ) || ! isset( $level['max'] ) || ! isset( $level['min'] ) ) {
									continue;
								}
								?>
								<td><?php echo esc_html( (int) ceil( $level['min'] ) ); ?>
									- <?php echo esc_html( (int) ceil( $level['max'] ) ); ?></td>
								<td><?php echo esc_html( $label ); ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>

					<div class="wds-small-text"><strong><?php esc_html_e( 'How to fix', 'wds' ); ?></strong></div>
					<p class="wds-small-text"><?php esc_html_e( 'Try to use shorter sentences, with less difficult words to improve readability.', 'wds' ); ?></p>

					<div class="wds-ignore-container">
						<button type="button"
						        class="wds-ignore wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request button button-small button-dark button-dark-o"
						        data-check_id="readability">
							<?php esc_html_e( 'Ignore', 'wds' ); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>