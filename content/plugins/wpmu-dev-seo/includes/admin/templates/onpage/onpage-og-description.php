<?php
$value = !empty($_view['options']["og-description-{$for_type}"])
	? $_view['options']["og-description-{$for_type}"]
	: (!empty($_view['options']["metadesc-{$for_type}"]) ? $_view['options']["metadesc-{$for_type}"] : '')
;
?>
<div class="wds-table-fields wds-table-fields-stacked">
	<div class="label">
		<label for="og-description-<?php echo esc_attr($for_type); ?>" class="wds-label">
			<?php esc_html_e('Description' , 'wds'); ?>
		</label>
	</div>
	<div class="fields wds-allow-macros">
		<textarea
			id='og-description-<?php echo esc_attr($for_type); ?>'
			name='<?php echo esc_attr($_view['option_name']); ?>[og-description-<?php echo esc_attr($for_type); ?>]'
			size='' type='text' class='wds-field'
		><?php echo esc_textarea($value); ?></textarea>
	</div>
</div>
