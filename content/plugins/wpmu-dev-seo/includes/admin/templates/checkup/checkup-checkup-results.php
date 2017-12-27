<?php
	$service = WDS_Service::get(WDS_Service::SERVICE_CHECKUP);
	$results = $service->result();
	$show_upsell_message = isset($show_upsell_message) ? $show_upsell_message : true;
?>

<?php if (!empty($results['error'])): ?>
	<!--
		We have encountered an error. So let's show that.
	-->
	<div class="wds-notice wds-notice-error">
		<p><?php echo esc_html($results['error']); ?></p>
	</div>
<?php endif; ?>

<?php if (!empty($results['items'])) { ?>
	<p><?php esc_html_e('Here’s your outstanding SEO issues. We recommend actioning as many as possible to ensure you’re as search engine and social media friendly as possible.', 'wds'); ?></p>
	<!--
		This is where we store the actual result items.
		Let's iterate through them.
	-->
	<div class="wds-accordion">
		<?php foreach ($results['items'] as $idx => $item): ?>
			<?php
				$item_id = "wds-checkup-item-{$idx}";
				$type_class = !empty($item['type'])
					? sanitize_html_class($item['type'])
					: '';
				$custom_class = !empty($item['class'])
					? sanitize_html_class($item['class'])
					: '';
				$style_class_map = array(
					'ok'       => 'wds-check-success',
					'info'     => 'wds-check-invalid',
					'warning'  => 'wds-check-warning',
					'critical' => 'wds-check-error'
				);
				$style_class = isset($style_class_map[ $item['type'] ]) ? $style_class_map[ $item['type'] ] : '';
				$details = !empty($item['tooltip']) ? $item['tooltip'] : '';
				$title = !empty($item['title']) ? $item['title'] : '';
				$body = !empty($item['body']) ? $item['body'] : '';
				$fix = !empty($item['fix']) ? $item['fix'] : '';
			?>
			<div class="wds-accordion-section wds-check-item <?php echo esc_attr($type_class); ?> <?php echo esc_attr($custom_class); ?> <?php echo esc_attr($style_class); ?>"
				 id="<?php echo esc_attr($item_id); ?>">
				<div class="wds-accordion-handle">
					<?php echo esc_html($title); ?>
				</div>
				<div class="wds-accordion-content">
					<?php if ($body || $fix): ?>
						<div class="wds-recommendation">
							<strong><?php esc_html_e('Recommendation', 'wds'); ?></strong>

							<?php echo $body; ?>
							<?php echo $fix; ?>
						</div>
					<?php endif; ?>

					<?php if ($details): ?>
						<div class="wds-more-info">
							<strong><?php esc_html_e('More Info', 'wds'); ?></strong>
							<p><?php echo esc_attr($details); ?></p>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php if (!$service->is_member() && $show_upsell_message) { ?>
		<?php
		$this->_render('mascot-message', array(
			'key'         => 'seo-checkup-upsell',
			'dismissible' => false,
			'message'     => sprintf(
				'%s <a href="#upgrade-to-pro">%s</a>',
				esc_html__('Grab the Pro version of SmartCrawl to unlock unlimited SEO Checkups plus automated scheduled reports to always stay on top of any issues.. These features are included in a WPMU DEV membership along with 100+ plugins &amp; themes, 24/7 support and lots of handy site management tools.', 'wds'),
				esc_html__('- Try it all FREE today', 'wds')
			)
		));
		?>
	<?php } ?>
<?php } ?>