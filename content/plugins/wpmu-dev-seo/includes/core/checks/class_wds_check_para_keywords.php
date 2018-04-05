<?php

if ( ! class_exists( 'Smartcrawl_Check_Abstract' ) ) { require_once( dirname( __FILE__ ) . '/class_wds_check_abstract.php' ); }

class Smartcrawl_Check_Para_Keywords extends Smartcrawl_Check_Abstract {

	private $_state;

	public function get_status_msg() {
		return $this->_state === false
			? __( 'First paragraph has no keywords', 'wds' )
			: __( 'First paragraph contains keywords', 'wds' );
	}

	public function apply() {
		$raw = $this->get_markup();
		$content = strip_tags( $raw );
		if ( ! ($content) ) { return ! ! $this->_state = false; }

		$subjects = Smartcrawl_Html::find_content( 'p', $raw );
		if ( empty( $subjects ) ) { return ! ! $this->_state = true; } // No paragraphs whatsoever, nothing to check.

		$subject = reset( $subjects );
		if ( empty( $subject ) ) { return ! ! $this->_state = false; } // First paragraph empty, this fails.

		return ! ! $this->_state = $this->has_focus( $subject );
	}

	public function get_recommendation() {
		if ( $this->_state ) {
			$message = __( "You've included your focus keywords in the first paragraph of your content which will help search engines and visitors quickly scope the topic of your article, well done.", 'wds' );
		} else {
			$message = __( "It's good practice to include your focus keywords in the first paragraph of your content so that search engines and visitors can quickly scope the topic of your article.", 'wds' );
		}

		return $message;
	}

	public function get_more_info() {
		return __( 'You should clearly formulate what your post is about in the first paragraph. In printed texts, a writer usually starts off with some kind of teaser, but there is no time for that if you are writing for the web. You only have seconds to draw you reader’s attention. Make sure the first paragraph tells the main message of your post. That way, you make it easy for your reader to figure out what your post is about and: you tell Google what your post is about. Don’t forget to put your focus keyword in that first paragraph!', 'wds' );
	}
}