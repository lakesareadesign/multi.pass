<?php

// Useful global constants
define( 'PW_SELECT2_URL', RH()->plugin_url() . '/includes/fields/custom/cmb2-select2/' );

/**
 * Enqueue scripts and styles, call requested select box field
 */
function pw_select2( $field, $meta ) {
	wp_enqueue_script( 'pw-select2-field-init', PW_SELECT2_URL . 'cmb2-select2-js.js', array( 'select2' ), null );
	wp_enqueue_style( 'pw-select2-field-mods', PW_SELECT2_URL . 'cmb2-select2-css.css', array(), null );

	call_user_func( $field->args( 'type' ), $field->args(), $meta );

	$desc = $field->args('desc');
	echo ( ! empty( $desc ) && ! empty( $meta ) ? '<p class="cmb2-metabox-description">' . $desc . '</p>' : '' );
}
add_filter( 'cmb2_render_pw_select', 'pw_select2', 10, 2 );
add_filter( 'cmb2_render_pw_multiselect', 'pw_select2', 10, 2 );

/**
 * Render select box field
 */
function pw_select( $field, $meta ) {
	echo '<select name="', $field['id'], '" id="', $field['id'], '" data-placeholder="' . $field['desc'] . '" class="select2">';
	if ( isset( $field['options'] ) && ! empty( $field['options'] ) ) {
		foreach ( $field['options'] as $option_key => $option ) {
			$opt_label = is_array( $option ) && array_key_exists( 'name', $option ) ? $option['name'] : $option;
			$opt_value = is_array( $option ) && array_key_exists( 'value', $option ) ? $option['value'] : $option_key;

			echo '<option value="', $opt_value, '" ', selected( $meta == $opt_value ) ,'>', $opt_label, '</option>';
		}
	}
	echo '</select>';
}

/**
 * Render multi-value select box field
 */
function pw_multiselect( $field, $meta ) {
	$options = array();

	if ( isset( $field['options'] ) && ! empty( $field['options'] ) ) {
		foreach ( $field['options'] as $option_key => $option ) {
			$opt_label = is_array( $option ) && array_key_exists( 'name', $option ) ? $option['name'] : $option;
			$opt_value = is_array( $option ) && array_key_exists( 'value', $option ) ? $option['value'] : $option_key;

			$options[] = array(
				'id' => $opt_value,
				'text' => $opt_label
			);
		}
	}

	wp_localize_script( 'pw-select2-field-init', $field['id'] . '_data', $options );

	if ( ! empty( $meta ) ) {
		$meta = implode( ',', $meta );
	}

	echo '<input type="hidden" name="' . $field['id'] . '" id="' . $field['id'] . '" data-placeholder="' . $field['desc'] . '" class="select2" value="' . $meta . '" />';
}

/**
 * Handle saving of single and multi-value select fields
 */
function pw_select2_sanitise( $meta_value, $field ) {
	if ( empty( $meta_value ) ) {
		$meta_value = '';
	} elseif ( 'pw_multiselect' == $field['type'] ) {
		$meta_value = explode( ',', $meta_value );
	}

	return $meta_value;
}