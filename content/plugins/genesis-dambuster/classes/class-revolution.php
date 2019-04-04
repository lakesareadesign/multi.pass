<?php
class Genesis_Dambuster_Revolution extends Genesis_Dambuster_Template {

	function remove_secondary_navigation() {
        remove_action( 'genesis_header', 'genesis_do_subnav', 12 ); 
    }
}
