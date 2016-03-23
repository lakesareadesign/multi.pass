<?php

interface AS3CF_Minify_Provider_Interface {

	/**
	 * AS3CF_Minify_Provider_Interface constructor
	 *
	 * @param string $input
	 */
	public function __construct( $input );

	/**
	 * Minify
	 *
	 * @return string
	 */
	public function minify();

}