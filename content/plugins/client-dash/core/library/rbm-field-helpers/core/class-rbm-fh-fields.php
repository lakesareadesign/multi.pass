<?php
/**
 * Handles all fields.
 *
 * @since 1.4.0
 */

defined( 'ABSPATH' ) || die();

/**
 * Class RBM_FH_Fields
 *
 * Handles all fields.
 *
 * @since 1.4.0
 */
class RBM_FH_Fields {

	/**
	 * Instance properties.
	 *
	 * @since 1.4.0
	 *
	 * @var array
	 */
	public $instance = array();

	/**
	 * Handles field saving.
	 *
	 * @since 1.4.0
	 *
	 * @var RBM_FH_FieldsSave
	 */
	public $save = array();

	/**
	 * Data to localize.
	 *
	 * @since 1.4.0
	 *
	 * @var array
	 */
	public $data = array();

	/**
	 * RBM_FH_Fields constructor.
	 *
	 * @since 1.4.0
	 */
	function __construct( $instance = array() ) {

		$this->instance = $instance;

		// Load files
		require_once __DIR__ . '/class-rbm-fh-field.php';
		require_once __DIR__ . '/class-rbm-fh-fields-save.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-checkbox.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-colorpicker.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-datepicker.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-timepicker.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-datetimepicker.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-hidden.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-html.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-list.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-media.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-radio.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-number.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-repeater.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-select.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-table.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-text.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-textarea.php';
		require_once __DIR__ . '/fields/class-rbm-fh-field-toggle.php';

		$this->save = new RBM_FH_FieldsSave( $instance['ID'] );

		add_filter( 'rbm_field_helpers_admin_data', array( $this, 'localize_data' ) );
	}

	/**
	 * Localizes data for the fields on the page.
	 *
	 * @since 1.3.0
	 * @access private
	 *
	 * @param array $data Data to be localized.
	 *
	 * @return array
	 */
	public function localize_data( $data ) {

		$data[ $this->instance['ID'] ] = $this->data;

		return $data;
	}

	/**
	 * Alias for get_meta_field().
	 *
	 * @since 1.4.0
	 *
	 * @param string $field The fieldname to get.
	 * @param bool|false $post_ID Supply post ID to get field from different post.
	 * @param array $args Arguments.
	 *
	 * @return bool|mixed|void
	 */
	public function get_field( $field, $post_ID = false, $args = array() ) {

		return $this->get_meta_field( $field, $post_ID, $args );
	}

	/**
	 * Gets a meta field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $field The fieldname to get.
	 * @param bool|false $post_ID Supply post ID to get field from different post.
	 * @param array $args Arguments.
	 *
	 * @return bool|mixed|void
	 */
	public function get_meta_field( $field, $post_ID = false, $args = array() ) {

		global $post;

		if ( $post_ID === false && ( $post instanceof WP_Post ) ) {
			$post_ID = $post->ID;
		} elseif ( $post_ID === false ) {
			return false;
		}

		$args = wp_parse_args( array(
			'sanitization' => false,
			'single'       => true,
		) );

		$value = get_post_meta( $post_ID, "{$this->instance['ID']}_{$field}", $args['single'] );

		if ( $args['sanitization'] && is_callable( $args['sanitization'] ) ) {
			$value = call_user_func( $args['sanitization'], $value );
		}

		/**
		 * Allows filtering of the meta field value.
		 *
		 * @since 1.4.0
		 */
		$value = apply_filters( "{$this->instance['ID']}_rbm_fh_get_meta_field", $value, $field, $post_ID );

		/**
		 * Allows filtering of the specific meta field value.
		 *
		 * @since 1.4.0
		 */
		$value = apply_filters( "{$this->instance['ID']}_rbm_fh_get_meta_field_{$field}", $value, $post_ID );

		return $value;
	}

