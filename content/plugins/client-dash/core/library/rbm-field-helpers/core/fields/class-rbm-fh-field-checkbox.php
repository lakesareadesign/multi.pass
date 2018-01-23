<?php
/**
 * Field: Checkbox
 *
 * @since 1.1.0
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_Checkbox
 *
 * @since 1.1.0
 */
class RBM_FH_Field_Checkbox extends RBM_FH_Field {

	/**
	 * RBM_FH_Field_Checkbox constructor.
	 *
	 * @since 1.1.0
	 *
	 * @var string $name
	 * @var array $args
	 * @var mixed $value
	 */
	function __construct( $name, $args = array() ) {

		// Legacy
		$args['l10n']['no_options_text'] = isset( $args['no_options_text'] ) ?
			$args['no_options_text'] : $args['l10n']['no_options_text'];

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

		// Legacy
		if ( ! $args['options'] ) {

			$args = wp_parse_args( $args, array(
				'check_value' => 1,
				'check_label' => $args['label'],
			) );

			$args['options'] = array(
				$args['check_value'] => $args['check_label'],
			);

		} else {

			if ( $args['options'] === false ) {

				echo $args['no_options_text'];

				return;
			}
		}

		do_action( "{$args['prefix']}_fieldhelpers_do_field", 'checkbox', $args, $name, $value );
	}
}