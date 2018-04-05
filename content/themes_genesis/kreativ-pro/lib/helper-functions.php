<?php
/**
 * Kreativ Pro.
 *
 * This file defines helper functions used elsewhere in the Kreativ Pro Theme.
 *
 * @package Kreativ
 * @author  ThemeSquare
 * @license GPL-2.0+
 * @link    http://themesquare.com/themes/kreativ/
 */

/**
 * Get default accent color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.1.0
 *
 * @return string Hex color code for accent color.
 */
function kreativ_customizer_default_accent_color() {
	return '#ff6c3a';
}

/**
 * Get count of widgets in a specified Widget Area.
 *
 * @since 1.1.0
 *
 * @return integer Indicates the number of widgets.
 */
function kreativ_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

/**
 * Flexible widget class.
 *
 * @since 1.1.0
 *
 * @return string class name for flexible widgets.
 */
function kreativ_widget_area_class( $id ) {

	$count = kreativ_count_widgets( $id );
	$class = '';

	if ( $count == 1 ) {
		$class .= ' widget-full';
	} elseif ( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif ( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif ( $count % 2 == 0 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}

	return $class;

}
