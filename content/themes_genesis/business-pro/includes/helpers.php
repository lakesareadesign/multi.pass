<?php
/**
 * Business Pro.
 *
 * This file contains theme-specific functions for the Business Pro theme.
 *
 * @package      Business Pro
 * @link         https://seothemes.com/business-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'gts', 'business_wrap_open', 3 );
/**
 * Custom opening wrapper div.
 *
 * @since  1.0.0
 *
 * @return void
 */
function business_wrap_open() {

	echo '<div class="wrap">';

}

add_action( 'gts', 'business_wrap_close', 13 );
/**
 * Custom closing wrapper div.
 *
 * @since  1.0.0
 *
 * @return void
 */
function business_wrap_close() {

	echo '</div>';

}

add_filter( 'genesis_attr_site-header', 'business_fixed_header' );
/**
 * Enable fixed header if theme supports it.
 *
 * @since  1.0.0
 *
 * @param  array $attr Site header attr.
 * @return array
 */
function business_fixed_header( $attr ) {

	if ( current_theme_supports( 'fixed-header' ) ) {
		$attr['class'] .= ' fixed';
	}

	return $attr;

}

add_filter( 'theme_page_templates', 'business_remove_templates' );
/**
 * Remove Page Templates.
 *
 * The Genesis Blog & Archive templates are not needed and can
 * create problems for users so it's safe to remove them. If
 * you need to use these templates, simply remove this function.
 *
 * @since  1.0.0
 *
 * @param  array $page_templates All page templates.
 * @return array Modified templates.
 */
function business_remove_templates( $page_templates ) {

	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );

	return $page_templates;

}

add_action( 'genesis_admin_before_metaboxes', 'business_remove_metaboxes' );
/**
 * Remove blog metabox.
 *
 * Also remove the Genesis blog settings metabox from the
 * Genesis admin settings screen as it is no longer required
 * if the Blog page template has been removed.
 *
 * @since  1.0.0
 *
 * @param  string $hook The metabox hook.
 * @return void
 */
function business_remove_metaboxes( $hook ) {

	remove_meta_box( 'genesis-theme-settings-blogpage', $hook, 'main' );

}

add_filter( 'template_include', 'business_blog_template', 99 );
/**
 * Custom blog template path.
 *
 * The following function adds a custom template path for the home
 * and archive template. This short circuits the WordPress template
 * hierarchy and allows us to reuse the masonry template.
 *
 * @since  1.0.0
 *
 * @param  string $template The template path.
 * @return string
 */
function business_blog_template( $template ) {

	if ( is_home() || is_search() || is_archive() && ! is_post_type_archive() && ! is_tax() ) {
		return get_stylesheet_directory() . '/templates/page-masonry.php';
	}

	return $template;

}

remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_post_content', 'genesis_do_post_image' );
add_action( 'genesis_entry_header', 'business_featured_image', 1 );
/**
 * Display featured image before post content.
 *
 * Custom featured image function to do some checks before
 * outputting the featured image. It will return early if we're not
 * on a post, page or portfolio item or if the post doesn't have a
 * featured image set or if the featured image option set in
 * Genesis > Theme Settings is not checked.
 *
 * @since  1.0.0
 *
 * @return array Featured image size.
 */
function business_featured_image() {

	if ( class_exists( 'WooCommerce' ) && is_shop() || ! is_home() && ! is_archive() || is_post_type_archive() ) {
		return;
	}

	if ( ! has_post_thumbnail() ) {
		return;
	}

	$genesis_settings = get_option( 'genesis-settings' );

	if ( 1 !== $genesis_settings['content_archive_thumbnail'] ) {
		return;
	}

	$link = is_singular() ? wp_get_attachment_url( get_post_thumbnail_id() ) : get_permalink();

	echo '<a href="' . esc_url( $link ) . '" class="featured-image">' . genesis_get_image() . '</a>';

}

add_filter( 'excerpt_more', 'business_read_more' );
add_filter( 'the_content_more_link', 'business_read_more' );
add_filter( 'get_the_content_more_link', 'business_read_more' );
/**
 * Accessible read more link.
 *
 * The below code modifies the default read more link when
 * using the WordPress More Tag to break a post on your site.
 * Instead of seeing 'Read more', screen readers will instead
 * see 'Read more about (entry title)'.
 *
 * @since  1.0.0
 *
 * @return string
 */
function business_read_more() {

	return sprintf( '&hellip; <a href="%s" class="more-link">%s</a>',
		get_the_permalink(),
		genesis_a11y_more_link( __( 'Read more', 'business-pro' ) )
	);

}

add_action( 'genesis_after_content_sidebar_wrap', 'business_prev_next_post_nav_cpt', 99 );
/**
 * Enable prev/next links in portfolio.
 *
 * @since  1.0.0
 *
 * @return void
 */
