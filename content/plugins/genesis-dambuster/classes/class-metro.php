<?php
class Genesis_Dambuster_Metro extends Genesis_Dambuster_Template {

	function remove_background() {
		remove_action( 'wp_enqueue_scripts', 'metro_enqueue_scripts' );
		parent::remove_background();
	}

	function remove_secondary_navigation() {
      remove_action( 'genesis_before_header', 'genesis_do_subnav' ,6);
      parent::remove_secondary_navigation();	  
	}	

   function remove_entry_footer() {
		remove_action( 'genesis_entry_footer', 'metro_after_post'  );
   		parent::remove_entry_footer();
   }

	function remove_footer_widgets() {
      remove_action( 'genesis_after', 'genesis_footer_widget_areas' );
      parent::remove_footer_widgets();      
	}
	
	function remove_footer() {
      remove_action( 'genesis_after', 'genesis_footer_markup_open', 11 );
      remove_action( 'genesis_after', 'genesis_do_footer', 12 );
      remove_action( 'genesis_after', 'genesis_footer_markup_close', 13 );
      parent::remove_footer();
   }
     
   function full_width() {
   		remove_action( 'genesis_before_header', 'metro_open_site_container_wrap' );
		remove_action( 'genesis_after_footer', 'metro_close_site_container_wrap' );
   		parent::full_width();
   }  
       
}