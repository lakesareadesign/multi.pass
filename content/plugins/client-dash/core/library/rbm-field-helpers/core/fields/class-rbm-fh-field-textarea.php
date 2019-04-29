<?php
/**
 * Field: Text Area
 *
 * @since 1.1.0
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_TextArea
 *
 * @since 1.1.0
 */
class RBM_FH_Field_TextArea extends RBM_FH_Field {

	/**
	 * Field defaults.
	 *
	 * @since 1.1.0
	 *
	 * @var array
	 */
	public $defaults = array(
		'input_class'     => 'regular-text',
		'rows'            => 4,
		'wysiwyg'         => false,
		'wysiwyg_options' => array(
			'mediaButtons' => true,
		),
	);

	/**
	 * RBM_FH_Field_TextArea constructor.
	 *
	 * @since 1.1.0
	 *
	 * @var string $name
	 * @var array $args
	 */
	function __construct( $name, $args = array() ) {

		// Backwards compat
		if ( isset( $args['wysiwyg_args'] ) ) {

			$args['wysiwyg_options'] = $args['wysiwyg_args'];
		}

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

		// This will only run once, so no worries
		if ( $args['wysiwyg'] ) {

			wp_enqueue_editor();
			$args['input_class'] = trim( $args['input_class'] . ' wp-editor-area' ); // Fixes sizing problems on the Text Tab
		}

		do_action( "{$args['prefix']}_fieldhelpers_do_field", 'textarea', $args, $name, $value );
	}
}
