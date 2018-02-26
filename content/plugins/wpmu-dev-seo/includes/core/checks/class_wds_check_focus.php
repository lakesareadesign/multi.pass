<?php

if ( ! class_exists( 'Smartcrawl_Check_Abstract' ) ) { require_once( dirname( __FILE__ ) . '/class_wds_check_abstract.php' ); }

class Smartcrawl_Check_Focus extends Smartcrawl_Check_Post_Abstract {

	/**
	 * Holds check state
	 *
	 * @var int
	 */
	private $_state;

	public function get_status_msg() {
		return $this->_state === false
			? __( 'There are no focus keywords', 'wds' )
			: __( 'There are some focus keywords', 'wds' );
	}

	public function apply() {
		$focus = $this->get_focus();
		return ! ! $this->_state = ! empty( $focus );
	}

	public function get_recommendation() {
		return false === $this->_state
			? __( 'In order to give your content the best possible chance to be discovered, it is best to select some focus keywords or key phrases, to give it some context.', 'wds' )
			: __( 'Nice work, now that we know what your article is about we can be more specific in analysis.', 'wds' );
	}

	public function get_more_info() {
		return __( 'Selecting focus keywords helps describe what your content is about.', 'wds' );
	}
}