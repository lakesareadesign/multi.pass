<?php
	$source = empty( $source ) ? '' : $source;
	$destination = empty( $destination ) ? '' : $destination;
	$index = empty( $index ) ? 0 : $index;
	$maybe_permanent_selected = empty( $maybe_permanent_selected ) ? '' : $maybe_permanent_selected;
	$maybe_temporary_selected = empty( $maybe_temporary_selected ) ? '' : $maybe_temporary_selected;

	$string_permanent = empty( $string_permanent ) ? '' : $string_permanent;
	$string_temporary = empty( $string_temporary ) ? '' : $string_temporary;
	$string_options = empty( $string_options ) ? '' : $string_options;
	$string_remove = empty( $string_remove ) ? '' : $string_remove;

	$option_name = empty( $_view['option_name'] ) ? '' : $_view['option_name'];
?>

<tr data-index="<?php echo $index; ?>">
	<td>
		<input type="checkbox"
			   autocomplete="off"
			   class="wds-checkbox"
			   name="<?php echo $option_name; ?>[bulk][]"
			   value="<?php echo $index; ?>" title=""/>
	</td>

	<td>
		<div class="wds-redirection_item-source">
			<input type="text"
				   class="wds-field"
				   placeholder="<?php esc_html_e( 'E.g. /cats', 'wds' ); ?>"
				   value="<?php echo $source; ?>"
				   name="<?php echo $option_name; ?>[urls][<?php echo $index; ?>][source]"
				   title=""/>
		</div>
	</td>

	<td>
		<div class="wds-redirection_item-destination">
			<input id="<?php echo $option_name; ?>"
				   name="<?php echo $option_name; ?>[urls][<?php echo $index; ?>][destination]"
				   type="text"
				   placeholder="<?php esc_html_e( 'E.g. /cats-new', 'wds' ); ?>"
				   class="wds-field"
				   value="<?php echo $destination; ?>"
				   title=""/>
		</div>
	</td>

	<td>
		<div class="wds-redirection_item-type select-container select-container-no-style">
			<select title=""
					style="width: 100%;"
					name="<?php echo $option_name; ?>[urls][<?php echo $index; ?>][type]">
				<option <?php echo $maybe_permanent_selected; ?> value="301"><?php echo $string_permanent; ?></option>
				<option <?php echo $maybe_temporary_selected; ?> value="302"><?php echo $string_temporary; ?></option>
			</select>
		</div>
	</td>

	<td>
		<?php
			$this->_render('links-dropdown', array(
				'label' => $string_options,
				'links' => array(
					'#remove' => $string_remove,
				),
			));
		?>
	</td>
</tr>