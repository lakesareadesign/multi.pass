<?php
/**
 * Global template modifications.
 *
 * @package    BrunchPro\Functions\Template
 * @subpackage Genesis
 * @author     Robert Neu
 * @copyright  Copyright (c) 2016, Shay Bocks
 * @license    GPL-2.0+
 * @link       http://www.shaybocks.com/brunch-pro/
 * @since      1.0.0
 */

defined( 'ABSPATH' ) || exit;

remove_action( 'genesis_after_header', 'genesis_do_nav' );

add_filter( 'body_class',                'brunch_pro_add_body_class' );
add_filter( 'genesis_post_info',         'brunch_pro_post_info_filter' );
add_filter( 'excerpt_more',              'brunch_pro_get_ellipsis' );
add_filter( 'the_excerpt',               'brunch_pro_excerpt_read_more_link' );
add_filter( 'get_the_content_more_link', 'brunch_pro_content_read_more_link' );
add_filter( 'the_content_more_link',     'brunch_pro_content_read_more_link' );
add_filter( 'genesis_footer_creds_text', 'brunch_pro_footer_creds_text' );

add_action( 'genesis_before',        'brunch_pro_before_header' );
add_action( 'genesis_before_header', 'genesis_do_nav' );
add_action( 'genesis_before_entry',  'brunch_pro_maybe_move_post_info', 0 );
add_action( 'genesis_after_loop',    'brunch_pro_maybe_disable_sidebars' );

/**
 * Add the theme name class to the body element.
 *
 * @since  1.0.0
 * @param  string $classes The existing body classes.
 * @return string $$classes Modified body classes.
 */
function brunch_pro_add_body_class( $classes ) {
	$classes[] = 'brunch-pro';
	return $classes;
}

/**
 * Load an ad section before .site-inner.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_before_header() {
	genesis_widget_area( 'before-header', array(
		'before' => '<div id="before-header" class="before-header">',
		'after'  => '</div> <!-- end .before-header -->',
	) );
}

/**
 * Relocate the post info if we're not on a blog archive.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_maybe_move_post_info() {
	if ( is_singular() ) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		add_action( 'genesis_before_entry',  'genesis_post_info', 12 );
	}
}

/**
 * Disable the sidebars on custom layouts where they're not needed.
 *
 * @since  1.0.0
 * @access public
 * @uses   genesis_site_layout() Return the site layout for different contexts.
 * @return void
 */
function brunch_pro_maybe_disable_sidebars() {
	$layout = genesis_site_layout();
	if ( in_array( $layout, array( 'full-width-slim', 'alt-sidebar-content' ) ) ) {
		remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
	}
	if ( 'full-width-slim' === $layout ) {
		remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
	}
}

/**
 * Modify the Genesis post info.
 *
 * @since  1.0.0
 * @access public
 * @return string Modified post info text.
 */
function brunch_pro_post_info_filter() {
	return '[post_date] [post_edit]';
}

/**
 * Return a "Read More" link wrapped in paragraph tags.
 *
 * @since  1.0.0
 * @access public
 * @return string Read more text.
 */
function brunch_pro_get_read_more_link() {
	return sprintf( '<p><a class="more-link" href="%s">%s</a></p>',
		get_permalink(),
		apply_filters( 'brunch_pro_read_more_text', __( 'Read More', 'brunch-pro' ) )
	);
}

/**
 * Return an ellipsis to be used when truncating excerpts.
 *
 * @since  1.0.0
 * @access public
 * @return string an ellipsis.
 */
function brunch_pro_get_ellipsis() {
	return '...';
}

/**
 * Modify the Genesis and WordPress content read more link.
 *
 * @since  1.0.0
 * @access public
 * @return string Modified read more text.
 */
function brunch_pro_content_read_more_link() {
	return sprintf( '...</p>%s',
		brunch_pro_get_read_more_link()
	);
}

/**
 * Modify the WordPress excerpt by forcing a read more link to be appended.
 *
 * @since  1.0.0
 * @access public
 * @param  string $output the default excerpt output.
 * @return string $output Modified excerpt with a read more link added.
 */
function brunch_pro_excerpt_read_more_link( $output ) {
	return $output . brunch_pro_get_read_more_link();
}

/**
 * Customize the footer text
 *
 * @since  1.0.0
 * @access public
 * @param  string $creds Default credits.
 * @return string Modified Shay Bocks credits.
 */
function brunch_pro_footer_creds_text( $creds ) {
	return sprintf( '[footer_copyright before="%s"] &middot; [footer_childtheme_link before=""] %s <a href="http://shaybocks.com/">%s</a>',
		__( 'Copyright', 'brunch-pro' ),
		__( 'by', 'brunch-pro' ),
		CHILD_THEME_DEVELOPER
	);
}
