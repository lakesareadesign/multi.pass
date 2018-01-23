<?php
/**
 * Field Template: Number
 *
 * @since 1.4.0
 *
 * @var array $args Field arguments.
 * @var string $name Field name.
 * @var mixed $value Field value.
 */

defined( 'ABSPATH' ) || die();
?>
<div class="fieldhelpers-field-number-container"
     data-fieldhelpers-field-number
	<?php echo $args['postfix'] ? 'data-postfix="' . esc_attr( $args['postfix'] ) . '"' : ''; ?>>
    <input type="text"
           name="<?php echo esc_attr( $name ); ?>"
           id="<?php echo esc_attr( $args['id'] ); ?>"
           class="fieldhelpers-field-input"
           value="<?php echo esc_attr( $value ); ?>"
		<?php RBM_FH_Field::input_atts( $args ); ?>
    />

    <button type="button"
            class="fieldhelpers-field-number-increase fieldhelpers-button"
            data-number-increase
            data-number-interval="<?php echo esc_attr( $args['increase_interval'] ); ?>"
            data-number-alt-interval="<?php echo esc_attr( $args['alt_increase_interval'] ); ?>"
            data-number-max="<?php echo esc_attr( $args['max'] ); ?>"
            title="increase number"
            aria-label="increase number"
    >
        <span class="dashicons dashicons-plus"></span>
    </button>

    <button type="button"
            class="fieldhelpers-field-number-decrease fieldhelpers-button"
            data-number-decrease
            data-number-interval="<?php echo esc_attr( $args['decrease_interval'] ); ?>"
            data-number-alt-interval="<?php echo esc_attr( $args['alt_decrease_interval'] ); ?>"
            data-number-min="<?php echo esc_attr( $args['min'] ); ?>"
            title="decrease number"
            aria-label="decrease number"
    >
        <span class="dashicons dashicons-minus"></span>
    </button>
</div>