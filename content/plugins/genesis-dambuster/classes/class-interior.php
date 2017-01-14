<?php
class Genesis_Dambuster_Interior extends Genesis_Dambuster_Template {

    function remove_post_title() {
        remove_action( 'genesis_after_header', 'interior_open_after_header', 5 );
        remove_action( 'genesis_after_header', 'interior_close_after_header', 15 );
        remove_action( 'genesis_after_header', 'genesis_do_taxonomy_title_description', 10 );
        remove_action( 'genesis_after_header', 'genesis_do_author_title_description', 10 );
        add_action('genesis_meta', array($this, 'late_remove_post_title'), 100);
        parent::remove_post_title();
    }
    
    function late_remove_post_title() {
        remove_action( 'genesis_after_header', 'genesis_do_post_title', 10 );	        
    }

    function remove_footer_widgets() {
        remove_action( 'genesis_before_footer', 'interior_footer_widgets' );   
        parent::remove_footer_widgets();
    }
}