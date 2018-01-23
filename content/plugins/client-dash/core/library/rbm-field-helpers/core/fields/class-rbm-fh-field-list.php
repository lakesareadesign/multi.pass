<?php
/**
 * Field: List
 *
 * @since 1.3.0
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_List
 *
 * @since 1.3.0
 */
class RBM_FH_Field_List extends RBM_FH_Field {

	/**
	 * Data to localize for the list fields.
	 *
	 * @since 1.3.0
	 *
	 * @var array
	 */
	static $data = array();

	/**
	 * Field defaults.
	 *
	 * @since 1.3.0
	 *
	 * @var array
	 */
	public $defaults = array(
		'items'         => array(),
		'sortable_args' => array(
			'axis' => 'y',
		),
	);

	/**
	 * RBM_FH_Field_List constructor.
	 *
	 * @since 1.3.0
	 *
	 * @var string $name
	 * @var array $args
	 * @var mixed $value
	 */
	function __construct( $name, $args = array() ) {

		parent::__construct( $name, $args );
	}

	/**
	 * Outputs the field.
	 *
	 * @since 1.3.0
	 *
	 * @param string $name Name of the field.
	 * @param mixed $value Value of the field.
	 * @param array $args Field arguments.
	 */
	public static function field( $name, $value, $args = array() ) {

		// Re-order based on saved value
		if ( $value ) {

			$args['items'] = array_replace( array_flip( $value ), $args['items'] );
		}

		do_action( "{$args['prefix']}_fieldhelpers_do_field", 'list', $args, $name, $value );
	}
}