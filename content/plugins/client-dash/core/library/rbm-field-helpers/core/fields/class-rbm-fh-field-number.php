<?php
/**
 * Field: Number
 *
 * @since 1.3.2
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_Number
 *
 * @since 1.3.2
 */
class RBM_FH_Field_Number extends RBM_FH_Field {

	/**
	 * Field defaults.
	 *
	 * @since 1.3.2
	 *
	 * @var array
	 */
	public $defaults = array(
		'increase_interval'     => 1,
		'decrease_interval'     => 1,
		'alt_increase_interval' => 10,
		'alt_decrease_interval' => 10,
		'max'                   => 'none',
		'min'                   => 'none',
		'postfix'               => false,
	);

	/**
	 * RBM_FH_Field_Number constructor.
	 *
	 * @since 1.3.2
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
	 * @since 1.3.2
	 *
	 * @param string $name Name of the field.
	 * @param mixed $value Value of the field.
	 * @param array $args Field arguments.
	 */
	public static function field( $name, $value, $args = array() ) {

	    do_action( "{$args['prefix']}_fieldhelpers_do_field", 'number', $args, $name, $value );
	}
}