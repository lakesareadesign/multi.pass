<?php
class Genesis_Dambuster_Divine extends Genesis_Dambuster_Template {

	function inline_specific_styles() {  //Limit width of wrapped header
	   return $this->has_site_header() ? '.gd-full-width .site-header .wrap, .gd-full-width .nav-primary .wrap { margin: 0 auto; max-width: 1280px; }' : false;
    }
	
}