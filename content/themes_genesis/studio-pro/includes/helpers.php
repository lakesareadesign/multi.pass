<?php
/**
 * Studio Pro.
 *
 * This file contains theme-specific functions for the Studio Pro theme.
 *
 * @package      Studio Pro
 * @link         https://seothemes.com/studio-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Custom blog template path.
 *
 * The following function adds a custom template path for the home
 * and archive template. This short circuits the WordPress template
 * hierarchy and allows us to reuse the masonry template.
 *
 * @param string $template The template path.
 */
function studio_blog_template( $template ) {
	if ( ! is_home() && ! is_archive() || is_post_type_archive() ) {
		return $template;
	}
	return get_stylesheet_directory() . '/templates/page-masonry.php';
}
add_filter( 'template_include', 'studio_blog_template', 99 );

/**
 * Remove Page Templates.
 *
 * The Genesis Blog & Archive templates are not needed and can
 * create problems for users so it's safe to remove them. If
 * you need to use these templates, simply remove this function.
 *
 * @param  array $page_templates All page templates.
 * @return array Modified templates.
 */
function studio_remove_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}

/**
 * Remove blog metabox.
 *
 * Also remove the Genesis blog settings metabox from the
 * Genesis admin settings screen as it is no longer required
 * if the Blog page template has been removed.
 *
 * @param string $hook The metabox hook.
 */
function studio_remove_metaboxes( $hook ) {
	remove_meta_box( 'genesis-theme-settings-blogpage', $hook, 'main' );
}

/**
 * Custom opening wrap.
 *
 * Used for entry-header, entry-content and entry-footer.
 * Genesis doesn't provide structural wraps for these elements
 * so we need to hook in and add the wrap div at the start.
 * This is a utility function that can be used anywhere to open
 * a wrap anywhere in your theme.
 */
function studio_wrap_open() {
	echo '<div class="wrap">';
}

/**
 * Custom closing wrap.
 *
 * The closing markup for the additional opening wrap divs,
 * simply closes the wrap divs that we created earlier. This
 * is a utility function that can be used anywhere to close
 * any kind of div, not just wraps.
 */
function studio_wrap_close() {
	echo '</div>';
}

/**
 * Clean the custom header markup for use in hero section.
 *
 * @return Cleaned custom header markup.
 */
function studio_custom_header_markup() {
	ob_start();
	the_custom_header_markup();
	return ob_get_clean();
}

/**
 * Add no-js class to body.
 *
 * Used for checking whether or not JavaScript is active so we can
 * style the navigation menus to suit the user. Also add an empty
 * `ontouchstart` attribute which emulates hover effects on mobile.
 *
 * @param  string $attr On touch start attribute.
 * @return string
 */
function studio_add_ontouchstart( $attr ) {
	$attr['class'] 		  .= ' no-js';
	$attr['ontouchstart']  = ' ';
	return $attr;
}

/**
 * Add schema microdata to title-area.
 *
 * @since  1.5.0
 * @param  array $args Array of arguments.
 * @return array $args Additional arguments.
 */
function studio_title_area( $args ) {
	$args['itemscope'] = 'itemscope';
	$args['itemtype']  = 'http://schema.org/Organization';
	return $args;
}

/**
 * Correct site-title schema microdata.
 *
 * @since  1.5.0
 * @param  array $args Array of arguments.
 * @return array $args New arguments.
 */
function studio_site_title( $args ) {
	$args['itemprop'] = 'name';
	return $args;
}

/**
 * Modify breadcrumb arguments.
 *
 * @param  array $args Original breadcrumb args.
 * @return array Cleaned breadcrumbs.
 */
function studio_breadcrumb_args( $args ) {
	$args['prefix']              = '<div class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList"><div class="wrap">';
	$args['suffix']              = '</div></div>';
	$args['labels']['prefix']    = '';
	$args['labels']['author']    = '';
	$args['labels']['category']  = '';
	$args['labels']['tag']       = '';
	$args['labels']['date']      = '';
	$args['labels']['tax']       = '';
	$args['labels']['post_type'] = '';
	return $args;
}

/**
 * Accessible read more link.
 *
 * The below code modifies the default read more link when
 * using the WordPress More Tag to break a post on your site.
 * Instead of seeing 'Read more', screen readers will instead
 * see 'Read more about (entry title)'.
 */