	/**
	 * Gets an option field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $field The fieldname to get.
	 * @param array $args Arguments.
	 *
	 * @return bool|mixed|void
	 */
	public function get_option_field( $field, $args = array() ) {

		$args = wp_parse_args( array(
			'sanitization' => false,
			'single'       => true,
		) );

		$value = get_option( "{$this->instance['ID']}_{$field}", $args['single'] );

		if ( $args['sanitization'] && is_callable( $args['sanitization'] ) ) {
			$value = call_user_func( $args['sanitization'], $value );
		}

		/**
		 * Allows filtering of the option field value.
		 *
		 * @since 1.4.0
		 */
		$value = apply_filters( "{$this->instance['ID']}_rbm_fh_get_option_field", $value, $field );

		/**
		 * Allows filtering of the specific option field value.
		 *
		 * @since 1.4.0
		 */
		$value = apply_filters( "{$this->instance['ID']}_rbm_fh_get_option_field_{$field}", $value );

		return $value;
	}

	/**
	 * Sets up field data to be localized.
	 *
	 * @since 1.4.0
	 * @access private
	 *
	 * @param string $name Field name.
	 * @param string $type Field type.
	 * @param array $field_args All field args (not all will be localized).
	 * @param array $args Field args to be localized.
	 */
	public function setup_data( $name, $type, $field_args, $args = array() ) {

		// Always add some standard args
		$args['id']      = $field_args['id'];
		$args['default'] = $field_args['default'];

		if ( $field_args['name_base'] ) {

			$name = "{$field_args['name_base']}[{$name}]";
		}

		if ( $field_args['repeater'] ) {

			$this->data['repeaterFields'][ $field_args['repeater'] ][ $name ] = $args;

		} else {

			$this->data[ $type ][ $name ] = $args;
		}
	}

	/**
	 * Imports instance translations.
	 *
	 * @since 1.4.0
	 *
	 * @param array $args Field args.
	 * @param string $type Field type.
	 *
	 * @return array Field args with default translations.
	 */
	public function setup_translations( $args, $type ) {

		if ( ! isset( $this->instance['l10n']["field_{$type}"] ) ) {

			return $args;
		}

		$args['l10n'] = wp_parse_args(
			isset( $args['l10n'] ) ? $args['l10n'] : array(),
			$this->instance['l10n']["field_{$type}"]
		);

		return $args;
	}

