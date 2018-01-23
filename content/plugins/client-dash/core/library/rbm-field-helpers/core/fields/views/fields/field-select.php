<?php
/**
 * Field Template: Select
 *
 * @since 1.4.0
 *
 * @var array $args Field arguments.
 * @var string $name Field name.
 * @var mixed $value Field value.
 */

defined( 'ABSPATH' ) || die();

if ( $args['multiple'] && ! $args['repeater'] ) {

	$name = "{$name}[]";
}
?>

<?php if ( ! empty( $args['options'] ) || $args['show_empty_select'] === true ) : ?>
    <select name="<?php echo esc_attr( $name ); ?>"
            id="<?php echo esc_attr( $args['id'] ); ?>"
            class="<?php echo esc_attr( $args['input_class'] ); ?>"
            data-fieldhelpers-field-select="<?php echo esc_attr( $name ); ?>"
		<?php RBM_FH_Field::input_atts( $args ); ?>
		<?php echo $args['multiple'] ? 'multiple' : ''; ?>
    >

		<?php if ( $args['option_none'] ) : ?>
            <option value="<?php echo esc_attr( $args['option_none_value'] ); ?>">
				<?php echo esc_attr( $args['option_none'] ); ?>
            </option>
		<?php endif; ?>

		<?php if ( ! empty( $args['options'] ) ) : ?>
			<?php if ( $args['opt_groups'] ) : ?>

				<?php foreach ( $args['options'] as $opt_group_label => $options ) : ?>
                    <optgroup label="<?php echo esc_attr( $opt_group_label ); ?>">

						<?php
						foreach ( $options as $option ) :

							if ( $args['multiple'] ) {
								$selected = in_array( $option['value'], (array) $value ) ? 'selected' : '';
							} else {
								$selected = selected( $option['value'], $value, false ) ? 'selected' : '';
							}
							?>
                            <option value="<?php echo esc_attr( $option['value'] ); ?>"
								<?php echo $selected; ?>
								<?php echo $option['disabled'] === true ? 'disabled' : '' ?>>
								<?php echo esc_attr( $option['text'] ); ?>
                            </option>
						<?php endforeach; ?>

                    </optgroup>
				<?php endforeach; ?>

			<?php else : ?>

				<?php foreach ( $args['options'] as $option ) :

					if ( $args['multiple'] ) {
						$selected = in_array( $option['value'], (array) $value ) ? 'selected' : '';
					} else {
						$selected = selected( $option['value'], $value, false ) ? 'selected' : '';
					}
					?>
                    <option value="<?php echo esc_attr( $option['value'] ); ?>"
						<?php echo $selected; ?>
						<?php echo $option['disabled'] === true ? 'disabled' : '' ?>>
						<?php echo esc_attr( $option['text'] ); ?>
                    </option>

				<?php endforeach; ?>
			<?php endif; ?>
		<?php endif; ?>

    </select>
<?php else: ?>
	<?php echo $args['l10n']['no_options']; ?>
<?php endif; ?>