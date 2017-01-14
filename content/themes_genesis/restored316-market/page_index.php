<?php
/**
 * This file adds the Category Index to the Market Theme.
 *
 * @package      Market
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 05/03/2016
 * @license      GPL-2.0+
 */
 
/*
Template Name: Category Index
*/

add_action( 'genesis_meta', 'market_category_genesis_meta' );
/**
 * Add widget support for category index. If no widgets active, display the default loop.
 *
 */
function market_category_genesis_meta() {

	if ( is_active_sidebar( 'category-index' )) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'market_category_sections' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

	}
	
}

function market_category_sections() {

	genesis_widget_area( 'category-index', array(
		'before' => '<div class="category-index widget-area">',
		'after'  => '</div>',
	) );
	
}

genesis();