<?php do_action('wds-template-seo_service-box-full-before'); ?>

<?php
	// We have Dashboard installed and set up, we're ready to go
?>
<?php if (empty($status['start']) /*&& empty($status['end'])*/) { ?>
<section class="box-dashboard-run-seo-anaysis dev-box">
	<div class="box-title">
		<h3><span class="dashicons dashicons-dashboard wds-dashicons wds-dashicons-box-title"></span><?php esc_html_e( 'Run SEO analysis of your site', 'wds' ); ?></h3>
	</div>
	<?php if (!empty($errors)) { ?>
	<div class="box-content">
		<?php foreach ($errors as $error) { ?>
			<div class="wds-notice wds-notice-error">
				<p><?php echo $error; ?></p>
			</div>
		<?php } ?>
	</div>
	<?php } ?>

	<div class="box-content wds-seo_service-results-parent">
	<?php do_action('wds-template-seo_service-box-full-before_body'); ?>
		<p><?php esc_html_e( 'Let our servers run a comprehensive scan of your entire website & compile a list of suggestions on how you can improve the SEO of your website.', 'wds' ); ?></p>
	</div>
	<div class="box-footer buttons">
		<a href="#run-seo-analysis-modal" rel="dialog" class="button button-cta-alt"><?php esc_html_e( 'Run SEO analysis', 'wds' ); ?></a>
	</div>

</section><!-- end box-dashboard-run-seo-anaysis -->
<?php } ?>


<?php
	// SEO Report Test still on progress
