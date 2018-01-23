<?php
/**
 * Field Template: Textarea
 *
 * @since 1.4.0
 *
 * @var array $args Field arguments.
 * @var string $name Field name.
 * @var mixed $value Field value.
 */

defined( 'ABSPATH' ) || die();

?>

<textarea name="<?php echo esc_attr( $name ); ?>"
          id="<?php echo esc_attr( $args['id'] ); ?>"
          class="<?php echo esc_attr( $args['input_class'] ); ?>"
          rows="<?php echo esc_attr( $args['rows'] ); ?>"
          data-fieldhelpers-field-textarea
	<?php RBM_FH_Field::input_atts( $args ); ?>
><?php echo $value; ?></textarea>