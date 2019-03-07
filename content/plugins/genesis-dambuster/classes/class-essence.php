<?php
class Genesis_Dambuster_Essence extends Genesis_Dambuster_Template {

   function remove_header() {
        remove_action( 'genesis_meta', 'essence_page_hero_header' );
        remove_action( 'genesis_header', 'essence_header_right_menu', 9 );
        remove_action( 'genesis_header', 'essence_header_left_widget', 9 );
        parent::remove_header();
   }

   function remove_footer() {
        remove_action( 'genesis_before_footer', 'essence_footer_cta', 17 );
        parent::remove_footer();
   }
   function remove_entry_header() {
        remove_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );
        parent::remove_entry_header();      
   }

   function remove_post_image() {
        remove_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );
        parent::remove_post_image();      
   }

	function remove_breadcrumbs() {
        remove_action( 'genesis_after_header', 'genesis_do_breadcrumbs', 90 );
        parent::remove_breadcrumbs();      
   }

	function inline_specific_styles() { 
	   return $this->has_site_header() ? false: '.gd-full-width .site-inner::before { height: 0; top: 0; }';
    }

}