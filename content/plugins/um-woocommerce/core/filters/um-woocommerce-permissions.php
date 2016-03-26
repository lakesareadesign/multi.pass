<?php
	
	/***
	***	@filter user permissions
	***/
	add_filter('um_user_permissions_filter', 'um_woocommerce_user_permissions_filter', 10, 4);
	function um_woocommerce_user_permissions_filter( $meta, $user_id ){
		
		if ( !isset( $meta['woo_purchases_tab'] ) )
			$meta['woo_purchases_tab'] = 1;
		
		if ( !isset( $meta['woo_reviews_tab'] ) )
			$meta['woo_reviews_tab'] = 1;

		if ( !isset( $meta['woo_account_orders'] ) )
			$meta['woo_account_orders'] = 1;
		
		if ( !isset( $meta['woo_account_shipping'] ) )
			$meta['woo_account_shipping'] = 1;
		
		if ( !isset( $meta['woo_account_billing'] ) )
			$meta['woo_account_billing'] = 1;
		
		return $meta;
	}