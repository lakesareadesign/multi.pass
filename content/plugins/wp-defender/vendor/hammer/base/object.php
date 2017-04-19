<?php
/**
 * Author: Hoang Ngo
 */

namespace Hammer\Base;

/**
 * Every class should extend this class.
 *
 * This contains generic function for checking internal info
 *
 * Class Object
 * @package Hammer\Base
 */
class Object {
	/**
	 * @param $property
	 *
	 * @return bool
	 */
	public function hasProperty( $property ) {
		$ref = new \ReflectionClass( $this );

		return $ref->hasProperty( $property );
	}

	/**
	 * @param $method
	 *
	 * @return bool
	 */
	public function hasMethod( $method ) {
		$ref = new \ReflectionClass( $this );

		return $ref->hasMethod( $method );
	}

	/**
	 * @return string
	 */
	public static function getClassName() {
		return get_called_class();
	}
}