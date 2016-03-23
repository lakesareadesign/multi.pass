<?php

class AS3CF_Minify_CssMin_Provider implements AS3CF_Minify_Provider_Interface {

	/**
	 * @var string
	 */
	protected $input;

	/**
	 * AS3CF_Minify_CssMin_Provider constructor
	 *
	 * @param string $input
	 */
	public function __construct( $input ) {
		$this->input = $input;

		if ( ! class_exists( 'CssMin' ) ) {
			require_once( dirname( __FILE__ ) . '/../../vendor/CssMin/CssMin.php' );
		}
	}

	/**
	 * Minify
	 *
	 * @return string
	 */
	public function minify() {
		return CssMin::minify( $this->input );
	}

}