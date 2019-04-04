<?php
class Genesis_Dambuster_Wellness extends Genesis_Dambuster_Template {

   function remove_post_image() {
      remove_action( 'genesis_entry_content', 'wellness_featured_image', 1 );
      parent::remove_post_image();
   }
  
	function remove_footer_widgets() {
      remove_action( 'genesis_before_footer', 'wellness_before_footer_widget' );
      remove_action( 'genesis_before_footer', 'wellness_footer_widgets' );
      parent::remove_footer_widgets();
   }       
}