<?php
/**
 * Hello Pro.
 *
 * This file loads theme setup used in the Hello Pro Theme.
 *
 * @package Hello Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

 // Add HTML5 markup structure.
 add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

 // Add Accessibility support.
 add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

 // Add viewport meta tag for mobile browsers.
 add_theme_support( 'genesis-responsive-viewport' );

 // Let's use the search form from WordPress core instead.
 remove_filter( 'get_search_form', 'genesis_search_form' );

 // Sticky Nav - Add a body class for the sticky nav option selected
 add_filter( 'body_class', 'hellopro_stickynav_body_class' );
function hellopro_stickynav_body_class( $classes ) {
	 $fixed_header_off = get_theme_mod( 'fixed_header_off', false );
	 $classes[] = ($fixed_header_off ? '' : 'sticky-header');
	 return $classes;
}

// Add a body class if primary nav option selected
add_filter( 'body_class', 'hellopro_nav_body_class' );
function hellopro_nav_body_class( $classes ) {
	$classes[] = (has_nav_menu( 'primary' ) ? 'primary-nav' : '');
	return $classes;
}



 // * Theme Image Sizes
 add_image_size( 'featured', 300, 100, true );
 add_image_size( 'portfolio', 300, 175, true );

 // * Unregister layout settings
 genesis_unregister_layout( 'content-sidebar-sidebar' );
 genesis_unregister_layout( 'sidebar-content-sidebar' );
 genesis_unregister_layout( 'sidebar-sidebar-content' );

 // * Unregister secondary sidebar
 unregister_sidebar( 'sidebar-alt' );

 // * Relocate the post info
 remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
 add_action( 'genesis_entry_header', 'genesis_post_info', 5 );

 // * Add support for custom header
 add_theme_support( 'custom-header', array(
	 'width'           => 320,
	 'height'          => 110,
	 // 'header-selector' => '.site-title a',
	 'header-text'     => false,
	 'flex-width' => true,
	 'flex-height' => true,
 ) );

 // Remove custom Genesis custom header style
 remove_action( 'wp_head', 'genesis_custom_header_style' );

 add_filter( 'genesis_seo_title', 'custom_header_inline_logo', 10, 3 );
 /**
  * Add an image inline in the site title element for the logo
  *
  * @param string $title Current markup of title.
  * @param string $inside Markup inside the title.
  * @param string $wrap Wrapping element for the title.
  *
  * @author @_AlphaBlossom
  * @author @_neilgee
  * @author @_JiveDig
  * @author @_srikat
  */
 function custom_header_inline_logo( $title, $inside, $wrap ) {

	 if ( get_header_image() ) {
		 $logo = '<img  src="' . get_header_image() . '" width="' . esc_attr( get_custom_header()->width ) . '" height="' . esc_attr( get_custom_header()->height ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . ' Homepage">';
		} else {
			$logo = get_bloginfo( 'name' );
		}

		$inside = sprintf( '<a href="%s">%s<span class="screen-reader-text">%s</span></a>', trailingslashit( home_url() ), $logo, get_bloginfo( 'name' ) );

		// Determine which wrapping tags to use
		$wrap = genesis_is_root_page() && 'title' === genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : 'p';

		// A little fallback, in case an SEO plugin is active
		$wrap = genesis_is_root_page() && ! genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : $wrap;

		// And finally, $wrap in h1 if HTML5 & semantic headings enabled
		$wrap = genesis_html5() && genesis_get_seo_option( 'semantic_headings' ) ? 'h1' : $wrap;

		return sprintf( '<%1$s %2$s>%3$s</%1$s>', $wrap, genesis_attr( 'site-title' ), $inside );

	}

	add_filter( 'genesis_attr_site-description', 'custom_add_site_description_class' );
	/**
	 * Add class for screen readers to site description.
	 * This will keep the site description markup but will not have any visual presence on the page
	 * This runs if there is a logo image set in the Customizer.
	 *
	 * @param array $attributes Current attributes.
	 *
	 * @author @_neilgee
	 * @author @_srikat
	 */
	function custom_add_site_description_class( $attributes ) {
		if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
			$attributes['class'] .= ' screen-reader-text';
		}

		  return $attributes;
	}

	add_filter( 'get_custom_logo', 'output_custom_image_logo' );
	/**
	 * Filter the output of logo to add a custom class for the img element.
	 *
	 * @return string Custom logo markup.
	 */
	function output_custom_image_logo() {
		  $custom_logo_id = get_theme_mod( 'custom_logo' );
		  $html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
			  esc_url( home_url( '/' ) ),
			  wp_get_attachment_image( $custom_logo_id, 'full', false, array(
				  'class'    => 'custom-logo style-svg',
				  'itemprop' => 'logo',
			  ) )
		  );
		  return $html;
	}

	// * Reposition the secondary navigation menu
	remove_action( 'genesis_after_header', 'genesis_do_subnav' );
	add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

	// * Reduce the secondary navigation menu to one level depth
	add_filter( 'wp_nav_menu_args', 'hello_pro_secondary_menu_args' );
	function hello_pro_secondary_menu_args( $args ) {

		if ( 'secondary' != $args['theme_location'] ) {
			return $args;
		}

		  $args['depth'] = 1;
		  return $args;

	}


	/**
	 * Remove Genesis Page Templates
	 *
	 * @author Bill Erickson
	 * @link http://www.billerickson.net/remove-genesis-page-templates
	 *
	 * @param array $page_templates
	 * @return array
	 */
	function be_remove_genesis_page_templates( $page_templates ) {
		  unset( $page_templates['page_archive.php'] );
		  unset( $page_templates['page_blog.php'] );
		  return $page_templates;
	}
	add_filter( 'theme_page_templates', 'be_remove_genesis_page_templates' );


	// * Add support for 3-column footer widgets
	add_theme_support( 'genesis-footer-widgets', 3 );

	// * Add support for after entry widget
	add_theme_support( 'genesis-after-entry-widget-area' );

	// Enable shortcodes in text widgets
	add_filter( 'widget_text', 'do_shortcode' );