function studio_read_more() {
	return sprintf( '&hellip; <a href="%s" class="more-link">%s</a>',
		get_the_permalink(),
		genesis_a11y_more_link( __( 'Read more', 'studio-pro' ) )
	);
}

/**
 * Enable prev/next links in portfolio.
 */
function studio_prev_next_post_nav_cpt() {

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

/**
 * Display featured image before post content.
 *
 * Custom featured image function to do some checks before
 * outputting the featured image. It will return early if we're not
 * on a post, page or portfolio item or if the post doesn't have a
 * featured image set or if the featured image option set in
 * Genesis > Theme Settings is not checked.
 *
 * @since  2.1.1
 * @return array Featured image size.
 */
function studio_featured_image() {

	if ( ! is_singular( array( 'post', 'page', 'portfolio' ) ) ) {
		return;
	}

	if ( ! has_post_thumbnail() ) {
		return;
	}

	$genesis_settings = get_option( 'genesis-settings' );

	if ( 1 !== $genesis_settings['content_archive_thumbnail'] ) {
		return;
	}

	echo '<div class="featured-image">' . genesis_get_image() . '</div>';

}

/**
 * Change the footer text.
 *
 * @since  1.5.0
 * @param  string $creds Defaults.
 * @return string Custom footer credits.
 */
function studio_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] <a href="' . CHILD_THEME_URL . '">Studio Pro</a> by <img src="' . get_stylesheet_directory_uri() . '/assets/images/favicon.png" width="10"> <a href="https://seothemes.com" title="Seo Themes">Seo Themes</a>. Built on the Genesis Framework.';
	return $creds;
}

/**
 * Sanitize RGBA values.
 *
 * If string does not start with 'rgba', then treat as hex then
 * sanitize the hex color and finally convert hex to rgba.
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
 * @author Gary Jones
 * @link   https://github.com/GaryJones/Simple-PHP-CSS-Minification
 * @param  string $css The CSS to minify.
 * @return string Minified CSS.
 */
function studio_minify_css( $css ) {

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
 * Fix Simple Social Icons multiple instances.
 *
 * By default, Simple Social Icons only allows you to create one
 * style for your icons, even if you have multiple on one page.
 * This function allows us to output different styles for each
 * widget that is output on the front end.
 */
function studio_simple_social_icons_css() {

	if ( ! class_exists( 'Simple_Social_Icons_Widget' ) ) {
		return;
	}
	$obj = new Simple_Social_Icons_Widget();

	// Get widget settings.
	$all_instances = $obj->get_settings();

	// Loop through instances.
	foreach ( $all_instances as $key => $options ) :

		$instance = wp_parse_args( $all_instances[$key] );

		$font_size = round( (int) $instance['size'] / 2 );
		$icon_padding = round ( (int) $font_size / 2 );

		// CSS to output.
		$css = '#' . $obj->id_base . '-' . $key . ' ul li a,
		#' . $obj->id_base . '-' . $key . ' ul li a:hover {
		background-color: ' . $instance['background_color'] . ';
		border-radius: ' . $instance['border_radius'] . 'px;
		color: ' . $instance['icon_color'] . ';
		border: ' . $instance['border_width'] . 'px ' . $instance['border_color'] . ' solid;
		font-size: ' . $font_size . 'px;
		padding: ' . $icon_padding . 'px;
		}
		
		#' . $obj->id_base . '-' . $key . ' ul li a:hover {
		background-color: ' . $instance['background_color_hover'] . ';
		border-color: ' . $instance['border_color_hover'] . ';
		color: ' . $instance['icon_color_hover'] . ';
		}';

		// Minify.
		$css = studio_minify_css( $css );

		// Output.
		echo '<style type="text/css" media="screen">' . $css . '</style>';
	endforeach;
}

/**
 * Remove Simple Social Icons inline CSS.
 *
 * No longer needed because we are generating custom CSS instead,
 * removing this means that we don't need to use !important rules
 * in the above function.
 *
 * @return void
 */
function studio_remove_ssi_inline_styles() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['Simple_Social_Icons_Widget'], 'css') );
}
