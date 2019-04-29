<?php
/**
 * Field: Time Picker
 *
 * @since 1.4.0
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_TimePicker
 *
 * @since 1.4.0
 */
class RBM_FH_Field_TimePicker extends RBM_FH_Field {

	/**
	 * Field defaults.
	 *
	 * @since 1.4.0
	 *
	 * @var array
	 */
	public $defaults = array(
		'default'         => '',
		'format'          => '',
		'timepicker_args' => array(
			'altFormat'        => 'yymmdd',
			'altTimeFormat'    => 'HH:mm',
			'altFieldTimeOnly' => false,
			'timeFormat'       => 'hh:mm tt',
			'controlType'      => 'select',
		),
	);

	/**
	 * RBM_FH_Field_TimePicker constructor.
	 *
	 * @since 1.4.0
	 *
	 * @var string $name
	 * @var array $args
	 */
	function __construct( $name, $args = array() ) {

		// Cannot use function in property declaration
		$this->defaults['format'] = get_option( 'time_format', 'g:i a' );
		
		$this->defaults['timepicker_args']['timeFormat'] = RBM_FH_Field_DateTimePicker::php_date_to_jquery_ui( $this->defaults['format'] );

		$args['default'] = current_time( $this->defaults['format'] );
		
		if ( ! isset( $args['timepicker_args'] ) ) {
			$args['timepicker_args'] = array();
		}

		// Default options
		$args['timepicker_args'] = wp_parse_args( $args['timepicker_args'], $this->defaults['timepicker_args'] );

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
		
		wp_enqueue_script( 'rbm-fh-jquery-ui-datetimepicker' );
		wp_enqueue_style( 'rbm-fh-jquery-ui-datetimepicker' );

		// Get preview format
		$args['preview'] = date( $args['format'], strtotime( $value ? $value : $args['default'] ) );

		// Timepicker args
		if ( $args['timepicker_args'] ) {
			add_filter( 'rbm_field_helpers_admin_data', function ( $data ) use ( $args, $name ) {

				$data["timepicker_args_$name"] = $args['timepicker_args'];

				return $data;
			} );
		}

		do_action( "{$args['prefix']}_fieldhelpers_do_field", 'timepicker', $args, $name, $value );
	}
}