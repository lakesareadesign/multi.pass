<?php

/**
 * Abstract class for optin model and stats
 *
 * Class Opt_In_Data
 */
abstract class Hustle_Data {

	const KEY_CONTENT				= "content";
	const KEY_DESIGN                = "design";
	const KEY_SETTINGS              = "settings";
	const KEY_TYPES              	= "types";
	const KEY_VIEW                  = "view";
	const KEY_CONVERSION            = "conversion";
	const KEY_PAGE_SHARES           = "page_shares";
	const KEY_SHORTCODE_ID			= "shortcode_id";
	const TEST_TYPES                = "test_types";
	const TRACK_TYPES               = "track_types";
	const KEY_SERVICES 				= "services";
	const KEY_APPEARANCE 			= "appearance";
	const KEY_FLOATING_SOCIAL 		= "floating_social";
	const ACTIVE_FOR_ADMIN 			= "active_for_admin";
	const ACTIVE_FOR_LOGGED_IN 		= "active_for_logged_in_user";
	const KEY_UNSUBSCRIBE_NONCES 	= "hustle_unsubscribe_nonces";

	/**
	 * Optins types
	 *
	 * @var array
	 */
	/* protected $types = array(
		'popup',
		'slide_in',
		'after_content',
		'shortcode',
		'widget'
	); */

	/**
	 *
	 * @since 1.0.0
	 *
	 * @var array $_data
	 */
	protected $_data;

	/**
	 * Reference to $wpdb global var
	 *
	 * @since 1.0.0
	 *
	 * @var $wpdb WPDB
	 * @access private
	 */
	protected $_wpdb;

	/**
	 *
	 * Opt_In_Data constructor.
	 */
	public function __construct(){
		global $wpdb;
		$this->_wpdb = $wpdb;
	}


	/**
	 * Returns table name
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_table(){
		return $this->_wpdb->base_prefix . Hustle_Db::TABLE_HUSTLE_MODULES;
	}

	/**
	 * Returns meta table name
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_meta_table(){
		return $this->_wpdb->base_prefix . Hustle_Db::TABLE_HUSTLE_MODULES_META;
	}

	/**
	 * Returns format for optin table
	 *
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_format(){
		return array(
			"blog_id" => "%d",
			"module_name" => "%s",
			"module_type" => "%s",
			"active" => "%d",
			"test_mode" => "%d"
		);
	}

	/**
	 * Implements setter magic method
	 *
	 *
	 * @since 1.0.0
	 *
	 * @param $property
	 * @param $val
	 */
	public function __set($property, $val){
		$this->{$property} = $val;
	}

	/**
	 * Implements getter magic method
	 *
	 *
	 * @since 1.0.0
	 *
	 * @param $field
	 * @return mixed
	 */
	public function __get( $field ){

		if( method_exists( $this, "get_" . $field ) )
			return $this->{"get_". $field}();

		if( !empty( $this->_data ) && isset( $this->_data->{$field} ) )
			return $this->_data->{$field};

	}

	/**
	 * Generate a new shortcode is based on provided one
	 *
	 * @param string $shortcode_id
	 * @return string New shortcode id based on the current one
	 */
	public function get_new_shortcode_id( $shortcode_id ) {
		$shortcode_id = trim( $shortcode_id );
		$i = 1;

		do {
			++$i;
			$new_shortcode_id = $shortcode_id . '-' . $i;

			$meta_id = $this->_wpdb->get_var( $this->_wpdb->prepare( "
				SELECT meta_id FROM `" . $this->get_meta_table() . "`
					WHERE `meta_key`='shortcode_id'
					AND `meta_value`=%s", $new_shortcode_id
			));

		} while ( $meta_id );

		return $new_shortcode_id;
	}
}
