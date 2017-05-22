<?php
/**
 * Slush Pro.
 *
 * This file integrates Bootstrap classes to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

add_filter( 'genesis_attr_site-header', 'zzp_site_header_id', 10, 2 );
/**
 *  Adds bootstrap class to .site-header.
 */
function zzp_site_header_id( $attributes, $context ) {

	$attributes['id'] = 'header' ;
	return  $attributes;

}

add_filter( 'genesis_attr_site-header', 'zzp_site_header_class', 10, 2 );
/**
 * Adds bootstrap class to .nav-primary.
 */
function zzp_site_header_class( $attributes, $context ) {

	$attributes['class'] = 'site-header navbar navbar-default fixed_header ';
	return  $attributes;

}

add_filter( 'genesis_attr_nav-primary', 'zzp_nav_primary_class', 10, 2 );
/**
 * Adds bootstrap class to .nav-primary.
 */
function zzp_nav_primary_class( $attributes, $context ) {

	$attributes['class'] = 'nav-primary';
	return $attributes;

}

add_filter( 'genesis_attr_nav-secondary', 'zzp_nav_secondary_class', 10, 2 );
/**
 * Adds bootstrap class to .secondary-primary.
 */
function zzp_nav_secondary_class( $attributes, $context ) {

	$attributes['class'] = 'nav-secondary';
	return $attributes;

}

add_filter( 'genesis_attr_content', 'zzp_content', 10, 2 );
/**
 * Adds id class to .content.
 */
function zzp_content( $attributes, $context ) {

	if ( is_home() || is_archive() || is_page_template( 'page-blog.php' ) ) {
		$attributes['id'] = 'content_scrolling' ;
	}
	return  $attributes;

}

add_filter( 'genesis_attr_site-footer', 'zzp_site_footer_class', 10, 2 );
/**
 * Adds bootstrap class to .site-footer.
 */
function zzp_site_footer_class( $attributes, $context ) {

	$attributes['class'] = 'site-footer bottom-menu';
	$attributes['id'] = 'zp-footer';
	return $attributes;

}

add_filter( 'genesis_attr_title-area', 'zzp_title_area_class', 10, 2 );
/**
 * Adds bootstrap class to .title-area.
 */
function zzp_title_area_class( $attributes, $context ) {

	$attributes['class'] = 'title-area';
	return $attributes;

}

add_filter( 'genesis_attr_header-widget-area', 'zzp_header_widget_area_class', 10, 2 );
/**
 * Adds bootstrap class to .header-widget-area.
 */
function zzp_header_widget_area_class( $attributes, $context ) {

	$attributes['class'] = 'header-widget-area col-md-8 col-sm-8';
	return $attributes;

}

add_action( 'genesis_header', 'zzp_header_markup_open', 6 );
/**
 * Creates additional <div> 'container' and 'row' on site header.
 */
function zzp_header_markup_open() {

	echo '<div class="container">';

}

add_action( 'genesis_header', 'zzp_header_markup_close', 14 );
/**
 * Closes additional <div> 'container' and 'row' on site header.
 */
function zzp_header_markup_close() {

	echo '</div>';

}

add_action( 'genesis_before_content', 'zzp_site_inner_markup_open' );
/**
 * Creates additional <div> 'container' and 'row' on site inner.
 */
function zzp_site_inner_markup_open() {
	if ( ! is_page_template( 'home_template.php' ) && ! is_tax( 'portfolio_category' ) && ! is_post_type_archive( 'portfolio' ) )
		echo '<div class="container"><div class="row">';
}

add_action( 'genesis_after_content', 'zzp_site_inner_markup_close' , 50);
/**
 * Closes additional <div> 'container' and 'row' on site inner.
 */
function zzp_site_inner_markup_close() {
	if ( ! is_page_template( 'home_template.php' ) && ! is_tax( 'portfolio_category' ) && ! is_post_type_archive( 'portfolio' ) )
		echo '</div></div>';
}

add_action( 'genesis_footer', 'zzp_footer_markup_open', 6 );
/**
 * Creates additional <div> 'container' and 'row' on site footer.
 */
function zzp_footer_markup_open() {
	echo '<div class="container"><div class="row">';
}

add_action( 'genesis_footer', 'zzp_footer_markup_close', 14 );
/**
 * Closes additional <div> 'container' and 'row' on site footer.
 */
function zzp_footer_markup_close() {
	echo '</div></div>'; 
}

