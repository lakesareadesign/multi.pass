<?php
$images = !empty($_view['options']["og-images-{$for_type}"]) && is_array($_view['options']["og-images-{$for_type}"])
	? $_view['options']["og-images-{$for_type}"]
	: array()
;
?>
<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="og-images-<?php echo esc_attr($for_type); ?>" class="wds-label">
				<?php esc_html_e('OpenGraph Images' , 'wds'); ?>
			</label>
		</div>
		<div
			class="fields og-images og-images-<?php echo esc_attr($for_type); ?>"
			data-name='<?php echo esc_attr($_view['option_name']); ?>[og-images-<?php echo esc_attr($for_type); ?>]'
		>
			<div class="add-action-wrapper item">
				<a href="#add" title="<?php esc_attr_e('Add image', 'wds'); ?>">+</a>
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
</div>

<?php wp_enqueue_media(); ?>
<?php wp_enqueue_style('wds-admin-opengraph'); ?>