function business_prev_next_post_nav_cpt() {

	if ( ! is_singular( 'portfolio' ) && ! is_singular( 'product' ) ) {
		return;
	}

	genesis_markup( array(
		'html5'   => '<div %s><div class="wrap">',
		'xhtml'   => '<div class="navigation">',
		'context' => 'adjacent-entry-pagination',
	) );

		echo '<div class="pagination-previous alignleft">';
			previous_post_link();
		echo '</div>';
		echo '<div class="pagination-next alignright">';
			next_post_link();
		echo '</div>';

	echo '</div></div>';

}

add_action( 'wp_head', 'business_simple_social_icons_css' );
/**
 * Simple Social Icons fix.
 *
 * This is a workaround to allow multiple instances of Simple
 * Social Icons to be displayed on a single page. Currently,
 * the plugin only outputs a single style which is applied to
 * every widget instance. This function outputs different CSS
 * for every widget instance based on the ID.
 *
 * @since  1.0.0
 *
 * @link http://genesisdeveloper.me/simple-social-icons-color-style-saver-scripts/
 */
function business_simple_social_icons_css() {

	// Check if plugin is active.
	if ( ! class_exists( 'Simple_Social_Icons_Widget' ) ) {
		return;
	}

	$object = new Simple_Social_Icons_Widget();

	// Get widget settings.
	$all_instances = $object->get_settings();

	// Loop through each instance.
	foreach ( $all_instances as $key => $options ) {

		$instance = wp_parse_args( $all_instances[ $key ] );

		$font_size = round( (int) $instance['size'] / 2 );
		$icon_padding = round( (int) $font_size / 2 );

		// Build the CSS.
		$css = '#' .
		$object->id_base . '-' . $key . ' ul li a,
		#' . $object->id_base . '-' . $key . ' ul li a:hover {
		background-color: ' . $instance['background_color'] . ';
		border-radius: ' . $instance['border_radius'] . 'px;
		color: ' . $instance['icon_color'] . ';
		border: ' . $instance['border_width'] . 'px ' . $instance['border_color'] . ' solid;
		font-size: ' . $font_size . 'px;
		padding: ' . $icon_padding . 'px;
		}

		#' . $object->id_base . '-' . $key . ' ul li a:hover {
		background-color: ' . $instance['background_color_hover'] . ';
		border-color: ' . $instance['border_color_hover'] . ';
		color: ' . $instance['icon_color_hover'] . ';
		}';

		// Minify and output inline CSS (Safe WPCS).
		echo '<style type="text/css" media="screen">' . business_minify_css( $css ) . '</style>';

	}

}

add_action( 'wp_head', 'business_remove_widget_action', 1 );
/**
 * Remove Simple Social Icons inline CSS.
 *
 * Since we are adding our own inline styles with the function
 * above, we also need to remove the default inline styles output
 * by the plugin.
 *
 * @since  1.0.0
 *
 * @return void
 */
function business_remove_widget_action() {

	// Check if plugin is active.
	if ( ! class_exists( 'Simple_Social_Icons_Widget' ) ) {
		return;
	}

	global $wp_widget_factory;

	remove_action( 'wp_head', array( $wp_widget_factory->widgets['Simple_Social_Icons_Widget'], 'css' ) );

}

add_action( 'genesis_before', 'business_remove_sidebars' );
/**
 * Force full-width-layout for custom layout.
 *
 * @since  1.0.0
 *
 * @return void
 */
function business_remove_sidebars() {

	$site_layout = genesis_site_layout();

	if ( 'centered-content' !== $site_layout ) {
		return;
	}

	add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

}

add_filter( 'display_posts_shortcode_post_class', 'business_dps_column_classes', 10, 4 );
/**
 * Column Classes
 *
 * Columns Extension for Display Posts Shortcode plugin makes it
 * easy for users to display posts in columns using
 * [display-posts columns="2"]
 *
 * @since  1.0.0
 *
 * @author Bill Erickson <bill@billerickson.net>
 * @link   http://www.billerickson.net/shortcode-to-display-posts/
 * @param  array  $classes Current CSS classes.
 * @param  object $post    The post object.
 * @param  object $listing The WP Query object for the listing.
 * @param  array  $atts    Original shortcode attributes.
 * @return array  $classes Modified CSS classes.
 */
function business_dps_column_classes( $classes, $post, $listing, $atts ) {

	if ( ! isset( $atts['columns'] ) ) {
		return $classes;
	}

	$columns = intval( $atts['columns'] );

	if ( $columns < 2 || $columns > 6 ) {
		return $classes;
	}

	$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );

	$classes[] = $column_classes[ $columns ];

	if ( 0 == $listing->current_post % $columns ) {
		$classes[] = 'first';
	}

	return $classes;

}

/**
 * Check if post content is empty.
 *
 * This function takes the string you pass into it, strips out all HTML
 * tags, then removes any non-breaking space entities, and then trims
 * all whitespace. If there’s nothing but that stuff, then it becomes
 * an empty string. If there’s any “real” content, the string won’t be
 * empty. Then it just compares whatever it has left against an actual
 * empty string, and returns the boolean result.
 *
 * @since  1.0.0
 *
 * @link   http://blog.room34.com/archives/5360
 * @param  string $str String to check.
 * @return string
 */
