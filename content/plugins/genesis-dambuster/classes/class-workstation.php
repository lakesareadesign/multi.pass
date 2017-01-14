<?php
class Genesis_Dambuster_Workstation extends Genesis_Dambuster_Template {

    function remove_entry_header() {
         remove_action( 'genesis_meta', 'workstation_page_description_meta' );
         parent::remove_entry_header();
    }

    function remove_post_image() {
        remove_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );
        remove_action( 'genesis_entry_header', 'workstation_featured_photo', 5 );        
        parent::remove_post_image();
    }

    function remove_footer_widgets() {
         remove_action( 'genesis_before_footer', 'workstation_footer_widgets' ) ;
         parent::remove_footer_widgets();
    }

}