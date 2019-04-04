<?php
class Genesis_Dambuster_Smart_Passive_Income extends Genesis_Dambuster_Template {

	function remove_after_entry() {
        remove_action( 'genesis_entry_content', 'genesis_after_entry_widget_area', 15 );
		parent::remove_after_entry() ;  
	}

	function remove_post_image() {
        remove_action( 'genesis_entry_content', 'genesis_do_post_image', 1 );
        remove_action( 'genesis_entry_content', 'spi_do_featured_image', 1 );
		parent::remove_post_image() ;    
	}	

}
