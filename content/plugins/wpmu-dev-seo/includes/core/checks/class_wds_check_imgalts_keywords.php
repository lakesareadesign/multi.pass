<?php

if ( ! class_exists( 'Smartcrawl_Check_Abstract' ) ) { require_once( dirname( __FILE__ ) . '/class_wds_check_abstract.php' ); }

class Smartcrawl_Check_Imgalts_Keywords extends Smartcrawl_Check_Abstract {

	private $_state;

	private $_image_count = null;

	public function get_status_msg() {
		$image_count = $this->_image_count ? $this->_image_count : 0;

		if ( $image_count === 0 ) {
			return __( 'No images found', 'wds' );
		} else {
			return $this->_state === false
				? __( 'Image alts have no keywords', 'wds' )
				: __( 'Image alt tags contain keywords', 'wds' );
		}

	}

	public function apply() {
		$subjects = Smartcrawl_Html::find_attributes( 'img', 'alt', $this->get_markup() );
		$this->_image_count = count( $subjects );
		if ( empty( $subjects ) ) { return false; }

		$status = true;
		foreach ( $subjects as $subject ) {
			if (empty($subject)) {
				$status = false;
				break;
			}
			$status = $this->has_focus( $subject );
			if ( !$status ) { break; }
		}

		return ! ! $this->_state = $status;
	}

	public function get_recommendation() {
		$image_count = $this->_image_count ? $this->_image_count : 0;

		if ( $image_count === 0 ) {
			$message = __( 'Images are a great addition to any piece of content. Consider adding imagery to enhance the reading experience of your article.', 'wds' );
		} elseif ( $this->_state ) {
			$message = __( "You've added alternative text attributes to all your images which helps search engines correctly index images and aid visually impaired readers, awesome!", 'wds' );
		} else {
			$message = __( "Alternative attribute text for images help search engines correctly index images and aid visually impaired readers. The text is also used in place of the image if it's unable to load. You should add alternative text for all images in your content.", 'wds' );
		}

		return $message;
	}

	public function get_more_info() {
		if (empty($this->_image_count)) return false;

		return $this->_state === false
			? ''
			: __( "Image alternative text attributes help search engines correctly index images, aid visually impaired readers and the text is used in place of the image if it's unable to load. You should add alternative text for all images in your content.", 'wds' )
		;
	}
}