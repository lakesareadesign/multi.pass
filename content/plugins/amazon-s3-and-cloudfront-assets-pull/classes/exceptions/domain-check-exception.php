<?php

namespace DeliciousBrains\WP_Offload_S3_Assets_Pull\Exceptions;

class Domain_Check_Exception extends \Exception {

	/**
	 * @var string Relative path for dbrains link
	 */
	protected $more_info = '/wp-offload-s3/doc/assets-pull-domain-check-errors/';

	/**
	 * Get the exception name in key form.
	 */
	public function get_key() {
		$class = new \ReflectionClass( $this );

		return strtolower( $class->getShortName() );
	}

	/**
	 * Get the relative URL to a help document for this exception.
	 *
	 * @return string
	 */
	public function more_info() {
		return $this->more_info;
	}
}