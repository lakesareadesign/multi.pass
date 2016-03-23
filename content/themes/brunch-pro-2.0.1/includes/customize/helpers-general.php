<?php
/**
 * Register Customizer settings.
 *
 * @package    BrunchPro\Functions\Customizer
 * @subpackage Genesis
 * @author     Robert Neu
 * @copyright  Copyright (c) 2016, Shay Bocks
 * @license    GPL-2.0+
 * @link       http://www.shaybocks.com/brunch-pro/
 * @since      1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add hover and focus states to an array of selectors.
 *
 * @since  1.0.0
 * @access public
 * @param  array $selectors an array of selectors.
 * @return array $output an array of selectors with hover states added.
 */
function brunch_pro_add_hover_states( $selectors ) {
	$output = array();
	foreach ( (array) $selectors as $selector ) {
		$output[] = "{$selector}:hover";
		$output[] = "{$selector}:focus";
	}
	return $output;
}

/**
 * Return a list of all button selectors used in the theme.
 *
 * @since  1.0.0
 * @access public
 * @return array $output an array of selectors.
 */
function brunch_pro_get_button_selectors() {
	return array(
		'.button',
		'.button-secondary',
		'button',
		'input[type="button"]',
		'input[type="reset"]',
		'input[type="submit"]',
		'.enews-widget input[type="submit"]',
		'.brunch-pro .simmer-icon-print',
		'.brunch-pro .simmer-icon-print a',
		'div.gform_wrapper .gform_footer input[type="submit"]',
		'a.more-link',
		'.more-from-category a',
	);
}
