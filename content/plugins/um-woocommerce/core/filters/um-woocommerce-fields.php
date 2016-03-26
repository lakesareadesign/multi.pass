<?php

	/***
	***	@extend core fields
	***/
	add_filter("um_predefined_fields_hook", 'um_woocommerce_add_field', 100 );
	function um_woocommerce_add_field($fields){

		$fields['woo_total_spent'] = array(
				'title' => __('Total Spent','um-woocommerce'),
				'metakey' => 'woo_total_spent',
				'type' => 'text',
				'label' => __('Total Spent','um-woocommerce'),
				'icon' => 'um-faicon-credit-card',
				'edit_forbidden' => 1,
				'show_anyway' => true,
				'custom' => true,
		);

		$fields['woo_order_count'] = array(
				'title' => __('Total Orders','um-woocommerce'),
				'metakey' => 'woo_order_count',
				'type' => 'text',
				'label' => __('Total Orders','um-woocommerce'),
				'icon' => 'um-faicon-shopping-cart',
				'edit_forbidden' => 1,
				'show_anyway' => true,
				'custom' => true,
		);
		
		return $fields;
		
	}
	
	/***
	***	@show total orders
	***/
	add_filter('um_profile_field_filter_hook__woo_order_count', 'um_profile_field_filter_hook__woo_order_count', 99, 2);
	function um_profile_field_filter_hook__woo_order_count( $value, $data ) {
		global $um_online;
		$output = '';
		global $wpdb;
		$user_id = um_profile_id();
		$count = $wpdb->get_var( "SELECT COUNT(*)
			FROM $wpdb->posts as posts 
			LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id 
			WHERE   meta.meta_key       = '_customer_user' 
			AND     posts.post_type     IN ('" . implode( "','", wc_get_order_types( 'order-count' ) ) . "') 
			AND     posts.post_status   IN ('" . implode( "','", array('wc-completed') )  . "') 
			AND     meta_value          = $user_id" );
		
		$count = absint($count);
		if ( $count == 1 ) {
			$output = sprintf(__('%s order','um-woocommerce'), ($count) );
		} else {
			$output = sprintf(__('%s orders','um-woocommerce'), ($count) );
		}
		
		return $output;
	}
	
	/***
	***	@show total spent
	***/
	add_filter('um_profile_field_filter_hook__woo_total_spent', 'um_profile_field_filter_hook__woo_total_spent', 99, 2);
	function um_profile_field_filter_hook__woo_total_spent( $value, $data ) {
		global $um_online;
		$output = '';
		
		$output = get_woocommerce_currency_symbol() . number_format( wc_get_customer_total_spent( um_profile_id() ) );
		
		return $output;
	}