	/**
	 * Outputs a text field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_text( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'text' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_Text( $name, $args );

		$this->save->field_init( $name, 'text', $field->args );
	}

	/**
	 * Outputs a textarea field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_textarea( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'textarea' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_TextArea( $name, $args );

		$this->save->field_init( $name, 'textarea', $field->args );

		$this->setup_data( $field->name, 'textarea', $field->args, array(
			'wysiwyg'        => $field->args['wysiwyg'],
			'wysiwygOptions' => $field->args['wysiwyg_options'],
		) );
	}

	/**
	 * Outputs a checkbox field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_checkbox( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'checkbox' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_Checkbox( $name, $args );

		$this->save->field_init( $name, 'checkbox', $field->args );

		$this->setup_data( $field->name, 'checkbox', $field->args );
	}

	/**
	 * Outputs a radio field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_radio( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'radio' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_Radio( $name, $args );

		$this->save->field_init( $name, 'radio', $field->args );

		$this->setup_data( $field->name, 'radio', $field->args );
	}

	/**
	 * Outputs a toggle field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_toggle( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'toggle' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_Toggle( $name, $args );

		$this->save->field_init( $name, 'toggle', $field->args );

		$this->setup_data( $field->name, 'toggle', $field->args, array(
			'checkedValue'   => $field->args['checked_value'],
			'uncheckedValue' => $field->args['unchecked_value'],
		) );
	}

	/**
	 * Outputs a select field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_select( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'select' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_Select( $name, $args );

		$this->save->field_init( $name, 'select', $field->args );

		$this->setup_data( $field->name, 'select', $field->args, array(
			'select2Disabled'         => $field->args['select2_disable'],
			'select2Options'          => $field->args['select2_options'],
			'optGroups'               => $field->args['opt_groups'],
			'optGroupSelectionPrefix' => $field->args['opt_group_selection_prefix'],
		) );
	}

	/**
	 * Outputs a number field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_number( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'number' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_Number( $name, $args );

		$this->save->field_init( $name, 'number', $field->args );

		$this->setup_data( $field->name, 'number', $field->args, array(
			'increaseInterval'    => $field->args['increase_interval'],
			'decreaseInterval'    => $field->args['decrease_interval'],
			'altIncreaseInterval' => $field->args['alt_increase_interval'],
			'altDecreaseInterval' => $field->args['alt_decrease_interval'],
			'max'                 => $field->args['max'],
			'min'                 => $field->args['min'],
			'postfix'             => $field->args['postfix'],
		) );
	}

	/**
	 * Outputs an image field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_media( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'media' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_Media( $name, $args );

		$this->save->field_init( $name, 'media', $field->args );

		$this->setup_data( $field->name, 'media', $field->args, array(
			'placeholder' => $field->args['placeholder'],
			'type'        => $field->args['type'],
			'previewSize' => $field->args['preview_size'],
			'l10n'        => array(
				'window_title' => $field->args['window_title'],
			),
		) );
	}

	/**
	 * Outputs a datepicker field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_datepicker( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'datepicker' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_DatePicker( $name, $args );

		$this->save->field_init( $name, 'datepicker', $field->args );

		$this->setup_data( $field->name, 'datepicker', $field->args, array(
			'datepickerOptions' => $field->args['datepicker_args'],
		) );
	}

	/**
	 * Outputs a timepicker field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_timepicker( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'timepicker' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_TimePicker( $name, $args );

		$this->save->field_init( $name, 'timepicker', $field->args );

		$this->setup_data( $field->name, 'timepicker', $field->args, array(
			'timepickerOptions' => $field->args['timepicker_args'],
		) );
	}

	/**
	 * Outputs a datetimepicker field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_datetimepicker( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'datetimepicker' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_DateTimePicker( $name, $args );

		$this->save->field_init( $name, 'datetimepicker', $field->args );

		$this->setup_data( $field->name, 'datetimepicker', $field->args, array(
			'datetimepickerOptions' => $field->args['datetimepicker_args'],
		) );
	}

	/**
	 * Outputs a colorpicker field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_colorpicker( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'colorpicker' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_ColorPicker( $name, $args );

		$this->save->field_init( $name, 'colorpicker', $field->args );

		$this->setup_data( $field->name, 'colorpicker', $field->args );
	}

	/**
	 * Outputs a list field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_list( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'list' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_List( $name, $args );

		$this->save->field_init( $name, 'list', $field->args );

		$this->setup_data( $field->name, 'list', $field->args );
	}

	/**
	 * Outputs a table field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_table( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'table' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_Table( $name, $args );

		$this->save->field_init( $name, 'table', $field->args );

		$this->setup_data( $field->name, 'table', $field->args );
	}

	/**
	 * Outputs a repeater field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param mixed $values
	 */
	public function do_field_repeater( $name, $args = array() ) {

		$args                    = $this->setup_translations( $args, 'repeater' );
		$args['prefix']          = $this->instance['ID'];
		$args['fields_instance'] = $this;

		$field = new RBM_FH_Field_Repeater( $name, $args );

		$this->save->field_init( $name, 'repeater', $field->args );

		$this->setup_data( $field->name, 'repeater', $field->args, array(
			'empty'                  => ! $field->value,
			'collapsable'            => $field->args['collapsable'],
			'sortable'               => $field->args['sortable'],
			'isFirstItemUndeletable' => $field->args['first_item_undeletable'],
			'l10n'                   => array(
				'collapsable_title'   => $field->args['collapsable_title'],
				'confirm_delete_text' => $field->args['confirm_delete_text'],
				'delete_item_text'    => $field->args['delete_item_text'],
				'add_item_text'       => $field->args['add_item_text'],
			),
		) );
	}

	/**
	 * Outputs a hidden field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_hidden( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'hidden' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_Hidden( $name, $args );

		$this->save->field_init( $name, 'hidden', $field->args );
	}

	/**
	 * Outputs a html field.
	 *
	 * @since 1.4.0
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function do_field_html( $name, $args = array() ) {

		$args           = $this->setup_translations( $args, 'html' );
		$args['prefix'] = $this->instance['ID'];

		$field = new RBM_FH_Field_HTML( $name, $args );

		$this->save->field_init( $name, 'html', $field->args );
	}
}