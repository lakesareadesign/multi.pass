<?php

	/***
	***	@hook before woocommerce update address
	***/
	add_action('template_redirect', 'um_woocommerce_pre_update', 1 );
	function um_woocommerce_pre_update() {
		global $wp, $ultimatemember;

		if ( isset( $_POST['save_address'] ) && get_query_var('um_tab') == 'shipping' ) {
			$wp->query_vars['edit-address'] = 'shipping';
		}

		if ( isset( $_POST['save_address'] ) && get_query_var('um_tab') == 'billing' ) {
			$wp->query_vars['edit-address'] = 'billing';
		}

		if ( wc_has_notice( __( 'Address changed successfully.', 'woocommerce' ) ) ) {
			wc_clear_notices();
			$url = $ultimatemember->account->tab_link( 'billing' );
			exit( wp_redirect( add_query_arg('updated','edit-billing', $url ) ) );
		}

	}

	/***
	***	@hook in account update
	***/
	add_action('um_post_account_update', 'um_woocommerce_account_update', 1 );
	function um_woocommerce_account_update() {
		global $wp;

		if ( isset( $_POST['save_address'] ) && get_query_var('um_tab') == 'shipping' ) {
			exit( wp_redirect( add_query_arg('updated','edit-shipping') ) );
		}

		if ( isset( $_POST['save_address'] ) && get_query_var('um_tab') == 'billing' ) {
			exit( wp_redirect( add_query_arg('updated','edit-billing') ) );
		}

	}

	// update billing email when the user's email address is changed
	add_action('um_update_profile_full_name', 'um_sync_update_user_wc_email');
	function um_sync_update_user_wc_email($changes) {
		global $ultimatemember;

		if(isset($changes['user_email'])) {
			update_user_meta($ultimatemember->user->id, 'billing_email', $changes['user_email']);
		}

		if(isset($changes['first_name'])) {
			update_user_meta($ultimatemember->user->id, 'billing_first_name', $changes['first_name']);
		}

		if(isset($changes['last_name'])) {
			update_user_meta($ultimatemember->user->id, 'billing_last_name', $changes['last_name']);
		}
	}

	// update um profile when wc billing is updated
	add_action( 'woocommerce_checkout_update_user_meta', 'um_update_um_profile_from_wc_billing', 10, 2 );
	add_action( 'woocommerce_customer_save_address', 'um_update_um_profile_from_wc_billing', 10, 2 );
	function um_update_um_profile_from_wc_billing($user_id, $data = null) {
		global $ultimatemember;

		if( isset( $_POST['save_address'] ) && isset( $_POST[ 'billing_first_name'] ) && isset( $_POST['billing_last_name'] ) && isset( $_POST[ 'billing_email' ] ) ) {
			$changes = array();
			foreach($_POST as $key => $value) {
				if(preg_match('/^billing_/', $key)) {
					$key           = str_replace('billing_', '', $key);

					if (in_array($key, array('first_name', 'last_name', 'user_email'))) {
						$changes[$key] = $value;

						update_user_meta( $user_id, $key, $value );
					}
				}
			}

			// update email
			$args = array('ID' => $user_id, 'user_email' => $_POST['billing_email']);
			wp_update_user($args);

			// hook for name changes
			do_action('um_update_profile_full_name', $changes);

			$ultimatemember->user->remove_cache($user_id);
		}
	}

