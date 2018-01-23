<?php
/**
 * Field: Radio
 *
 * @since 1.1.0
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_Radio
 *
 * @since 1.1.0
 */
class RBM_FH_Field_Radio extends RBM_FH_Field {

	/**
	 * Field defaults.
	 *
	 * @since 1.1.0
	 *
	 * @var array
	 */
	public $defaults = array(
		'options' => false,
	);

	/**
	 * RBM_FH_Field_Radio constructor.
	 *
	 * @since 1.1.0
	 *
	 * @var string $name
	 * @var array $args
	 */
	function __construct( $name, $args = array() ) {

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
				'radio_value' => 1,
				'radio_label' => $args['label'],
			) );

			$args['options'] = array(
				$args['radio_value'] => $args['radio_label'],
			);

		} else {

			if ( $args['options'] === false ) {

				echo 'No radio options';

				return;
			}
		}

		do_action( "{$args['prefix']}_fieldhelpers_do_field", 'radio', $args, $name, $value );
	}
}