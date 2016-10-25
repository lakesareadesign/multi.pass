<?php
/**
 * Global
 *
 */

//* Add HTML5 support
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add responsive viewport tag
add_theme_support( 'genesis-responsive-viewport' );

//* Add .wrap class to...
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer'
) );

//* Add accessibility support
add_theme_support( 'genesis-accessibility', array(
	'404-page',
	'drop-down-menu',
	'headings',
	'search-form',
	'skip-links'
) );

//* Add screen reader class to archive description
add_filter( 'genesis_attr_author-archive-description', 'genesis_attributes_screen_reader_class' );


/**
 * Header
 *
 */

//* Remove site tagline
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );


/**
 * Navigation
 *
 */

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav', 5 );

remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_subnav' );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Remove navigation meta box
add_action( 'genesis_theme_settings_metaboxes', 'bbs_remove_genesis_metaboxes' );
function bbs_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}


/**
 * Widgets
 *
 */

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for shortcodes in widget areas
add_filter('widget_text', 'do_shortcode');

//* Remove header right widget area
unregister_sidebar( 'header-right' );

//* Remove content/sidebar/sidebar layout
genesis_unregister_layout( 'content-sidebar-sidebar' );

//* Remove sidebar/sidebar/content layout
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Remove sidebar/content/sidebar layout
genesis_unregister_layout( 'sidebar-content-sidebar' );


/**
 * Blog
 *
 */

//Removes Title and Description on Blog Archive
remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );

//Removes Title and Description on Blog Template Page
remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );

//* Reposition post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 4 );

//* Customize entry meta in the entry header
add_filter( 'genesis_post_info', 'bbs_entry_meta_header' );
function bbs_entry_meta_header( $post_info ) {

	$post_info = '[post_date] [post_comments before=""]';

	return $post_info;

}

//* Customize the post meta function
add_filter( 'genesis_post_meta', 'bbs_post_meta_filter' );
function bbs_post_meta_filter($post_meta) {

	if ( !is_page() ) {

		$post_meta = '[post_categories before=""]';

		return $post_meta;

	}

}

//* Customize the content limit more markup
add_filter( 'get_the_content_limit', 'bbs_content_limit_read_more_markup', 10, 3 );
function bbs_content_limit_read_more_markup( $output, $content, $link ) {

	$output = sprintf( '<p>%s &#x02026;</p><p>%s</p>', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;

}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'bbs_read_more_link', 8 );
function bbs_read_more_link() {

    return '<a class="more-link button arrow-right" href="' . get_permalink() . '">Read More</a>';

}

//* Customize author box title
add_filter( 'genesis_author_box_title', 'bbs_author_box_title' );
function bbs_author_box_title() {

	return '<span itemprop="name">' . get_the_author() . '</span>';

}

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'bbs_author_box_gravatar' );
function bbs_author_box_gravatar( $size ) {

	return 160;

}

//* Remove entry meta in the entry footer on category pages
add_action( 'genesis_before_entry', 'bbs_remove_entry_footer' );
function bbs_remove_entry_footer() {

	if ( is_front_page() || is_archive() || is_search() || is_home() || is_page_template( 'page_blog.php' ) ) {

		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

	}

}

//* Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

//* Customize the next page link
add_filter ( 'genesis_next_link_text' , 'bbs_next_page_link' );
function bbs_next_page_link ( $text ) {

    return 'Older Posts <i class="dashicons dashicons-arrow-right"></i>';

}

//* Customize the previous page link
add_filter ( 'genesis_prev_link_text' , 'bbs_previous_page_link' );
function bbs_previous_page_link ( $text ) {

    return '<i class="dashicons dashicons-arrow-left"></i> Newer Posts';

}
