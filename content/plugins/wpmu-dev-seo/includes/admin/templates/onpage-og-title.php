<?php
$value = !empty($_view['options']["og-title-{$for_type}"])
	? $_view['options']["og-title-{$for_type}"]
	: (!empty($_view['options']["title-{$for_type}"]) ? $_view['options']["title-{$for_type}"] : '')
;
?>
<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="og-title-<?php echo esc_attr($for_type); ?>" class="wds-label">
				<?php esc_html_e('OpenGraph Title' , 'wds'); ?>
			</label>
		</div>
		<div class="fields wds-allow-macros">
			<input
				id='og-title-<?php echo esc_attr($for_type); ?>'
				name='<?php echo esc_attr($_view['option_name']); ?>[og-title-<?php echo esc_attr($for_type); ?>]'
				size='' type='text' class='wds-field'
				value='<?php echo esc_attr($value); ?>'
			/>
		</div>
	</div>
</div>
