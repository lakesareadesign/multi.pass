<?php
class Genesis_Dambuster_Pretty_Chic extends Genesis_Dambuster_Template {

	function inline_specific_styles() {  //Center Navigation Menu on page
	   return $this->has_site_header() ? '.gd-full-width .nav-primary { margin-left: auto; margin-right: auto; }' : false;
    }
	
}