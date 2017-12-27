<?php
$images = !empty($_view['options']["og-images-{$for_type}"]) && is_array($_view['options']["og-images-{$for_type}"])
	? $_view['options']["og-images-{$for_type}"]
	: array()
;
?>
<div class="wds-table-fields wds-table-fields-stacked">
	<div class="label">
		<label for="og-images-<?php echo esc_attr($for_type); ?>" class="wds-label">
			<?php esc_html_e('Default Featured Images' , 'wds'); ?>
		</label>
	</div>
	<div
		class="fields og-images og-images-<?php echo esc_attr($for_type); ?>"
		data-name='<?php echo esc_attr($_view['option_name']); ?>[og-images-<?php echo esc_attr($for_type); ?>]'
	>
		<div class="wds-has-tooltip add-action-wrapper item" data-content="<?php _e('Add featured image', 'wds'); ?>">
			<a href="#add" title="<?php esc_attr_e('Add image', 'wds'); ?>"><i class="wds-icon-plus"></i></a>
		</div>
	<?php foreach ($images as $value) { ?>
			<input
				name='<?php echo esc_attr($_view['option_name']); ?>[images-<?php echo esc_attr($for_type); ?>][]'
				type='text'
				value='<?php echo esc_attr($value); ?>'
			/>
	<?php } ?>
	</div>
</div>
<p class="wds-label-description"><?php _e("These images will be available to use if the post or page being shared doesn't contain any images.", 'wds'); ?></p>

<?php wp_enqueue_media(); ?>
<?php wp_enqueue_style('wds-admin-opengraph'); ?>