<?php
class Genesis_Dambuster_Altitude extends Genesis_Dambuster_Template {

	function remove_footer() {
        remove_action( 'genesis_footer', 'rainmaker_footer_menu', 7 );
        parent::remove_footer();
	}

	function inline_specific_styles() {  //Reduce margin
	   return $this->has_site_header() ? '.gd-full-width .site-inner { margin-top: 75px;} .gd-full-width.secondary-nav .site-inner { margin-top: 150px; }' : false;
    }

}