<?php
/**
 * Field Template: List
 *
 * @since 1.4.0
 *
 * @var array $args Field arguments.
 * @var string $name Field name.
 * @var mixed $value Field value.
 */

defined( 'ABSPATH' ) || die();
?>

<ul class="fieldhelpers-field-list-items"
    data-fieldhelpers-field-list="<?php echo esc_attr( $name ); ?>"
>
	<?php foreach ( $args['items'] as $value => $label ) : ?>
        <li class="fieldhelpers-field-list-item">
            <span class="fieldhelpers-field-list-item-handle dashicons dashicons-menu"></span>

			<?php echo esc_attr( $label ); ?>

            <input type="hidden"
                   name="<?php echo esc_attr( $name ); ?>[]"
                   value="<?php echo esc_attr( $value ); ?>"
				<?php RBM_FH_Field::input_atts( $args ); ?>
            />
        </li>
	<?php endforeach; ?>
</ul>