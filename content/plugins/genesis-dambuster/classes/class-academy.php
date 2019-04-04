<?php
class Genesis_Dambuster_Academy extends Genesis_Dambuster_Template {

    private $remove_background = false;

    function remove_header() {
        remove_action( 'body_class', 'academy_top_banner_classes' );
        add_action('wp_enqueue_scripts', array($this, 'remove_banner_scripts'), 20);       
		parent::remove_header() ;  
    }

    function remove_banner_scripts() {
        wp_dequeue_script( 'top-banner-js' );             
    }

	function remove_post_title() {
        add_action('wp_head', array($this, 'late_remove_post_title'));   
		parent::remove_post_title() ;    
	}	

	function late_remove_post_title() {
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_close', 15 );
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_post_title' );  
	}

	function remove_post_image() {
        remove_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );
		parent::remove_post_image() ;    
	}	

	function remove_footer_widgets() {
        remove_action( 'genesis_before_footer', 'academy_footer_cta' );
		parent::remove_footer_widgets() ;    
	}

	function remove_background() {
	    $this->remove_background = true;
		parent::remove_background() ;    
	}

	function inline_specific_styles() {  //remove background flashes at the top and bottom of site inner
	   return $this->remove_background ? '.site-inner::before, .site-inner::after { background-color : transparent!important; position:static!important; height:0!important  }' : false;
    }

}
