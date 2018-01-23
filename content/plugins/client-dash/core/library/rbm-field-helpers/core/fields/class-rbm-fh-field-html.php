<?php
/**
 * Field: HTML
 *
 * @since 1.4.0
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_HTML
 *
 * @since 1.4.0
 */
class RBM_FH_Field_HTML extends RBM_FH_Field {

	/**
	 * RBM_FH_Field_HTML constructor.
	 *
	 * @since 1.4.0
	 *
	 * @var string $name
	 * @var string $label
	 * @var array $args
	 */
	function __construct( $name, $label = '', $args = array() ) {

		parent::__construct( $name, $label, $args );
	}

	/**
	 * Outputs the field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name Name of the field.
	 * @param mixed $value Value of the field.
	 * @param array $args Field arguments.
	 */
	public static function field( $name, $value, $args = array() ) {

		do_action( "{$args['prefix']}_fieldhelpers_do_field", 'html', $args, $name, $value );
	}
}