<?php
/**
 * Field Template: Radio
 *
 * @since 1.4.0
 *
 * @var array $args Field arguments.
 * @var string $name Field name.
 * @var mixed $value Field value.
 */

defined( 'ABSPATH' ) || die();
?>

<div class="fieldhelpers-field-radio-container"
     data-fieldhelpers-field-radio
>
	<?php $i = 0; ?>
	<?php foreach ( $args['options'] as $radio_value => $radio_label ) : ?>
		<?php $i ++; ?>

        <div class="fieldhelpers-field-radio-row">

            <div class="fieldhelpers-field-radio-input-container">
                <input type="radio"
                       name="<?php echo $name; ?>"
                       id="<?php echo "{$args['id']}_{$i}"; ?>"
                       value="<?php echo $radio_value; ?>"
                       class="<?php echo $args['input_class']; ?>"
					<?php checked( $radio_value, $value ); ?>
					<?php RBM_FH_Field::input_atts( $args ); ?>
                />
            </div>

            <label for="<?php echo "{$args['id']}_{$i}"; ?>"
                   class="fieldhelpers-field-radio-label"
            ><?php echo $radio_label; ?></label>

        </div>

	<?php endforeach; ?>
</div>
