<?php
/**
 * Field: Media
 *
 * @since 1.1.0
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Field_Media
 *
 * @since 1.1.0
 */
class RBM_FH_Field_Media extends RBM_FH_Field {

	/**
	 * Field defaults.
	 *
	 * @since 1.1.0
	 *
	 * @var array
	 */
	public $defaults = array(
		'preview_size' => 'medium',
		'type'         => 'image',
		'placeholder'  => false,
	);

	/**
	 * RBM_FH_Field_Media constructor.
	 *
	 * @since 1.1.0
	 *
	 * @var string $name
	 * @var array $args
	 */
	function __construct( $name, $args = array() ) {

		// Legacy
		$args['l10n']['button_text'] = isset( $args['button_text'] ) ?
			$args['button_text'] : $args['l10n']['button_text'];

		$args['l10n']['button_remove_text'] = isset( $args['button_remove_text'] ) ?
			$args['button_remove_text'] : $args['l10n']['button_remove_text'];

		$args['l10n']['window_title'] = isset( $args['window_title'] ) ?
			$args['window_title'] : $args['l10n']['window_title'];

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

		if ( $media_item_src = wp_get_attachment_image_src( $value, $args['preview_size'] ) ) {

			$args['media_preview_url'] = $media_item_src[0];

		} else {

			$args['media_preview_url'] = wp_get_attachment_url( $value );
		}

		do_action( "{$args['prefix']}_fieldhelpers_do_field", 'media', $args, $name, $value );
	}
}