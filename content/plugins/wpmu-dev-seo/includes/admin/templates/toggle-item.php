<?php
	$inverted = empty($inverted) ? false : $inverted;
	$field_name = empty($field_name) ? '' : $field_name;
	$field_id = empty($field_id) ? $field_name : $field_id;
	$checked = empty($checked) ? '' : $checked;
	$item_label = empty($item_label) ? '' : $item_label;
	$item_value = empty($item_value) ? '1' : $item_value;
	$item_description = empty($item_description) ? '' : $item_description;
	$html_description = empty($html_description) ? '' : $html_description;
	$attributes = empty($attributes) ? array() : $attributes;

	$attr_string = '';
	foreach ($attributes as $attribute => $attribute_value) {
		$attr_string .= sprintf('%s="%s" ', $attribute, esc_attr($attribute_value));
	}
?>
<div class="wds-toggle-table">
	<span class="toggle wds-toggle <?php echo $inverted ? 'wds-inverted-toggle' : ''; ?>">
		<input
			type="checkbox"
			class="toggle-checkbox"
			value='<?php esc_attr_e($item_value); ?>'
			name="<?php esc_attr_e($field_name); ?>"
			id="<?php esc_attr_e($field_id); ?>"
			<?php echo $checked; ?>
			<?php echo $attr_string; ?>>
		<label
			class="toggle-label"
			for="<?php esc_attr_e($field_id); ?>">
		</label>
	</span>

	<div class="wds-toggle-description">
		<label
			for="<?php esc_attr_e($field_id); ?>"
			class="wds-label">
			<?php esc_html_e($item_label); ?>
		</label>

		<?php if ($item_description): ?>
			<p class="wds-label-description">
				<?php esc_html_e($item_description); ?>
			</p>
		<?php endif; ?>

		<?php if ($html_description): ?>
			<?php echo $html_description; ?>
		<?php endif; ?>
	</div>
</div>