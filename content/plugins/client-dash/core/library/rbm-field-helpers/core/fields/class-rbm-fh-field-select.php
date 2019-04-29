<?php
/**
 * Field: Select
 *
 * @since 1.1.0
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_Select
 *
 * @since 1.1.0
 */
class RBM_FH_Field_Select extends RBM_FH_Field {

	/**
	 * Field defaults.
	 *
	 * @since 1.1.0
	 *
	 * @var array
	 */
	public $defaults = array(
		'input_class'                => 'regular-text',
		'options'                    => array(),
		'opt_groups'                 => false,
		'multiple'                   => false,
		'option_none'                => false,
		'option_none_value'          => '',
		'multi_field'                => false,
		'no_options_text'            => '',
		'show_empty_select'          => false,
		'singular_name'              => '',
		'plural_name'                => '',
		'opt_group_selection_prefix' => true,
		'select2_disable'            => false,
		'select2_options'            => array(
			'placeholder'       => '',
			'containerCssClass' => 'fieldhelpers-select2',
			'dropdownCssClass'  => 'fieldhelpers-select2',
			'language'          => array(),
		),
	);

	/**
	 * RBM_FH_Field_Select constructor.
	 *
	 * @since 1.1.0
	 *
	 * @var string $name
	 * @var array $args
	 */
	function __construct( $name, $args = array() ) {

		// Legacy l10n
		$args['l10n']['no_options'] = isset( $args['no_options_text'] ) ?
			$args['no_options_text'] : $args['l10n']['no_options'];

		// Select2 Options defaults
		if ( ! isset( $args['select2_disable'] ) || $args['select2_disable'] !== true ) {

			$args['select2_options'] = wp_parse_args(
				isset( $args['select2_options'] ) ? $args['select2_options'] : array(),
				$this->defaults['select2_options']
			);

			if ( isset( $args['placeholder'] ) ) {

				$args['select2_options']['placeholder'] = $args['placeholder'];
			}

			// Languages
			$args['select2_options']['language'] = array(
				'errorLoading'    => $args['l10n']['error_loading'],
				'inputTooLong'    => $args['l10n']['input_too_long'],
				'inputTooShort'   => $args['l10n']['input_too_short'],
				'loadingMore'     => $args['l10n']['loading_more'],
				'maximumSelected' => $args['l10n']['maximum_selected'],
				'noResults'       => $args['l10n']['no_results'],
				'searching'       => $args['l10n']['searching'],
			);
		}

		if ( ! isset( $args['options'] ) ) {

			$args['options'] = array();
		}

		$args['options'] = $this->legacy_options_support(
			$args['options'],
			isset( $args['opt_groups'] ) && $args['opt_groups'] === true
		);

		// Set option defaults
		if ( isset( $args['opt_groups'] ) && $args['opt_groups'] === true ) {

			foreach ( $args['options'] as $opt_group => $options ) {

				foreach ( $options as $i => $option ) {

					$args['options'][ $opt_group ][ $i ] = wp_parse_args( $option, array(
						'text'     => '',
						'value'    => '',
						'disabled' => false,
					) );
				}
			}

		} else {

			foreach ( $args['options'] as $i => $option ) {

				$args['options'][ $i ] = wp_parse_args( $option, array(
					'text'     => '',
					'value'    => '',
					'disabled' => false,
				) );
			}
		}

		parent::__construct( $name, $args );
	}

	/**
	 * Outputs the field.
	 *
	 * @since 1.1.0
	 *
	 * @param string $name Name of the field.
	 * @param mixed $value Value of the field.
	 * @param array $args Field arguments.
	 */
	public static function field( $name, $value, $args = array() ) {

		do_action( "{$args['prefix']}_fieldhelpers_do_field", 'select', $args, $name, $value );
	}

	/**
	 * Supports old option formatting.
	 *
	 * @since 1.4.2
	 * @access private
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	private function legacy_options_support( $options, $opt_groups ) {

		if ( $opt_groups === true ) {

			// Determine if properly formatted by getting the first item and seeing if is an array
			$properly_formatted = true;
			foreach ( $options as $opt_group_label => $opt_group_options ) {

				foreach ( $opt_group_options as $maybe_i => $maybe_option ) {

					if ( ! is_array( $maybe_option ) ) {

						$properly_formatted = false;
					}

					break;
				}
			}

			if ( $properly_formatted === false ) {

				$new_options = array();
				foreach ( $options as $opt_group_label => $opt_group_options ) {

					$new_options[ $opt_group_label ] = array();

					foreach ( $opt_group_options as $value => $text ) {

						$new_options[ $opt_group_label ][] = array(
							'value' => $value,
							'text'  => $text,
						);
					}
				}
			}

		} else {

			// Determine if properly formatted by getting the first item and seeing if is an array
			$properly_formatted = true;
			foreach ( $options as $maybe_i => $maybe_option ) {

				if ( ! is_array( $maybe_option ) ) {

					$properly_formatted = false;
				}

				break;
			}

			if ( $properly_formatted === false ) {

				$new_options = array();
				foreach ( $options as $value => $text ) {

					$new_options[] = array(
						'value' => $value,
						'text'  => $text,
					);
				}
			}
		}

		return isset( $new_options ) ? $new_options : $options;
	}
}