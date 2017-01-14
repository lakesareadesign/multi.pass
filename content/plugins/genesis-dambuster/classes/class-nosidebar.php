<?php
class Genesis_Dambuster_NoSidebar extends Genesis_Dambuster_Template {

	function remove_header() {
        remove_action( 'genesis_header', 'ns_search', 13 );
        parent::remove_header();
    }

    function remove_secondary_navigation() {
         remove_action( 'genesis_footer', 'genesis_do_subnav', 12 );		
         parent::remove_secondary_navigation();
    }

    function remove_post_image() {
         remove_action( 'genesis_entry_header', 'ns_featured_image', 1 );		
         parent::remove_post_image();
    }

}