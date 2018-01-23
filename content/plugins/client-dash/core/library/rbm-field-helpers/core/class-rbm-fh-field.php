<?php
/**
 * Field framework.
 *
 * @since 1.1.0
 *
 * @package RBMFieldHelpers
 * @subpackage RBMFieldHelpers/includes
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field
 *
 * @since 1.1.0
 */
abstract class RBM_FH_Field {

	/**
	 * Field name.
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Field original name (non-prefixed).
	 *
	 * @since 1.4.0
	 * @access private
	 *
	 * @var string
	 */
	public $_original_name;

	/**
	 * Field arguments.
	 *
	 * @since 1.1.0
	 *
	 * @var array|null
	 */
	public $args;

	/**
	 * Field value.
	 *
	 * @since 1.1.0
	 *
	 * @var mixed
	 */
	public $value;

	/**
	 * RBM_FH_Field constructor.
	 *
	 * @since 1.1.0
	 *
	 * @var string $name Field name.
	 * @var array $args Field arguments.
	 */
	function __construct( $name, $args = array() ) {

		$this->_original_name = $name;

		// Unique args
		if ( isset( $this->defaults ) ) {

			$args = wp_parse_args( $args, $this->defaults );
		}

		$this->args = wp_parse_args( $args, array(
			'id'                        => $name,
			'group'                     => 'default',
			'value'                     => false,
			'prefix'                    => '_rbm',
			'label'                     => '',
			'default'                   => '',
			'description'               => false,
			'description_placement'     => 'beneath',
			'description_tip_alignment' => 'left',
			'wrapper_classes'           => array(),
			'no_init'                   => false,
			'sanitization'              => false,
			'input_class'               => '',
			'input_atts'                => array(),
			'option_field'              => false,
			'repeater'                  => false,
			'name_base'                 => false,
			'description_tip'           => true,
			'multi_field'               => false,
			'option_field'              => false,
			'wrapper_class'             => '', // Legacy
		) );

		// Legacy wrapper class use
		if ( $this->args['wrapper_class'] ) {

			$this->args['wrapper_classes'] = array_merge(
				$this->args['wrapper_classes'],
				explode( ' ', $this->args['wrapper_class'] )
			);
		}

		$this->name = $this->args['no_init'] === true ? $name : "{$this->args['prefix']}_{$name}";

		if ( $this->args['name_base'] !== false && $args['no_init'] !== true ) {

			$this->args['name_base'] = "{$this->args['prefix']}_{$this->args['name_base']}";
		}

		if ( $this->args['value'] === false ) {

			$this->get_value();

		} else {

			$this->value = $this->args['value'];
		}

		static::field(
			$this->args['name_base'] !== false ? "{$this->args['name_base']}[{$name}]" : $this->name,
			$this->value,
			$this->args
		);
	}

	/**
	 * Gets the field value.
	 *
	 * @since 1.1.0
	 */
	function get_value() {

		if ( $this->args['option_field'] ) {

			$value = $this->get_option_value();

		} else {

			$value = $this->get_meta_value();
		}

		$value = $value !== '' && $value !== false && $value !== null ? $value : $this->args['default'];

		// Sanitize
		if ( $this->args['sanitization'] && is_callable( $this->args['sanitization'] ) ) {

			$value = call_user_func( $this->args['sanitization'], $value );
		}

		/**
		 * Filter the set value.
		 *
		 * @since 1.1.0
		 */
		$this->value = apply_filters( "rbm_field_{$this->name}_value", $value, $this );
	}

	/**
	 * Gets post meta field value.
	 *
	 * @since 1.4.0
	 * @access private
	 *
	 * @return mixed
	 */
	private function get_meta_value() {

		global $post;

		// Make sure something exists in post
		if ( ! $post ) {

			return false;
		}

		// If not a post object, try to get it
		if ( ! $post instanceof WP_Post ) {

			if ( ! ( $post = get_post( $post ) ) ) {

				return false;
			}
		}

		if ( $this->args['name_base'] !== false ) {

			$base_value = get_post_meta( $post->ID, $this->args['name_base'], true );

			$value = isset( $base_value[ $this->_original_name ] ) ? $base_value[ $this->_original_name ] : '';

		} else {

			$value = get_post_meta( $post->ID, $this->name, ! $this->args['multi_field'] );
		}

		return $value;
	}

	/**
	 * Gets option field value.
	 *
	 * @since 1.4.0
	 * @access private
	 *
	 * @return mixed
	 */
	private function get_option_value() {

		if ( $this->args['name_base'] !== false ) {

			$base_value = get_option( $this->args['name_base'] );

			$value = isset( $base_value[ $this->name ] ) ? $base_value[ $this->_original_name ] : '';

		} else {

			$value = get_option( $this->name );
		}

		return $value;
	}

	/**
	 * Returns the input atts, if set.
	 *
	 * @since 1.3.2
	 *
	 * @param array $args Field args
	 */
	public static function get_input_atts( $args ) {

		if ( ! isset( $args['input_atts'] ) || ! $args['input_atts'] ) {

			return '';
		}

		$input_atts = array();
		foreach ( $args['input_atts'] as $attr_name => $attr_value ) {

			$input_atts[] = $attr_name . '="' . esc_attr( $attr_value ) . '"';
		}

		$input_atts = implode( ' ', $input_atts );

		return $input_atts;
	}

	/**
	 * Echoes the input atts, if set.
	 *
	 * @since 1.3.2
	 *
	 * @param array $args Field args
	 */
	public static function input_atts( $args ) {

		echo self::get_input_atts( $args );
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
	}
}
