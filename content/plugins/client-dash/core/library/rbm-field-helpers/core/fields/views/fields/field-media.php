<?php
/**
 * Field Template: Media
 *
 * @since 1.4.0
 *
 * @var array $args Field arguments.
 * @var string $name Field name.
 * @var mixed $value Field value.
 */

defined( 'ABSPATH' ) || die();
?>

<div class="fieldhelpers-media-uploader"
     data-fieldhelpers-field-media
>

	<?php
	switch ( $args['type'] ) :

		case 'image':

			$args['placeholder'] = $args['placeholder'] != '&nbsp;' ? $args['placeholder'] : '';
			?>
            <img src="<?php echo $value ? esc_attr( $args['media_preview_url'] ) : esc_attr( $args['placeholder'] ); ?>"
                 data-image-preview
            />
			<?php
			break;

		default:
			?>
            <code data-media-preview>
				<?php echo $value ? $args['media_preview_url'] : $args['placeholder']; ?>
            </code>
			<?php
	endswitch;
	?>

    <br/>

    <input type="button"
           class="button"
           value="<?php echo esc_attr( $args['l10n']['button_text'] ); ?>"
           data-add-media
		<?php echo $value ? 'style="display: none;"' : ''; ?>
    />
    <input type="button"
           class="button"
           value="<?php echo esc_attr( $args['l10n']['button_remove_text'] ); ?>"
           data-remove-media
		<?php echo ! $value ? 'style="display: none;"' : ''; ?>
    />

    <input type="hidden"
           name="<?php echo esc_attr( $name ); ?>"
           value="<?php echo esc_attr( $value ); ?>"
           class="<?php echo isset( $args['input_class'] ) ? esc_attr( $args['input_class'] ) : ''; ?>"
           data-media-input
		<?php RBM_FH_Field::input_atts( $args ); ?>
    />
</div>
