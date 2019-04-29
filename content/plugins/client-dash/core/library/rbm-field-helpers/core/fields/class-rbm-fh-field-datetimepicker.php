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
			'dateFormat'       => 'MM d, yy',
			'timeFormat'       => 'h:mm tt',
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
		
		$date_format_php = get_option( 'date_format', 'F j, Y' );
		$time_format_php = get_option( 'time_format', 'g:i a' );

		// Cannot use function in property declaration
		$this->defaults['format'] = $date_format_php . ' ' . $time_format_php;
		
		// Ensure the Date/Time Format matches the stored format in WordPress
		$this->defaults['datetimepicker_args']['dateFormat'] = RBM_FH_Field_DateTimePicker::php_date_to_jquery_ui( $date_format_php );
		$this->defaults['datetimepicker_args']['timeFormat'] = RBM_FH_Field_DateTimePicker::php_date_to_jquery_ui( $time_format_php );

		$args['default'] = current_time( $this->defaults['format'] );
		
		if ( ! isset( $args['datetimepicker_args'] ) ) {
			$args['datetimepicker_args'] = array();
		}

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
		
		wp_enqueue_script( 'rbm-fh-jquery-ui-datetimepicker' );
		wp_enqueue_style( 'rbm-fh-jquery-ui-datetimepicker' );

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
	
	/**
	 * Converts a PHP Date/Time Format to jQuery UI Date/Time
	 * Cleaned up variant of http://stackoverflow.com/a/16725290
	 * 
	 * @since 1.4.5
	 * 
	 * @param string $php_format PHP Date Format
	 * @return string jQuery UI Date Format
	 */
	public static function php_date_to_jquery_ui( $php_format ) {
		
		$format_map = array(
			// Day
			'd' => 'dd',
			'D' => 'D',
			'j' => 'd',
			'l' => 'DD',
			'N' => '',
			'S' => '',
			'w' => '',
			'z' => 'o',
			// Week
			'W' => '',
			// Month
			'F' => 'MM',
			'm' => 'mm',
			'M' => 'M',
			'n' => 'm',
			't' => '',
			// Year
			'L' => '',
			'o' => '',
			'Y' => 'yy',
			'y' => 'y',
			// Time
			'a' => 'tt',
			'A' => 'TT',
			'B' => '',
			'g' => 'h',
			'G' => 'H',
			'h' => 'hh',
			'H' => 'HH',
			'i' => 'mm',
			's' => 'ss',
			'u' => 'c'
		);

		$jqueryui_format = '';
		$escaped = false;

		for ( $index = 0; $index < strlen( $php_format ); $index++ ) {

			$char = $php_format[$index];

			if ( $char === '\\' ) { // If Character is an Escaping Slash

				$index++;

				// If we haven't already escaped a character, output it alongside the next character
				if ( ! $escaped ) {

					$jqueryui_format .= '\'' . $php_format[ $index ];
					$escaped = true;

				}
				else  {

					// Ignore, we've already escaped it
					$jqueryui_format .= $php_format[ $index ];

				}

			}
			else {

				// Reset Escaped Status for next loop
				if ( $escaped ) {

					$jqueryui_format .= "'";
					$escaped = false;

				}

				// Make necessary replacements via our PHP->jQuery UI Format Map
				if ( isset( $format_map[ $char ] ) ) {
					$jqueryui_format .= $format_map[ $char ];
				}
				else {
					$jqueryui_format .= $char;
				}

			}

		}

		return $jqueryui_format;	
	}
	
}