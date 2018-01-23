<?php
/**
 * Field: DateTime Picker
 *
 * @since 1.4.0
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_DateTimePicker
 *
 * @since 1.4.0
 */
class RBM_FH_Field_DateTimePicker extends RBM_FH_Field {

	/**
	 * Field defaults.
	 *
	 * @since 1.4.0
	 *
	 * @var array
	 */
	public $defaults = array(
		'default'             => '',
		'format'              => '',
		'datetimepicker_args' => array(
			'altFormat'        => 'yymmdd',
			'altTimeFormat'    => 'HH:mm',
			'altFieldTimeOnly' => false,
			'timeFormat'       => 'hh:mm tt',
			'controlType'      => 'select',
		),
	);

	/**
	 * RBM_FH_Field_DateTimePicker constructor.
	 *
	 * @since 1.4.0
	 *
	 * @var string $name
	 * @var array $args
	 * @var mixed $value
	 */
	function __construct( $name, $args = array() ) {

		// Cannot use function in property declaration
		$this->defaults['format'] = get_option( 'date_format', 'F j, Y' ) . ' ' . get_option( 'time_format', 'g:i a' );

		$args['default'] = current_time( $this->defaults['format'] );

		// Default options
		$args['datetimepicker_args'] = wp_parse_args( $args['datetimepicker_args'], $this->defaults['datetimepicker_args'] );

		parent::__construct( $name, $args );
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

		// Get preview format
		$args['preview'] = date( $args['format'], strtotime( $value ? $value : $args['default'] ) );

		// DateTimepicker args
		if ( $args['datetimepicker_args'] ) {

			add_filter( 'rbm_field_helpers_admin_data', function ( $data ) use ( $args, $name ) {

				$data["datetimepicker_args_$name"] = $args['datetimepicker_args'];

				return $data;
			} );
		}

		do_action( "{$args['prefix']}_fieldhelpers_do_field", 'datetimepicker', $args, $name, $value );
	}
}