<?php
	$wds_options = WDS_Settings::get_options();
	$link = !isset($link) ? home_url() : $link;
	$title = !isset($title) ? wds_replace_vars($wds_options['title-home']) : $title;
	$description = !isset($description) ? wds_replace_vars($wds_options['metadesc-home']) : $description;
?>
<div class="wds-preview-container">
	<div class="wds-preview">
		<div class="wds-preview-title">
			<h3>
				<a href="<?php echo esc_url($link); ?>">
					<?php echo esc_html($title); ?>
				</a>
			</h3>
		</div>
		<div class="wds-preview-url">
			<a href="<?php echo esc_url($link); ?>">
				<?php echo esc_url($link); ?>
			</a>
		</div>
		<div class="wds-preview-meta">
			<?php echo esc_html($description); ?>
		</div>
	</div>
	<p class="wds-preview-description"><?php _e('A preview of how your title and meta will appear in Google Search.', 'wds'); ?></p>
</div>