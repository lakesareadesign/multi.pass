<!--
<img src="<?php echo WDS_PLUGIN_URL; ?>/images/title-meta-example.png" alt="<?php esc_html_e('','wds'); ?>" class="wphb-image wphb-image-standalone ">
-->
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