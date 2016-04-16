    <?php
    $settings = C_NextGen_Settings::get_instance();
    $currency = C_NextGen_Pro_Currencies::$currencies[$settings->ecommerce_currency];
    ?>
	<tbody id="manual_shipping_options">
	<tr>
		<td class="label_column">
			<label for="manual_domestic_shipping_method"><?php echo esc_html($i18n->domestic_shipping)?></label>
		</td>
		<td>
			<select id="manual_domestic_shipping_method" name="pricelist[manual_settings][domestic_shipping_method]">
				<?php foreach ($shipping_methods as $value => $label): ?>
					<option <?php selected($manual_settings['domestic_shipping_method'], $value) ?> value="<?php echo esc_attr($value) ?>"><?php echo esc_html($label)?></option>
				<?php endforeach ?>
			</select>
			<input type="text" class='shipping_rate price_field' name="pricelist[manual_settings][domestic_shipping_rate]" value="<?php echo esc_attr($manual_settings['domestic_shipping_rate'])?>"/>
		</td>
	</tr>
	<tr>
		<td class='label_column' colspan="2">
			<input
				type="checkbox"
				value="1"
				<?php checked($manual_settings['allow_global_shipments'], 1)?>
				name="pricelist[manual_settings][allow_global_shipments]"
				id="manual_allow_global_shipping"
				/>
			<label for="manual_allow_global_shipping">
				<?php echo esc_html($i18n->allow_global_shipping)?>
			</label>
		</td>
	</tr>
	<tr id="manual_global_shipping_options">
		<td>
			<label for="manual_global_shipping_method"><?php echo esc_html($i18n->global_shipping)?></label>
		</td>
		<td>
			<select id="manual_global_shipping_method" name="pricelist[manual_settings][global_shipping_method]">
				<?php foreach ($shipping_methods as $value => $label): ?>
					<option <?php selected($manual_settings['global_shipping_method'], $value) ?> value="<?php echo esc_attr($value) ?>"><?php echo esc_html($label)?></option>
				<?php endforeach ?>
			</select>
            <input type="text" class='shipping_rate price_field' name="pricelist[manual_settings][global_shipping_rate]" value="<?php echo esc_attr($manual_settings['global_shipping_rate'])?>"/>
		</td>
	</tr>
	</tbody>
</table>
<script type="ngg-template" id="manual_pricelist_item_template">
	<tr id="manual_pricelist_item_{id}" class='item manual_pricelist_item item_{id}'>
		<td>
			<input type='hidden' name='pricelist_item[{id}][source]' value='<?php echo esc_attr($item_source)?>'/>
			<input
                class="title_field"
				type="text"
				name="pricelist_item[{id}][title]"
				value=""
				placeholder="<?php echo esc_attr($i18n->item_title_placeholder)?>"
				/>
		</td>
		<td>
			<input
                class='price_field'
                type="text"
				name="pricelist_item[{id}][price]"
				value=""
				min="0.00"
				placeholder="0.00"
				/>
		</td>
		<td>
            <i class="fa fa-times-circle delete_item" data-id="{id}" data-table-id="manual_pricelist"></i>
		</td>
	</tr>
</script>
<br/>
<table>
<tbody id="manual_pricelist">
	<tr>
		<th class="title_column"><?php echo esc_html($i18n->name_header)?></th>
		<th class="price_column"><?php echo esc_html($i18n->price_header)?></th>
		<th class="delete_item_column"></th>
	</tr>
	<?php foreach ($items as $item): ?>
		<tr class='item manual_pricelist_item item_<?php echo esc_attr($item->ID)?>' id="manual_pricelist_item_<?php echo $item->ID ?>">
			<td>
				<input
					type="hidden"
					name="pricelist_item[<?php echo esc_attr($item->ID)?>][source]"
					value="<?php echo esc_attr($item->source)?>"
					/>
				<input
                    class="title_field"
					type="text"
					name="pricelist_item[<?php echo esc_attr($item->ID)?>][title]"
					value="<?php echo esc_attr($item->title)?>"
					placeholder="<?php echo esc_attr($i18n->item_title_placeholder)?>"
				/>
			</td>
			<td>
				<input
                    class="price_field"
                    type="text"
					step="any"
					name="pricelist_item[<?php echo esc_attr($item->ID)?>][price]"
					value="<?php echo esc_attr(sprintf("%.{$currency['exponent']}f", $item->price))?>"
					min="0.00"
					placeholder="0.00"
				/>
			</td>
			<td>
                <i class="fa fa-times-circle delete_item" data-id="<?php echo esc_attr($item->ID)?>" data-table-id="manual_pricelist"></i>
			</td>
		</tr>
	<?php endforeach ?>
</tbody>
<tfoot>
	<tr>
		<td colspan="3"><p class="no_items hidden"><?php echo esc_html($i18n->no_items)?></p></td>
	</tr>
	<tr>
		<td colspan="3">
			<input
				type="button"
				class="new_item"
				data-table-id="manual_pricelist"
				data-template-id="manual_pricelist_item_template"
				value="<?php echo esc_attr($i18n->add_another_item)?>"
			/>
		</td>
	</tr>
</tfoot>
