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

add_filter( 'customizer_library_font_variants',    'brunch_pro_font_variants', 10, 3 );
add_filter( 'customizer_library_all_fonts',        'brunch_pro_get_google_fonts' );
add_filter( 'customizer_library_get_google_fonts', 'brunch_pro_get_google_fonts' );

/**
 * Filters the allowed Google Font variants for the Brunch Pro theme.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $chosen_variants The chosen variants.
 * @param  string $font The font to load variants for.
 * @param  array  $variants The variants for the font.
 * @return array $chosen_variants The chosen variants.
 */
function brunch_pro_font_variants( $chosen_variants, $font, $variants ) {
	$allowed = array(
		'200',
		'200italic',
		'300',
		'300italic',
		'regular',
		'italic',
		'600',
		'600italic',
		'700',
		'700italic',
		'900',
		'900italic',
	);

	foreach ( $allowed as $variant ) {
		if ( in_array( $variant, $variants ) ) {
			$chosen_variants[] = $variant;
		}
	}

	return array_unique( $chosen_variants );
}

/**
 * Filters the allowed Google Fonts for the Brunch Pro theme.
 *
 * @since  1.0.0
 * @access public
 * @param  array $fonts All Google Fonts.
 * @return array $fonts Selected Google Fonts.
 */
function brunch_pro_get_google_fonts( $fonts ) {
	$fonts = array(
		'Source Sans Pro' => array(
			'label'    => 'Source Sans Pro',
			'variants' => array(
				'200',
				'200italic',
				'300',
				'300italic',
				'regular',
				'italic',
				'600',
				'600italic',
				'700',
				'700italic',
				'900',
				'900italic',
			),
			'subsets' => array(
				'latin',
				'vietnamese',
				'latin-ext',
			),
		),
		'Abril Fatface' => array(
			'label'    => 'Abril Fatface',
			'variants' => array(
				'regular',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
		'Adamina' => array(
			'label'    => 'Adamina',
			'variants' => array(
				'regular',
			),
			'subsets' => array(
				'latin',
			),
		),
		'Droid Serif' => array(
			'label'    => 'Droid Serif',
			'variants' => array(
				'regular',
				'italic',
				'700',
				'700italic',
			),
			'subsets' => array(
				'latin',
			),
		),
		'Lato' => array(
			'label'    => 'Lato',
			'variants' => array(
				'100',
				'100italic',
				'300',
				'300italic',
				'regular',
				'italic',
				'700',
				'700italic',
				'900',
				'900italic',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
		'Libre Baskerville' => array(
			'label'    => 'Libre Baskerville',
			'variants' => array(
				'regular',
				'italic',
				'700',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
		'Oswald' => array(
			'label'    => 'Oswald',
			'variants' => array(
				'300',
				'regular',
				'700',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
		'PT Sans Narrow' => array(
			'label'    => 'PT Sans Narrow',
			'variants' => array(
				'regular',
				'700',
			),
			'subsets' => array(
				'latin',
				'cyrillic',
				'latin-ext',
				'cyrillic-ext',
			),
		),
		'PT Serif' => array(
			'label'    => 'PT Serif',
			'variants' => array(
				'regular',
				'italic',
				'700',
				'700italic',
			),
			'subsets' => array(
				'latin',
				'cyrillic',
				'latin-ext',
				'cyrillic-ext',
			),
		),
		'Playfair Display' => array(
			'label'    => 'Playfair Display',
			'variants' => array(
				'regular',
				'italic',
				'700',
				'700italic',
				'900',
				'900italic',
			),
			'subsets' => array(
				'latin',
				'cyrillic',
				'latin-ext',
			),
		),
		'Raleway' => array(
			'label'    => 'Raleway',
			'variants' => array(
				'100',
				'200',
				'300',
				'regular',
				'500',
				'600',
				'700',
				'800',
				'900',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
		'Roboto Slab' => array(
			'label'    => 'Roboto Slab',
			'variants' => array(
				'100',
				'300',
				'regular',
				'700',
			),
			'subsets' => array(
				'latin',
				'greek-ext',
				'cyrillic',
				'greek',
				'vietnamese',
				'latin-ext',
				'cyrillic-ext',
			),
		),
	);

	return (array) apply_filters( 'brunch_pro_get_google_fonts', $fonts );
}
