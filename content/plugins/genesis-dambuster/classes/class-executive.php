<?php
class Genesis_Dambuster_Executive extends Genesis_Dambuster_Template {

	function inline_specific_styles() { //restrict header and footer width
       $styles = ''; 
	   if ($this->has_site_header()) $styles .= '.gd-full-width .site-header { max-width: 1140px; }';
	   if ($this->has_site_footer()) $styles .= '.gd-full-width .site-footer { max-width: 1140px; margin: 0 auto; }';
	   return empty($styles) ? false : $styles ;
    }
       
}