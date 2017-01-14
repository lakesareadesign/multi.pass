<?php
class Genesis_Dambuster_Digital extends Genesis_Dambuster_Template {

    function remove_secondary_navigation() {
         remove_action( 'genesis_footer', 'genesis_do_subnav', 12 );		
         parent::remove_secondary_navigation();
    }

}