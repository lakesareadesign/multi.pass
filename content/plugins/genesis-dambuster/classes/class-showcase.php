<?php
class Genesis_Dambuster_Showcase extends Genesis_Dambuster_Template {


    function remove_entry_header() {
         remove_action( 'genesis_before_header', 'showcase_opening_page_header' );    
         remove_action( 'genesis_after_header', 'showcase_opening_page_header', 8 );
         remove_action( 'genesis_after_header', 'showcase_closing_page_header' );
         parent::remove_entry_header();
    }

    function remove_secondary_navigation() {
        add_filter ('genesis_do_subnav', '__return_empty_string',100) ;
        parent::remove_secondary_navigation();
    }

    function remove_footer_widgets() {
         remove_action( 'genesis_before_footer', 'showcase_before_footer_widget_area', 5 ) ;
         parent::remove_footer_widgets();
    }

}