<?php
	$page_url = WDS_Settings_Admin::admin_url(WDS_Settings::TAB_CHECKUP);
	$dashboard_url = WDS_Settings_Admin::admin_url(WDS_Settings::TAB_DASHBOARD);
	/**
	 * @var $service WDS_Checkup_Service
	 */
	$service = WDS_Service::get(WDS_Service::SERVICE_CHECKUP);
	$options = $_view['options'];
	$reporting_enabled = wds_get_array_value($options, 'checkup-cron-enable');
	$last_checked = (boolean)$service->get_last_checked_timestamp();
	$in_progress = $last_checked ? false : $service->in_progress();
	$option_name = WDS_Settings::TAB_SETTINGS . '_options';
	$checkup_enabled = wds_get_array_value($options, 'checkup');
	$checkup_text = esc_html__('Get a comprehensive report on how optimized your website is for search engines and social media. We recommend running this checkup first to see what needs improving.', 'wds');
	$results = $in_progress ? array() : $service->result();
	$counts = wds_get_array_value($results, 'counts');
	$issue_count = intval(wds_get_array_value($counts, 'warning')) + intval(wds_get_array_value($counts, 'critical'));
?>
<section id="<?php echo WDS_Settings_Dashboard::BOX_SEO_CHECKUP; ?>" class="dev-box">
	<div class="box-title">
		<?php if ($checkup_enabled): ?>
			<div class="buttons buttons-icon">
				<a href="<?php echo esc_attr($page_url); ?>">
					<i class="wds-icon-arrow-right-carats"></i>
				</a>
			</div>
		<?php endif; ?>
		<h3>
			<i class="wds-icon-icon-smart-crawl"></i> <?php esc_html_e('SEO Checkup', 'wds'); ?>
			<?php if ($issue_count > 0): ?>
                <span class="wds-issues wds-issues-warning wds-has-tooltip"
                      data-content="<?php printf(__('You have %s outstanding SEO issues to fix up', 'wds'), $issue_count); ?>">
                    <?php echo $issue_count; ?>
                </span>
			<?php endif; ?>
		</h3>
	</div>
	<div class="box-content">
		<?php if ($checkup_enabled): ?>
			<?php
				if (!$last_checked && !$in_progress) {
					?>
					<p><?php echo $checkup_text; ?></p>

                    <div class="wds-box-footer">
                        <a href="<?php echo esc_url(add_query_arg('run-checkup', 'yes', $dashboard_url)); ?>"
                           class="button button-small">
							<?php esc_html_e('Run checkup', 'wds'); ?>
                        </a>
                    </div>
					<?php
				} else if ($service->in_progress()) {
					$this->_render('dashboard/dashboard-checkup-progress');
				} else {
					$this->_render('dashboard/dashboard-mini-checkup-report', array(
						'results'     => $results,
						'issue_count' => $issue_count
					));
				}
			?>
		<?php else: ?>
			<p><?php echo $checkup_text; ?></p>
			<button type="button"
					data-option-id="<?php echo esc_attr($option_name); ?>"
					data-flag="<?php echo esc_attr('checkup'); ?>"
					class="wds-activate-component button button-small wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request">

				<?php esc_html_e('Activate', 'wds'); ?>
			</button>
		<?php endif; ?>
	</div>
</section>