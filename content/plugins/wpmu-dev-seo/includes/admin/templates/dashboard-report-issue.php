<div class="wds-service-issue wds-seo_service-issue wds-seo_service-issue-<?php echo esc_attr($type); ?>">
	<p>
		<strong><?php echo (int)count($issues); ?></strong>
		<?php echo esc_html($msg); ?>
		<button type="button" class="wds-fix button button-white"><?php esc_html_e('Fix', 'wds'); ?></button>
	</p>

	<?php if (!empty($issues)) { ?>
		<div class="wds-issue-items">
			<header>
				<div class="wds-issue-item-part wds-issue-occurences">
					Occurences
				</div>
				<div class="wds-issue-item-part wds-issue-path">
					URL
				</div>
			</header>
		<?php foreach ($issues as $issue) { ?>
			<?php $issue_id = md5(serialize($issue)); ?>
			<div class="wds-issue-item">

				<!-- Occurences list modal for this URL -->
				<dialog class="dev-overlay wds-modal wds-occurences" id="wds-issue-occurences-<?php echo esc_attr($issue_id); ?>" title="<?php echo esc_attr($issue['path']); ?>">
					<div class="box-content">
						<div class="wds-issue-occurences-list">
						<ul class="wds-listing wds-path-occurences">
							<li class="wds-listing-label"><?php esc_html_e('Link Location', 'wds'); ?></li>
							<?php if (!empty($issue['origin'])) foreach ($issue['origin'] as $origin) { ?>
								<li>
									<?php
										$origin = is_array($origin) && !empty($origin[0]) ? $origin[0] : $origin;
									?>
									<a href="<?php echo is_string($origin) ? esc_url($origin) : esc_url($origin[0]); ?>">
										<?php echo is_string($origin) ? esc_html($origin) : esc_html($origin[0]); ?>
									</a>
								</li>
							<?php } ?>
							</ul>
						</div>
					</div>

				</dialog>

				<!-- Redirection modal for this URL -->
				<dialog class="dev-overlay wds-modal wds-redirect" id="wds-issue-redirect-<?php echo esc_attr($issue_id); ?>" title="<?php echo esc_attr($issue['path']); ?>">
					<div class="box-content modal">
						<p class="group wds-group">
							<label for="" class="wds-label"><?php esc_html_e('Enter re-direct URL', 'wds'); ?></label>
							<input type="url" name="redirect" value="<?php echo (
									!empty($redirections[$issue['path']])
										? esc_url($redirections[$issue['path']])
										: ''
								); ?>" class="wds-field">
						</p>
					</div>

					<div class="box-footer buttons modal">
						<input type="hidden" name="source" value="<?php echo esc_url($issue['path']); ?>" />
						<?php wp_nonce_field('wds-redirect', 'wds-redirect'); ?>
						<button type="button" class="button button-cta-alt wds-submit-redirect"><?php echo esc_html_e('Save', 'wds'); ?></button>
					</div>

				</dialog>

				<!-- Occurences count part -->
				<div class="wds-issue-item-part wds-issue-occurences">
					<span><?php echo count($issue['origin']); ?></span>
				</div>

				<!-- Issue URL part -->
				<div class="wds-issue-item-part wds-issue-path">
					<a href="<?php echo esc_url($issue['path']); ?>">
						<?php echo esc_html($issue['path']); ?>
						<?php if (in_array($issue['path'], array_keys($redirections))) { ?>
							[redirected]
						<?php } ?>
					</a>
				</div>

				<!-- Actions list dropdown -->
				<div class="wds-issue-item-part wds-issue-actions">
					<a href="#actions">
						&hellip;
					</a>
					<div class="wds-issue-actions-options">
						<ul>
							<li class="heading">Options <i class="wdv-icon wdv-icon-fw wdv-icon-remove"></i></li>
							<li><a href="#list"><i class="wds-icon wds-icon-inline wds-icon-inline-left wds-icon-list"></i> List occurences</a></li>
							<li><a href="#redirect"><i class="wds-icon wds-icon-inline wds-icon-inline-left wds-icon-redirect"></i> Re-direct</a></li>
						</ul>
					</div>
				</div>

			</div> <!-- .wds-issue-item -->
		<?php } ?>
		</div> <!-- .wds-issue-items -->
	<?php } ?>

</div>