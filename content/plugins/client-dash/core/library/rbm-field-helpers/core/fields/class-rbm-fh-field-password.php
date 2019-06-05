<?php
/**
 * Field: Password
 *
 * @since 1.4.7
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_Password
 *
 * @since 1.4.7
 */
class RBM_FH_Field_Password extends RBM_FH_Field_Text {

	/**
	 * Field defaults.
	 *
	 * @since 1.4.7
	 *
	 * @var array
	 */
	public $defaults = array(
		'input_class' => 'regular-text',
	);

	/**
	 * RBM_FH_Field_Password constructor.
	 *
	 * @since 1.4.7
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
	 * @since 1.4.7
	 *
	 * @param string $name Name of the field.
	 * @param mixed $value Value of the field.
	 * @param array $args Field arguments.
	 */
	public static function field( $name, $value, $args = array() ) {

		do_action( "{$args['prefix']}_fieldhelpers_do_field", 'password', $args, $name, $value );
	}
}