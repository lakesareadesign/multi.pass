<?php

class UM_WooCommerce_Core {

	function __construct() {

	}

	/***
	***	@
	***/
	function edit_address( $address ){

		global $woocommerce;

		// Current user
		global $current_user;
		get_currentuserinfo();

		$load_address = $address;
		$load_address = sanitize_key( $load_address );

		$address = WC()->countries->get_address_fields( get_user_meta( get_current_user_id(), $load_address . '_country', true ), $load_address . '_' );

		// Enqueue scripts
		wp_enqueue_script( 'wc-country-select' );
		wp_enqueue_script( 'wc-address-i18n' );

		// Prepare values
		foreach ( $address as $key => $field ) {

			$value = get_user_meta( get_current_user_id(), $key, true );

			if ( ! $value ) {
				switch( $key ) {
					case 'billing_email' :
					case 'shipping_email' :
						$value = $current_user->user_email;
					break;
					case 'billing_country' :
					case 'shipping_country' :
						$value = WC()->countries->get_base_country();
					break;
					case 'billing_state' :
					case 'shipping_state' :
						$value = WC()->countries->get_base_state();
					break;
				}
			}

			$address[ $key ]['value'] = apply_filters( 'woocommerce_my_account_edit_address_field_value', $value, $key, $load_address );
		}


		?>

		<h3><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></h3>

		<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

		<?php foreach ( $address as $key => $field ) : ?>

			<?php
				$field['return'] = true;
				$field = woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] );

				if(in_array($key, array('billing_first_name', 'billing_last_name', 'billing_email'))) {
					$field = str_replace('<input', '<input disabled', $field);
				}

				echo $field;
			?>

		<?php endforeach; ?>

		<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

		<p>
			<input type="submit" class="button" name="save_address" value="<?php _e( 'Save Address', 'woocommerce' ); ?>" />
		</p>

		<?php

	}

}
