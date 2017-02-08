<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Integrates this theme with the WooCommerce Catalog Visibility Options plugin
 * http://woocommerce.com/products/catalog-visibility-options/
 */
		
add_action( 'init', 'cvo_mystile_hide_cart_nav' );
function cvo_mystile_hide_cart_nav(){
	global $wc_cvo;

	if ( ( 'secured' == $wc_cvo->setting( 'wc_cvo_prices' ) && ! catalog_visibility_user_has_access() ) || 'disabled' == $wc_cvo->setting( 'wc_cvo_prices' ) ) { 
		remove_action( 'mystile_cart_nav', 'mystile_cart_nav', 10 );
	}
}
