<?php
	if (!WDS_Settings::get_setting('analysis-seo')) return false;

	/**
	 * @var $model \WDS_Model_Analysis
	 */
	$model = empty($model) ? null : $model;
	$readability_data = empty($readability_data) ? array() : $readability_data;
	$readability_ignored = empty($readability_ignored) ? false : $readability_ignored;
	$readability_score = wds_get_array_value($readability_data, 'score');

	if($model === null || $readability_score === null)
	{
		return;
	}

	$readability_score = intval(ceil($readability_score));
	$readability_level = $model->get_readability_level();
	$readability_levels_map = $model->get_readability_levels_map();
	$readability_strategy = WDS_String::get_readability_strategy();

	if ($readability_ignored) {
		$classes_array[] = 'disabled';
	}

	$total_possible_score = $readability_strategy == WDS_String::READABILITY_KINCAID ? '100' : '';
	$readability_level_description = $model->get_readability_level_description($readability_level);
	$readability_state = $model->get_kincaid_readability_state($readability_score, $readability_ignored);
	$classes_array[] = sprintf(
		'wds-check-%s',
		$readability_state
	);
	$score_class = sprintf(
		'wds-score-%s',
		$readability_state
	);
	$classes = implode(' ', $classes_array);
?>

<div class="wds-readability-report wds-report"
	 data-readability-state="<?php echo $readability_state; ?>">

	<div class="wds-readability-stats wds-report-stats">
		<div class="wds-report-score">
			<span class="wds-score <?php echo $score_class; ?>">
				<?php echo $readability_score; ?><?php if ($total_possible_score): ?><span class="wds-total">/<?php echo $total_possible_score; ?></span><?php endif; ?>
			</span>
			<span class="wds-small-text"><?php esc_html_e('Readability score', 'wds'); ?></span>
		</div>

		<div class="wds-readability-level-description wds-small-text">
			<?php echo $readability_level_description; ?>
		</div>
	</div>

	<div class="wds-accordion">
		<div class="wds-check-item wds-accordion-section <?php echo $classes; ?>">
			<div class="wds-accordion-handle">
				<div class="wds-accordion-handle-part">
					<?php esc_html_e('Flesch-Kincaid Test', 'wds'); ?>
				</div>

				<?php if ($readability_ignored): ?>
					<div class="wds-unignore-container wds-accordion-handle-part">
						<button type="button" class="wds-unignore wds-button-with-loader wds-button-with-left-loader wds-disabled-during-request button button-small button-dark-o" data-check_id="readability">
							<?php esc_html_e('Restore', 'wds'); ?>
						</button>
					</div>
				<?php else: ?>
					<div class="wds-readability-level wds-accordion-handle-part">
						<span class="wds-check-item-indicator"><?php echo $readability_level; ?></span>
					</div>
				<?php endif; ?>
			</div>
			<div class="wds-accordion-content">
				<div class="wds-small-text"><strong><?php esc_html_e('Overview', 'wds') ?></strong></div>
				<p class="wds-small-text"><?php esc_html_e('The Flesch-Kincaid readability tests are readability tests designed to indicate how difficult a passage in English is to understand. Here are the benchmarks.', 'wds'); ?></p>
				<table class="wds-list-table">
					<tbody>
					<tr>
						<th><?php esc_html_e('Score', 'wds'); ?></th>
						<th><?php esc_html_e('Description', 'wds'); ?></th>
					</tr>

					<?php foreach ($readability_levels_map as $label => $level): ?>
						<tr>
							<?php
							if (!is_array($level) || !isset($level['max']) || !isset($level['min'])) {
								continue;
							}
							?>
							<td><?php echo esc_html((int)ceil($level['min'])); ?>
								- <?php echo esc_html((int)ceil($level['max'])); ?></td>
							<td><?php echo esc_html($label); ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>

				<div class="wds-small-text"><strong><?php esc_html_e('How to fix', 'wds') ?></strong></div>
				<p class="wds-small-text"><?php esc_html_e('Try to use shorter sentences, with less difficult words to improve readability.', 'wds'); ?></p>

				<div class="wds-ignore-container">
					<button type="button" class="wds-ignore wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request button button-small button-dark button-dark-o" data-check_id="readability">
						<?php esc_html_e('Ignore', 'wds'); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>