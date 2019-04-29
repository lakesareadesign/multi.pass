<?php
/**
 * Field: Text
 *
 * @since 1.1.0
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_Text
 *
 * @since 1.1.0
 */
class RBM_FH_Field_Text extends RBM_FH_Field {

	/**
	 * Field defaults.
	 *
	 * @since 1.4.6
	 *
	 * @var array
	 */
	public $defaults = array(
		'input_class' => 'regular-text',
	);

	/**
	 * RBM_FH_Field_Text constructor.
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

		do_action( "{$args['prefix']}_fieldhelpers_do_field", 'text', $args, $name, $value );
	}
}