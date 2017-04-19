<?php
class Genesis_Dambuster_Agency extends Genesis_Dambuster_Template {

	function remove_header() {
        remove_action( 'genesis_before', 'genesis_header_markup_open', 5 );
        remove_action( 'genesis_before', 'genesis_do_header' );
        remove_action( 'genesis_before', 'genesis_header_markup_close', 15 );
        parent::remove_header();
	}

	function enqueue_full_width_styles() {
      wp_dequeue_script( 'agency-pro-backstretch-set' );
      parent::enqueue_full_width_styles();
	}

	function inline_specific_styles() {  //Agency used padding instead of margin so need to put it back if there is a header
	   return $this->has_site_header() ? '.site-container { margin-top: 61px; }' : false;
    }
	
}