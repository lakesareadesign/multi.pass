<?php

/**
 * @author: Hoang Ngo
 */
class WD_Model extends WD_Component {
	/**
	 * @var array
	 * @since 1.0
	 */
	public $virtual_attributes = array();

	/**
	 * @var array
	 */
	private $virtual_data = array();
	/**
	 * @var array
	 * @since 1.0
	 */
	protected $errors = array();
	/**
	 * @var string
	 * @since 1.0
	 */
	public $scenario;

	/**
	 * This variable contain validate rules, example usage
	 * array(
	 * 'username'    => array('required|alpha_numeric|max_len,100|min_len,6','scenario'=>''),
	 * )
	 * For more information, check the GUMP library https://github.com/Wixel/GUMP
	 * @var array
	 */
	/**
	 * @var array
	 * @since 1.0
	 */
	protected $rules = array();

	/**
	 * Magic method __get
	 *
	 * @param string $property
	 *
	 * @access public
	 * @since 1.0
	 * @return mixed|null
	 */
	public function &__get( $property ) {
		$attributes = array_keys( $this->export() );
		if ( in_array( $property, $attributes ) ) {
			//all good
			return $this->$property;
		}

		if ( isset( $this->virtual_attributes[ $property ] ) ) {
			//check in the virtual property
			return $this->virtual_attributes[ $property ];
		}

		return null;
	}

	/**
	 * Magic method __set
	 *
	 * @param string $property
	 * @param mixed $value
	 *
	 * @access public
	 * @since 1.0
	 */
	public function __set( $property, $value ) {
		$attributes = array_keys( $this->export() );
		if ( in_array( $property, $attributes ) ) {
			//all good
			$this->$property = $value;
		} else {
			//jsut throw it into virtual attribute
			$this->virtual_attributes[ $property ] = $value;
		}
	}

	public function before_validate() {

	}

	/**
	 * Validate class properties by defined rules
	 * @return bool
	 */
	public function validate() {
		if ( ! class_exists( 'GUMP' ) ) {
			require_once wp_defender()->get_plugin_path() . 'vendors/gump.class.php';
		}

		$this->before_validate();
		$gump  = new GUMP();
		$rules = array();
		foreach ( $this->rules as $key => $row ) {
			if ( count( $row ) == 2 ) {
				if ( $row[1] == $this->scenario ) {
					$rules[ $key ] = $row[0];
				}
			} elseif ( count( $row ) == 1 ) {
				$rules[ $key ] = $row[0];
			}
		}

		$results = $gump->is_valid( $this->export(), $rules );
		if ( $results !== true ) {
			if ( ! is_array( $this->errors ) ) {
				$this->errors = array();
			}
			$this->errors = array_merge( $this->errors, $results );
		}
		$this->after_validate();
		//if everything fine, we will check the addition validate
		$ret = false;
		if ( $results === true ) {
			if ( $this->addition_validate() == true ) {
				$ret = true;
			} else {
				$ret = false;
			}
		}

		return $ret;
	}

	public function addition_validate() {
		return true;
	}

	public function after_validate() {

	}

	protected function before_insert() {

	}

	protected function after_insert() {

	}

	protected function before_update() {

	}

	protected function after_update() {

	}

	/**
	 * @param string $key
	 *
	 * @return bool
	 * @since 1.0
	 */
	public function has_error( $key ) {
		return isset( $this->errors[ $key ] );
	}

	/**
	 * @param string $key
	 *
	 * @return null
	 * @since 1.0
	 */
	public function get_error( $key ) {
		return isset( $this->errors[ $key ] ) ? $this->errors[ $key ] : null;
	}

	/**
	 * @param string $key
	 * @param string $error
	 *
	 * @since 1.0
	 */
	public function add_error( $key, $error ) {
		$this->errors[ $key ] = $error;
	}

	/**
	 * @param array $errors
	 *
	 * @since 1.0
	 */
	public function add_errors( $errors ) {
		foreach ( $errors as $key => $error ) {
			$this->errors[ $key ] = $error;
		}
	}

	/**
	 * @return array
	 * @since 1.0
	 */
	public function get_errors() {
		return $this->errors;
	}

	public function clear_errors() {
		$this->errors = array();
	}

	/**
	 * Export class properties as array
	 * @return array
	 * @since 1.0
	 */
	public function export() {
		$data              = array();

		$reflection        = new ReflectionClass( get_class( $this ) );
		$native_attributes = $this->get_native_attributes();

		foreach ( $reflection->getProperties() as $prop ) {
			if ( ! in_array( $prop->name, $native_attributes ) ) {
				$data[ $prop->name ] = $this->{$prop->name};
			}
		}
		//virtual attribute
		foreach ( $this->virtual_attributes as $key ) {
			$data[ $key ] = $this->virtual_data[ $key ];
		}

		return $data;
	}

	/**
	 * Import data to class properties
	 *
	 * @param array $data
	 *
	 * @since 1.0
	 */
	public function import( $data = array() ) {
		foreach ( (array) $data as $key => $val ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $val;
			} elseif ( isset( $this->virtual_attributes[ $key ] ) ) {
				$this->virtual_attributes[ $key ] = $val;
			}
		}
	}

	/**
	 * @return mixed|void
	 */
	protected function get_native_attributes() {
		return apply_filters( 'wd_core_model_attribute', array(
			'attributes',
			'errors',
			'scenario',
			'rules',
			'relations',
			'table'
		) );
	}
}