function is_empty_content( $str ) {

	return trim( str_replace( '&nbsp;', '', strip_tags( $str ) ) ) == '';

}

/**
 * Sanitize RGBA values.
 *
 * If string does not start with 'rgba', then treat as hex then
 * sanitize the hex color and finally convert hex to rgba.
 *
 * @since  1.0.0
 *
 * @param  string $color The rgba color to sanitize.
 * @return string $color Sanitized value.
 */
function sanitize_rgba_color( $color ) {

	// Return invisible if empty.
	if ( empty( $color ) || is_array( $color ) ) {
		return 'rgba(0,0,0,0)';
	}

	// Return sanitized hex if not rgba value.
	if ( false === strpos( $color, 'rgba' ) ) {
		return sanitize_hex_color( $color );
	}

	// Finally, sanitize and return rgba.
	$color = str_replace( ' ', '', $color );
	sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

	return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';

}

/**
 * Minify CSS helper function.
 *
 * A handy CSS minification script by Gary Jones that we'll use to
 * minify the CSS output by the customizer. This is called near the
 * end of the /includes/customizer-output.php file.
 *
 * @since  1.0.0
 *
 * @author Gary Jones
 * @link   https://github.com/GaryJones/Simple-PHP-CSS-Minification
 * @param  string $css The CSS to minify.
 * @return string Minified CSS.
 */
function business_minify_css( $css ) {

	// Normalize whitespace.
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove spaces before and after comment.
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

	// Remove comment blocks, everything between /* and */, unless preserved with /*! ... */ or /** ... */.
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

	// Remove ; before }.
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ >.
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	// Remove space before , ; { } ( ) >.
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px).
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0).
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Converts all zeros value into short-hand.
	$css = preg_replace( '/0 0 0 0/', '0', $css );

	// Shorten 6-character hex color codes to 3-character where possible.
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );

}

/**
 * Custom header image callback.
 *
 * Loads custom header or featured image depending on what is set.
 * If a featured image is set it will override the header image.
 *
 * @since 2.0.0
 *
 * @return void
 */
function business_custom_header() {

	$id = '';

	// Get the current page ID.
	if ( class_exists( 'WooCommerce' ) && is_shop() ) {

		$id = get_option( 'woocommerce_shop_page_id' );

	} elseif ( is_home() ) {

		$id = get_option( 'page_for_posts' );

	} elseif ( is_singular() ) {

		$id = get_the_id();

	}

	$url = get_the_post_thumbnail_url( $id );

	if ( ! $url ) {

		$url = get_header_image();

	}

	return sprintf( 'style="background-image: url(%s)"', esc_url( $url ) );

}

add_action( 'genesis_after_header', 'business_page_header_open', 20 );
/**
 * Page header opening markup.
 *
 * @since 1.0.0
 *
 * @return void
 */
function business_page_header_open() {

	echo '<section class="page-header" role="banner" ' . business_custom_header() . '><div class="wrap">';

}

add_action( 'genesis_after_header', 'business_page_header_close', 28 );
/**
 * Page header closing markup.
 *
 * @since 1.0.0
 *
 * @return void
 */
function business_page_header_close() {

	echo '</div></section>';

}

add_action( 'genesis_after_header', 'business_page_header_title', 24 );
/**
 * Display title in page header.
 *
 * @since 1.0.0
 *
 * @return void
 */
function business_page_header_title() {

	// Add post titles back inside posts loop.
	if ( is_home() || is_archive() || is_category() || is_tag() || is_tax() || is_search() || is_page_template( 'page_blog.php' ) ) {

		add_action( 'genesis_entry_header', 'genesis_do_post_title', 2 );

	}

	if ( class_exists( 'WooCommerce' ) && is_shop() ) {

		printf( '<h1 itemprop="headline">%s</h1>', get_the_title( get_option( 'woocommerce_shop_page_id' ) ) );

	} elseif ( 'posts' === get_option( 'show_on_front' ) && is_home() ) {

		printf( '<h1 itemprop="headline">%s</h1>', esc_html( apply_filters( 'business_latest_posts_title', __( 'Latest Posts', 'business-pro' ) ) ) );

	} elseif ( is_404() ) {

		printf( '<h1 itemprop="headline">%s</h1>', esc_html( apply_filters( 'genesis_404_entry_title', __( 'Not found, error 404', 'business-pro' ) ) ) );

	} elseif ( is_search() ) {

		printf( '<h1 itemprop="headline">%s %s</h1></div>', apply_filters( 'genesis_search_title_text', __( 'Search Results for:', 'business-pro' ) ), get_search_query() );

	} elseif ( is_single() || is_singular() ) {

		the_title( apply_filters( 'business_hero_title_markup', '<h1 itemprop="headline">' ), '</h1>', true );

		if ( has_excerpt() ) {

			printf( '<p itemprop="description">%s</p>', esc_html( strip_tags( get_the_excerpt() ) ) );

		}
	}

}
