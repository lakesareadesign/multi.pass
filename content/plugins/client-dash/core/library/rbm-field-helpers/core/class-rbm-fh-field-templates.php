<?php
/**
 * Applies templates to fields.
 *
 * @since 1.4.0
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_FieldTemplates
 *
 * Applies templates to fields.
 *
 * @since 1.4.0
 */
class RBM_FH_FieldTemplates {

	/**
	 * Instance properties.
	 *
	 * @since 1.4.0
	 *
	 * @var array
	 */
	public $instance = array();

	/**
	 * RBM_FH_FieldTemplates constructor.
	 *
	 * @since 1.4.0
	 *
	 * @param array $instance Instance properties.
	 */
	function __construct( $instance = array() ) {

		$this->instance = $instance;

		$prefix = $this->instance['ID'];

		add_action( "{$prefix}_fieldhelpers_do_field", array( $this, 'do_field' ), 10, 4 );

		add_action( "{$prefix}_fieldhelpers_field_template_header", array( $this, 'template_label' ), 10, 4 );
		add_action( "{$prefix}_fieldhelpers_field_template_header", array(
			$this,
			'template_description_after_label'
		), 15, 4 );
		add_action( "{$prefix}_fieldhelpers_field_template_content", array( $this, 'template_field' ), 10, 4 );
		add_action( "{$prefix}_fieldhelpers_field_template_footer", array(
			$this,
			'template_description_beneath'
		), 10, 4 );
	}

	/**
	 * Outputs a field.
	 *
	 * @since 1.4.0
	 * @access private
	 *
	 * @param string $type Field type.
	 * @param array $args Field arguments.
	 * @param string $name Field name.
	 * @param mixed $value Field value.
	 */
	function do_field( $type, $args, $name, $value ) {

		include $this->maybe_override_template( '/fields/views/field.php', $type, $args, $name, $value );

	}

	/**
	 * Outputs the field content.
	 *
	 * @since 1.4.0
	 * @access private
	 *
	 * @param string $type Field type.
	 * @param array $args Field arguments.
	 * @param string $name Field name.
	 * @param mixed $value Field value.
	 */
	function template_field( $type, $args, $name, $value ) {

		include $this->maybe_override_template( "/fields/views/fields/field-{$type}.php", $type, $args, $name, $value );

	}

	/**
	 * Outputs the field label.
	 *
	 * @since 1.4.0
	 * @access private
	 *
	 * @param string $type Field type.
	 * @param array $args Field arguments.
	 * @param string $name Field name.
	 * @param mixed $value Field value.
	 */
	function template_label( $type, $args, $name, $value ) {

		include $this->maybe_override_template( '/fields/views/field-label.php', $type, $args, $name, $value );

	}

	/**
	 * Outputs the field description.
	 *
	 * @since 1.4.0
	 * @access private
	 *
	 * @param string $type Field type.
	 * @param array $args Field arguments.
	 * @param string $name Field name.
	 * @param mixed $value Field value.
	 */
	function template_description_after_label( $type, $args, $name, $value ) {

		if ( $args['description_placement'] === 'after_label' ) {

			$this->template_description( $type, $args, $name, $value );
		}
	}

	/**
	 * Outputs the field description.
	 *
	 * @since 1.4.0
	 * @access private
	 *
	 * @param string $type Field type.
	 * @param array $args Field arguments.
	 * @param string $name Field name.
	 * @param mixed $value Field value.
	 */
	function template_description_beneath( $type, $args, $name, $value ) {

		if ( $args['description_placement'] === 'beneath' ) {

			$this->template_description( $type, $args, $name, $value );
		}
	}

	/**
	 * Outputs the field description.
	 *
	 * @since 1.4.0
	 * @access private
	 *
	 * @param string $type Field type.
	 * @param array $args Field arguments.
	 * @param string $name Field name.
	 * @param mixed $value Field value.
	 */
	function template_description( $type, $args, $name, $value ) {

		if ( $args['description_tip'] === true ) {

			include $this->maybe_override_template( '/fields/views/field-description-tip.php', $type, $args, $name, $value );

		} else {

			include $this->maybe_override_template( '/fields/views/field-description.php', $type, $args, $name, $value );
		}
	}

	/**
	 * Load an alternate Field Template if one exists in your Theme/Plugin
	 *
	 * @since 1.4.0
	 * @access private
	 *
	 * @param  string $template_file Relative File Path to the Template File
	 * @param string $type Field type.
	 * @param array $args Field arguments.
	 * @param string $name Field name.
	 * @param mixed $value Field value.
	 *
	 * @return string Absolute File Path to the Template File
	 */
	function maybe_override_template( $template_file, $type, $args, $name, $value ) {

		$prefix = $this->instance['ID'];

		/**
		 * Allows changing the Directory that Field Template Overrides in your Theme/Plugin should be loaded from
		 *
		 * @param string $override_directory Relative Directory Path to the inclusion of your Field Template Overrides
		 * @param string $template_file Relative File Path to the Template File
		 * @param string $type Field type.
		 * @param array $args Field arguments.
		 * @param string $name Field name.
		 * @param mixed $value Field value.
		 *
		 * @since 1.4.0
		 */
		$override_directory = trailingslashit( apply_filters(
			"{$prefix}_fieldhelpers_field_template_override_directory",
			'/rbm-field-helpers',
			$template_file,
			$type,
			$args,
			$name,
			$value
		) );

		$result = '';

		if ( isset( $this->instance['file'] ) &&
		     is_file( dirname( $this->instance['file'] ) . $override_directory . $template_file ) ) {
			$result = dirname( $this->instance['file'] ) . $override_directory . $template_file;
		} else {
			$result = __DIR__ . $template_file;
		}

		/**
		 * Allows changing the loaded Template File per-Field. This occurs after the override has been applied.
		 *
		 * @param string $result Relative Directory Path to the inclusion of your Field Template Overrides
		 * @param string $template_file Relative File Path to the Template File
		 * @param string $type Field type.
		 * @param array $args Field arguments.
		 * @param string $name Field name.
		 * @param mixed $value Field value.
		 *
		 * @since 1.4.0
		 */
		return apply_filters(
			"{$prefix}_fieldhelpers_after_override_field_template_path",
			$result,
			$template_file,
			$type,
			$args,
			$name,
			$value
		);
	}
}