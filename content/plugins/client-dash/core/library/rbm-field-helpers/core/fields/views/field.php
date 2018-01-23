<?php
/**
 * Main field view.
 *
 * @since 1.4.0
 *
 * @var string $type
 * @var array $args
 * @var string $name
 * @var mixed $value
 */

defined( 'ABSPATH' ) || die();

$classes = array_merge(
	array(
		'fieldhelpers-field',
		"fieldhelpers-field-{$type}",
		"{$args['prefix']}-fieldhelpers-field",
	),
	$args['wrapper_classes']
);
?>

<div class="<?php echo implode( ' ', $classes ); ?>"
     data-fieldhelpers-instance="<?php echo esc_attr( $args['prefix'] ); ?>"
     data-fieldhelpers-name="<?php echo esc_attr( $name ); ?>"
>
    <header class="fieldhelpers-field-header">
		<?php
		/**
		 * Outputs the field header.
		 *
		 * @since 1.4.0
		 */
		do_action( "{$args['prefix']}_fieldhelpers_field_template_header", $type, $args, $name, $value );
		?>
    </header>

    <div class="fieldhelpers-field-content">
		<?php
		/**
		 * Outputs the field content.
		 *
		 * @since 1.4.0
		 */
		do_action( "{$args['prefix']}_fieldhelpers_field_template_content", $type, $args, $name, $value );
		?>
    </div>

    <footer class="fieldhelpers-field-footer">
		<?php
		/**
		 * Outputs the field footer.
		 */
		do_action( "{$args['prefix']}_fieldhelpers_field_template_footer", $type, $args, $name, $value );
		?>
    </footer>
</div>