add_filter( 'wp_nav_menu_args' , 'zp_custom_primary_nav' );
/**
 * Adds Classes to Genesis Primary nav.
 */
function zp_custom_primary_nav( $args ) {

	if ( $args['theme_location'] == 'primary' ) {
		$args['walker'] = new ZP_Custom_Genesis_Nav_Menu;
		$args['desc_depth'] = 0;
		$args['thumbnail'] = false;
	}
	return $args;
	
}

/**
 * Menu Walker Class.
 */
class ZP_Custom_Genesis_Nav_Menu extends Walker_Nav_Menu {

	function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

	global $wp_query;

	$attributes='';

	$class_names = $value = '';

	$classes = empty( $item->classes ) ? array() : (array) $item->classes;

	$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
	$class_names = ' class="' . esc_attr( $class_names ) . ' dropdown"';

	$output .= '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

	$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
	
	// Checks if the link is a section or an http link.
	$check_link = strpos( $item->url, 'http' );
	if ( $check_link === false ) {
		$dropdown_class = 'class="dropdown-toggle" data-toggle="dropdown"';
		$external_class = '';
	} else {
		$dropdown_class = '';
		$external_class = '';
	}

	$item_output = $args->before;

	// Outputs menu link.
	$item_output .= '<a class="' . $external_class . '" ' . $attributes . '  ' . $dropdown_class . ' >';
	$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

	// Closes menu link anchor.
	$item_output .= '</a>';
	$item_output .= $args->after;

	$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );

	}
}

add_filter( 'genesis_do_nav', 'zp_filter_genesis_nav', 10, 3 );
/**
 * Filters Primary Nav.
 */
function zp_filter_genesis_nav( $nav_output , $nav, $args ) {
	
	if ( ! genesis_nav_menu_supported( 'primary' ) )
	return;

	// If menu is assigned to theme location, outputs.
	if ( has_nav_menu( 'primary' ) ) {

		$class = 'menu genesis-nav-menu menu-primary nav navbar-nav';
		if ( genesis_superfish_enabled() )
			$class .= ' js-superfish';

		$args = array(
			'container'      => '',
			'echo'           => 0,
			'menu_class'     => $class,
			'theme_location' => 'primary',
		);

		$nav = wp_nav_menu( $args );

		// Does nothing if there is nothing to show.
		if ( ! $nav )
			return;

		$nav_markup_open = genesis_markup( array(
			'context' => 'nav-primary',
			'echo'    => false,
			'html5'   => '<nav %s>',
			'xhtml'   => '<div id="nav">',
		) );
		$nav_markup_open .= genesis_structural_wrap( 'menu-primary', 'open', 0 );

		$nav_markup_close = genesis_structural_wrap( 'menu-primary', 'close', 0 );
		$nav_markup_close .= genesis_html5() ? '</nav>' : '</div>';

		$nav_output = $nav_markup_open . $nav . $nav_markup_close;

	 }
	 return $nav_output;

}

add_filter( 'genesis_do_subnav', 'zp_filter_genesis_subnav', 10, 3 );
/**
 * Filters Secondary Nav.
 */
function zp_filter_genesis_subnav( $nav_output , $nav, $args ) {
	
	if ( ! genesis_nav_menu_supported( 'secondary' ) )
	return;

	// If menu is assigned to theme location, outputs.
	if ( has_nav_menu( 'secondary' ) ) {

		$class = 'menu genesis-nav-menu menu-secondary nav navbar-nav';
		if ( genesis_superfish_enabled() )
			$class .= ' js-superfish';

		$args = array(
			'container'      => '',
			'echo'           => 0,
			'menu_class'     => $class,
			'theme_location' => 'secondary',
		);

		$subnav = wp_nav_menu( $args );

		// Does nothing if there is nothing to show.
		if ( ! $subnav )
			return;

		$subnav_markup_open = genesis_markup( array(
			'context' => 'nav-secondary',
			'echo'    => false,
			'html5'   => '<nav %s>',
			'xhtml'   => '<div id="subnav">',
		) );
		$subnav_markup_open .= genesis_structural_wrap( 'menu-secondary', 'open', 0 );

		$subnav_markup_close = genesis_structural_wrap( 'menu-secondary', 'close', 0 );
		$subnav_markup_close .= genesis_html5() ? '</nav>' : '</div>';

		$subnav_output = $subnav_markup_open . $subnav . $subnav_markup_close;

	}
	return $subnav_output;

}
