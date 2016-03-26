<?php

	/***
	***	@When a specific product is bought
	***/
	add_action('woocommerce_order_status_completed', 'um_woocommerce_per_product_hook');
	function um_woocommerce_per_product_hook( $order_id ) {
		global $ultimatemember;
		$order = new WC_Order( $order_id );
		$user_id = (int)$order->user_id;
		$items = $order->get_items();

		// forcefully flush the cache
		$ultimatemember->user->remove_cache( $user_id );

		um_fetch_user( $user_id );
		$user_role = $ultimatemember->user->get_role();
		$excludes = um_get_option( 'woo_oncomplete_except_roles' );

		foreach ($items as $item) {
			$id = $item['product_id'];
			if ( get_post_meta( $id, '_um_woo_product_role', true ) != '' && !in_array( $user_role, $excludes ) ) {
				um_fetch_user( $user_id );
				$ultimatemember->user->set_role( esc_attr( get_post_meta( $id, '_um_woo_product_role', true ) ) );
			}
		}
		return $order_id;
	}

	/***
	***	@When any product is bought
	***/
	add_action( 'woocommerce_order_status_completed', 'um_woocommerce_sync_role_completed' );
	function um_woocommerce_sync_role_completed( $order_id ) {
		global $ultimatemember;

		$role = um_get_option( 'woo_oncomplete_role' );
		if ( !$role )
			return;

		$order = new WC_Order( $order_id );
		$user_id = (int)$order->user_id;
		um_fetch_user( $user_id );

		// forcefully flush the cache
		$ultimatemember->user->remove_cache( $user_id );

		// fetch role and excluded roles
		$user_role = $ultimatemember->user->get_role();
		$excludes = um_get_option( 'woo_oncomplete_except_roles' );

		if( !in_array( $user_role, $excludes ) )
		{
			$ultimatemember->user->set_role( $role );
		}

	}
