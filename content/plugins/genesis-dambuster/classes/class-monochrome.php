<?php
class Genesis_Dambuster_Monochrome extends Genesis_Dambuster_Template {

	function remove_background() {
        remove_action( 'wp_enqueue_scripts', 'monochrome_enqueue_backstretch_post' );	
        remove_action( 'genesis_before', 'monochrome_setup_full_width' );
	    remove_action( 'genesis_after_header', 'monochrome_entry_background_post' );
        parent::remove_background();
	}

    function remove_entry_header() {
        remove_action( 'genesis_entry_header', 'monochrome_gravatar_post', 7 ); 
        parent::remove_entry_header();
    }

    function remove_entry_footer() {
        remove_action( 'genesis_entry_footer', 'genesis_post_meta' );         
        parent::remove_entry_footer();
	}

	function remove_secondary_navigation() {
        remove_action( 'genesis_after', 'genesis_do_subnav' ,12);
        parent::remove_secondary_navigation();	  
	}

	function remove_footer_widgets() {
        remove_action( 'genesis_before_footer', 'monochrome_before_footer_cta' );
        parent::remove_footer_widgets();      
	}
	
	function remove_footer() {
        remove_action( 'genesis_after', 'genesis_footer_markup_open', 5 );
        remove_action( 'genesis_after', 'monochrome_before_footer', 8 );
        remove_action( 'genesis_after', 'genesis_do_footer' );
        remove_action( 'genesis_after', 'monochrome_footer_menu', 12 );
        remove_action( 'genesis_after', 'genesis_footer_markup_close', 15 );
        parent::remove_footer();
    } 
 
	function inline_specific_styles() { //restrict header and footer width
       $styles = ''; 
	   if ($this->has_site_header()) $styles .= '.gd-full-width .site-inner { margin-top:0 ; }';
	   return empty($styles) ? false : $styles ;
    }
        
}