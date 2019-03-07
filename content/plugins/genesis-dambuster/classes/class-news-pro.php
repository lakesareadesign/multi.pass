<?php
class Genesis_Dambuster_News_Pro extends Genesis_Dambuster_Template {

   function full_width() {
      remove_action( 'genesis_before_header', 'news_open_site_container_wrap' );
      remove_action( 'genesis_after_footer', 'news_close_site_container_wrap' );
      parent::full_width();
   }

}