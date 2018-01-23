<?php
/**
 * Field Template: Hidden
 *
 * @since 1.4.0
 *
 * @var array $args Field arguments.
 * @var string $name Field name.
 * @var mixed $value Field value.
 */

defined( 'ABSPATH' ) || die();
?>

<input type="hidden"
       name="<?php echo esc_attr( $name ); ?>"
       id="<?php esc_attr( $args['id'] ); ?>"
       value="<?php echo $value !== false ? esc_attr( $value ) : esc_attr( $args['default'] ); ?>"
       class="<?php echo isset( $args['input_class'] ) ? esc_attr( $args['input_class'] ) : 'regular-text'; ?>"
	<?php RBM_FH_Field::input_atts( $args ); ?>
/>