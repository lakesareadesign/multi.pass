<?php
class Genesis_Dambuster_Breakthrough extends Genesis_Dambuster_Template {

   function remove_header() {
        remove_action( 'genesis_before_content_sidebar_wrap', 'breakthrough_header_title_wrap', 1 );
        remove_action( 'genesis_before_content_sidebar_wrap', 'breakthrough_header_title_end_wrap', 16 );
        parent::remove_header();
   }

   function remove_footer() {
        remove_action( 'genesis_before_footer', 'breakthrough_above_footer_cta' );
        remove_action( 'genesis_before_footer', 'breakthrough_footer_widgets' );
        parent::remove_footer();
   }
   function remove_entry_header() {
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_close', 15 );
        parent::remove_entry_header();      
   }

   function remove_post_title() {
        add_action('genesis_meta', 'breakthrough_integrate_genesis_title_toggle');
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_post_title' );
        parent::remove_post_title();      
   }

   function remove_post_info() {
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_post_info', 4 );
        parent::remove_post_info();      
   }

   function remove_post_image() {
		add_action('genesis_meta', array($this, 'late_remove_post_image'), 100);      
   }

	function late_remove_post_image() {
		remove_action( 'genesis_before_content_sidebar_wrap', 'breakthrough_featured_image', 16 );
        remove_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );   
        remove_filter( 'genesis_get_image', 'breakthrough_wrap_featured_images', 10, 2 );
        remove_filter( 'genesis_markup_entry-image-link_content', 'breakthrough_wrap_featured_images', 10, 2 );
        parent::remove_post_image() ;
	}


}