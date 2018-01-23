<?php
/**
 * Field Description.
 *
 * @since 1.4.0
 *
 * @var string $type
 * @var array $args
 * @var string $name
 * @var mixed $value
 */

defined( 'ABSPATH' ) || die();
?>

<?php if ( $args['description'] ) : ?>

    <div class="fieldhelpers-field-description fieldhelpers-field-tip fieldhelpers-field-tip-align-<?php echo $args['description_tip_alignment']; ?>">
        <span class="fieldhelpers-field-tip-toggle dashicons dashicons-editor-help" data-toggle-tip></span>
        <p class="fieldhelpers-field-tip-text">
			<?php echo $args['description']; ?>
        </p>
    </div>
<?php endif; ?>
