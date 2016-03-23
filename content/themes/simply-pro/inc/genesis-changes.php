<?php
/**
 * BloomBlogShop
 *
 * @package      BloomBlogShop
 * @since        1.0.0
 * @copyright    Copyright (c) 2015
 * @license      GPL-2.0+
 */

/**
 * Theme Supports
 *
 */

add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery' ) );
add_theme_support( 'genesis-responsive-viewport' );
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

/**
 * Header
 *
 */

remove_action( 'genesis_site_description', 'genesis_seo_site_description' );


/**
 * Menus
 *
 */

add_theme_support ( 'genesis-menus' , array ( 
	'primary' 	=> __( 'Primary Navigation Menu', 'genesis' ),
) );

// Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );


/**
 * Page Layouts
 *
 */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

/**
 * Posts
 *
 */

add_filter( 'genesis_edit_post_link', '__return_false' );

function jt_post_info_filter($post_info) {
	if ( !is_page() ) {
		$post_info = '[post_date]';
		return $post_info;
	}
}
add_filter( 'genesis_post_info', 'jt_post_info_filter' );

function jt_post_meta_filter($post_meta) {
	$post_meta = '[post_comments] &middot; [post_categories before=""]';
	return $post_meta;
}
add_filter( 'genesis_post_meta', 'jt_post_meta_filter' );

// Modify the Genesis content limit read more link
function jt_read_more_link() {
	return '. . . <div class="cf"><a class="button entry-meta" href="' . get_permalink() . '">Read the Post</a></div>';
}
add_filter( 'get_the_content_more_link', 'jt_read_more_link' );

// Customize the next page link
function jt_next_page_link ( $text ) {
    return 'Older Posts <i class="dashicons dashicons-arrow-right"></i>';
}
add_filter ( 'genesis_next_link_text' , 'jt_next_page_link' );

// Customize the previous page link
function jt_previous_page_link ( $text ) {
    return '<i class="dashicons dashicons-arrow-left"></i> Newer Posts';
}
add_filter ( 'genesis_prev_link_text' , 'jt_previous_page_link' );


/**
 * Sidebars
 *
 */

unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'header-right' );


/**
 * Widgets
 *
 */
add_theme_support( 'genesis-footer-widgets', 1 );
