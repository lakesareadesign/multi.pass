<?php
	$options = $_view['options'];
	$seo_analysis_enabled = wds_get_array_value($options, 'analysis-seo');
	$readability_analysis_enabled = wds_get_array_value($options, 'analysis-readability');
	$option_name = WDS_Settings::TAB_SETTINGS . '_options';
	$is_ajax_request = defined('DOING_AJAX') && DOING_AJAX;
	$refresh_required = !$is_ajax_request && ($seo_analysis_enabled || $readability_analysis_enabled);

	$classes = array();
	if ($refresh_required) {
		$classes[] = 'wds-box-refresh-required';
	}
	if ($seo_analysis_enabled) {
		$classes[] = 'wds-seo-analysis-enabled';
	}
	if ($readability_analysis_enabled) {
		$classes[] = 'wds-readability-analysis-enabled';
	}
?>

<section id="<?php echo WDS_Settings_Dashboard::BOX_CONTENT_ANALYSIS; ?>"
		 class="dev-box <?php echo implode(' ', $classes); ?>">

	<div class="box-title">
		<h3>
			<i class="wds-icon-magnifying-glass-search"></i> <?php esc_html_e('Content Analysis', 'wds'); ?>
		</h3>
	</div>

	<div class="box-content">
		<p><?php esc_html_e('SEO and Readability Analysis recommend improvements to your content to give it the best chance of ranking highly, as well as being easy for average person to read.', 'wds'); ?></p>

		<div class="wds-report">
			<?php if ($seo_analysis_enabled): ?>
				<?php if ($is_ajax_request) $this->_render('dashboard/dashboard-content-analysis-seo-overview'); ?>
			<?php else: ?>
				<div class="wds-separator-top">
					<span class="wds-small-text"><strong><?php esc_html_e('SEO Analysis', 'wds'); ?></strong></span>
					<p class="wds-small-text">
						<?php esc_html_e('Analyses your content against recommend SEO practice and gives recommendations for improvement to make sure content is as optimized as possible.', 'wds'); ?>
					</p>
					<button type="button"
							data-option-id="<?php echo esc_attr($option_name); ?>"
							data-flag="analysis-seo"
							class="wds-activate-component button button-small wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request">

						<?php esc_html_e('Activate', 'wds'); ?>
					</button>
				</div>
			<?php endif; ?>

			<?php if ($readability_analysis_enabled): ?>
				<?php if ($is_ajax_request) $this->_render('dashboard/dashboard-content-analysis-readability-overview'); ?>
			<?php else: ?>
				<div class="wds-separator-top">
					<span class="wds-small-text"><strong><?php esc_html_e('Readability Analysis', 'wds'); ?></strong></span>
					<p class="wds-small-text">
						<?php esc_html_e('Benchmarks the readability of your content for the average visitor and gives recommendations for improvement.', 'wds'); ?>
					</p>
					<button type="button"
							data-option-id="<?php echo esc_attr($option_name); ?>"
							data-flag="analysis-readability"
							class="wds-activate-component button button-small wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request">

						<?php esc_html_e('Activate', 'wds'); ?>
					</button>
				</div>
			<?php endif; ?>
		</div>

        <div class="wds-box-footer">
            <a href="<?php echo esc_attr(admin_url('edit.php')); ?>"
               class="button button-small button-dark button-dark-o wds-dash-edit-posts-button">

				<?php esc_html_e('Edit Posts', 'wds'); ?>
            </a>
        </div>
	</div>
</section>