?>
<?php if (!empty($status['start'])) { ?>
<section class="box-dashboard-run-seo-anaysis dev-box">
	<div class="box-title">
		<h3><span class="dashicons dashicons-dashboard wds-dashicons wds-dashicons-box-title"></span><?php esc_html_e( 'Run SEO analysis of your site', 'wds' ); ?></h3>
	</div>

	<div class="box-content">
		<?php if (!empty($errors)) foreach ($errors as $error) { ?>
			<div class="wds-notice wds-notice-error">
				<p><?php echo $error; ?></p>
			</div>
		<?php } ?>

	<?php if ($report->has_state_messages()) { ?>
		<div class="result state-messages">
			<?php foreach ($report->get_state_messages() as $message) { ?>
				<div class="wds-notice wds-notice-error">
					<p><?php echo esc_html($message); ?></p>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>

	<?php if (empty($status['end'])) { ?>
		<?php $this->_render('dashboard-dialog-seo_service-run', array('status' => $status)); ?>
	<?php } else if (!empty($has_result)) { ?>
		<?php
		// --- SEO check is done, let's go for results ---
		?>
		<div class="box-content no-padding wds-seo_service-results-parent">
		<?php do_action('wds-template-seo_service-box-full-before_body'); ?>
			<div class="wds-seo_service-results">

				<div class="wds-overview">
				<?php if ($report->has_meta('total')) { ?>
					<div class="wds-overview-item">
						<strong><?php echo (int)$report->get_meta('total'); ?></strong>
						<span><?php esc_html_e('Total Discovered URLs', 'wds'); ?></span>
					</div>
				<?php } ?>
				<?php if ($report->has_meta('discovered')) { ?>
					<div class="wds-overview-item">
						<strong><?php echo (int)$report->get_meta('discovered'); ?></strong>
						<span><?php esc_html_e('Newly Discovered URLs', 'wds'); ?></span>
					</div>
				<?php } ?>
				<?php if ($report->has_issues('inaccessible')) { ?>
					<div class="wds-overview-item">
						<strong><?php echo (int)$report->get_issues_count('inaccessible'); ?></strong>
						<span><?php esc_html_e('Invisible URLs', 'wds'); ?></span>
					</div>
				<?php } ?>
				<?php if ($report->has_meta('sitemap_total')) { ?>
					<div class="wds-overview-item">
						<strong><?php echo (int)$report->get_meta('sitemap_total'); ?></strong>
						<span><?php esc_html_e('URLs in the Sitemap', 'wds'); ?></span>
					</div>
				<?php } ?>
				</div>

			<?php /* "Not processed" notice, displayed as warning, outside the main report */ ?>
			<?php if ($report->get_issues_count('not_processed')) { ?>
			<div class="result not-processed">
				<div class="wds-notice wds-notice-warning">
					<p><?php esc_html_e('Some parts of your site were too slow to respond and were not included in our crawl.', 'wds'); ?></p>
				</div>
			</div>
			<?php } ?>

			<?php if ($report->has_issues()) { ?>
				<div class="wds-breakdown">
					<h4><?php echo esc_html_e('We have found a few issues with URLs:', 'wds'); ?></h4>
					<?php
						if ($report->has_issues('5xx')) {
							$this->_render('dashboard-report-issue', array(
								'type' => '5xx',
								'msg' => __('URLs that result in a server error (500 etc)', 'wds'),
								'report' => $report,
								'issues' => $report->get_issues_by_type('5xx'),
								'redirections' => $redirections,
							));
						}
						if ($report->has_issues('4xx')) {
							$this->_render('dashboard-report-issue', array(
								'type' => '4xx',
								'msg' => __('URLs that result in a soft error (404 etc)', 'wds'),
								'report' => $report,
								'issues' => $report->get_issues_by_type('4xx'),
								'redirections' => $redirections,
							));
						}
						if ($report->has_issues('3xx')) {
							$this->_render('dashboard-report-issue', array(
								'type' => '3xx',
								'msg' => __('URLs that have multiple re-directs', 'wds'),
								'report' => $report,
								'issues' => $report->get_issues_by_type('3xx'),
								'redirections' => $redirections,
							));
						}
					?>
				</div>
			<?php } else { // if issues count ?>
				<div class="wds-breakdown">
					<div class="wds-service-no_issue">
					<?php if (!$report->has_state_messages()) { ?>
						<div class="wds-crawl-result wds-crawl-success">
							<p><?php esc_html_e('Your latest crawl revealed no SEO issues, well done!', 'wds'); ?></p>
						<?php if ($report->has_ignored_issues()) { ?>
							<p>
								<em><small><?php esc_html_e('Well, that\'s not entirely true, but you opted to ignore a couple of them ;)', 'wds'); ?></small></em>
								<a href="#purge-ignores"><?php esc_html_e('Purge ignored list', 'wds'); ?></a>
							</p>
						<?php } ?>
						</div>
					<?php } else { ?>
						<p><?php
							esc_html_e('Please, have a look into the displayed messages and re-crawl your site.', 'wds');
						?></p>
					<?php } ?>
					</div>
				</div>
			<?php } // if issues count ?>

			<?php if ($report->get_sitemap_misses()) { ?>
				<div class="wds-sitemap">
					<div class="wds-seo_service-warning wds-seo_service-warning-sitemap">
						<p>
							<?php printf(__('%d URLs are not in the Sitemap', 'wds'), ($report->get_sitemap_misses())); ?>
							<button
								class="wds-update-sitemap button button-yellow-alt"
								data-working="<?php esc_attr_e('Updating...', 'wds'); ?>"
								data-static="<?php esc_attr_e('Update Sitemap', 'wds'); ?>"
								data-done="<?php esc_attr_e('Sitemap updated, please hold on...', 'wds'); ?>"
							type="button" >
								<?php esc_html_e('Update Sitemap', 'wds'); ?>
							</button>
							<span class="info">
								<small><i>
									<?php esc_html_e('This number might not be indicative of an actual issue on your site. These URLs could also be things that don\'t make sense to be found in the sitemap, such as date archives.', 'wds'); ?>
									<?php if ($report->has_issues('sitemap')) { ?>
										<a href="#toggle-sitemap-urls"><?php esc_html_e('Show', 'wds'); ?></a>
									<?php } ?>
								</i></small>
							</span>
						</p>
					<?php if ($report->has_issues('sitemap')) { ?>
						<div class="wds-sitemap-issues_list" style="display:none">
							<ul>
							<?php foreach ($report->get_issues_by_type('sitemap') as $key) { ?>
								<?php $info = $report->get_issue($key); ?>
								<?php if (empty($info['path'])) continue; ?>
								<li
									data-issue_id="<?php echo esc_attr($key); ?>"
									data-path="<?php echo esc_attr($info['path']); ?>"
								>
									<a href="<?php echo esc_url($info['path']); ?>">
										<?php echo esc_html($info['path']); ?>
									</a>
									<a class="wds-sitemap-action wds-sitemap-ignore" href="#ignore"><?php esc_html_e('Ignore', 'wds'); ?></a>
									<a class="wds-sitemap-action wds-sitemap-add" href="#add"><?php esc_html_e('Add to sitemap', 'wds'); ?></a>
								</li>
							<?php } ?>
							</ul>
						</div>
					<?php } ?>
					</div>
				</div>
			<?php } ?>

			<?php if ($report->has_ignored_issues()) { ?>
				<p class="wds-crawl-result wds-action-purge_ignored">
					<a href="#purge-ignores">
						<?php echo esc_html(sprintf(
							_n('Purge %d ignored issue', 'Purge %d ignored issues', $report->get_ignored_issues_count(), 'wds'),
							$report->get_ignored_issues_count()
						)); ?>
					</a>
				</p>
			<?php } ?>

			</div>
		</div><!-- end box-content -->

		<div class="box-footer buttons bordered-top">
			<a href="#run-seo-analysis-modal" rel="dialog" class="button button-cta-alt"><?php esc_html_e( 'Run SEO analysis', 'wds' ); ?></a>
		</div>

	<?php } ?>

</section><!-- end box-dashboard-run-seo-anaysis -->
<?php } ?>

<?php do_action('wds-template-seo_service-box-full-after'); ?>