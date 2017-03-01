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

	<?php if (!empty($result['issues']['messages']) && is_array($result['issues']['messages'])) { ?>
		<div class="result state-messages">
			<?php foreach ($result['issues']['messages'] as $message) { ?>
				<div class="wds-notice wds-notice-warning">
					<p><?php echo esc_html($message); ?></p>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>

	<?php if (empty($status['end'])) { ?>
		<?php $this->_render('dashboard-dialog-seo_service-run', array('status' => $status)); ?>
	<?php } else if (!empty($result)) { ?>
		<?php
		// --- SEO check is done, let's go for results ---
		?>
		<div class="box-content no-padding wds-seo_service-results-parent">
			<div class="wds-seo_service-results">

				<div class="wds-overview">
				<?php if (isset($result['total'])) { ?>
					<div class="wds-overview-item">
						<strong><?php echo (int)$result['total']; ?></strong>
						<span><?php esc_html_e('Total Discovered URLs', 'wds'); ?></span>
					</div>
				<?php } ?>
<?php
	// Legacy vs new service results normalization
	$discovered = isset($result['discovered'])
		? $result['discovered']
		: (isset($issues['discovered']) ? $issues['discovered'] : false)
	;
?>
				<?php if (false !== $discovered) { ?>
					<div class="wds-overview-item">
						<strong><?php echo (int)$discovered; ?></strong>
						<span><?php esc_html_e('Newly Discovered URLs', 'wds'); ?></span>
					</div>
				<?php } ?>
				<?php if (isset($issues['inaccessible'])) { ?>
					<div class="wds-overview-item">
						<strong><?php echo (int)count($issues['inaccessible']); ?></strong>
						<span><?php esc_html_e('Invisible URLs', 'wds'); ?></span>
					</div>
				<?php } ?>
<?php
	// Legacy vs new service results normalization
	$sitemap_total = isset($result['sitemap_total'])
		? $result['sitemap_total']
		: (isset($issues['sitemap_total']) ? $issues['sitemap_total'] : false)
	;
?>
				<?php if (false !== $sitemap_total) { ?>
					<div class="wds-overview-item">
						<strong><?php echo (int)$sitemap_total; ?></strong>
						<span><?php esc_html_e('URLs in the Sitemap', 'wds'); ?></span>
					</div>
				<?php } ?>
				</div>

<?php
	$issues_count = (int)(
		(!empty($issues['5xx']) ? count($issues['5xx']) : 0)
		+
		(!empty($issues['4xx']) ? count($issues['4xx']) : 0)
		+
		(!empty($issues['3xx']) ? count($issues['3xx']) : 0)
	);
?>
			<?php /* "Not processed" notice, displayed as warning, outside the main report */ ?>
			<?php if (!empty($issues['not_processed']) && is_array($issues['not_processed'])) { ?>
			<div class="result not-processed">
				<div class="wds-notice wds-notice-warning">
					<p><?php esc_html_e('Some parts of your site were too slow to respond and were not included in our crawl.', 'wds'); ?></p>
				</div>
			</div>
			<?php } ?>

			<?php if ($issues_count > 0) { ?>
				<div class="wds-breakdown">
					<h4><?php echo esc_html_e('We have found a few issues with URLs:', 'wds'); ?></h4>
					<?php
						if (!empty($issues['5xx'])) {
							$this->_render('dashboard-report-issue', array(
								'type' => '5xx',
								'msg' => __('URLs that result in server error (500 etc)', 'wds'),
								'issues' => $issues['5xx'],
								'redirections' => $redirections,
							));
						}
						if (!empty($issues['4xx'])) {
							$this->_render('dashboard-report-issue', array(
								'type' => '4xx',
								'msg' => __('URLs that result in soft error (404 etc)', 'wds'),
								'issues' => $issues['4xx'],
								'redirections' => $redirections,
							));
						}
						if (!empty($issues['3xx'])) {
							$this->_render('dashboard-report-issue', array(
								'type' => '5xx',
								'msg' => __('URLs that have multiple re-directs', 'wds'),
								'issues' => $issues['3xx'],
								'redirections' => $redirections,
							));
						}
					?>
				</div>
			<?php } else { // if issues count ?>
				<div class="wds-breakdown">
					<div class="wds-service-no_issue">
					<?php if (empty($result['issues']['messages'])) { ?>
						<div class="wds-crawl-result wds-crawl-success">
							<p><?php esc_html_e('Your latest crawl revealed no SEO issues, well done!', 'wds'); ?></p>
						</div>
					<?php } else if (!empty($result['issues']['messages'])) { ?>
						<p><?php
							esc_html_e('Please, have a look into the displayed messages and re-crawl your site.', 'wds');
						?></p>
					<?php } ?>
					</div>
				</div>
			<?php } // if issues count ?>

			<?php if (!empty($issues['sitemap'])) { ?>
				<div class="wds-sitemap">
					<div class="wds-seo_service-warning wds-seo_service-warning-sitemap">
						<p>
							<?php printf(__('%d URLs are not in the Sitemap', 'wds'), (is_array($issues['sitemap']) ? count($issues['sitemap']) : (int)$issues['sitemap'])); ?>
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
									<?php if (!empty($issues['sitemap']) && is_array($issues['sitemap'])) { ?>
										<a href="#toggle-sitemap-urls"><?php esc_html_e('Show', 'wds'); ?></a>
									<?php } ?>
								</i></small>
							</span>
						</p>
					<?php if (!empty($issues['sitemap']) && is_array($issues['sitemap'])) { ?>
						<div class="wds-sitemap-issues_list" style="display:none">
							<ul>
							<?php foreach ($issues['sitemap'] as $info) { ?>
								<?php if (empty($info['path'])) continue; ?>
								<li><a href="<?php echo esc_url($info['path']); ?>"><?php echo esc_html($info['path']); ?></a></li>
							<?php } ?>
							</ul>
						</div>
					<?php } ?>
					</div>
				</div>
			<?php } ?>

			</div>
		</div><!-- end box-content -->

		<div class="box-footer buttons bordered-top">
			<a href="#run-seo-analysis-modal" rel="dialog" class="button button-cta-alt"><?php esc_html_e( 'Run SEO analysis', 'wds' ); ?></a>
		</div>

	<?php } ?>

</section><!-- end box-dashboard-run-seo-anaysis -->
<?php } ?>