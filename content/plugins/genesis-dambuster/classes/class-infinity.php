<?php
class Genesis_Dambuster_Infinity extends Genesis_Dambuster_Template {

	function remove_header() {
		remove_action( 'genesis_after_header', 'infinity_offscreen_content_output' );
      	parent::remove_header();
	}


}