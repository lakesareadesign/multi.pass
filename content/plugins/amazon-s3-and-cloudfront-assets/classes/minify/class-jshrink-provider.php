<?php

class AS3CF_Minify_JShrink_Provider implements AS3CF_Minify_Provider_Interface {

	/**
	 * @var string
	 */
	protected $input;

	/**
	 * AS3CF_Minify_JShrink_Provider constructor
	 *
	 * @param string $input
	 */
	public function __construct( $input ) {
		$this->input = $input;

		if ( ! class_exists( 'JShrink\Minifier' ) ) {
			require_once( dirname( __FILE__ ) . '/../../vendor/JShrink/Minifier.php' );
		}
	}

	/**
	 * Minify
	 *
	 * @return string
	 */
	public function minify() {
		return JShrink\Minifier::minify( $this->input );
	}

}