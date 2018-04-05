<?php
/**
 * Register customizer defaults.
 *
 * @package   FoodiePro\Functions\Customizer
 * @copyright Copyright (c) 2018, Feast Design Co.
 * @license   GPL-2.0+
 * @since     3.0.0
 */

defined( 'WPINC' ) || die;

add_filter( 'feastco_customizer_font_variants', 'foodie_pro_font_variants', 10, 3 );
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
function foodie_pro_font_variants( $chosen_variants, $font, $variants ) {
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

add_filter( 'feastco_customizer_all_fonts', 'feastco_customizer_get_google_fonts' );
add_filter( 'feastco_customizer_get_google_fonts', 'foodie_pro_get_google_fonts' );
/**
 * Filters the allowed Google Fonts for the Foodie Pro theme.
 *
 * @since  3.0.0
 *
 * @param  array $fonts
 * @return array $fonts
 */
function foodie_pro_get_google_fonts( $fonts ) {
	$fonts = array(
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
		'Coustard' => array(
			'label'    => 'Coustard',
			'variants' => array(
				'regular',
				'900',
			),
			'subsets' => array(
				'latin',
			),
		),
		'Cutive Mono' => array(
			'label'    => 'Cutive Mono',
			'variants' => array(
				'regular',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
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
		'Karla' => array(
			'label'    => 'Karla',
			'variants' => array(
				'regular',
				'italic',
				'700',
				'700italic',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
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
		'Muli' => array(
			'label'    => 'Muli',
			'variants' => array(
				'300',
				'300italic',
				'regular',
				'italic',
			),
			'subsets' => array(
				'latin',
			),
		),
		'Nunito' => array(
			'label'    => 'Nunito',
			'variants' => array(
				'300',
				'regular',
				'700',
			),
			'subsets' => array(
				'latin',
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
		'Pontano Sans' => array(
			'label'    => 'Pontano Sans',
			'variants' => array(
				'regular',
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
		'Questrial' => array(
			'label'    => 'Questrial',
			'variants' => array(
				'regular',
			),
			'subsets' => array(
				'latin',
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
		'Trocchi' => array(
			'label'    => 'Trocchi',
			'variants' => array(
				'regular',
			),
			'subsets' => array(
				'latin',
				'latin-ext',
			),
		),
	);

	return $fonts;
}
