<?php
/**
 * Field Template: Colorpicker
 *
 * @since 1.4.0
 *
 * @var array $args Field arguments.
 * @var string $name Field name.
 * @var mixed $value Field value.
 */

defined( 'ABSPATH' ) || die();
?>

<input type="text"
       name="<?php echo esc_attr( $name ); ?>"
       value="<?php echo esc_attr( $value ); ?>"
       class="<?php echo esc_attr( $args['input_class'] ); ?>"
       data-fieldhelpers-field-colorpicker
	<?php RBM_FH_Field::input_atts( $args ); ?> />
