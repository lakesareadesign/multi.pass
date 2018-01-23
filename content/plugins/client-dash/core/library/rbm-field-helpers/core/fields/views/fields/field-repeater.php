<?php
/**
 * Field Template: Repeater
 *
 * @since 1.4.0
 *
 * @var array $args Field arguments.
 * @var string $name Field name.
 * @var mixed $value Field value.
 */

defined( 'ABSPATH' ) || die();

$empty     = ! $value;
$row_count = count( $value ) >= 1 ? count( $value ) : 1;

// TODO test layout with collapsable
?>

<div class="fielhelpers-field-repeater-container"
     data-fieldhelpers-field-repeater="<?php echo esc_attr( $name ); ?>"
>

    <div class="fieldhelpers-field-repeater-list"
         data-repeater-list="<?php echo esc_attr( $name ); ?>"
    >

		<?php foreach ( $value as $field_value ) : ?>

            <div class="fieldhelpers-field-repeater-row" data-repeater-item>

				<?php if ( $args['collapsable'] ) : ?>

                    <div class="fieldhelpers-field-repeater-header">

						<?php if ( $args['sortable'] ) : ?>
                            <div class="fieldhelpers-field-repeater-handle"></div>
						<?php endif; ?>

                        <div class="fieldhelpers-field-repeater-header-interior">

                            <h2 class="fieldhelpers-field-repeater-collapsable-handle"
                                data-repeater-collapsable-handle
                            >
                            <span class="collapsable-title"
                                  data-collapsable-title-default="<?php echo $args['l10n']['collapsable_title']; ?>"
                            >
                                <?php echo $args['l10n']['collapsable_title']; ?>
                            </span>
                                <span class="fieldhelpers-field-repeater-collapsable-collapse-icon dashicons dashicons-arrow-down-alt2"></span>
                                <input data-repeater-delete
                                       type="button"
                                       class="fieldhelpers-field-repeater-delete-button button"
                                       value="<?php echo $args['l10n']['delete_item']; ?>"
                                />
                            </h2>

                        </div>

                    </div>


				<?php elseif ( $args['sortable'] ) : ?>

                    <div class="fieldhelpers-field-repeater-handle"></div>

				<?php endif; ?>

                <div class="fieldhelpers-field-repeater-content">

					<?php RBM_FH_Field_Repeater::do_fields( $name, $field_value, $args ); ?>

                </div>

				<?php if ( ! $args['collapsable'] ) : ?>

                    <input data-repeater-delete
                           type="button"
                           class="fieldhelpers-field-repeater-delete-button button"
                           value="<?php echo $args['l10n']['delete_item']; ?>"
                    />

				<?php endif; ?>

            </div>

        <?php endforeach; ?>

    </div>

    <input data-repeater-create
           type="button"
           class="fieldhelpers-field-repeater-add-button button button-primary"
           value="<?php echo $args['l10n']['add_item']; ?>"
    />
</div>