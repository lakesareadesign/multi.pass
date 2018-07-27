<?php
/**
 * Sidebar Functions
 *
 * This file controls the various sidebar displays on the site
 *
 * @category     Jessica
 * @package      Admin
 * @author       9seeds
 * @copyright    Copyright (c) 2018, 9seeds
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0.0
 *
 */

// Conditionally unregister sidebar(s)
if ( ( is_admin() && wsm_is_widgets_page() ) || ( !is_admin() ) ) {
    unregister_sidebar( 'sidebar' );
}

function wsm_is_widgets_page() {
    return in_array( $GLOBALS['pagenow'], array( 'widgets.php', ) );
}

// Replace Sidebar With Custom Sidebar
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );



add_action( 'get_header', 'wsm_child_sidebars_init', 15 );
/**
 * Remove sidebars
 */
function wsm_child_sidebars_init() {
	remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
	remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
	remove_action( 'genesis_sidebar', 'ss_do_sidebar' );
	remove_action( 'genesis_sidebar_alt', 'ss_do_sidebar_alt' );
	remove_action( 'genesis_sidebar', 'gencwooc_ss_do_sidebar' );
	remove_action( 'genesis_sidebar_alt', 'gencwooc_ss_do_sidebar_alt' );
	add_action( 'genesis_sidebar', 'jessica_child_do_sidebar' );
}

/**
 * Checks to see if simple sidebar exists
 *
 * @return string/boolean String of sidebar key OR false if none found
 */
function wsm_child_has_ss_sidebar( $sidebar_key = '_ss_sidebar' ) {

	if ( is_singular() && $sidebar_key = genesis_get_custom_field( $sidebar_key ) ) {
		return $sidebar_key;
	}

	if ( is_tax() || is_category() || is_tag() ) {

		if ( $sidebar_key = get_term_meta( get_queried_object()->term_id, $sidebar_key, true ) ) {
			return $sidebar_key;
		}
	}

	return false;
}


/**
 * Custom Jessica Sidebar for each sidebar
 */
function jessica_child_do_sidebar() {

	if ( $id = wsm_child_has_ss_sidebar() ) {

		if ( dynamic_sidebar( $id ) ) { /* do nothing */ }
	}

	elseif ( class_exists( 'Woocommerce' ) ) {

			if( is_shop() || is_product_category() || is_product_tag() ) {
				genesis_widget_area( 'store-sidebar');
			}

			elseif( is_archive() || is_single() || is_category() || is_page_template( 'page_blog.php' ) ) {
				genesis_widget_area( 'blog-sidebar');
			}

			else genesis_widget_area( 'page-sidebar');

	}

	elseif ( class_exists( 'IT_Exchange' ) ) {

			if( it_exchange_is_page() || is_tax( 'it_exchange_category') || is_tax()  ) {
				genesis_widget_area( 'store-sidebar');
			}

			elseif( is_archive() || is_single() || is_category() || is_page_template( 'page_blog.php' ) ) {
				genesis_widget_area( 'blog-sidebar');
			}

			else genesis_widget_area( 'page-sidebar');

	}

	elseif ( class_exists( 'WP_eCommerce' ) ) {

			if( wpsc_is_in_category() || wpsc_is_product() || wpsc_is_single_product()  || is_page( 'products-page') || is_tax() ) {
				genesis_widget_area( 'store-sidebar');
			}

			elseif( is_front_page() || is_home() || is_archive() || is_single() || is_category() || is_page_template( 'page_blog.php' ) ) {
				genesis_widget_area( 'blog-sidebar');
			}


			else genesis_widget_area( 'page-sidebar');
	}

	else {

		if( is_archive() || is_single() || is_category() || is_page_template( 'page_blog.php' ) ) {
			genesis_widget_area( 'blog-sidebar');
		}

		else genesis_widget_area( 'page-sidebar');
	}
}